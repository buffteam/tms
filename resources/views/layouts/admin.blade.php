<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', '管理界面') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('libs/mdui/css/mdui.min.css') }}" >
    <link rel="stylesheet" href="{{ asset('module/admin/dashboard.css') }}" >
    @yield('style')
</head>
<body class="mdui-theme-primary-deep-purple  mdui-drawer-body-left">
<header class="mdui-appbar mdui-appbar-fixed ">
    <div class="mdui-toolbar mdui-color-theme">
        <span class="mdui-btn mdui-btn-icon mdui-ripple mdui-ripple-white" mdui-drawer="{target: '#mdui-drawer'}"><i
                    class="mdui-icon material-icons">menu</i></span>
        <a href="{{route('dashboard')}}" class="mdui-typo-headline mdui-hidden-xs">{{ config('app.name', '管理界面') }}</a>
        {{--<a href="" class="mdui-typo-title">抽屉式导航栏</a>--}}
        <div class="mdui-toolbar-spacer"></div>
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

    </div>
</header>

<div class="mdui-drawer mdui-color-grey-50" id="mdui-drawer" style="top:64px;">
    <ul class="mdui-list" mdui-collapse="{accordion: true}">

        <li class="mdui-list-item mdui-ripple">
            <i class="mdui-icon material-icons">&#xe88a;</i>
            <div class="mdui-list-item-content"><a href="{{url('/')}}">主页</a></div>
        </li>

        <li class="mdui-list-item mdui-ripple">
            <i class="mdui-icon material-icons">&#xe871;</i>
            <div class="mdui-list-item-content"><a href="{{url('/admin')}}">Dashboard</a></div>
        </li>

        <li class="mdui-collapse-item mdui-collapse-item-open">
            <div class="mdui-collapse-item-header mdui-list-item mdui-ripple">
                <i class="mdui-list-item-icon mdui-icon material-icons">people</i>
                <div class="mdui-list-item-content">系统设置</div>
                <i class="mdui-collapse-item-arrow mdui-icon material-icons">keyboard_arrow_down</i>
            </div>
            <ul class="mdui-collapse-item-body mdui-list mdui-list-dense">
                <li class="mdui-list-item mdui-ripple"><a href="{{url('admin/navSetting')}}">导航栏设置</a></li>
                <li class="mdui-list-item mdui-ripple"> <a href="{{url('admin/account')}}">账号审核</a></li>
                {{--<li class="mdui-list-item mdui-ripple">修改</li>--}}
                {{--<li class="mdui-list-item mdui-ripple">New vs Returning</li>--}}
            </ul>
        </li>

        <li class="mdui-list-item mdui-ripple">
            <i class="mdui-icon material-icons">&#xe87f;</i>
            <div class="mdui-list-item-content"><a href="{{url('admin/feedback')}}">问题反馈</a></div>
        </li>

    </ul>
</div>

<div class="mdui-container-fluid main-content">
    @yield('content')
</div>


<!-- Scripts -->
<script src="{{ asset('libs/mdui/js/mdui.min.js') }}"></script>
<script>
    var inst = new mdui.Menu('#open', '#menu');

</script>
@yield('script')
</body>
</html>

