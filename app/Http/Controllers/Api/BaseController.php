<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helper;
use App\Models\category;
use App\Models\LokasiTempat;
use App\Models\Tempat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BaseController extends Controller
{
    use Helper;

    public function upload(Request $request, $path){
        $fileName = "";
        if($request->image){
            $image = $request->image->getClientOriginalName();
            $image = str_replace(' ', '', $image);
            $image = date('Hs') . rand(1,999) . "_" . $image;
            $fileName = $image;
            $request->image->storeAs('public/' . $path, $image);

            return  $this->success($fileName);
        }else{
            return $this->error("Image wajib di kirim");
        }
    }

    public function saveImage($request, $location, $default = ''){
        $fileName = $default;
        $image = $request->image;
        if($image->getClientOriginalName()){
            $file = str_replace(' ', '', $image->getClientOriginalName());
            $ext = "";
            if(str_contains($file,'.jpg')){
                $ext = '.jpg';
            } else if(str_contains($file,'.png')){
                $ext = '.png';
            } else if(str_contains($file,'.png')){
                $ext = '.png';
            }

            $fileName = $location . '-' . date('mdHs') . rand(1,999) . "_" . $ext;
            $tokoSlug = $this->getToko($request)->slug;
            $fileLocation = $tokoSlug . '/' . $location;
            $image->storeAs('public/' . $fileLocation, $fileName);

        }
        return $fileName;
    }

}
