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
        .mdui-alert {
            position: relative;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .mdui-alert-danger {
            /*color: "";*/
            /*background-color: ;*/
            color: #a94442;
            background-color: #f2dede;
        }
        .mdui-close {
            position: absolute;
            right: 15px;
            top:10px;
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
            <legend><h2>重置密码</h2></legend>
            {!! csrf_field() !!}
            @if (count($errors) > 0)
                <div class="mdui-alert  mdui-alert-danger">
                    <span class="mdui-btn mdui-btn-icon mdui-ripple mdui-ripple-white mdui-close"><i class="mdui-icon material-icons" data-dismiss="alert" >&#xe14c;</i></span>
                    <ul class="mdui-list">
                        @foreach ($errors->all() as $error)
                            <li class="mdui-list-item">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="mdui-textfield mdui-textfield-floating-label">
                <label class="mdui-textfield-label">原密码</label>
                <input class="mdui-textfield-input" type="password" name="oldpassword" required/>
                <div class="mdui-textfield-error">用户名不能为空</div>
            </div>

            <div class="mdui-textfield mdui-textfield-floating-label">
                <label class="mdui-textfield-label">新密码</label>
                <input class="mdui-textfield-input" type="password" name="password" autocomplete="off" minlength="6" maxlength="20" required/>
                <div class="mdui-textfield-error">邮箱格式错误</div>
            </div>

            <div class="mdui-textfield mdui-textfield-floating-label">
                <label class="mdui-textfield-label">确认新密码</label>
                <input class="mdui-textfield-input" type="password" name="password_confirmation" autocomplete="off" minlength="6" maxlength="20" required/>
                <div class="mdui-textfield-error">密码至少 6 位，最多20位</div>
            </div>
            <div class="mdui-textfield mdui-textfield-floating-label">
                <button type="submit" class="mdui-btn mdui-btn-raised mdui-btn-dense mdui-color-blue mdui-ripple " id="modify">保存</button>
            </div>
        </fieldset>


    </form>
</div>
@endsection
@section('script')
    <script src="{{ asset('libs/mdui/js/mdui.min.js') }}"></script>
    {{--<script src="{{asset('module/doc/js/dropzone.js')}}"></script>--}}
    <script>
        $('.mdui-close').on('click',function () {
            $(this).parent().fadeOut();
        });
//        var dropz = new Dropzone("#dropz", {
//            url: "handle-upload.php",
//            maxFiles: 10,
//            maxFilesize: 512,
//            acceptedFiles: ".js,.obj,.dae"
//        });
    </script>
    @endsection


