<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>注册</title>
    <link rel="stylesheet" href="{{asset('libs/pure/base-min.css')}}">
    <link rel="stylesheet" href="{{asset('libs/pure/grids-min.css')}}">
    <link rel="stylesheet" href="{{asset('libs/pure/forms-min.css')}}">
    <link rel="stylesheet" href="{{asset('libs/pure/buttons-min.css')}}">
    <link rel="stylesheet" href="{{asset('module//common/css/sign.css')}}">
</head>
<body >

    <form class="pure-form pure-form-stacked register-form " method="post" action="/doRegister" >

        <fieldset>
            <legend>文档系统注册</legend>
            {{ csrf_field() }}
            <div class="pure-g">

                <div class="pure-u-1 pure-u-md-1-3 form-group">
                    <label for="first-name">用户名</label>
                    <input id="username" class="pure-u-1 button-xlarge" type="text" name="username" minlength="3" maxlength="40" placeholder="请输入用户名" required>
                    <span class="check-span"><strong>！</strong><span class="info">请输入用户名.</span></span>
                </div>

                <div class="pure-u-1 pure-u-md-1-3 form-group">
                    <label for="last-name">密码</label>
                    <input id="password" class="pure-u-1 button-xlarge" type="password" name="password" minlength="5" maxlength="40" placeholder="请输入密码" required>
                    <span class="check-span"><strong>！</strong><span class="info">请输入密码.</span></span>
                </div>

                <div class="pure-u-1 pure-u-md-1-3 form-group" >
                    <label for="last-name">重复密码</label>
                    <input id="repassword" class="pure-u-1 button-xlarge" type="password" name="repassword" minlength="5" maxlength="40" placeholder="请输入密码" required>
                    <span class="check-span"><strong>！</strong><span class="info">请重复密码</span></span>
                </div>

                <div class="pure-u-1 pure-u-md-1-3 form-group">
                    <label for="last-name">邮箱</label>
                    <input id="email" class="pure-u-1 button-xlarge" type="email" name="email" placeholder="请输入邮箱" minlength="6" maxlength="80" required>
                    <span class="check-span"><strong>！</strong><span class="info">请输入邮箱</span></span>
                </div>
                <button type="submit" class="pure-button button-xlarge pure-button-primary pure-u-1" id="register">注册</button>

            </div>
        </fieldset>
    </form>

    <script src="/libs/jquery/jquery.min.js"></script>
<script>

    var $username = $('#username'),
        $pwd = $('#password'),
        $repwd = $('#repassword'),
        $email = $('#email');
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
        if ($repwd.val() !== $pwd.val()) {
            $repwd.parent().addClass('error');
            $repwd.next().find('.info').html('两次密码输入不一致.');
            return false;
        }
        var myreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
        if (!myreg.test($email.val())) {
            $email.parent().addClass('error');
            $email.next().find('.info').html('邮箱格式不正确.');
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
            password: $pwd.val(),
            email: $email.val()
        }
    }
//    $('#register').on('click',function () {
//
//        removeErrorStyle();
//        checkForm();
//
//        if (!checkForm()) {
//            return;
//        }
//        $.ajax({
//            headers: {
//                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//            },
//            method: 'post',
//            url: '/doRegister',
//            dataType: 'json',
//            data: getFormData(),
//            success: function (res) {
//                if (res.code == 200) {
//                    alert(res.msg)
//                } else {
//                    alert(res.error)
//                }
//            },
//            error: function (res) {
//                console.log(res)
//            }
//        })
//    })
</script>
</body>
</html>
