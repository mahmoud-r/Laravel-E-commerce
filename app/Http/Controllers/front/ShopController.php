<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCollection;
use App\Models\ProductRating;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ShopController extends Controller
{
    public function index(Request $request, $categorySlug=null,$subCategorySlug=null){

        $categorySelected = '';
        $subCategorySelected = '';
        $priceMinSelected =$request->get('price_min');
        $priceMaxSelected =$request->get('price_max');
        $brandArray =[];
        $collectionArray =[];
        $attributeFilters = $request->except(['sort','Showing','search','category','price_max','price_min','collection','page','brand']);
        $sort = $request->get('sort');
        $Showing = $request->get('Showing');
        $searchQuery = $request->get('search');
        if ( $request->get('category')){
            $categorySlug =  $request->get('category');
        }


        $categoreis = Category::where('status', 1)
            ->whereHas('products')
            ->orWhereHas('subCategories.products')
            ->with('subCategories')
            ->select('id', 'name', 'slug')
            ->latest()
            ->get();

        $brands = Brand::where('status',1)->select('id','name','slug');
        $products = Product::IsActive();

        //apply Filter

        // Apply Category Filter
         if (!empty($categorySlug)){
                    $category = Category::where('slug',$categorySlug)->first();
                    $products = $products->where('category_id',$category->id);


                    $categorySelected= $category->id;
                    $brands_id = $category->products()->distinct('brand_id')->pluck('brand_id');
                    $brands = $brands->whereIn('id', $brands_id);

         }

        // Apply SubCategory Filter
         if (!empty($subCategorySlug)){
                $sub_category = SubCategory::where('slug',$subCategorySlug)->first();
                $products = $products->where('sub_category_id',$sub_category->id);
                $subCategorySelected= $sub_category->id;
                $brands_id = $sub_category->products()->distinct('brand_id')->pluck('brand_id');
                $brands = $brands->whereIn('id', $brands_id);

            }

        // Apply Search Filter
        if (!empty($searchQuery)) {
            $products = $products->where(function ($query) use ($searchQuery) {
                $query->where('title', 'LIKE', "%{$searchQuery}%")
                    ->orWhere('description', 'LIKE', "%{$searchQuery}%");
            });
        }


        // Apply Attribute Filters
        if (!empty($attributeFilters)) {
            $products = $products->where(function ($query) use ($attributeFilters) {
                foreach ($attributeFilters as $attributeName => $values) {
                    $valueArray = explode(',', $values);
                    $query->whereHas('attributeValues', function ($query) use ($attributeName, $valueArray) {
                        $query->whereHas('attribute', function ($query) use ($attributeName) {
                            $query->where('slug', $attributeName);
                        })->whereIn('slug', $valueArray);
                    });
                }
            });
        }



        //  Price Filter
        $maxPrice = $products->max('price');
        $minPrice = $products->min('price');


        // Apply Brand Filter
        if (!empty($request->get('brand'))){
            $brandArray = explode(',',$request->get('brand'));
//            $products =$products->whereIn('brand_id',$brandArray);
            $products =$products->whereHas('brand',function ($q) use ($brandArray){
                $q->whereIn('slug',$brandArray);
            });
        }

        // Apply collection Filter
        if (!empty($request->get('collection'))){
            $collectionArray = ProductCollection::wherein('slug',explode(',',$request->get('collection')))->pluck('id')->toArray();
            $products =$products->whereHas('Collections',function ($q) use ($collectionArray){
                $q->wherein('product_collection_id',$collectionArray);
            });
        }

        if ($priceMinSelected != '' && $priceMaxSelected != '' ){

            $products =$products->whereBetween('price',[intval($request->get('price_min')),intval($request->get('price_max'))]);

        }




        // Apply Sorting
        if ($sort){
            switch ($sort) {
                case 'latest':
                    $products =$products->orderBy('id','DESC');
                    break;
                case 'price-asc':
                    $products =$products->orderBy('price','asc');
                    break;
                case 'price-desc':
                    $products =$products->orderBy('price','DESC');
                    break;
                default:
                    $products =$products->orderBy('updated_at','DESC');

            }
        }else{
            $products =$products->orderBy('updated_at','DESC');

        }
        if ($Showing && in_array(intval($Showing), [9, 12, 18])){

            $products =$products->paginate($Showing);

        }else{
            $products =$products->paginate(9);

        }

        $attributes = Attribute::whereHas('values.products', function ($query) use ($categorySelected) {
            $query->where('category_id', $categorySelected);
        })->with(['values' => function ($query) use ($categorySelected) {
            $query->whereHas('products', function ($query) use ($categorySelected) {
                $query->where('category_id', $categorySelected);
            });
        }])->get();

        $brands = $brands->orderBy('id','DESC')->get();
        $Collections = ProductCollection::where('status','1')->latest()->get();

        return view('front/shop',compact(
            'categoreis',
            'brands',
            'products',
            'categorySelected',
            'subCategorySelected',
            'brandArray',
            'maxPrice',
            'minPrice',
            'sort',
            'Showing',
            'searchQuery',
            'attributes',
            'attributeFilters',
            'Collections',
            'collectionArray',
            'priceMinSelected',
            'priceMaxSelected',

        ));
    }


    public function product($slug){

        $product = Product::where('slug',$slug)->first();
        if ($product == null){
            abort(404);
        }
        //Related Product
        if ($product->related_product){

            $productArray = explode(',',$product->related_product);
            $relatedProducts = Product::whereIn('id',$productArray)->IsActive()->get();
        }else{
            $relatedProducts = Product::where('category_id', $product->category_id)->where('id', '!=', $product->id)->IsActive()->take(6)->get();
        }


        return view('front.product',compact('product','relatedProducts'));
    }



    public function quickView($id) {
        $product = Product::findOrFail($id);
        return view('front.popup.shop-quick-view', compact('product'));
    }

    public function search(Request $request)
    {
        $query = $request->input('search');
        $categorySlug = $request->input('category');

        $products = Product::query();

        if (!empty($categorySlug)) {
            $category = Category::where('slug', $categorySlug)->first();

            if ($category) {
                $products = $products->where('category_id', $category->id);
            }
        }

        $products =$products->where(function ($q) use ($query) {
            return $q->where('title', 'LIKE', "%{$query}%")
                ->orWhere('description', 'LIKE', "%{$query}%");
        })
            ->latest()->IsActive()->paginate(12);


        return view('front.layouts.header.search_results', compact('products','categorySlug','query'))->render();
    }

    public function saveRating(Request $request,$productId){
        $validator = Validator::make($request->all(),[
            'comment'=>'required|min:10',
            'rating'=>'required',
        ]);
        if ($validator->fails()){
            return response()->json([
                'status' =>false,
                'errors'=>$validator->errors()
            ]);
        }
        if (!Auth::check()){
            session()->flash('error','You must login first.');
            return response()->json([
                'status' =>false,
                'rated_before' => true,
                'msg'=>'You must login first.'
            ]);
        }
        $count = ProductRating::where('user_id',Auth::id())->where('product_id',$productId)->count();

        if ($count > 0){
            session()->flash('error','You already rated this product.');
            return response()->json([
                'status' =>false,
                'rated_before' => true,
                'msg'=>'You already rated this product.'.$count
            ]);
        }
        ProductRating::create([
            'user_id'=>Auth::id(),
            'product_id'=>$productId,
            'rating'=>$request->rating,
            'comment'=>$request->comment
        ]);
        session()->flash('success','Thank You for your Rating.');
        return response()->json([
            'status'=>true,
            'msg'=>'Thank You for your Rating'
        ]);

    }

}
