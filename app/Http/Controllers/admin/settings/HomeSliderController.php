<?php

namespace App\Http\Controllers\admin\settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSliderRequest;
use App\Http\Traits\ImageTrait;
use App\Models\HomeSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class HomeSliderController extends Controller
{
    use ImageTrait;

    function __construct()
    {
        $this->middleware('permission:pages-home-slider', ['only' => ['index','store','edit','update','destroy'] ]);

    }
    public function index()
    {
        $sliders = HomeSlider::paginate(25);
        return view('admin.slider.index',compact('sliders'));
    }

    public function store(StoreSliderRequest $request)
    {
        DB::beginTransaction();
        try {
            $slider = HomeSlider::create($request->except('image'));
            if (!empty($request->image)){

                $newImageName =$this->saveImage($request->image,$slider->id,'home_slider');

                $slider->image = $newImageName;
                $slider->save();

            }

            DB::commit();

            $request->session()->flash('success','Slide Created successfully');

            return response()->json([
                'status' =>true,
                'msg' =>'Slide Created successfully'
            ]);

        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'msg' => 'Failed to Create Slide',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function edit($id)
    {
        $slider = HomeSlider::findOrFail($id);
        return view('admin.slider.edit',compact('slider'))->render();
    }

    public function update(StoreSliderRequest $request, $id)
    {
        $slider = HomeSlider::findOrFail($id);

        DB::beginTransaction();
        try {

            if (!empty($request->image)){
                File::delete(public_path('/uploads/home_slider/images/'.$slider->image));

                $newImageName =$this->saveImage($request->image,$slider->id,'home_slider');
                $slider->image = $newImageName;
                $slider->save();
            }
            $slider->update($request->except('image'));

            DB::commit();

            $request->session()->flash('success','Slide Created successfully');

            return response()->json([
                'status' =>true,
                'msg' =>'Slide Created successfully'
            ]);

        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'msg' => 'Failed to Create Slide',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        $slider = HomeSlider::findOrFail($id);


        File::delete(public_path('/uploads/home_slider/images/'.$slider->image));


        if ($slider->delete()) {
            return response()->json([
                'status' => true,
                'msg' => 'Slider Deleted Successfully',
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
