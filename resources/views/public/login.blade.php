@extends('layouts.doc.basic')
@section('style')
    <link rel="stylesheet" href="{{asset('css/pure-tip.css')}}">
@endsection
@section('title')
    <title>登录</title>
@endsection
@section('content')
    <form class="pure-form pure-form-stacked login-form" method="post" action="/doLogin" >

        <fieldset>
            {{--<legend>登录</legend>--}}
            {{ csrf_field() }}
            <div class="pure-g">

                <div class="pure-u-1 pure-u-md-1-3 form-group">
                    <label for="first-name">用户名</label>
                    <input id="username" class="pure-u-1 button-xlarge" type="text" name="username" minlength="3" maxlength="40" placeholder="请输入用户名/邮箱" required>
                    <span class="check-span"><strong>！</strong><span class="info">请输入用户名.</span></span>
                </div>

                <div class="pure-u-1 pure-u-md-1-3 form-group">
                    <label for="last-name">密码</label>
                    <input id="password" class="pure-u-1 button-xlarge" type="password" name="password" minlength="5" maxlength="40" placeholder="请输入密码" required>
                    <span class="check-span"><strong>！</strong><span class="info">请输入密码.</span></span>
                </div>
                <button type="button" class="pure-button button-xlarge pure-button-primary pure-u-1" id="login">登录</button>

            </div>
        </fieldset>
    </form>
@endsection

@section('script')

    <script>
        $(function () {
            var $username = $('#username'),
                $pwd = $('#password');

            /**
             * 验证表单
             */
            function checkForm() {

                // 验证用户名是否为空和长度超过100
                if ($username.val().length < 1) {
                    $username.parent().addClass('error');
                    $username.next().find('.info').html('请输入用户名.');
                    return false;
                }

                if ($username.val().length > 40) {
                    $username.parent().addClass('error');
                    $username.next().find('.info').html('用户名长度不能超过40个字符.');
                    return false;
                }
                if ($pwd.val().length < 1) {
                    $pwd.parent().addClass('error');
                    $pwd.next().find('.info').html('请输入密码.');
                    return false;
                }
                if ($pwd.val().length > 40) {
                    $pwd.parent().addClass('error');
                    $pwd.next().find('.info').html('密码长度不能超过40个字符.');
                    return false;
                }

                return true;

            }
            /**
             * 移除验证元素错误显示样式
             */
            function removeErrorStyle() {
                $('.form-group').each(function () {
                    var $this = $(this);
                    if ($this.find('input').val().length > 0) {
                        $this.removeClass('error');
                    }
                })
            }
            /**
             * 获取表单数据
             */
            function getFormData() {
                return {
                    username: $username.val(),
                    password: $pwd.val()
                }
            }

            $('#login').on('click',function () {

                removeErrorStyle();
               if (!checkForm()) {
                   return;
               }

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'post',
                    url: '/doLogin',
                    dataType: 'json',
                    data: getFormData(),
                    success: function (res) {
                        if (res.code == 200) {
                            $.pureTip({
                                tip: '登陆成功，正在跳转，请稍后！',
                                callback: function () {
                                    window.location.href = "/dashboard"
                                }
                            });
                        } else {
                            alert(res.error)
                        }
                    },
                    error: function (res) {
                        console.log(res)
                    }
                })
            })
        });
    </script>



@endsection
