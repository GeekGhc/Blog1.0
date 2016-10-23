<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Models\User;
use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;


class IndexController extends CommonController
{

    public function index()
    {
        return view('admin.index');
    }

    public function info()
    {
        return view('admin.info');
    }

    //修改用户密码(格式等判断可通过建立Request来判断 Validator现在用的不多)
    public function password()
    {
        if ($input = Input::all()) {
            $rules = [
                'password'=>'required|between:3,20|confirmed',

            ];
            $message = [
                'password.required'=>'新密码不能为空',
                'password.between'=>'新密码的长度在6-20位之间',
                'password.confirmed'=>'新密码和确认密码不一致'
            ];
            $validator = Validator::make($input,$rules,$message);

            //判断validator  如果错误返回错误信息
            if($validator->passes()){
                $user = User::findOrFail(1);
                $_password = Crypt::decrypt($user->user_pwd);
                if($input['password_o']==$_password){
                    $user->user_pwd = Crypt::encrypt($input['password']);
//                    return $user;
                    $user->update();
                    return Redirect::back()->with('errors','success');
                }else{
                    return Redirect::back()->with('errors','原密码错误');
                }
                echo $_password;
            }else{
                //打印错误信息
//                dd($validator->errors()->all());

                return Redirect::back()->withErrors($validator);
            }
        } else {
            return view('admin.password');
        }
    }
}
