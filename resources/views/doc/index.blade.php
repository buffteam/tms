@extends('layouts.doc.index')

@section('style')
    <link rel="stylesheet" href="{{asset('libs/editormd/css/editormd.min.css')}}">
    <link rel="stylesheet" href="{{asset('libs/wangEditor-3.0.3/wangEditor.min.css')}}">
    <link rel="stylesheet" href="{{asset('module/doc/css/layouts/main.css')}}">
@endsection

@section('content')
    <div id="layout" class="content pure-g">
        <div id="nav" class="">
            <span class="nav-menu-button"></span>
            <div class="nav-inner">
                <div class="pure-menu">
                    <ul class="pure-menu-list">
                        <li class="pure-menu-item new-note-item">
                            <span class="middle-add-item"></span>
                            <div class="new-doc-box">
                                <span class="add-icon"><img src="{{asset('module/doc/imgs/icon/add.png')}}"></span>
                                <span class="add-text">新建文档</span>
                                <ul class="more-ul add-list">
                                    <li data-idx="1">新建md文档</li>
                                    <li data-idx="2">新建笔记</li>
                                </ul>
                            </div>
                        </li>
                        <li class="pure-menu-item nav-newest-item active">
                            <div class="first-menu-a">最新笔记</div>
                        </li>
                        <li class="pure-menu-item nav-del-item">
                            <div class="first-menu-a">回收站</div>
                        </li>
                        <div class="more-ul down-box">
                            <p data-type="add">新建子文件夹</p>
                            <p data-type="rename">重命名</p>
                            <p data-type="del">删除文件夹</p>
                        </div>
                    </ul>
                    <div class="feedback">
                        <a href="{{route('feedback',['action'=> 'dashboard'])}}" target="_blank">
                            <span class="feedback-icon"><img src="{{asset('module/doc/imgs/icon/feedback.png')}}"></span>
                            <span>问题反馈与建议</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <div id="list" class="">
            <div class="list-head">
                <div class="search-input-box">
                    <span class="search-type" data-type="title">标题</span>
                    <ul class="more-ul search-type-ul">
                        <li data-type="title">标题</li>
                        <li data-type="content">内容</li>
                        <li data-type="name">作者</li>
                    </ul>
                    <input type="text" class="search-input" placeholder="搜索笔记">
                    <span class="search-close"></span>
                </div>
                <div class="sort-box">
                    <span class="sort-box-icon"></span>
                    <ul class="sort-down-menu">
                        <li data-type="updated_at">修改时间</li>
                        <li data-type="created_at">创建时间</li>
                    </ul>
                </div>
            </div>
            <div class="list-content">
                <ul class="list-content-ul"></ul>
                <div class="list-content-null">
                    <div class="list-null">
                        <p>没有内容哦！</p>
                    </div>
                    <div class="search-null">
                        <p>搜索结果为空</p>
                    </div>
                </div>
            </div>
        </div>

        <div id="main">
            <div class="doc-content">
                <div class="doc-content-header">
                    <div class="doc-content-title">
                        <input class="doc-title-input" type="text" placeholder="这里是标题">
                        <span class="doc-title-span" contenteditable="plaintext-only"></span>
                    </div>

                    <div class="doc-content-controls">
                        <span class="more-btn">更多</span>
                        <span class="edit-btn">编辑</span>
                        <span class="save-btn">保存</span>
                        <span class="restore-btn">还原</span>
                        <ul class="more-ul more-list">
                            <li class="list-lock" style="display: none;">上锁</li>
                            <li class="list-unlock" style="display: none;">解锁</li>
                            <li class="list-line"></li>
                            <li class="list-move">移动到</li>
                            <li class="list-share">分享</li>
                            <li class="list-unshare" style="display: none;">取消分享</li>
                            <li class="list-line"></li>
                            <li class="list-topdf">导出PDF</li>
                            <li class="list-del">删除笔记</li>
                        </ul>
                    </div>
                </div>

                <div class="doc-content-body">
                    <div class="doc-preview-body markdown-body  editormd-preview-container">

                    </div>
                    <div class="doc-edit-body">
                        <div id="editormd" class="editor-1">
                            <textarea id="page_content" style="display:none;"></textarea>
                            <ul class="editor-theme">
                                <li>default</li><li>3024-day</li><li>3024-night</li><li>ambiance</li><li>base16-dark</li><li>base16-light</li><li>blackboard</li><li>cobalt</li><li>eclipse</li><li>erlang-dark</li><li>lesser-dark</li><li>mbo</li><li>mdn-like</li><li>midnight</li><li>monokai</li><li>neo</li><li>night</li><li>paraiso-dark</li><li>paraiso-light</li><li>pastel-on-dark</li><li>rubyblue</li><li>solarized</li><li>the-matrix</li><li>twilight</li><li>vibrant-ink</li><li>xq-dark</li><li>tomorrow-night-eighties</li>
                            </ul>
                        </div>
                        <div id="editor" class="editor-2"></div>
                    </div>
                </div>
                <div class="doc-content-null">

                </div>
            </div>
        </div>
    </div>
    <div id="move-content">
        <p>移动到：</p>
        <div class="folder-box">
            <div class="folder-group-list folder-parent-list">我的文档</div>
            <ul>
                <li class="folder-group-child">
                    <div class="folder-parent-list">旅行游记</div>
                    <ul>
                        <li class="folder-group-child">
                            <div class="folder-parent-list">三毛流浪记</div>
                        </li>
                    </ul>
                </li>
                <li class="folder-group-child">
                    <div class="folder-parent-list">生活日记</div>
                </li>
            </ul>
            <div class="folder-group-list">团队文档</div>
            <ul>
                <li class="folder-group-child">web前端</li>
                <li class="folder-group-child">ios</li>
                <li class="folder-group-child">andriod</li>
            </ul>
        </div>
    </div>
    <script id="share-dialog" type="text/html">
        <div class="share-dialog-content">
            <div class="share-text">获取分享链接成功，复制链接进行分享!</div>
            <div class="share-input">
                <input type="text" id="share_url" value="<%= value %>">
                <span class="share-btn" data-clipboard-target="#share_url">复制链接</span>
            </div>
            <div class="share-handle">
                <a href="<%= value %>" target="_blank">查看分享</a>
                <a href="javascript:;" class="cancel-share">取消分享</a>
            </div>
        </div>
    </script>
    <script id="folder-tpl" type="text/html">
        <div id="move-content">
            <p>移动到：</p>
            <div class="folder-box">
            <% for(var j = 0; j < group.length; j++) { %>
                <div class="folder-group-list folder-parent-list on">
                    <span class="folder-group-open"></span>
                    <span class="folder-group-icon"></span>
                    <span><%= group[j].name %></span>
                </div>
                <ul>
                    <% for(var i = 0, list = renderNav(group[j].folders); i < list.length; i++) { %>
                    <li class="folder-group-child">
                        <% if(list[i].child) {%>
                            <div class="folder-child-list folder-parent-list on" 
                                data-type="<%= group[j].type %>" data-fid="<%= list[i].id %>">
                                <span class="folder-group-open"></span>
                                <span class="folder-group-icon"></span>
                                <span><%= list[i].title %></span>
                            </div>
                            <ul>
                                <% include('folder-child-tpl', {list: list[i].child, type: group[j].type})  %>
                            </ul>
                        <% } else { %>
                            <div class="folder-child-list folder-parent-list"
                                data-type="<%= group[j].type %>" data-fid="<%= list[i].id %>">
                                <span class="folder-group-icon"></span>
                                <span><%= list[i].title %></span>
                            </div>
                        <% } %>
                    </li>
                    <% } %>
                </ul>
            <% } %>
            </div>
        </div>
    </script>
    <script id="folder-child-tpl" type="text/html">
        <% for(var i = 0; i < list.length; i++) { %>
            <li class="folder-group-child">
                <% if(list[i].child) {%>
                    <div class="folder-child-list folder-parent-list on" data-type="<%= type %>" data-fid="<%= list[i].id %>">
                        <span class="folder-group-open"></span>
                        <span class="folder-group-icon"></span>
                        <span><%= list[i].title %></span>
                    </div>
                    <ul>
                        <% include('folder-child-tpl', {list:list[i].child, type: type})  %>
                    </ul>
                <% } else { %>
                    <div class="folder-child-list folder-parent-list" data-type="<%= type %>" data-fid="<%= list[i].id %>">
                        <span class="folder-group-icon"></span>
                        <span><%= list[i].title %></span>
                    </div>
                <% } %>
            </li>
        <% } %>
    </script>
    <script id="pdf-tpl" type="text/html">
        <html><head><meta charset="utf-8">
            <style>.markdown-body pre{background-color:#f7f7f7;}</style>
            </head><body><div class="markdown-body">##content##</div></body>
        </html>
    </script>
    <script id="folder-list-tpl" type="text/html">
        <% for(var i = 0; i < list.length; i++) { %>
            <li class="folder-item" data-id="<%= list[i].id %>">
                <p class="folder-title"><span class="icon-folder"></span><%= list[i].title %></p>
                <p class="folder-time"><%= list[i].updated_at %></p>
            </li>
        <% } %>
    </script>
    <script id="list-tpl" type="text/html">
        <% for(var i = 0; i < list.length; i++) { %>
        <li class="doc-item <% if(list[i].id === active) {%> active <% } %>" data-id="<%= list[i].id %>" data-fid="<%= list[i].f_id %>">
            <p class="doc-title">
                <% if(list[i].type === '1') {%><span class="icon-md"></span>
                <% }else{ %><span class="icon-note"></span>
                <% } %>
                <span class="list-title-text"><%= list[i].title %></span>
            </p>
            <p class="doc-author">
                <span>创建人：<%= list[i].author %></span>
                <% if(list[i].last_updated_name) {%>
                <span>最后修改人：<%= list[i].last_updated_name %></span>
                <% } %>
            </p>
            <p class="doc-time">
                <span><%= list[i].updated_at %></span>
            </p>
        </li>
        <% } %>
    </script>
    <script id="recycle-tpl" type="text/html">
        <% for(var i = 0; i < list.length; i++) { %>
        <li class="doc-item" data-id="<%= list[i].id %>" data-fid="<%= list[i].f_id %>">
            <p class="doc-title">
                <% if(list[i].type === '1') {%><span class="icon-md"></span>
                <% }else{ %><span class="icon-note"></span>
                <% } %>
                <span class="list-title-text"><%= list[i].title %></span>
            </p>
            <p class="doc-author">
                <span>创建人：<%= list[i].author %></span>
                <% if(list[i].last_updated_name) {%>
                <span>删除人：<%= list[i].last_updated_name %></span>
                <% } %>
            </p>
            <p class="doc-time">
                <span>删除时间：<%= list[i].updated_at %></span>
            </p>
        </li>
        <% } %>
    </script>
    <script id="add-input-tpl" type="text/html">
        <li class="child-item">
            <div class="second-menu-a" data-id="" data-pid="">
                <span class="child-menu-open"></span>
                <span class="child-menu-icon"></span>
                <span class="item-name"><input type="text"></span>
                <span class="item-count">(0)</span>
                <span class="child-menu-down" data-idx="##idx##" data-type="##type##" data-gid="##gid##"></span>
            </div>
        </li>
    </script>

    <script id="group-tpl" type="text/html">
    <% for(var j = 0; j < group.length; j++) { %>
        <li class="pure-menu-item nav-doc-item group-<%= j %>">
            <div class="nav-doc-a first-menu-a is-parent" data-switch="on">
                <span><%= group[j].name %></span>
            </div>
            <ul class="child-list first-child-list">
                <% idx = 1; for(var i = 0, list = renderNav(group[j].folders); i < list.length; i++) { %>
                    <li class="child-item">
                    <% if(list[i].child) {%> 
                        <div class="second-menu-a is-parent on" data-id="<%= list[i].id %>" data-pid="<%= list[i].p_id %>" data-switch="on">
                    <% }else{ %>
                        <div class="second-menu-a" data-id="<%= list[i].id %>" data-pid="<%= list[i].p_id %>">
                    <% } %>
                            <span class="child-menu-open"></span>
                            <span class="child-menu-icon"></span>
                            <span class="item-name"><%= list[i].title %></span>
                            <span class="item-count g_<%= list[i].id %>">(<%= list[i].currentCount %><% if(list[i].hasOwnProperty('totalCount')) {%>/<%= list[i].totalCount %><% } %>)</span>
                            <span class="child-menu-down" data-idx="<%= idx %>" data-type="<%= group[j].type %>" data-gid="<%= group[j].id %>"></span>
                        </div>

                        <% if(list[i].child) {%>
                            <ul class="child-list">
                            <% include('nav-tpl', {list:list[i].child, idx: idx, type: group[j].type, gid: group[j].id})  %>
                            </ul>
                        <% } %>
                    </li>
                <% } %>
                <li class="child-item child-item-input">
                    <input type="text" name="add_dir<%= group[j].id %>" data-type="<%= group[j].type %>" data-gid="<%= group[j].id %>">
                </li>
                <li class="child-item add-dir">
                    <span>+</span>新建文件夹
                </li>
            </ul>
            
        </li>
    <% } %>
    </script>

    <script id="nav-tpl" type="text/html">
    	<% idx++; for(var i = 0; i < list.length; i++) { %>
            <li class="child-item">
            <% if(list[i].child) {%> 
    			<div class="second-menu-a is-parent on" data-id="<%= list[i].id %>" data-pid="<%= list[i].p_id %>" data-switch="on">
            <% }else{ %>
                <div class="second-menu-a" data-id="<%= list[i].id %>" data-pid="<%= list[i].p_id %>">
            <% } %>
                	<span class="child-menu-open"></span>
                    <span class="child-menu-icon"></span>
                    <span class="item-name"><%= list[i].title %></span>
                    <span class="item-count g_<%= list[i].id %>">(<%= list[i].currentCount %><% if(list[i].hasOwnProperty('totalCount')) {%>/<%= list[i].totalCount %><% } %>)</span>
                    <span class="child-menu-down" data-idx="<%= idx %>" data-type="<%= type %>" data-gid="<%= gid %>"></span>
                </div>

                <% if(list[i].child) {%>
                	<ul class="child-list">
                	<% include('nav-tpl', {list:list[i].child, idx: idx, type: type, gid: gid})  %>
                	</ul>
                <% } %>
            </li>
        <% } %>
    </script>
@endsection
@section('script')
    <script src="{{asset('/libs/editormd/lib/raphael.min.js')}}"></script>
    <script src="{{asset('/libs/seajs/sea.js')}}"></script>
    <script src="{{asset('/module/doc/js/index.js')}}"></script>
@endsection