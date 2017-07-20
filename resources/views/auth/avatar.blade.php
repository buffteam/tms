@extends('layouts.doc.index')
@section('style')
    <link rel="stylesheet" href="{{asset('libs/mdui/css/mdui.min.css')}}">
    <style>
        .main-content {
            position: relative;
            top:80px;
        }
        .form-fieldset {
            margin-top: 25px;
            padding: 20px;
        }
    </style>
@endsection
@section('content')
<div class="mdui-container main-content" >
    @if (session('status'))
        <div class="mdui-alert mdui-alert-success">
            {{ session('status') }}
        </div>
    @endif
    <form action="" method="post">

        <fieldset class="form-fieldset">
            <legend><h2>更换头像</h2></legend>


            <div class="mdui-textfield mdui-textfield-floating-label">
                {{--<label class="mdui-textfield-label">上传头像</label>--}}
                <input class="mdui-textfield-input" type="file" name="avatar" placeholder="请选择图片" required/>
            </div>
            <div class="mdui-textfield mdui-textfield-floating-label">
                <button type="button" class="mdui-btn mdui-btn-raised mdui-btn-dense mdui-color-blue mdui-ripple " id="upload">上传</button>
            </div>

        </fieldset>

        <fieldset>
            <legend><h2>已上传图片列表</h2></legend>
            <div class="mdui-row ">
                <div class="mdui-col-md-3" >
                    <label class="mdui-list-item mdui-ripple" >
                        <div class="mdui-checkbox">
                            <input type="checkbox" checked/>
                            <i class="mdui-checkbox-icon"></i>
                        </div>
                        <div class="mdui-list-item-content"> <img src="{{asset('/uploads/49f81bcf3b900c9495dd2f85157b453f.png')}}"/></div>
                    </label>
                </div>
                <div class="mdui-col-md-3" >
                    <label class="mdui-list-item mdui-ripple" >
                        <div class="mdui-checkbox">
                            <input type="checkbox" checked/>
                            <i class="mdui-checkbox-icon"></i>
                        </div>
                        <div class="mdui-list-item-content"> <img src="{{asset('/uploads/49f81bcf3b900c9495dd2f85157b453f.png')}}"/></div>
                    </label>
                </div>
                <div class="mdui-col-md-3" >
                    <label class="mdui-list-item mdui-ripple" >
                        <div class="mdui-checkbox">
                            <input type="checkbox" checked/>
                            <i class="mdui-checkbox-icon"></i>
                        </div>
                        <div class="mdui-list-item-content"> <img src="{{asset('/uploads/49f81bcf3b900c9495dd2f85157b453f.png')}}"/></div>
                    </label>
                </div>
                <div class="mdui-col-md-3" >
                    <label class="mdui-list-item mdui-ripple" >
                        <div class="mdui-checkbox">
                            <input type="checkbox" checked/>
                            <i class="mdui-checkbox-icon"></i>
                        </div>
                        <div class="mdui-list-item-content"> <img src="{{asset('/uploads/49f81bcf3b900c9495dd2f85157b453f.png')}}"/></div>
                    </label>
                </div>
            </div>
            <div class="mdui-textfield mdui-textfield-floating-label">
                <button type="button" class="mdui-btn mdui-btn-raised mdui-btn-dense mdui-color-blue mdui-ripple " id="upload">保存</button>
            </div>
        </fieldset>
    </form>
</div>
@endsection
@section('script')
    <script src="{{ asset('libs/mdui/js/mdui.min.js') }}"></script>
    <script src="{{asset('module/doc/js/dropzone.js')}}"></script>
    <script>
//        var dropz = new Dropzone("#dropz", {
//            url: "handle-upload.php",
//            maxFiles: 10,
//            maxFilesize: 512,
//            acceptedFiles: ".js,.obj,.dae"
//        });
    </script>
    @endsection


