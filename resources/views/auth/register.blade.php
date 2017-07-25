@extends('layouts.md')
@section('content')
    <div class="mdui-container" style="margin-top: 80px;">
        <div class="mdui-row">
            <div class="mdui-col-md-8 mdui-col-offset-md-2">

                <div class="mdui-panel">
                    <div class="mdui-panel-item mdui-panel-item-open">
                        <div class="mdui-panel-item-header"><h2>注册</h2></div>
                        <div class="mdui-panel-item-body">
                            @if (session('status'))
                                <div class="mdui-alert  mdui-alert-success">
                                    <span class="mdui-btn mdui-btn-icon mdui-ripple mdui-ripple-white mdui-close"><i class="mdui-icon material-icons" data-dismiss="alert" >&#xe14c;</i></span>
                                    {{ session('status') }}
                                </div>
                            @endif
                            <form class="mdui-form" method="POST" action="{{ route('register') }}">
                                {{ csrf_field() }}

                                @if (count($errors) > 0)
                                    <div class="mdui-alert  mdui-alert-danger">
                                        <span class="mdui-btn mdui-btn-icon mdui-ripple mdui-ripple-white mdui-close"><i
                                                    class="mdui-icon material-icons"
                                                    data-dismiss="alert">&#xe14c;</i></span>
                                        <ul class="mdui-list">
                                            @foreach ($errors->all() as $error)
                                                <li class="mdui-list-item">{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="mdui-textfield mdui-textfield-floating-label {{ $errors->has('name') ? ' mdui-textfield-invalid' : '' }}">
                                    <label class="mdui-textfield-label">昵称</label>
                                    <input class="mdui-textfield-input" type="text" name="name"
                                           value="{{ old('name') }}" autocomplete="on" minlength="3" required/>
                                    <div class="mdui-textfield-error">{{ $errors->has('name') ? $errors->first('name') : '昵称至少3位'}}</div>
                                </div>
                                <div class="mdui-textfield mdui-textfield-floating-label {{ $errors->has('email') ? ' mdui-textfield-invalid' : '' }}">
                                    <label class="mdui-textfield-label">邮箱</label>
                                    <input class="mdui-textfield-input" type="email" name="email"
                                           value="{{ old('email') }}" placeholder="请使用OA邮箱：@oaserver.dw.gdbbk.com"  required/>
                                    <div class="mdui-textfield-error"></div>
                                    <div class="mdui-textfield-error">{{ $errors->has('email') ? $errors->first('email') : '邮箱不能为空'}}</div>
                                </div>

                                <div class="mdui-textfield mdui-textfield-floating-label {{ $errors->has('password') ? ' mdui-textfield-invalid' : '' }}">
                                    <label class="mdui-textfield-label">密码</label>
                                    <input class="mdui-textfield-input" type="password" name="password"
                                           autocomplete="off" minlength="6" required/>
                                    <div class="mdui-textfield-error">{{ $errors->has('password') ? $errors->first('password') : '密码至少 6 位'}}</div>
                                </div>

                                <div class="mdui-textfield mdui-textfield-floating-label {{ $errors->has('password_confirmation') ? ' mdui-textfield-invalid' : '' }}">
                                    <label class="mdui-textfield-label">确认密码</label>
                                    <input class="mdui-textfield-input" type="password" name="password_confirmation"
                                           autocomplete="off" minlength="6" required/>
                                    <div class="mdui-textfield-error">{{ $errors->has('password_confirmation') ? $errors->first('password_confirmation') : '确认密码至少 6 位'}}</div>
                                </div>
                                <div class="mdui-textfield mdui-textfield-floating-label">
                                    <button type="submit"
                                            class="mdui-btn mdui-btn-raised mdui-btn-dense mdui-color-blue mdui-ripple "
                                            id="modify">注册
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
