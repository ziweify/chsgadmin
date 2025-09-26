<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UploadService
{
    public static function upload($uploadMode,UploadedFile $file,$path){
        if($uploadMode == 'local'){//本地上传模式
            $extension = $file->getClientOriginalExtension();
            $filename = uniqid();
            $filename = $filename.'.'.$extension;
            $url = $file->storeAs($path,$filename,'upload');
            $url = '/upload/'.$url;
        }elseif ($uploadMode == 'oss'){
            $disk = Storage::disk('oss');
            $extension = $file->getClientOriginalExtension();
            $filename = uniqid();
            $url = "/upload/{$path}/".$filename.'.'.$extension;
            $disk->put($url,$file->getContent());
            //$url = $disk->getAdapter()->getUrl($filePath);
        }
        return $url;
    }
}