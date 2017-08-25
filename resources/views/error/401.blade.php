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
    <link rel="stylesheet" href="{{ asset('libs/mdui/css/mdui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('module/admin/css/dashboard.css') }}">
    @yield('style')
</head>
<body class="mdui-theme-primary-deep-purple  mdui-drawer-body-left">
<header class="mdui-appbar mdui-appbar-fixed ">
    <div class="mdui-toolbar mdui-color-theme">
        <span class="mdui-btn mdui-btn-icon mdui-ripple mdui-ripple-white" mdui-drawer="{target: '#mdui-drawer'}"><i
                    class="mdui-icon material-icons">menu</i></span>
        <a href="{{route('dashboard')}}" class="mdui-typo-headline mdui-hidden-xs">{{ config('app.name', '管理界面') }}</a>


    </div>
</header>


<div class="mdui-container-fluid main-content">
    <div class="mdui-container" style="margin-top: 80px;">
        <div class="mdui-row">
            <div class="mdui-col-md-8 mdui-col-offset-md-2">
                <h4 class="mdui-color-red-500">服务器错误</h4>
            </div>
        </div>
    </div>
</div>


<!-- Scripts -->
<script src="{{ asset('libs/mdui/js/mdui.min.js') }}"></script>
<script>
    var inst = new mdui.Menu('#open', '#menu');

</script>
@yield('script')
</body>
</html>

