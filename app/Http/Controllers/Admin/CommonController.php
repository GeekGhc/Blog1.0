<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use  App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CommonController extends Controller
{
    //图片上传
    public function upload()
    {
        $file = Input::file('Filedata');
        if($file->isValid()){
            $entension = $file->getClientOriginalExtension();//上传文件的后缀
            $newName = str_random(15).'.'.$entension;
            $path = $file->move(base_path().'/public/uploads/',$newName);
            $filePath = 'public/uploads/'.$newName;
            return $filePath;
        }
    }
}
