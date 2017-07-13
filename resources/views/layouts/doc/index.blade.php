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
    <div class="user-info">
        <span>{{ Auth::user()->name }}</span>
        <span> | </span>
        {{--<span class="logout" onclick="main.loginOut()">退出</span>--}}
        <a  class="logout" href="{{ route('logout') }}"
           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">

            退出

        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </div>
</header>
@yield('content')
{{--<div class="mask" style="display: none"></div>--}}
{{--<div class="share-dialog" style="display: none">--}}
    {{--<div class="share-close"></div>--}}
    {{--<div class="share-dialog-title">分享</div>--}}
    {{--<div class="share-dialog-cont">--}}
        {{--<div class="share-copy">--}}
            {{--<div class="share-copy-l">分享链接：</div>--}}
            {{--<div class="share-copy-c"><input id="copytext" type="text"/></div>--}}
            {{--<div id="btnCopy" class="share-copy-r"  data-clipboard-target="copytext">复制链接</div>--}}
            {{--<div class="clear"></div>--}}
        {{--</div>--}}
        {{--<div class="share-platform">--}}
            {{--<div class="share-platform-l">社交平台：</div>--}}
            {{--<div class="share-platform-r">--}}
                {{--<div class="bdsharebuttonbox">--}}
                    {{--<a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>--}}
                    {{--<a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a>--}}
                    {{--<a href="#" class="bds_sqq" data-cmd="sqq" title="分享到QQ好友"></a>--}}
                    {{--<a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a>--}}
                {{--</div>--}}
                {{--<div class="share-platform-text">--}}
                    {{--您可以直接复制短链，分享给朋友，也可直接点击社交平台图标，指定分享。--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
<script src="{{asset('/libs/jquery/jquery.min.js')}}"></script>
<script src="{{asset('/libs/template/template-native.js')}}"></script>
<script src="{{asset('/libs/editormd/editormd.min.js')}}"></script>
<script src="{{asset('/libs/nicescroll/jquery.nicescroll.min.js')}}"></script>
<script src="{{asset('/libs/wangEditor-3.0.3/wangEditor.min.js')}}"></script>
<script src="{{asset('/libs/layer-v3.0.3/layer.js')}}"></script>
{{--<script src="http://cdn.bootcss.com/zeroclipboard/1.2.0/ZeroClipboard.min.js"></script>--}}
@yield('script')

</body>
</html>
