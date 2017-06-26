<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('title')
    <link rel="stylesheet" href="{{asset('libs/pure/pure-min.css')}}">
    <link rel="stylesheet" href="{{asset('libs/pure/grids-responsive.min.css')}}">
    <link rel="stylesheet" href="{{asset('module/common/css/marketing.css')}}">
    <link rel="stylesheet" href="{{asset('module/common/css/sign.css')}}">
</head>
<body >
{{--头部导航栏--}}
<div class="header">
    <div class="home-menu pure-menu pure-menu-horizontal pure-menu-fixed">
        <a class="pure-menu-heading" href="">笔记共享系统</a>

        <ul class="pure-menu-list">
            <li class="pure-menu-item"><a href="#" class="pure-menu-link">主页</a></li>
            <li class="pure-menu-item pure-menu-selected"><a href="#" class="pure-menu-link">注册</a></li>
            <li class="pure-menu-item"><a href="#" class="pure-menu-link">登录</a></li>
        </ul>
    </div>
</div>
{{--注册表单--}}
@yield('content')

<div class="footer l-box is-center">
    View the source of this layout to learn more. Made with love by the YUI Team.
</div>
@yield('script')
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
