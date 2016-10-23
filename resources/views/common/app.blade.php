<html>
<head>
    <title>@yield('title')</title>
    <link rel="icon" href="/Blog/public/images/icon/favicon1.ico">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">
    @yield('title_css')
    <script src="/Blog/public/js/jQuery/jquery.min.js"></script>
    @yield('title_js')
</head>
<body>

<div class="container" >
    @yield('content')
</div>

</body>
    @yield('foot_js')
</html>