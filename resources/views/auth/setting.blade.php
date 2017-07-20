@extends('layouts.md')
@section('content')
    <div class="mdui-container" style="margin-top: 80px;">
        <div class="mdui-panel">
            <div class="mdui-panel-item mdui-panel-item-open">
                <div class="mdui-panel-item-header"><h2>修改密码</h2></div>
                <div class="mdui-panel-item-body">
                    @if (session('status'))
                        <div class="mdui-alert mdui-alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="" method="post">
                        {!! csrf_field() !!}
                        @if (count($errors) > 0)
                            <div class="mdui-alert  mdui-alert-danger">
                                <span class="mdui-btn mdui-btn-icon mdui-ripple mdui-ripple-white mdui-close"><i
                                            class="mdui-icon material-icons" data-dismiss="alert">&#xe14c;</i></span>
                                <ul class="mdui-list">
                                    @foreach ($errors->all() as $error)
                                        <li class="mdui-list-item">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="mdui-textfield mdui-textfield-floating-label {{ $errors->has('oldpassword') ? ' mdui-textfield-invalid' : '' }}">
                            <label class="mdui-textfield-label">原密码</label>
                            <input class="mdui-textfield-input" type="password" name="oldpassword" required/>
                            <div class="mdui-textfield-error">{{ $errors->has('oldpassword') ? $errors->first('oldpassword') : '原始密码不正确'}}</div>
                        </div>

                        <div class="mdui-textfield mdui-textfield-floating-label {{ $errors->has('password') ? ' mdui-textfield-invalid' : '' }}">
                            <label class="mdui-textfield-label">新密码</label>
                            <input class="mdui-textfield-input" type="password" name="password" autocomplete="off"
                                   minlength="6"  required/>
                            <div class="mdui-textfield-error">{{ $errors->has('password') ? $errors->first('password') : '密码至少6位'}}</div>
                        </div>

                        <div class="mdui-textfield mdui-textfield-floating-label {{ $errors->has('password_confirmation') ? ' mdui-textfield-invalid' : '' }}">
                            <label class="mdui-textfield-label">确认新密码</label>
                            <input class="mdui-textfield-input" type="password" name="password_confirmation"
                                   autocomplete="off" minlength="6"  required/>
                            <div class="mdui-textfield-error">{{ $errors->has('password_confirmation') ? $errors->first('password_confirmation') : '密码至少6位'}}</div>
                        </div>
                        <div class="mdui-textfield mdui-textfield-floating-label">
                            <button type="submit"
                                    class="mdui-btn mdui-btn-raised mdui-btn-dense mdui-color-blue mdui-ripple "
                                    id="modify">
                                保存
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>

    </div>
@endsection


