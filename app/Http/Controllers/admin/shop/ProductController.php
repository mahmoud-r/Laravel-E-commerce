<?php

namespace App\Http\Controllers\admin\shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttributeRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Traits\ImageTrait;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order_item;
use App\Models\Product;
use App\Models\Product_Image;
use App\Models\ProductAttribute;
use App\Models\ProductCollection;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use function PHPUnit\Framework\isNull;

class ProductController extends Controller
{
    use ImageTrait;

    function __construct()
    {
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','getAll','getProducts','get_sub_categories','edit'] ]);
        $this->middleware('permission:product-create', ['only' => ['create','store','storeAttribute','storeAttributeValue']]);
        $this->middleware('permission:product-edit', ['only' => ['update','storeAttribute','storeAttributeValue','updateImages','deleteImages']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);


    }

    public function index()
    {
        return view('admin/products/index');
    }

    public function getAll() {
        $products = Product::select('id','title','price','qty','sku','status','category_id')->latest('id')
            ->with(['images','category'])->get();

        return response()->json($products);
    }

    public function create()
    {
        $categories = Category::select('name','id')->orderBy('name','ASC')->get();
        $brands = Brand::select('name','id')->orderBy('name','ASC')->get();
        $collections =ProductCollection::where('status','1')->get();

        return view('admin/products/create',compact('categories','brands','collections'));
    }


    public function store(StoreProductRequest $request)
    {
        $slug = Str::slug($request->slug);

        DB::beginTransaction();

        try {

            $product =Product::create([
                'title'=>$request->title,
                'description'=>$request->description,
                'short_description'=>$request->short_description,
                'slug'=>$slug,
                'price'=>$request->price,
                'compare_price'=>$request->compare_price,
                'category_id'=>$request->category_id,
                'sub_category_id'=>$request->sub_category_id,
                'brand_id'=>$request->brand_id,
                'sku'=>$request->sku,
                'weight'=>$request->weight,
                'max_order'=>$request->max_order,
                'qty'=>$request->qty,
                'status'=>$request->status,
                'warranty'=>$request->warranty,
                'return'=>$request->return,
                'seo_title'=>$request->seo_title,
                'seo_description'=>$request->seo_description,
                'seo_index'=>$request->seo_index,
                'flash_sale_price'=>$request->flash_sale_price,
                'flash_sale_expiry_date'=>$request->flash_sale_expiry_date,
                'flash_sale_qty'=>$request->flash_sale_qty,
                'flash_sale_qty_solid'=>$request->flash_sale_qty_solid,
                'related_product'=>(!empty($request->relatedProducts))?implode(',',$request->relatedProducts):'',

            ]);

            if ($request->has('attributes')) {
                foreach ($request->input('attributes') as $attributeId => $valueId) {
                    if ($valueId) {
                        ProductAttribute::create([
                            'product_id' => $product->id,
                            'attribute_id' => $attributeId,
                            'attribute_value_id' => $valueId,
                        ]);
                    }
                }
            }

            $product->Collections()->sync($request->product_collections);


            //save images
            if (!empty($request->images_array)){
                foreach ($request->images_array as $temp_image_id){

                    $Product_Image=new Product_Image();
                    $Product_Image->product_id = $product->id;
                    $Product_Image->image = null;
                    $Product_Image->save();


                    $imageName = $product->id.'-'.$Product_Image->id;

                    $newImageName = $this->saveImage($temp_image_id,$imageName,'products',1400);
                    $this->saveThumbnail('products', $newImageName, 300);

                    $Product_Image->image = $newImageName;
                    $Product_Image->save();
                }
            }



            DB::commit();

            Session()->flash('success','Product Created Successfully');

            return response()->json([
                'status' => true,
                'msg'=>'Product Created Successfully'
            ]);

        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'msg' => 'There was an error creating the product: ' . $e->getMessage(),
            ], 500);
        }



    }

    public function storeAttribute(StoreAttributeRequest $request)
    {
        $slug= Str::slug($request->name);

        $attribute = Attribute::create([
            'name' =>$request->name,
            'category_id'=>$request->category_id,
            'slug'=>$slug
        ]);
        if ($request->has('values')) {
            foreach ($request->input('values') as $value) {
                $attribute->values()->create(['value' => $value,'slug'=>Str::slug($value)]);
            }
        }
        $attributesCount = Attribute::where('category_id',$request->category_id)->count();
        $html = view('admin.products.models.NewAttributeResult',compact('attribute','attributesCount'))->render();
        return response()->json([
            'status' =>true,
            'msg'=>'Attribute Created Successfully',
            'id'=>$attribute->id,
            'html'=>$html
        ]);
    }

    public function storeAttributeValue(Request $request)
    {
        $validator = Validator::make($request->all(),[
           'attributeId' =>'required|exists:attributes,id',
            'value' => 'string|max:255'
        ]);

        $attribute = Attribute::findOrFail($request->attributeId);

        $slug= Str::slug($request->value);
        $value = $attribute->values()->create(['value' => $request->value,'slug'=>$slug]);


        return response()->json([
            'status' =>true,
            'msg'=>'Value Created Successfully',
            'attribute'=>$attribute->id,
            'value'=>$value,
        ]);
    }

    public function edit( $id)
    {
        $product = Product::findOrFail($id);

        $categories = Category::select('name','id')->orderBy('name','ASC')->get();

        $attributes = $product->category->attributes;

        $brands = brand::select('name','id')->orderBy('name','ASC')->get();

        $subCategories = SubCategory::where('category_id',$product->category_id)
            ->select('name','id')->orderBy('name','ASC')->get();

        $collections =ProductCollection::where('status','1')->get();
        $relatedProduct = [];
        if ($product->related_product){
            $productArray = explode(',',$product->related_product);
            $relatedProduct = Product::select('title','id')->whereIn('id',$productArray)->get();
        }

        return(view('admin/products/edit',compact(
            'product',
            'categories',
            'brands',
            'subCategories',
            'relatedProduct',
            'attributes',
            'collections'
        )));
    }


    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $slug = Str::slug($request->slug);
        DB::beginTransaction();

        try {
            $product->update([
                'title'=>$request->title,
                'description'=>$request->description,
                'short_description'=>$request->short_description,
                'slug'=>$slug,
                'price'=>$request->price,
                'compare_price'=>$request->compare_price,
                'category_id'=>$request->category_id,
                'sub_category_id'=>$request->sub_category_id,
                'brand_id'=>$request->brand_id,
                'sku'=>$request->sku,
                'weight'=>$request->weight,
                'max_order'=>$request->max_order,
                'qty'=>$request->qty,
                'status'=>$request->status,
                'warranty'=>$request->warranty,
                'return'=>$request->return,
                'seo_title'=>$request->seo_title,
                'seo_description'=>$request->seo_description,
                'seo_index'=>$request->seo_index,
                'flash_sale_price'=>$request->flash_sale_price,
                'flash_sale_expiry_date'=>$request->flash_sale_expiry_date,
                'flash_sale_qty'=>$request->flash_sale_qty,
                'flash_sale_qty_solid'=>$request->flash_sale_qty_solid,
                'related_product'=>(!empty($request->relatedProducts))?implode(',',$request->relatedProducts):'',
            ]);

            $product->productAttributes()->delete();

            if ($request->has('attributes')) {
                foreach ($request->input('attributes') as $attributeId => $valueId) {
                    if ($valueId) {
                        ProductAttribute::create([
                            'product_id' => $product->id,
                            'attribute_id' => $attributeId,
                            'attribute_value_id' => $valueId,
                        ]);
                    }
                }
            }

            $product->Collections()->sync($request->product_collections);


            DB::commit();
            Session()->flash('success','Product Updated Successfully');

            return response()->json([
                'status' => true,
                'msg'=>'Product Updated Successfully'
            ]);

        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'msg' => 'Failed to update product',
                'error' => $e->getMessage()
            ]);
        }

    }

    public function updateImages(Request $request){
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all(),
            ]);
        }
        if ($request->hasFile('image')) {
            $image = $request->image;

            if ($image->isValid()) {
                $ext = $image->getClientOriginalExtension();
                $sourcePath = $image->getPathName();

                $productImage = new Product_Image();
                $productImage->product_id = $request->product_id;
                $productImage->image = null;
                $productImage->save();

                $imageName =$request->product_id.'-'.$productImage->id.'-'.time().'.webp';

                $productImage->image = $imageName;


                if ($productImage->save()) {

                    $dPath = public_path().'/uploads/products/images/'.$imageName;

                    $manager = new ImageManager(new Driver());
                    $image = $manager->read( $sourcePath);
                    $image->scaleDown(1400);
                    $image->toWebp();
                    $image->save($dPath);


                    //Generate Image Thumbnail
                    $dPath = public_path().'/uploads/products/images/thumb/'.$imageName;
                    $image->resizeDown(300,300);
                    $image =  $image->toWebp();
                    $image->save($dPath);


                    return response()->json([
                        'status' => true,
                        'image_id' => $productImage->id,
                        'ImagePath' => asset('/uploads/products/images/'.$productImage->image),
                        'msg' => 'Image uploaded successfully'
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'errors' => ['Failed to save temporary image']
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'errors' => ['Invalid image file']
                ]);
            }
        }

        return response()->json([
            'status' => false,
            'errors' => ['No image file uploaded']
        ]);
    }



    public function destroy(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $ordersCount = Order_item::where('product_id', $product->id)->count();

        if ($ordersCount > 0) {
            return response()->json([
                'status' => false,
                'msg' => 'Cannot delete Product because it contains Orders'
            ]);
        }

        $product_Images = Product_Image::where('product_id',$id)->get();
        if (!empty($product_Images)){

            //Delete from Folder
            foreach ($product_Images as $image){
                File::delete(public_path('/uploads/products/images/'.$image->image));
                File::delete(public_path('/uploads/products/images/thumb/'.$image->image));
            }
            Product_Image::where('product_id',$id)->delete();


        }
        if ($product->delete()) {
            return response()->json([
                'status' => true,
                'msg' => 'Product Deleted Successfully',
                'deleted_id' => $id
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'Something went wrong',
            ], 500);
        }


    }


    public function deleteImages(Request $request){

        $productImage = Product_Image::findOrFail($request->id);


        //Delete from Folder
        File::delete(public_path('/uploads/products/images/'.$productImage->image));
        File::delete(public_path('/uploads/products/images/thumb/'.$productImage->image));

        $productImage->delete();
        return response()->json([
            'status' => true,
            'msg' => 'Image Deleted Successfully',
        ]);

    }

    public function get_sub_categories(Request $request){

        if (!empty($request->category_id)){

            $subCategory = SubCategory::select('name','id')->where('category_id',$request->category_id)
                ->orderBy('name','ASC')
                ->get();
            return response()->json([
                'status'=>true,
                'subCategory'=>$subCategory
            ]);
        }else{
            return response()->json([
                'status'=>true,
                'subCategory'=>[]
            ]);
        }

    }

    public function getProducts(Request $request){
        $tempProducts=[];

        if (!empty($request->term)){
            $products = Product::where('title','like','%'.$request->term.'%')->get();

            if ($products != null){
                foreach ($products as $product){
                    $img = !empty($product->images->first()) ? asset('uploads/products/images/thumb/'.$product->images->first()->image):  asset('front_assets/images/empty-img.png');

                    $tempProducts[]=array('id'=>$product->id,'text'=>$product->title,'img'=>$img);
                }
            }
        }
        return response()->json([
            'tags'=>$tempProducts,
            'status'=>true
        ]);
    }


}
