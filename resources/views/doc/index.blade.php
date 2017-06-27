<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>云笔记</title>

    <link rel="stylesheet" href="{{asset('libs/pure/pure-min.css')}}">
    <link rel="stylesheet" href="{{asset('libs/editormd/css/editormd.min.css')}}">
    <!--[if lte IE 8]>
            <link rel="stylesheet" href="{{asset('module/doc/css/layouts/main-old-ie.css')}}">
        <![endif]-->
    <!--[if gt IE 8]><!-->
    <link rel="stylesheet" href="{{asset('module/doc/css/layouts/main.css')}}">
    <!--<![endif]-->
</head>

<body>
    <header class="header pure-g">
        <div class="logo pure-u-1-8">云笔记</div>
    </header>

    <div id="layout" class="content pure-g">
        <div id="nav" class="">
            <span class="nav-menu-button"></span>

            <div class="nav-inner">
                <div class="pure-menu">
                    <ul class="pure-menu-list">
                        <li class="pure-menu-item nav-doc-item">
                            <a href="#" class="first-menu-a is-parent" data-switch="on">
                                <span>我的文档</span>
                            </a>
							<ul class="child-list first-child-list">

                            	<li class="child-item child-item-input">
					                <input type="text" name="add_dir1">
					            </li>
					            <li class="child-item add-dir"><a href="#" class="">新建文件夹</a></li>
					        </ul>
                            <div class="down-box">
                                <p data-type="add">新建子文件夹</p>
                                <p data-type="rename">重命名</p>
                                <p data-type="del">删除文件夹</p>
                            </div>
                        </li>
                        <li class="pure-menu-item nav-share-item">
                            <a href="#" class="first-menu-a">我的分享</a>
                        </li>
                        <li class="pure-menu-item nav-del-item">
                            <a href="#" class="first-menu-a">回收站</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="list" class="">
            <div class="list-search-box pure-form">
                <input type="text" class="pure-input-rounded">
            </div>
            <div class="doc-item doc-item-selected">
                <p class="doc-subject">HTML5 进阶系列：文件API</p>
                <p class="doc-time">
                    2017-06-20
                </p>
            </div>
            <div class="doc-item">
                <p class="doc-subject">HTML5 进阶系列：canvas 动态图表</p>
                <p class="doc-time">
                    2017-06-19
                </p>
            </div>
            <div class="doc-item">
                <p class="doc-subject">HTML5 进阶系列：拖放 API 实现拖放排序</p>
                <p class="doc-time">
                    2017-06-18
                </p>
            </div>
            <div class="doc-item">
                <p class="doc-subject">HTML5 进阶系列：indexedDB 数据库</p>
                <p class="doc-time">
                    2017-06-17
                </p>
            </div>
            <div class="doc-item">
                <p class="doc-subject">HTML5 进阶系列：web Storage</p>
                <p class="doc-time">
                    2017-06-16
                </p>
            </div>
            <div class="doc-item">
                <p class="doc-subject">HTML5 进阶系列：文件API</p>
                <p class="doc-time">
                    2017-06-20
                </p>
            </div>
            <div class="doc-item">
                <p class="doc-subject">HTML5 进阶系列：canvas 动态图表</p>
                <p class="doc-time">
                    2017-06-19
                </p>
            </div>
            <div class="doc-item">
                <p class="doc-subject">HTML5 进阶系列：拖放 API 实现拖放排序</p>
                <p class="doc-time">
                    2017-06-18
                </p>
            </div>
            <div class="doc-item">
                <p class="doc-subject">HTML5 进阶系列：indexedDB 数据库</p>
                <p class="doc-time">
                    2017-06-17
                </p>
            </div>
            <div class="doc-item">
                <p class="doc-subject">HTML5 进阶系列：web Storage</p>
                <p class="doc-time">
                    2017-06-16
                </p>
            </div>
            <div class="doc-item">
                <p class="doc-subject">HTML5 进阶系列：文件API</p>
                <p class="doc-time">
                    2017-06-20
                </p>
            </div>
            <div class="doc-item">
                <p class="doc-subject">HTML5 进阶系列：canvas 动态图表</p>
                <p class="doc-time">
                    2017-06-19
                </p>
            </div>
            <div class="doc-item">
                <p class="doc-subject">HTML5 进阶系列：拖放 API 实现拖放排序</p>
                <p class="doc-time">
                    2017-06-18
                </p>
            </div>
            <div class="doc-item">
                <p class="doc-subject">HTML5 进阶系列：indexedDB 数据库</p>
                <p class="doc-time">
                    2017-06-17
                </p>
            </div>
            <div class="doc-item">
                <p class="doc-subject">HTML5 进阶系列：web Storage</p>
                <p class="doc-time">
                    2017-06-16
                </p>
            </div>
        </div>

        <div id="main" class="">
            <div class="doc-content">
                <div class="doc-content-header pure-g">
                    <div class="pure-u-2-3">
                        <input type="text" name="title" placeholder="这里是标题">
                    </div>

                    <div class="doc-content-controls pure-u-1-3">
                        <span>分享</span>
                        <span>导出</span>
                        <span>删除</span>
                    </div>
                </div>

                <div class="doc-content-body">
                    <div id="editormd">
                        <textarea id="page_content" style="display:none;"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="dialog">
        <div class="dialog-wrapper">
            <div class="dialog-header">
                <span class="dialog-header-title">提示</span>
            </div>
            <div class="dialog-content">
                <p>删除之后不可恢复，是否仍要删除？</p>
            </div>
            <div class="dialog-btns">
                <button type="button" class="cancel-btn" onclick="main.cancelDialog()">取消</button>
                <button type="button" class="sure-btn" onclick="main.sureDialog()">确定</button>
            </div>
        </div>
    </div>
    <script id="add-input-tpl" type="text/html">
        <li class="child-item">
            <a href="#" class="last-menu-a">
                <span class="child-menu-icon"></span>
                <span class="item-name"><input type="text"></span>
                <span class="child-menu-down"></span>
            </a>
        </li>
    </script>

    <script id="nav-tpl" type="text/html">
    	<% idx++; for(var i = 0; i < list.length; i++) { %>
        <li class="child-item">
        <% if(list[i].child) {%> 
			<a href="#" class="second-menu-a is-parent on" data-id="<%= list[i].id %>" data-switch="on">
        <% }else{ %>
            <a href="#" class="second-menu-a" data-id="<%= list[i].id %>">
        <% } %>
            	<span class="child-menu-open"></span>
                <span class="child-menu-icon"></span>
                <span class="item-name"><%= list[i].title %></span>
                <span class="child-menu-down" data-idx="<%= idx %>"></span>
            </a>

            <% if(list[i].child) {%>
            	<ul class="child-list">
            	<% include('nav-tpl', {list:list[i].child, idx: idx})  %>
            	</ul>
            <% } %>
        </li>
        <% } %>
    </script>

    <script src="{{asset('/libs/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('/libs/template/template-native.js')}}"></script>
    <script src="{{asset('/libs/editormd/editormd.min.js')}}"></script>
    <script src="{{asset('/module/doc/js/index.js')}}"></script>
</body>

</html>