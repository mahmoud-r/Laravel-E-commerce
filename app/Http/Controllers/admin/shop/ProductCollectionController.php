<?php

namespace App\Http\Controllers\admin\shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductCollectionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:collection-list|collection-create|collection-edit|collection-delete', ['only' => ['index','getAll','edit'] ]);
        $this->middleware('permission:collection-create', ['only' => ['create','store']]);
        $this->middleware('permission:collection-edit', ['only' => ['update','getProducts']]);
        $this->middleware('permission:collection-delete', ['only' => ['destroy']]);

    }

    public function index(Request $request)
    {
        $Collections = ProductCollection::latest();

        if (! empty($request->get('keyword'))){

            $Collections = $Collections->where('name','like','%'.$request->get('keyword').'%')
                ->orwhere('slug','like','%'.$request->get('keyword').'%');

        }

        $Collections =$Collections->paginate(25);
        return view('admin.collections.index',compact('Collections'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required|string|max:255'
        ]);

        if ($validator->fails()){
            return response()->json([
                'status'=>false,
                'errors'=>$validator->errors()
            ]);
        }
        $slug = str::slug($request->name);

        ProductCollection::create([
            'name'=>$request->name,
            'slug'=>$slug
        ]);

        session()->flash('success','Collection Created Successfully');
        return response()->json([
            'status'=>true,
            'msg'=>'Collection Created Successfully'
        ]);

    }


    public function edit( $productCollection)
    {
        $Collection = ProductCollection::findOrFail($productCollection);

        return view('admin.collections.edit',compact('Collection'));
    }


    public function update(Request $request, $productCollection)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required|string|max:255',
            'products'=>'array',
            'status' => 'required|integer|in:0,1',
            'products.*' => 'integer|exists:products,id'
        ]);

        if ($validator->fails()){
            return response()->json([
                'status'=>false,
                'errors'=>$validator->errors()
            ]);
        }
        $Collection = ProductCollection::findOrFail($productCollection);
        $slug = str::slug($request->name);

        $Collection->update([
            'name'=>$request->name,
            'slug'=>$slug,
            'status'=>$request->status
        ]);


        $Collection->products()->sync($request->products);

        session()->flash('success','Collection Updated Successfully');
        return response()->json([
            'status'=>true,
            'msg'=>'Collection Updated Successfully'
        ]);

    }

    public function destroy( $id)
    {
        $Collection = ProductCollection::findOrFail($id);

        if ($Collection->delete()) {
            return response()->json([
                'status' => true,
                'msg' => 'Collection Deleted Successfully',
                'deleted_id' => $id
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'Something went wrong',
            ], 500);
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
