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
    protected $extension = '.png';
    protected $tmp = 'tmp'.DIRECTORY_SEPARATOR;

    public function getPic($id) {
        //Check permissions
        if(Auth::id() == $id) {
            try {
                $path = $this->path.$id.$this->extension;
                $contents = Storage::get($path);
            }
            catch (\Exception $exception) {
                $path = $this->path.'0'.$this->extension;
                $contents = Storage::get($path);
            }

            $mimetype = Storage::mimeType($path);

            $response = Response::make($contents, 200);
            $response->header("Content-Type", $mimetype);

            return $response;

        }
        else {
            return response()->json(['error'=>'Unauthorised'], 401);
        }
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

        if(Auth::id() == $id) {


            $file = $request->file('profile_pic');
            $mime_type =  $file->getClientMimeType();


            if($mime_type == 'image/png') {
                $path = $file->store($this->path.$this->tmp);


                $path_app = 'app'.$path;
                $path_new = 'app'.$this->path.$id.$this->extension;

                $image = imagecreatefrompng(storage_path($path_app));
                $bg = imagecreatetruecolor(imagesx($image), imagesy($image));
                imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
                imagealphablending($bg, TRUE);
                imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
                imagedestroy($image);
                $quality = 50; // 0 = worst / smaller file, 100 = better / bigger file
                imagejpeg($bg, storage_path($path_new), $quality);
                imagedestroy($bg);

                Storage::delete($path);
                return response()->json(['success'=>'true'], 200);
            }
            elseif($mime_type == 'image/jpeg') {
                $file->storeAs(
                    $this->path, $id.$this->extension
                );
                return response()->json(['success'=>'true'], 200);
            }
            else {
                return response()->json(['error'=>'wrong_profile_pic_format'], 200);
            }
        }
        else {
            return response()->json(['error'=>'Unauthorised'], 401);
        }

    }
}
