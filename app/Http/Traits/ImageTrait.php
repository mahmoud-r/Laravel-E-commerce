<?php

namespace App\Http\Traits;

use App\Models\TempImage;
use Illuminate\Support\Facades\File;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

trait ImageTrait
{
    public function saveImage($image_id,$uniqid,$folderName,$width = '')
    {
        $tempImage = TempImage::find($image_id);
        $extArray = explode('.',$tempImage->name);
        $ext = last($extArray);
        $newImageName = $uniqid.'-'.time().'.'.$ext ;
        $sPath = public_path().'/temp/'.$tempImage->name;
        $dPath = public_path().'/uploads/'.$folderName.'/images/'.$newImageName;


        if (File::copy($sPath, $dPath)) {

            if (!empty($width)){
                $this->scaleImage($folderName,$width,$newImageName);
            }
//            File::delete($sPath);
//            if (File::exists($sPath)) {
//                File::delete($sPath);
//                $tempImage->delete();
//            }
        }


        return $newImageName;
    }

    public function saveThumbnail($folderName, $ImageName, $width = 300,$height=300)
    {
        //Generate Image Thumbnail
        $manager = new ImageManager(new Driver());
        $sourcePath = public_path().'/uploads/'.$folderName.'/images/'.$ImageName;
        $thumbnailPath = public_path().'/uploads/'.$folderName.'/images/thumb/'.$ImageName;

        $image = $manager->read( $sourcePath);

        $image->resizeDown($width,$height);



        $image->save($thumbnailPath);

    }



    public function scaleImage($folderName ,$width ,$ImageName){

        $manager = new ImageManager(new Driver());
        $sourcePath = public_path().'/uploads/'.$folderName.'/images/'.$ImageName;
        $image = $manager->read( $sourcePath);

        $image->scaleDown($width);


        $image->save($sourcePath);
    }
}
