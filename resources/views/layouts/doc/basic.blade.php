<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('title')
    <link rel="stylesheet" href="{{asset('libs/pure/pure-min.css')}}">
    <link rel="stylesheet" href="{{asset('module/common/css/marketing.css')}}">
    <link rel="stylesheet" href="{{asset('module/common/css/sign.css')}}">
    <link rel="stylesheet" href="{{asset('css/pure-tip.css')}}">
    @yield('style')
</head>
<body >
{{--头部导航栏--}}
<div class="header">
    <div class="home-menu pure-menu pure-menu-horizontal pure-menu-fixed">
        <a class="pure-menu-heading" href="">醍醐共享笔记</a>

        <ul class="pure-menu-list">
            <li class="pure-menu-item"><a href="{{route('home')}}" class="pure-menu-link">主页</a></li>
            <li class="pure-menu-item "><a href="{{route('register')}}" class="pure-menu-link">注册</a></li>
            <li class="pure-menu-item"><a href="{{route('login')}}" class="pure-menu-link">登录</a></li>
        </ul>
    </div>
</div>
{{--注册表单--}}
@yield('content')

<div class="footer l-box is-center">
    微想团队版权所有
</div>
<script src="{{asset('/libs/jquery/jquery.min.js')}}"></script>
<script src="{{asset('module/doc/js/pure-tip.js')}}"></script>
@yield('script')

</body>
</html>
