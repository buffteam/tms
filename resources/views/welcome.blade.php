@extends('layouts.doc.basic')
@section('style')
    <link rel="stylesheet" href="{{asset('libs/pure/grids-responsive-min.css')}}">
@endsection
@section('title')
    <title>首页</title>
@endsection
@section('content')
    <div class="splash-container">
        <div class="splash">
            <h1 class="splash-head">欢迎使用醍醐共享云笔记</h1>
            <p class="splash-subhead">
                醍醐（teahu Cloud ） 共享云笔记，舒适、行云流水的抒写自己的畅想。
            </p>
            <p>
                <a href="/" class="pure-button pure-button-primary">开始抒写吧</a>
            </p>
        </div>
    </div>

    <div class="content-wrapper">
        <div class="content">
            <h2 class="content-head is-center">Excepteur sint occaecat cupidatat.</h2>

            <div class="pure-g">
                <div class="l-box pure-u-1 pure-u-md-1-2 pure-u-lg-1-4">

                    <h3 class="content-subhead">
                        <i class="fa fa-rocket"></i>
                        Get Started Quickly
                    </h3>
                    <p>
                        Phasellus eget enim eu lectus faucibus vestibulum. Suspendisse sodales pellentesque elementum.
                    </p>
                </div>
                <div class="l-box pure-u-1 pure-u-md-1-2 pure-u-lg-1-4">
                    <h3 class="content-subhead">
                        <i class="fa fa-mobile"></i>
                        Responsive Layouts
                    </h3>
                    <p>
                        Phasellus eget enim eu lectus faucibus vestibulum. Suspendisse sodales pellentesque elementum.
                    </p>
                </div>
                <div class="l-box pure-u-1 pure-u-md-1-2 pure-u-lg-1-4">
                    <h3 class="content-subhead">
                        <i class="fa fa-th-large"></i>
                        Modular
                    </h3>
                    <p>
                        Phasellus eget enim eu lectus faucibus vestibulum. Suspendisse sodales pellentesque elementum.
                    </p>
                </div>
                <div class="l-box pure-u-1 pure-u-md-1-2 pure-u-lg-1-4">
                    <h3 class="content-subhead">
                        <i class="fa fa-check-square-o"></i>
                        Plays Nice
                    </h3>
                    <p>
                        Phasellus eget enim eu lectus faucibus vestibulum. Suspendisse sodales pellentesque elementum.
                    </p>
                </div>
            </div>
        </div>

        <div class="ribbon l-box-lrg pure-g">
            <div class="l-box-lrg is-center pure-u-1 pure-u-md-1-2 pure-u-lg-2-5">
                <img width="300" alt="File Icons" class="pure-img-responsive" src="/module/doc/imgs/file-icons.png">
            </div>
            <div class="pure-u-1 pure-u-md-1-2 pure-u-lg-3-5">

                <h2 class="content-head content-head-ribbon">Laboris nisi ut aliquip.</h2>

                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor.
                </p>
            </div>
        </div>

        <div class="content">
            <h2 class="content-head is-center">Dolore magna aliqua. Uis aute irure.</h2>

            <div class="pure-g">
                <div class="l-box-lrg pure-u-1 pure-u-md-2-5">
                    <form class="pure-form pure-form-stacked">
                        <fieldset>

                            <label for="name">Your Name</label>
                            <input id="name" type="text" placeholder="Your Name">


                            <label for="email">Your Email</label>
                            <input id="email" type="email" placeholder="Your Email">

                            <label for="password">Your Password</label>
                            <input id="password" type="password" placeholder="Your Password">

                            <button type="submit" class="pure-button">Sign Up</button>
                        </fieldset>
                    </form>
                </div>

                <div class="l-box-lrg pure-u-1 pure-u-md-3-5">
                    <h4>Contact Us</h4>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat.
                    </p>

                    <h4>More Information</h4>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua.
                    </p>
                </div>
            </div>

        </div>

    </div>

@endsection

@section('script')
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
@endsection
