<?php

namespace App\Http\Controllers\admin\shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttributeRequest;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AttributeController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:attribute-list|attribute-create|attribute-edit|attribute-delete', ['only' => ['index','create','edit','getAllCategories']]);
        $this->middleware('permission:attribute-create', ['only' => ['store']]);
        $this->middleware('permission:attribute-edit', ['only' => ['update']]);
        $this->middleware('permission:attribute-delete', ['only' => ['destroy']]);
    }


    public function index()
    {
        return view('admin.attributes.index');
    }
    public function getAllCategories() {
        $categories = Category::latest()->get();
        return response()->json($categories);
    }


    public function getAllByCategory($id)
    {
        $category = Category::with('attributes.values')->findOrFail($id);
        $attributes = $category->attributes;

        $html = view('admin.products.attributes', compact('attributes'))->render();

        return response()->json(['html' => $html]);
    }


    public function create($categoryId)
    {
        $category = Category::with('attributes')->findOrFail($categoryId);
        return view('admin.attributes.create', compact('category'));
    }


    public function store(StoreAttributeRequest $request)
    {
        $slug= Str::slug($request->name);

        $attribute = Attribute::create([
            'category_id'=>$request->category_id,
            'name' =>$request->name,
            'slug'=>$slug
        ]);

        if ($request->has('values')) {
            foreach ($request->input('values') as $value) {
                $attribute->values()->create(['value' => $value,'slug'=>Str::slug($value)]);
            }
        }
        Session()->flash('success','Attribute Created Successfully');

        return response()->json([
            'status' =>true,
            'msg'=>'Attribute Created Successfully',
            'id'=>$attribute->id
        ]);
    }


    public function edit($id)
    {
        $attribute = Attribute::with('category')->findOrFail($id);
        $category = $attribute->category;
        return view('admin.attributes.edit', compact('attribute', 'category'));
    }


    public function update(StoreAttributeRequest $request, $id)
    {
        $slug= Str::slug($request->name);
        $attribute = Attribute::findOrFail($id);

        $attribute->update([
            'category_id'=>$request->category_id,
            'name' =>$request->name,
            'slug'=>$slug
        ]);

        $newValues = $request->input('values', []);

        $currentValues = $attribute->values->keyBy('id')->toArray();

        foreach ($newValues as $valueData) {
            if (isset($valueData['id']) && !empty($valueData['id']) && isset($currentValues[$valueData['id']])) {
                $attribute->values()->where('id', $valueData['id'])->update([
                    'value' => $valueData['value'],
                    'slug' => Str::slug($valueData['value'])
                ]);
                unset($currentValues[$valueData['id']]);
            } else {
                $attribute->values()->create([
                    'value' => $valueData['value'],
                    'slug' => Str::slug($valueData['value'])
                ]);
            }
        }

        if (!empty($currentValues)) {
            $attribute->values()->whereIn('id', array_keys($currentValues))->delete();
        }

        Session()->flash('success', 'Attribute Updated Successfully');

        return response()->json([
            'status' => true,
            'msg' => 'Attribute Updated Successfully',
            'id' => $attribute->id
        ]);
    }


    public function destroy($id)
    {
        $attribute = Attribute::findOrFail($id);


        if ( $attribute->delete()) {
            Session()->flash('success', $attribute->name . ' Deleted Successfully');
            return response()->json([
                'status' => true,
                'msg' => 'Attribute Deleted Successfully',
                'id' => $attribute->id
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'Something went wrong',
            ], 500);
        }
    }
}
