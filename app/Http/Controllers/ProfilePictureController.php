<?php

namespace App\Http\Controllers;

use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ProfilePictureController extends Controller
{
    //  jpg
    protected $path = "public".DIRECTORY_SEPARATOR."avatar".DIRECTORY_SEPARATOR;
    protected $extension = '.jpg';
    protected $tmp = 'tmp'.DIRECTORY_SEPARATOR;

    public function getPic($id) {
        //Check permissions
            try {
                $path = $this->path.$id.$this->extension;
                $contents = Storage::get($path);
                $mimetype = Storage::mimeType($path);
            }
            catch (\Exception $exception) {
                $path = resource_path('img'.DIRECTORY_SEPARATOR."0.jpg");
                $contents = file_get_contents($path);
                $mimetype = "image/jpeg";
            }


            $response = Response::make($contents, 200);
            $response->header("Content-Type", $mimetype);

            return $response;
    }
    public function deletePic($id) {
        if(Auth::id() == $id) {
            try {
                $path = $this->path.$id.$this->extension;
                Storage::delete($path);
            }
            catch (\Exception $exception) {

            }
            return response()->json(['success'=>'true'], 200);
        }
        else {
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }
    public function uploadPic(Request $request, $id) {

            $file = $request->file('profile_pic');
            $mime_type =  $file->getClientMimeType();


            $path = $file->store($this->path);


            $path_app = 'app'.DIRECTORY_SEPARATOR.$path;
            $path_new = 'app'.DIRECTORY_SEPARATOR.$this->path.$id.$this->extension;
            if($mime_type == 'image/png') {
                $image = imagecreatefrompng(storage_path($path_app));
                $size = max(imagesx($image), imagesy($image));
                $bg = imagecreatetruecolor(300, 300);
                imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
                imagealphablending($bg, TRUE);
                imagecopyresized (
                    $bg,
                    $image,
                    ($size-imagesx($image))/2,
                    ($size-imagesy($image))/2,
                    0,
                    0,
                    300,
                    300,
                    imagesx($image),
                    imagesy($image));
                imagedestroy($image);
                $quality = 50; // 0 = worst / smaller file, 100 = better / bigger file
                imagejpeg($bg, storage_path($path_new), $quality);
                imagedestroy($bg);

                Storage::delete($path);
                return response()->json(['success'=>'true'], 200);
            }
            elseif($mime_type == 'image/jpeg') {

                $image = imagecreatefromjpeg(storage_path($path_app));
                $size = max(imagesx($image), imagesy($image));
                $bg = imagecreatetruecolor($size, $size);
                imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
                imagealphablending($bg, TRUE);
                imagecopy($bg, $image,  ($size-imagesx($image))/2, ($size-imagesy($image))/2, 0, 0, imagesx($image), imagesy($image));

                imagedestroy($image);
                $quality = 50; // 0 = worst / smaller file, 100 = better / bigger file
                imagejpeg($bg, storage_path($path_new), $quality);
                imagedestroy($bg);

                Storage::delete($path);
                return response()->json(['success'=>'true'], 200);
            }
            else {
                return response()->json(['error'=>'wrong_profile_pic_format'], 200);
            }


    }
}
