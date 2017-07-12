
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .list-group-item:hover {
            background-color: #ECF0F1;
        }
        .panel-default > .panel-heading {
            color: #333;
            background-color: #f5f5f5;
            border-color: #ddd;
        }
    </style>
    @yield('style')
</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp; <li><a href="{{ url('/feedback') }}">问题反馈与建议</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())

                        <li><a href="{{ route('login') }}">登录</a></li>
                        <li><a href="{{ route('register') }}">注册</a></li>

                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">

                                        退出

                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid" >
        <div class="row">
            <div class="col-md-2" >
                <div class="panel-group" role="tablist">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="collapseListGroupHeading1">
                            <h4 class="panel-title">
                                <a class="" role="button" data-toggle="collapse" href="#feedback" aria-expanded="true" aria-controls="collapseListGroup1">
                                    问题反馈
                                </a>
                            </h4>
                        </div>
                        <div id="feedback" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="collapseListGroupHeading1" aria-expanded="true">
                            <ul class="list-group">
                                <li class="list-group-item">问题列表</li>
                                <li class="list-group-item">建议列表</li>
                                <li class="list-group-item">其他</li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="collapseListGroupHeading1">
                            <h4 class="panel-title">
                                <a class="" role="button" data-toggle="collapse" href="#systemSetting" aria-expanded="true" aria-controls="collapseListGroup1">
                                    系统设置
                                </a>
                            </h4>
                        </div>
                        <div id="systemSetting" class="panel-collapse collapse in " role="tabpanel" aria-labelledby="collapseListGroupHeading1" aria-expanded="true">
                            <ul class="list-group">
                                <li class="list-group-item">设置菜单列表</li>
                                <li class="list-group-item">设置应用名称</li>
                                <li class="list-group-item">权限设置</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                @yield('content')

            </div>

        </div>


    </div>

</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
@yield('script')
</body>
</html>

