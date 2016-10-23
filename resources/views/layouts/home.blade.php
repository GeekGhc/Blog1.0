<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    @yield('info')
    <link href="{{asset('resources/views/home/css/base.css')}}" rel="stylesheet">
    {{--<link href="{{asset('resources/views/home/css/index.css')}}" rel="stylesheet">--}}
    @yield('head-css')
    <!--[if lt IE 9]>
    <script src="{{asset('resources/views/home/js/modernizr.js')}}"></script>
    <![endif]-->
</head>
<body>
<header>
    <div id="logo"><a href="{{url('/')}}"></a></div>
    <nav class="topnav" id="topnav">
        @foreach($navs as $k=>$value)
            <a href="{{$value->nav_url}}"><span>{{$value->nav_name}}</span><span class="en">{{$value->nav_alias}}</span></a>
        @endforeach
    </nav>
</header>

@section('content')
    <h3>
        <p>最新<span>文章</span></p>
    </h3>
    <ul class="rank">
        @foreach($new as $n)
            <li><a href="{{url('article/'.$n->art_id)}}" title="{{$n->art_title}}"
                   target="_blank">{{$n->art_title}}</a></li>
        @endforeach
    </ul>
    <h3 class="ph">
        <p>点击<span>排行</span></p>
    </h3>
    <ul class="paih">
        @foreach($hot as $h)
            <li><a href="{{url('article/'.$h->art_id)}}" title="{{$h->art_title}}"
                   target="_blank">{{$h->art_title}}</a></li>
        @endforeach
    </ul>
@show


<footer>
    <p>
        CopyRight @ JellyBean<a href="http://www.gehuachun.com/" target="_blank">http://www.gehuachun.com</a>
    </p>
</footer>
{{--<script src="{{asset('resources/views/home/js/silder.js')}}"></script>--}}
</body>
</html>
