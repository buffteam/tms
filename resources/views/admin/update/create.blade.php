@extends('layouts.admin')
@section('style')
<link rel="stylesheet" href="{{asset('libs/editormd/css/editormd.min.css')}}">
<link rel="stylesheet" href="{{asset('module/doc/css/mdui-alert.css')}}">
<style>
    .mdui-select {
        display: block;
        width: 100%;
        height: 34px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
        box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
        -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
        -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    }
    .mdui-select option {

    }
</style>
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
    <form action="{{url('updateLog/add')}}" method="post">
        {{csrf_field()}}
        <div class="mdui-row">

            <div class="mdui-textfield mdui-col-md-9 mdui-col-offset-md-1">
                <input class="mdui-textfield-input " type="text" name="title" value="" placeholder="标题" required/>
            </div>
        </div>
        <div class="mdui-row">
            <div class="mdui-textfield mdui-col-md-9 mdui-col-offset-md-1">
                <input class="mdui-textfield-input" type="text" name="version" value="" placeholder="版本信息" required/>
            </div>
        </div>
        <div class="mdui-row">
            <div class="mdui-textfield mdui-col-md-1 mdui-col-offset-md-1">
                <select name="type" id="" class="mdui-select">
                    <option value="1">日志</option>
                    <option value="2">说明</option>
                    <option value="3">计划</option>
                </select>
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
                <button type="submit" class="mdui-btn mdui-ripple  mdui-color-blue" id="addBtn">提交</button>
            </div>
        </div>

    </form>
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
        var  testEditor = editormd("content", {
            width: "100%",
            height: 600,
            path : "/libs/editormd/lib/",
            readOnly: false,
            markdown : '',
            saveHTMLToTextarea : true,
            toolbar  : true,
            onload : function() {
//                testEditor.previewing();
                console.log('onload', this);
            }
        });

        //
        $('#addBtn').on('click',function () {
            $.post('')
        })
    </script>
@endsection