@extends('layouts.admin')
@section('content')
        <!--面包屑配置项 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 配置项管理
</div>
<!--面包屑配置项 结束-->


<!--搜索结果页面 列表 开始-->
<div class="result_wrap">
    <!--快捷配置项 开始-->
    <!--快捷配置项 开始-->
    <div class="result_title">
        <h3>配置项列表</h3>
        @if(count($errors)>0)
            <div class="mark">
                <p style="color: #3c763d;">{{$errors}}</p>
            </div>
        @endif
    </div>
    <div class="result_content">
        <div class="short_wrap">
            <a href="{{url('admin/config/create')}}"><i class="fa fa-plus"></i>添加配置项</a>
            <a href="{{url('admin/config/')}}"><i class="fa fa-recycle"></i>全部配置项</a>
        </div>
    </div>
    <!--快捷配置项 结束-->
    <!--快捷配置项 结束-->
</div>

<div class="result_wrap">
    <div class="result_content">
        <form method="post" action="{{url('admin/config/changecontent')}}">
            {{csrf_field()}}
            <table class="list_tab">
                <tr>
                    <th class="tc" width="5%">排序</th>
                    <th class="tc" width="5%">ID</th>
                    <th>标题</th>
                    <th>名称</th>
                    <th>内容</th>
                    <th>操作</th>
                </tr>

                @foreach($data as $value)
                    <tr>
                        <td class="tc">
                            <input type="text" onchange="changeOrder(this,{{$value->conf_id}})"
                                   value="{{$value->conf_order}}">
                        </td>
                        <td class="tc">{{$value->conf_id}}</td>
                        <td>
                            <a href="#">{{$value->conf_title}}</a>
                        </td>
                        <td>{{$value->conf_name}}</td>
                        <td>
                            <input type="hidden" name="conf_id[]" value="{{$value->conf_id}}">
                            {!! $value->_html !!}
                        </td>
                        <td>
                            <a href="{{url('admin/config/'.$value->conf_id.'/edit')}}">修改</a>
                            <a href="javascript: void(0);" onclick="delNav({{$value->conf_id}})">删除</a>
                        </td>
                    </tr>
                @endforeach

            </table>
            <div class="btn_group">
                <input type="submit" value="提交">
                <input type="button" class="back" onclick="history.go(-1)" value="返回">
            </div>
        </form>


        <div class="page_list">
            {{--{{$data->config()}}--}}
        </div>
    </div>
</div>
<!--搜索结果页面 列表 结束-->

<script>
    function changeOrder(obj, conf_id) {
        var conf_order = $(obj).val();

        $.post("{{url('admin/config/changeorder')}}",
                {'_token': '{{csrf_token()}}', 'conf_id': conf_id, 'conf_order': conf_order},
                function (data) {
                    if (data.status) {
                        layer.msg(data.msg, {icon: 6})
                    } else {
                        layer.msg(data.msg, {icon: 5})
                    }
                });
    }

    //删除配置项
    function delNav(conf_id) {
        layer.confirm('你确定删除这个配置项吗?', {
            btn: ['确定', '取消']//按钮部分,
        }, function () {
            $.post("{{url('admin/config/')}}/" + conf_id, {
                '_method': 'delete',
                '_token': "{{csrf_token()}}"
            }, function (data) {
                if (data.status == 1) {
                    location.href = location.href;
                    layer.msg(data.msg, {icon: 6});
                } else {
                    layer.msg(data.msg, {icon: 5});
                }
            });
        }, function () {

        });
    }
</script>
@endsection
