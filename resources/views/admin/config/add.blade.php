@extends('layouts.admin')
@section('content')

        <!--面包屑配置项 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 配置项管理
</div>
<!--面包屑配置项 结束-->

<!--结果集标题与配置项组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>添加配置项</h3>
        @if(count($errors)>0)
            <div class="mark">
                @if(is_object($errors))
                    @foreach($errors->all() as $error)
                        <p style="color: red">{{$error}}</p>
                    @endforeach
                @else
                    @if($errors=='success')
                        <p style="color: #3c763d;">分类添加成功</p>
                    @else
                        <p style="color: red">{{$errors}}</p>
                    @endif
                @endif
            </div>
        @endif
    </div>
    <div class="result_content">
        <div class="short_wrap">
            <a href="{{url('admin/config/create')}}"><i class="fa fa-plus"></i>添加配置项</a>
            <a href="{{url('admin/config')}}"><i class="fa fa-recycle"></i>配置项列表</a>
        </div>
    </div>
</div>
<!--结果集标题与配置项组件 结束-->

<div class="result_wrap">
    <form action="{{url('admin/config')}}" method="post">
        {{csrf_field()}}
        <table class="add_tab">
            <tbody>

            <tr>
                <th><i class="require">*</i>标题：</th>
                <td>
                    <input type="text" name="conf_title">
                    <span><i class="fa fa-exclamation-circle yellow"></i>配置项标题必须填写</span>
                </td>
            </tr>

            <tr>
                <th><i class="require">*</i>名称：</th>
                <td>
                    <input type="text" name="conf_name">
                    <span><i class="fa fa-exclamation-circle yellow"></i>配置项名称必须填写</span>
                </td>
            </tr>

            <tr>
                <th>类型：</th>
                <td>
                    <input type="radio" name="field_type" value="input" checked onclick="showVal()">input　
                    <input type="radio" name="field_type" value="textarea" onclick="showVal()">textarea　
                    <input type="radio" name="field_type" value="radio" onclick="showVal()">radio　
                </td>
            </tr>

            <tr class="showVal">
                <th>类型值：</th>
                <td>
                    <input type="text" class="lg" name="field_value">
                    <p><i class="fa fa-exclamation-circle yellow"></i>类型值只有在类型为radio时才需要配置 1|开始 , 0|关闭</p>
                </td>
            </tr>

            <tr>
                <th>排序：</th>
                <td>
                    <input type="text" class="sm" name="conf_order" value="0">
                </td>
            </tr>

            <tr>
                <th>说明：</th>
                <td>
                    <textarea cols="30" rows="10" name="conf_tips"></textarea>
                </td>
            </tr>

            <tr>
                <th></th>
                <td>
                    <input type="submit" value="提交">
                    <input type="button" class="back" onclick="history.go(-1)" value="返回">
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
<script>
    showVal();
   function showVal(){
       var type = $('input[name=field_type]:checked').val();
       if(type=='radio'){
           $('.showVal').show();
       }else{
           $('.showVal').hide();
       }
   }
</script>

@endsection