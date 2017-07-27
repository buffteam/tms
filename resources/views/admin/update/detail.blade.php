@extends('layouts.admin')
@section('style')
<link rel="stylesheet" href="{{asset('libs/editormd/css/editormd.min.css')}}">
<link rel="stylesheet" href="{{asset('module/doc/css/mdui-alert.css')}}">

@endsection
@section('content')
    <div class="mdui-bread-crumb ">
        面包屑
    </div>
    <div class="mdui-divider" style="margin-bottom: 15px;"></div>
    @if (count($errors) > 0)
        <div class="mdui-alert mdui-alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{url('updateLog/update')}}" method="post">
        {{csrf_field()}}
        <div class="mdui-row">
            <input type="hidden" value="{{$data->id}}" name="id">
            <div class="mdui-textfield mdui-col-md-9 mdui-col-offset-md-1">
                <input class="mdui-textfield-input " type="text" name="title" value="{{$data->title}}" placeholder="标题" required/>
            </div>
        </div>
        <div class="mdui-row">
            <div class="mdui-textfield mdui-col-md-9 mdui-col-offset-md-1">
                <input class="mdui-textfield-input" type="text" name="version" value="{{$data->version}}" placeholder="版本信息" required/>
            </div>
        </div>
        <div class="mdui-row">
            <div class="mdui-textfield mdui-col-md-9 mdui-col-offset-md-1">
                <div id="content">
                    {{--<textarea class="editormd-markdown-textarea" name="content-markdown-doc" required></textarea>--}}
                    <!-- html textarea 需要开启配置项 saveHTMLToTextarea == true -->
                    {{--<textarea class="editormd-html-textarea" name="content" required></textarea>--}}
                </div>
            </div>
        </div>
        <div class="mdui-row">
            <div class="mdui-textfield mdui-col-md-11 mdui-col-offset-md-1">
                <button type="submit" class="mdui-btn mdui-ripple  mdui-color-blue" id="addBtn">保存</button>
            </div>
        </div>

    </form>
    <input type="hidden" value="{{$data->md_doc}}" id="md_doc">
@endsection
@section('script')
    <script src="{{asset('/libs/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('/libs/editormd/editormd.min.js')}}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var md = $('#md_doc').val();
        var  testEditor = editormd("content", {
            width: "100%",
            height: 600,
            path : "/libs/editormd/lib/",
            readOnly: false,
            markdown : md,
//            taskList : true,
            saveHTMLToTextarea : true,
            toolbar  : true,
            onload : function() {
                testEditor.previewing();
                console.log('onload', this);
            }
        });

        //
        $('#addBtn').on('click',function () {
            $.post('')
        })
    </script>
@endsection