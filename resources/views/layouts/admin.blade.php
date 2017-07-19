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
        <a href="./" class="mdui-typo-headline mdui-hidden-xs">{{ config('app.name', '管理界面') }}</a>
        {{--<a href="" class="mdui-typo-title">抽屉式导航栏</a>--}}
        <div class="mdui-toolbar-spacer"></div>
        <span class="mdui-btn mdui-btn-icon mdui-ripple mdui-ripple-white" mdui-dialog="{target: '#dialog-docs-theme'}"
              mdui-tooltip="{content: '设置主题'}"><i class="mdui-icon material-icons">color_lens</i></span>

        <span class="mdui-btn mdui-btn-icon mdui-ripple mdui-ripple-white"><i class="mdui-icon material-icons">settings</i></span>
        {{--<a href="https://github.com/zdhxiong/mdui" target="_blank"--}}
           {{--class="mdui-btn mdui-btn-icon mdui-ripple mdui-ripple-white" mdui-tooltip="{content: '查看 Github'}">--}}

        {{--</a>--}}
    </div>
</header>

<div class="mdui-drawer mdui-color-grey-50" id="mdui-drawer" style="top:64px;">
    <ul class="mdui-list" mdui-collapse="{accordion: true}">

        <li class="mdui-list-item mdui-ripple">
            <i class="mdui-list-item-icon mdui-icon material-icons">home</i>
            <div class="mdui-list-item-content">主页</div>
        </li>

        <li class="mdui-list-item mdui-ripple">
            <i class="mdui-list-item-icon mdui-icon material-icons">dashboard</i>
            <div class="mdui-list-item-content">Dashboard</div>
        </li>

        <li class="mdui-collapse-item mdui-collapse-item-open">
            <div class="mdui-collapse-item-header mdui-list-item mdui-ripple">
                <i class="mdui-list-item-icon mdui-icon material-icons">people</i>
                <div class="mdui-list-item-content">系统设置</div>
                <i class="mdui-collapse-item-arrow mdui-icon material-icons">keyboard_arrow_down</i>
            </div>
            <ul class="mdui-collapse-item-body mdui-list mdui-list-dense">
                <li class="mdui-list-item mdui-ripple">导航栏入口</li>
                <li class="mdui-list-item mdui-ripple">主题改版</li>
                <li class="mdui-list-item mdui-ripple">修改</li>
                {{--<li class="mdui-list-item mdui-ripple">New vs Returning</li>--}}
            </ul>
        </li>

        <li class="mdui-collapse-item">
            <div class="mdui-collapse-item-header mdui-list-item mdui-ripple">
                <i class="mdui-list-item-icon mdui-icon material-icons">device_hub</i>
                <div class="mdui-list-item-content">问题反馈</div>
                <i class="mdui-collapse-item-arrow mdui-icon material-icons">keyboard_arrow_down</i>
            </div>
            <ul class="mdui-collapse-item-body mdui-list mdui-list-dense">
                <li class="mdui-list-item mdui-ripple">list</li>
                {{--<li class="mdui-list-item mdui-ripple"></li>--}}
                <li class="mdui-list-item mdui-ripple">Direct Traffic</li>
                <li class="mdui-list-item mdui-ripple">Search Overview</li>
            </ul>
        </li>

    </ul>
</div>

<div class="mdui-container-fluid main-content">
    <h1>主要内容</h1>
</div>


<!-- Scripts -->
<script src="{{ asset('libs/mdui/js/mdui.min.js') }}"></script>
@yield('script')
</body>
</html>

