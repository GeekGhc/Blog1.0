<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

require_once 'resources/org/code/Code.class.php';

class LoginController extends CommonController
{
    //用户登录
    public function login()
    {
        if($input = Input::all()){
            //获取验证码
            $code = new \Code;
            $_code = $code->get();

            //如果验证码错误
            if(strtoupper($input['code'])!=$_code){
                return back()->with('warningMsg','验证码错误');//返回请求前的一个页面
            }

            //获取用户登录名和密码
            $user = User::first();
            if($user->user_name!=$input['user_name']||Crypt::decrypt($user->user_pwd)!=$input['user_pwd']){
                return back()->with('warningMsg','用户名或密码错误');//返回请求前的一个页面
            }
            session(['user'=>$user]);

            //跳转到后台欢迎页面
            return redirect('admin');
        }else{
            return view('admin.login');
        }
    }

    //返回验证码
    public function code()
    {
        $code = new \Code;
        $code->make();
    }

    public function crypt()
    {
        $str = '123';
        echo Crypt::encrypt($str);
    }

    //用户退出登录
    public function logout(){
        //清空session
        session(['user'=>null]);

        return redirect()->route('admin.login');
    }
}
