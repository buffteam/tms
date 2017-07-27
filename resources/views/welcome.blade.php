@extends('layouts.doc.index')
@section('style')
    <link rel="stylesheet" href="{{asset('libs/mdui/css/mdui.min.css')}}">
    <link rel="stylesheet" href="{{asset('libs/editormd/css/editormd.min.css')}}">
    <link rel="stylesheet" href="{{asset('module/doc/css/common.css')}}">

@endsection
@section('content')
    <div class="mdui-container content-top">
        <div class="mdui-row" id="container">
            <div class="mdui-col-md-2">
                <ul class="mdui-list">
                    <li class="mdui-list-item mdui-list-item-active mdui-ripple" id="desc"><h3>使用说明</h3></li>
                    <li class="mdui-list-item mdui-ripple" id="updateLog"><h3>更新日志</h3></li>
                    <li class="mdui-list-item mdui-ripple" id="other"><h3>其他</h3></li>
                </ul>
                {{--<div class="mdui-list">--}}
                    {{--<a href="#" class="mdui-list-item mdui-ripple "></a>--}}
                    {{--<a href="#" class="mdui-list-item mdui-ripple"></a>--}}
                    {{--<a href="#" class="mdui-list-item mdui-ripple"></a>--}}
                {{--</div>--}}
            </div>
            <div class="mdui-col-md-9">
                {{--<div id="content">--}}

                {{--<textarea class="editormd-markdown-textarea" name="content-markdown-doc" id="mdContent">{{$data->md_doc}}</textarea>--}}
                {{--<!-- html textarea 需要开启配置项 saveHTMLToTextarea == true -->--}}
                    {{--<textarea class="editormd-html-textarea" name="content" required></textarea>--}}
                {{--</div>--}}
                <div class="markdown-body editormd-preview-container" style="border: 1px solid gainsboro;" id="content">
                    {{--{{$data->html_doc}}--}}
                </div>
            </div>

        </div>
    </div>
    <input type="hidden" value=" {{$data->html_doc}}" id="md">
    <input type="hidden" value="{{route('updateLog')}}" id="updateUrl">
    <input type="hidden" value="{{route('getDesc')}}" id="descUrl">
@endsection
@section('script')
    <script src="{{asset('/libs/editormd/editormd.min.js')}}"></script>
    <script>
        var initMd = $('#md').val();
//        var  testEditor = editormd("content", {
//            width: "100%",
//            height: 1200,
//            path : "/libs/editormd/lib/",
//            readOnly: true,
//            markdown : initMd,
//            taskList : true,
////            saveHTMLToTextarea : true,
////            toolbar  : true,
//            onload : function() {
//                testEditor.previewing();
//                console.log('onload', this);
//            }
//        });

        var $container = $('#container'),
            updateUrl = $('#updateUrl').val();


        $container.on('click','#updateLog',function () {
            $.get(updateUrl,function (res) {
                $('#content').html(res.content);
            })
        });
        $container.on('click','#desc',function () {
            $('#content').html(initMd);
        });
        $('#desc').trigger('click');
        $container.on('click','.mdui-list-item',function () {
            $(this).addClass('mdui-list-item-active').siblings().removeClass('mdui-list-item-active');
        });
    </script>
@endsection
