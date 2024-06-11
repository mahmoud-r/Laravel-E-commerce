<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductRating;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{
    public function index(Request $request, $categorySlug=null,$subCategorySlug=null){

        $categorySelected = '';
        $subCategorySelected = '';
        $brandArray =[];
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

        $brands = Brand::where('status',1)->select('id','name');
        $products = Product::where('status',1);

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
        // Apply Price Filter
        $maxPrice = $products->max('price');
        $minPrice = $products->min('price');

        if (!empty($request->get('brand'))){
            $brandArray = explode(',',$request->get('brand'));
            $products =$products->whereIn('brand_id',$brandArray);
        }

        if ($request->get('price_min') != '' && $request->get('price_max') != '' ){

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


        $brands = $brands->orderBy('id','DESC')->get();

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
            'searchQuery'

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
            $relatedProducts = Product::whereIn('id',$productArray)->get();
        }else{
            $relatedProducts = Product::where('category_id', $product->category_id)->where('id', '!=', $product->id)->take(6)->get();
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
            ->latest()->paginate(12);


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
                'msg'=>'You already rated this product.'
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
