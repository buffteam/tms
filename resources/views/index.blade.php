<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title></title>
    <link rel="stylesheet" href="{{asset('module/doc/css/header.css')}}">
    <link rel="stylesheet" href="{{asset('module/doc/css/skin.css')}}">
    <link rel="stylesheet" href="{{asset('libs/editormd/css/editormd.min.css')}}">
    <style>
        .feedback {
            position: fixed;
            top: 50%;
            right: 30px;
            box-sizing: content-box;
            width: 100px;
            height: 25px;
            padding: 10px;
            text-align: center;
            border-radius: 4px;
            line-height: 25px;

        }
        .feedback:hover {
            background-color: gainsboro;
            cursor: pointer;
        }
        .main-content {
            margin-top: 64px;
        }
        .container {
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }
        @media (min-width: 768px) {
            .container {
                width: 750px;
            }
        }
        @media (min-width: 992px) {
            .container {
                width: 970px;
            }
        }
        @media (min-width: 1200px) {
            .container {
                width: 1170px;
            }
        }
    </style>
</head>
<body>
<section id="skin">
    <header class="header">
        <div class="logo">{{ config('app.name', '共享笔记') }}</div>
        <ul class="menu">
            <li>
                <a href="{{route('root')}}" >首页</a>
            </li>
        </ul>
        @if (Route::has('login'))
            @if (Auth::check())
                <div class="user-info" onclick="header.userDropDown(this,event)">
                    <span>{{ Auth::user()->name }}</span>
                    <ul class="user-down-list">
                        <li><a href="{{ route('dashboard') }}">进入主页</a></li>
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

            @else
                <span><a href="{{ url('/login') }}">登录</a></span>
                <span><a href="{{ url('/register') }}">注册</a></span>
            @endif
        @endif

        <div class="theme-box">
            <ul class="theme-ul">
                <li class="theme-li blue-color"><span class="theme-span">blue</span></li>
                <li class="theme-li purple-color"><span class="theme-span">purple</span></li>
                <li class="theme-li green-color"><span class="theme-span">green</span></li>
                <li class="theme-li brown-color"><span class="theme-span">brown</span></li>
                <li class="theme-li cyan-color"><span class="theme-span">cyan</span></li>
                <li class="theme-li indigo-color"><span class="theme-span">indigo</span></li>
                <li class="theme-li teal-color"><span class="theme-span">teal</span></li>
                <li class="theme-li red-color"><span class="theme-span">red</span></li>
                <li class="theme-li dark-color"><span class="theme-span">dark</span></li>
            </ul>
        </div>
    </header>

    <div class="container main-content">
        <div id="test-editormd" class="editormd-onlyread"></div>
    </div>
</section>

<a class="feedback" href="{{route('feedback')}}" title="问题反馈与建议">问题反馈与建议</a>
<script src="{{asset('libs/jquery/jquery.min.js')}}"></script>
<script src="{{asset('/libs/layer-v3.0.3/layer.js')}}"></script>
<script src="{{asset('/module/doc/js/header.js')}}"></script>
<script src="{{asset('/libs/editormd/editormd.min.js')}}"></script>
<script>

    $.get("@php echo route('getReadme'); @endphp", function(md){
        var testEditor = editormd("test-editormd", {
            width: "100%",
            height: 900,
            path : "./libs/editormd/lib/",
            readOnly: true,
            markdown : md,
            taskList : true,
//        theme : "dark",
//        previewTheme : "dark",
//        editorTheme : "pastel-on-dark",

//        codeFold : true,

            //syncScrolling : false,
//        saveHTMLToTextarea : true,    // 保存 HTML 到 Textarea
//        searchReplace : true,
//        watch : false,                // 关闭实时预览
//        htmlDecode : "style,script,iframe|on*",            // 开启 HTML 标签解析，为了安全性，默认不开启
//        toolbar  : true,             //关闭工具栏
//        previewCodeHighlight : false, // 关闭预览 HTML 的代码块高亮，默认开启
//        emoji : true,

//        tocm            : true,         // Using [TOCM]
//        tex : true,                   // 开启科学公式TeX语言支持，默认关闭
//        flowChart : true,             // 开启流程图支持，默认关闭
//        sequenceDiagram : true,       // 开启时序/序列图支持，默认关闭,
//        dialogLockScreen : false,   // 设置弹出层对话框不锁屏，全局通用，默认为true
//        dialogShowMask : false,     // 设置弹出层对话框显示透明遮罩层，全局通用，默认为true
//        dialogDraggable : false,    // 设置弹出层对话框不可拖动，全局通用，默认为true
//        dialogMaskOpacity : 0.4,    // 设置透明遮罩层的透明度，全局通用，默认值为0.1
//        dialogMaskBgColor : "#000", // 设置透明遮罩层的背景颜色，全局通用，默认为#fff
//        imageUpload : true,
//        imageFormats : ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
//        imageUploadURL : "./php/upload.php",

            onload : function() {
                testEditor.previewing();
                console.log('onload', this);
            }
        });
    });




</script>
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
