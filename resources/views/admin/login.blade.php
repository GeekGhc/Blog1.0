{{--<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="{{ asset('/resources/views/admin/style/css/ch-ui.admin.css') }}">
	<link rel="stylesheet" href="{{ asset('/resources/views/admin/style/font/css/font-awesome.min.css') }}">
</head>
<body style="background:#F3F3F4;">
	<div class="login_box">
		<h1>Blog</h1>
		<h2>欢迎使用博客管理平台</h2>
		<div class="form">
			<p style="color:red">用户名错误</p>
			<form action="#" method="post">
				<ul>
					<li>
					<input type="text" name="username" class="text"/>
						<span><i class="fa fa-user"></i></span>
					</li>
					<li>
						<input type="password" name="password" class="text"/>
						<span><i class="fa fa-lock"></i></span>
					</li>
					<li>
						<input type="text" class="code" name="code"/>
						<span><i class="fa fa-check-square-o"></i></span>
						<img src="{{url('admin/code')}}" alt="" onclick="this.src='{{url('admin/code')}}?'+Math.random()">
					</li>
					<li>
						<input type="submit" value="立即登陆"/>
					</li>
				</ul>
			</form>
			<p><a href="#">返回首页</a> &copy; 2016 Created by Gavin <a href="http://www.gehuachun.com" target="_blank">http://www.gehuachun.club</a></p>
		</div>
	</div>
</body>
</html>--}}

@extends('common/app')
@section('title','iBlog用户注册')

@section('title_css')
    <link rel="stylesheet" href="{{ asset('/public/css/admin/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/font/css/font-awesome.min.css') }}">
@endsection

@section('content')
    <div class="login_box">
        <h1>iBlog</h1>
        <h2 style="color: #35b558;font-weight: bold">欢迎使用博客管理平台</h2>
        @if(session('warningMsg'))
        <p class="warning">{{session('warningMsg')}}</p>
        @endif
        <div class="admin_form">
            {!! Form::open(['url'=>'admin/login']) !!}
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" name="user_name" class="text form-control"/>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="password" name="user_pwd" class="text form-control"/>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-check-square-o"></i></span>
                    <input type="text" class="code form-control" name="code"/>
                    <img class="code-img" src="{{url('admin/code')}}" alt=""
                         onclick="this.src='{{url('admin/code')}}?'+Math.random()">
                </div>
            </div>
            {!! Form::submit('立即登录',['class'=>'btn btn-primary form-control']) !!}
            {!! Form::close() !!}
        </div>
    </div>
    <div class="admin_footer">
        <p>&copy; 2016 Created by Gavin<br><a href="http://www.gehuachun.com"
                                              target="_blank">http://www.gehuachun.com</a>
        </p>
    </div>
@endsection
