<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', '共享笔记') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('libs/mdui/css/mdui.min.css') }}" >
    @yield('style')

</head>
<body>
<header class="mdui-appbar mdui-appbar-fixed ">
    <div class="mdui-toolbar mdui-color-theme">

        <a href="{{route('dashboard')}}" class="mdui-typo-headline mdui-hidden-xs">{{ config('app.name', '管理界面') }}</a>

        <div class="mdui-toolbar-spacer"></div>
        @if (Route::has('login'))

            @if (Auth::check())

                <button id="open" class="mdui-btn mdui-color-theme-accent mdui-ripple">{{ Auth::user()->name }}<i class="mdui-icon material-icons">&#xe5cf;</i></button>
                <ul class="mdui-menu" id="menu">
                    <li class="mdui-menu-item">
                        <a href="{{ url('/admin') }}"><i class="mdui-icon material-icons">&#xe8b8;</i>系统设置</a>
                    </li>
                    <li class="mdui-menu-item">
                        <a href="{{ route('modify') }}"><i class="mdui-icon material-icons">&#xe32a;</i>修改密码</a>
                    </li>
                    {{--<li class="mdui-menu-item"><a href="{{ route('avatar') }}">上传头像</a></li>--}}
                    <li class="mdui-menu-item"><a class="logout" href="{{ route('logout') }}"
                                                  onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="mdui-icon material-icons">&#xe879;</i> 退出登录
                        </a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </ul>
            @else

                <a href="{{ url('/login') }}">登录</a><a href="{{ url('/register') }}">注册</a>
                {{--</ul>--}}
            @endif
        @endif

    </div>
</header>
<script>
    function GetQueryString(name)
    {
        var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
        var r = window.location.search.substr(1).match(reg);
        if(r!=null)return  unescape(r[2]); return null;
    }
    var skin = GetQueryString('skin'),
        _header = document.querySelector('header');
    _header.classList.add(skin);
    _header.classList.add('is-skin');
</script>

<div class="mdui-container-fluid main-content wrapper">
    @yield('content')
</div>

<script src="{{ asset('libs/mdui/js/mdui.min.js') }}"></script>
<script>
    var inst = new mdui.Menu('#open', '#menu');

</script>
@yield('script')
</body>
</html>

