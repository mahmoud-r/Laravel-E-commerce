<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Traits\ImageTrait;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order_item;
use App\Models\Product;
use App\Models\Product_Image;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProductController extends Controller
{
    use ImageTrait;
    public function index(Request $request)
    {

        $products = Product::select('id','title','price','qty','sku','status')->latest('id');

        if (!empty($request->keyword)){
            $products= $products->where('title','like','%'.$request->keyword.'%')
            ->orwhere('sku','like','%'.$request->keyword.'%');
        }

        $products=  $products->paginate(10);

        return view('admin/products/index',compact('products'));
    }


    public function create()
    {
        $categories = Category::select('name','id')->orderBy('name','ASC')->get();
        $brands = Brand::select('name','id')->orderBy('name','ASC')->get();

        return view('admin/products/create',compact('categories','brands'));
    }

    public function store(StoreProductRequest $request)
    {
        $slug = Str::slug($request->slug);

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
            'is_featured'=>$request->is_featured,
            'sku'=>$request->sku,
            'weight'=>$request->weight,
            'max_order'=>$request->max_order,
            'qty'=>$request->qty,
            'status'=>$request->status,
            'warranty'=>$request->warranty,
            'return'=>$request->return,
            'cachDelivery'=>$request->cachDelivery,
            'related_product'=>(!empty($request->relatedProducts))?implode(',',$request->relatedProducts):'',

        ]);

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

        Session()->flash('success','Product Created Successfully');

        return response()->json([
            'status' => true,
            'msg'=>'Product Created Successfully'
        ]);
    }

    public function edit( $id)
    {
        $product = Product::findOrFail($id);

        $categories = Category::select('name','id')->orderBy('name','ASC')->get();

        $brands = brand::select('name','id')->orderBy('name','ASC')->get();

        $subCategories = SubCategory::where('category_id',$product->category_id)
            ->select('name','id')->orderBy('name','ASC')->get();

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
            'relatedProduct'
        )));
    }


    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        $slug = Str::slug($request->slug);

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
            'is_featured'=>$request->is_featured,
            'sku'=>$request->sku,
            'weight'=>$request->weight,
            'max_order'=>$request->max_order,
            'qty'=>$request->qty,
            'status'=>$request->status,
            'warranty'=>$request->warranty,
            'return'=>$request->return,
            'cachDelivery'=>$request->cachDelivery,
            'related_product'=>(!empty($request->relatedProducts))?implode(',',$request->relatedProducts):'',
        ]);

        Session()->flash('success','Product Updated Successfully');

        return response()->json([
            'status' => true,
            'msg'=>'Product Updated Successfully'
        ]);

    }

    public function updateImages(Request $request){
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
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

                $imageName =$request->product_id.'-'.$productImage->id.'-'.time().'.'.$ext;

                $productImage->image = $imageName;


                if ($productImage->save()) {

                    $dPath = public_path().'/uploads/products/images/'.$imageName;

                    $manager = new ImageManager(new Driver());
                    $image = $manager->read( $sourcePath);
                    $image->scaleDown(1400);
                    $image->save($dPath);


                    //Generate Image Thumbnail
                    $dPath = public_path().'/uploads/products/images/thumb/'.$imageName;
                    $image->resizeDown(300,300);
                    $image->save($dPath);


                    return response()->json([
                        'status' => true,
                        'image_id' => $productImage->id,
                        'ImagePath' => asset('/uploads/products/images/thumb/'.$productImage->image),
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
                    $tempProducts[]=array('id'=>$product->id,'text'=>$product->title);
                }
            }
        }
        return response()->json([
            'tags'=>$tempProducts,
            'status'=>true
        ]);
    }
}
