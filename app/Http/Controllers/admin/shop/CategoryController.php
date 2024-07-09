<?php

namespace App\Http\Controllers\admin\shop;

use App\Http\Controllers\Controller;
use App\Http\Traits\ImageTrait;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

    use ImageTrait;

    function __construct()
    {
        $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['index','getAll'] ]);
        $this->middleware('permission:category-create', ['only' => ['create','store']]);
        $this->middleware('permission:category-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:category-delete', ['only' => ['destroy']]);

    }



    public function index()
    {

        return view('admin/category/index');
    }
    public function getAll() {
        $categories = Category::latest()->get();
        return response()->json($categories);
    }

    public function create()
    {

        return view('admin/category/create');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
           'name' => 'required',
           'slug' => 'required|unique:categories',
            'status' => 'required|boolean',
            'showHome' => 'required|boolean',
            'sort' => 'required|integer',
        ]);
        $slug =Str::slug($request->slug);

        if ($validator->fails()){
            return response()->json([
                'status' =>false,
                'errors' =>$validator->errors()
            ]);
        }
        $category = Category::create([
            'name' => $request->name,
            'status' => $request->status,
            'showHome' => $request->showHome,
            'slug' => $slug,
            'sort' => $request->sort,
        ]);
//            save Image
        if (!empty($request->image_id)){

            $newImageName =$this->saveImage($request->image_id,$category->id,'category');
            $this->saveThumbnail('category', $newImageName);

            $category->image = $newImageName;
            $category->save();

        }

        $request->session()->flash('success','category added successfully');

        return response()->json([
            'status' =>true,
            'msg' =>'category added successfully'
        ]);
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit',compact('category'));
    }
    public function update(Request $request,  $id)
    {
        $category = Category::findOrFail($id);

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,'.$category->id.'id',
            'status' => 'required|boolean',
            'showHome' => 'required|boolean',
            'sort' => 'required|integer',


        ]);
        $slug =Str::slug($request->slug);


        if ($validator->fails()){
            return response()->json([
                'status' =>false,
                'errors' =>$validator->errors()
            ]);
        }
        $oldImage = $category->image;
        $category->update([
            'name'=>$request->name,
            'status'=>$request->status,
            'showHome'=>$request->showHome,
            'sort' => $request->sort,
            'slug'=>$slug,
        ]);

//            save Image
        if (!empty($request->image_id)){


            $newImageName =$this->saveImage($request->image_id,$category->id,'category');
            $this->saveThumbnail('category', $newImageName);

            $category->image = $newImageName;
            $category->save();

            //Delete old image

            File::delete(public_path('/uploads/category/images/'.$oldImage));
            File::delete(public_path('/uploads/category/images/thumb/'.$oldImage));
        }

        $request->session()->flash('success','category edited successfully');

        return response()->json([
            'status' =>true,
            'msg' =>'category edited successfully'
        ]);

    }

    public function destroy(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $productsCount = Product::where('category_id', $category->id)->count();

        if ($productsCount > 0) {
            return response()->json([
                'status' => false,
                'msg' => 'Cannot delete  category because it contains products'
            ]);
        }

        File::delete(public_path('/uploads/category/images/'.$category->image));
        File::delete(public_path('/uploads/category/images/thumb/'.$category->image));


        if ($category->delete()) {
            return response()->json([
                'status' => true,
                'msg' => 'Category Deleted Successfully',
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
