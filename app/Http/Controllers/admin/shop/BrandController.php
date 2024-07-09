<?php

namespace App\Http\Controllers\admin\shop;

use App\Http\Controllers\Controller;
use App\Http\Traits\ImageTrait;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BrandController extends Controller
{
        use ImageTrait;

    function __construct()
    {
        $this->middleware('permission:brand-list|brand-create|brand-edit|brand-delete', ['only' => ['index','store','getAll'] ]);
        $this->middleware('permission:brand-create', ['only' => ['create','store']]);
        $this->middleware('permission:brand-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:brand-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('admin/brands/index');
    }

    public function getAll() {
        $brands = Brand::latest()->get();
        return response()->json($brands);
    }

    public function create()
    {
        return view('admin/brands/create');
    }


    public function store(Request $request)
    {
        $vlidator = Validator::make($request->all(),[
            'name' =>'required',
            'slug' => 'required|unique:brands',
            'status' => 'required|boolean',

        ]);


        if ($vlidator->passes()){
            $slug = Str::slug($request->slug);

           $brand= Brand::create([
                'name'=>$request->name,
                'slug'=>$slug,
            ]);

            if (!empty($request->image_id)){

               $newImageName= $this->saveImage($request->image_id,$brand->id,'brands');
                $this->saveThumbnail('brands', $newImageName);

                $brand->image =$newImageName;
                $brand->save();

                session()->flash('success','Brand Created successfully');

                return response()->json([
                    'status' => true,
                    'msg'=>'Brand Created Successfully',

                ]);


            }else{
                return response()->json([
                    'status'=>false,
                    'errors'=>$vlidator->errors()
                ]);
            }


        }

    }




    public function edit($id)
    {
        $brand = Brand::findOrFail($id);

        return view('admin/brands/edit',compact('brand'));
    }


    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,'.$brand->id.'id',
            'status' => 'required|boolean',

        ]);

        if ($validator->passes()){
            $slug = Str::slug($request->slug);
            $oldImage = $brand->image;

            $brand->update([
                'name' =>$request->name,
                'status' => $request->status,
                'slug' => $slug,
            ]);

            if (!empty($request->image_id)){

                $newImageName = $this->saveImage($request->image_id,$brand->id,'brands');
                $this->saveThumbnail('brands', $newImageName);

                $brand->image = $newImageName;
                $brand->save();

                //Delete old image
                File::delete(public_path('/uploads/brands/images/'.$oldImage));
                File::delete(public_path('/uploads/brands/images/thumb/'.$oldImage));
            }
            Session()->flash('success','the Brand Edit Successfully');
            return response()->json([
                'status'=>true,
                'msg'=>'the Brand Edit Successfully'
            ]);


        }else{

            return response()->json([
                'status'=>false,
                'errors'=>$validator->errors()
            ]);

        }



    }


    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);

        $productsCount = Product::where('brand_id', $brand->id)->count();

        if ($productsCount > 0) {
            return response()->json([
                'status' => false,
                'msg' => 'Cannot delete  Brand because it contains products'
            ]);
        }

        File::delete(public_path('/uploads/brands/images/'.$brand->image));
        File::delete(public_path('/uploads/brands/images/thumb/'.$brand->image));


        if ($brand->delete()) {
            return response()->json([
                'status' => true,
                'msg' => 'brand Deleted Successfully',
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
