<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class TempImagesController extends Controller
{
    public function create(Request $request)
    {
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
            $image = $request->file('image');

            if ($image->isValid()) {
                $ext = $image->getClientOriginalExtension();
                $newName = time() . '.' . $ext;

                $tempImage = new TempImage();
                $tempImage->name = null;
                $tempImage->save();

                $newName = $tempImage->id.'-'.time() . '.' . $ext;

                $tempImage->name = $newName;
                $tempImage->save();

                if ($tempImage->save()) {
                    $image->move(public_path() . '/temp', $newName);

                    //Generate Image Thumbnail
                    $manager = new ImageManager(new Driver());
                    $sourcePath = public_path() . '/temp/'. $newName;
                    $thumbnailPath = public_path() . '/temp/thumb/'. $newName;

                    $image = $manager->read( $sourcePath);

                    $image->resizeDown(300, 275);

                    $image->save($thumbnailPath);

                    return response()->json([
                        'status' => true,
                        'image_id' => $tempImage->id,
                        'ImagePath' => asset('/temp/thumb/'. $newName),
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
}
