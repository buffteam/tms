<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('title')
    <link rel="stylesheet" href="{{asset('libs/pure/pure-min.css')}}">
    <link rel="stylesheet" href="{{asset('libs/editormd/css/editormd.min.css')}}">
    <link rel="stylesheet" href="{{asset('libs/wangEditor-3.0.3/wangEditor.min.css')}}">
    <style>
        .markdown-body p {
            font-size: 15px;
        }
    </style>
    @yield('style')
</head>
<body>
<header class="header">
    <div class="logo">云笔记</div>
    <ul class="menu">
        <li>
            <a href="./" target="_blank">首页</a>
        </li>
    </ul>
    <div class="user-info" onclick="main.userDropDown(this,event)">
        <span>{{ Auth::user()->name }}</span>
        <ul class="user-down-list">
            <li><a href="{{ route('modify') }}">修改密码</a></li>
            <li><a class="logout" href="{{ route('logout') }}"
                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    退出登录
                </a>
            </li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </ul>
    </div>
</header>
@yield('content')

<script src="{{asset('/libs/jquery/jquery.min.js')}}"></script>
<script src="{{asset('/libs/template/template-native.js')}}"></script>
<script src="{{asset('/libs/editormd/editormd.min.js')}}"></script>
<script src="{{asset('/libs/nicescroll/jquery.nicescroll.min.js')}}"></script>
<script src="{{asset('/libs/wangEditor-3.0.3/wangEditor.min.js')}}"></script>
<script src="{{asset('/libs/layer-v3.0.3/layer.js')}}"></script>
@yield('script')
<script>
    var _hmt = _hmt || [];
    (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?4dfecf0ae81170fba757c72f3cf83e11";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
</script>

</body>
</html>
