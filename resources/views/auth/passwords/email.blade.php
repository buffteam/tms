@extends('layouts.md')

@section('content')
    <div class="mdui-container" style="margin-top: 80px;">
        <div class="mdui-row">
            <div class="mdui-col-md-8 mdui-col-offset-md-2">
                <div class="mdui-panel">
                    <div class="mdui-panel-item mdui-panel-item-open">
                        <div class="mdui-panel-item-header"><h2>重置密码</h2></div>
                        <div class="mdui-panel-item-body">
                            @if (session('status'))
                                <div class="mdui-alert  mdui-alert-success">
                                    <span class="mdui-btn mdui-btn-icon mdui-ripple mdui-ripple-white mdui-close"><i
                                                class="mdui-icon material-icons"
                                                data-dismiss="alert">&#xe14c;</i></span>
                                    {{ session('status') }}
                                </div>
                            @endif
                            <form class="mdui-form" method="POST" action="{{ route('password.email') }}">
                                {{ csrf_field() }}

                                <div class="mdui-textfield mdui-textfield-floating-label {{ $errors->has('email') ? ' mdui-textfield-invalid' : '' }}">
                                    <label class="mdui-textfield-label">邮箱</label>
                                    <input class="mdui-textfield-input" type="email" name="email"
                                           value="{{ old('email') }}" required/>
                                    <div class="mdui-textfield-error">{{ $errors->has('email') ? $errors->first('email') : '邮箱不能为空'}}</div>
                                </div>
                                <div class="mdui-textfield mdui-textfield-floating-label">
                                    <button type="submit"
                                            class="mdui-btn mdui-btn-raised mdui-btn-dense mdui-color-blue mdui-ripple ">
                                        发送密码重置邮件
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
