<?php

namespace App\Http\Controllers\admin\shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{

    public function index($category_id)
    {
        $category = Category::findorFail($category_id);

        return view('admin.category.subCategory.index',compact('category'));
    }

    public function getAll($category_id) {
        $category = Category::findorFail($category_id);
        $SubCategories = SubCategory::where('category_id',$category->id)->with('category')->latest()->get();
        return response()->json($SubCategories);
    }

    public function create($category_id)
    {
        $category = Category::findorFail($category_id);
        $categories = Category::orderBy('name','ASC')->get();
        return view('admin.category.subCategory.create',compact('categories','category'));

    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:sub_categories',
            'category' => 'required|exists:categories,id',
            'status' => 'required|boolean',
            'showHome' => 'required|boolean',

        ]);
        $slug =Str::slug($request->slug);

        if ($validator->passes()){

            SubCategory::create([
                'name' => $request->name,
                'status' => $request->status,
                'showHome' => $request->showHome,
                'slug' => $slug,
                'category_id'=>$request->category
            ]);

            $request->session()->flash('success','sub category added successfully');

            return response()->json([
                'status' =>true,
                'msg' =>'sub category added successfully'
            ]);
        }else{
            return response()->json([
                'status' =>false,
                'errors' =>$validator->errors()
            ]);
        }
    }





    public function edit( $id)
    {
        $subCategory= SubCategory::findOrFail($id);

        return view('admin.category.subCategory.edit',compact('subCategory'));
    }


    public function update(Request $request, $id)
    {
        $subCategory= SubCategory::findOrFail($id);

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:sub_categories,slug,'.$subCategory->id.'id',
            'status' => 'required|boolean',
            'showHome' => 'required|boolean',

        ]);
        $slug =Str::slug($request->slug);

        if ($validator->passes()){

            $subCategory->update([
                'name' => $request->name,
                'status' => $request->status,
                'showHome' => $request->showHome,
                'slug' => $slug,
            ]);

            $request->session()->flash('success','sub category edited successfully');

            return response()->json([
                'status' =>true,
                'msg' =>'sub category edited successfully'
            ]);
        }else{
            return response()->json([
                'status' =>false,
                'errors' =>$validator->errors()
            ]);
        }
    }


    public function destroy(Request $request, $id)
    {
        $subCategory = SubCategory::findOrFail($id);

        $productsCount = Product::where('sub_category_id', $subCategory->id)->count();

        if ($productsCount > 0) {
            return response()->json([
                'status' => false,
                'msg' => 'Cannot delete  SubCategory because it contains products'
            ]);
        }

        if ($subCategory->delete()) {
            return response()->json([
                'status' => true,
                'msg' => 'sub Category Deleted Successfully',
                'deleted_id' => $id
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'Something went wrong',
            ], 500);
        }


    }
}
