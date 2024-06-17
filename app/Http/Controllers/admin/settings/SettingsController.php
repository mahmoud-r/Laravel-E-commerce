<?php

namespace App\Http\Controllers\admin\settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\storeSetingsRequest;
use App\Http\Traits\ImageTrait;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SettingsController extends Controller
{
    use ImageTrait;
    public function index()
    {
        return view('admin.settings.index');
    }

    public function email(){
        return view('admin.settings.email');
    }
    public function general(){
        return view('admin.settings.general');
    }

    public function store(storeSetingsRequest $request)
    {
        $old_logo = get_setting('store_logo');
        $old_store_logo_white = get_setting('store_logo_white');
        $old_store_favicon_icon = get_setting('favicon_icon');

        $settings = $request->except('_token');
        foreach ($settings as $key => $value) {
            Settings::set($key, $value);
        }

        if (!empty($request->store_logo)){

            File::delete(public_path('/uploads/site/images/'.$old_logo));
            $newImageName =$this->saveImage($request->store_logo,'logo','site');
            $this->scaleImage('site','182',$newImageName);

            Settings::set('store_logo', $newImageName);

        }
        if (!empty($request->store_logo_white)){

            File::delete(public_path('/uploads/site/images/'.$old_store_logo_white));
            $newImageName =$this->saveImage($request->store_logo_white,'logo-white','site');
            $this->scaleImage('site','182',$newImageName);

            Settings::set('store_logo_white', $newImageName);

        }
        if (!empty($request->favicon_icon)){

            File::delete(public_path('/uploads/site/images/'.$old_store_favicon_icon));
            $newImageName =$this->saveImage($request->favicon_icon,'favicon_icon','site');
            $this->scaleImage('site','30',$newImageName);

            Settings::set('favicon_icon', $newImageName);

        }

        return response()->json([
            'status'=>true,
            'msg'=>'Settings saved successfully.'
        ]);
    }


}