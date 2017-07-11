@extends('layouts.doc.index')
@section('title')
    <title>云笔记</title>
@endsection

@section('style')
    <link rel="stylesheet" href="{{asset('module/doc/css/layouts/main.css')}}">
    <link rel="stylesheet" href="{{asset('module/doc/css/dialog.css')}}">
@endsection

@section('content')
    <div id="layout" class="content pure-g">
        <div id="nav" class="">
            <span class="nav-menu-button"></span>

            <div class="nav-inner">
                <div class="pure-menu">
                    <ul class="pure-menu-list">
                        <li class="pure-menu-item new-note-item">
                            <span class="middle-add-item" onclick="note.newNote('1')"></span>
                            <div class="new-doc-box">
                                <span class="add-icon"><img src="{{asset('module/doc/imgs/icon/add.png')}}"></span>
                                <span class="add-text">新建文档</span>
                                <ul class="add-list">
                                    <li onclick="note.newNote('1')">新建md文档</li>
                                    <li onclick="note.newNote('2')">新建笔记</li>
                                </ul>
                            </div>
                        </li>
                        <li class="pure-menu-item nav-newest-item active">
                            <a href="#" class="first-menu-a">最新笔记</a>
                        </li>
                        <li class="pure-menu-item nav-doc-item">
                            <a href="#" class="nav-doc-a first-menu-a is-parent" data-switch="on">
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
                        {{--<li class="pure-menu-item nav-share-item">--}}
                            {{--<a href="#" class="first-menu-a">我的分享</a>--}}
                        {{--</li>--}}
                        {{--<li class="pure-menu-item nav-del-item">--}}
                            {{--<a href="#" class="first-menu-a">回收站</a>--}}
                        {{--</li>--}}
                    </ul>
                </div>
            </div>
        </div>

        <div id="list" class="">
            <div class="list-head">
                <div class="search-input-box">
                    <input type="text" class="search-input" placeholder="搜索笔记">
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
                        <p>该目录下没有文档</p>
                        <span class="new-note" onclick="note.newNote('1')">新建文档</span>
                    </div>
                    <div class="search-null">
                        <p>搜索结果为空</p>
                    </div>
                </div>
            </div>

        </div>

        <div id="main">
            <div class="doc-content">
                <div class="doc-content-header pure-g">
                    <div class="pure-u-2-3 doc-content-title">
                        <input class="doc-title-input" type="text" name="title" placeholder="这里是标题">
                        <span class="doc-title-span"></span>
                    </div>

                    <div class="doc-content-controls pure-u-1-3">
                        <span class="more-btn"></span>
                        <span class="edit-btn" onclick="note.editNote()">编辑</span>
                        <span class="save-btn" onclick="note.saveNote()">保存</span>
                        <ul class="more-list">
                            <li onclick="note.htmlToPDF()">导出PDF</li>
                        </ul>
                    </div>
                </div>

                <div class="doc-content-body">
                    <div class="doc-preview-body markdown-body  editormd-preview-container">

                    </div>
                    <div class="doc-edit-body">
                        <div id="editormd" class="editor-1">
                            <textarea id="page_content" style="display:none;"></textarea>
                        </div>
                        <div id="editor" class="editor-2"></div>
                    </div>
                </div>
                <div class="doc-content-null">

                </div>
            </div>
        </div>
    </div>
    <script id="pdf-tpl" type="text/html">
        <html><head><meta charset="utf-8">
            <style>
                .markdown-body{color:#333;overflow:hidden;font-size:16px;line-height:1.6;word-wrap:break-word}.markdown-body a{background:0 0}.markdown-body a:active,.markdown-body a:hover{outline:0}.markdown-body strong{font-weight:700}.markdown-body h1{font-size:2em;margin:.67em 0}.markdown-body img{border:0}.markdown-body hr{-moz-box-sizing:content-box;box-sizing:content-box;height:0}.markdown-body pre{overflow:auto}.markdown-body code,.markdown-body kbd,.markdown-body pre{font-size:1em}.markdown-body input{color:inherit;font:inherit;margin:0}.markdown-body html input[disabled]{cursor:default}.markdown-body input{line-height:normal}.markdown-body input[type=checkbox]{-moz-box-sizing:border-box;box-sizing:border-box;padding:0}.markdown-body table{border-collapse:collapse;border-spacing:0}.markdown-body td,.markdown-body th{padding:0}.markdown-body *{-moz-box-sizing:border-box;box-sizing:border-box}.markdown-body input{font:13px;}.markdown-body a{color:#4183c4;text-decoration:none}.markdown-body a:active,.markdown-body a:hover{text-decoration:underline}.markdown-body hr{height:0;margin:15px 0;overflow:hidden;background:0 0;border:0;border-bottom:1px solid #ddd}.markdown-body hr:before{display:table;content:""}.markdown-body hr:after{display:table;clear:both;content:""}.markdown-body h1,.markdown-body h2,.markdown-body h3,.markdown-body h4,.markdown-body h5,.markdown-body h6{margin-top:15px;margin-bottom:15px;line-height:1.1}.markdown-body h1{font-size:30px}.markdown-body h2{font-size:21px}.markdown-body h3{font-size:16px}.markdown-body h4{font-size:14px}.markdown-body h5{font-size:12px}.markdown-body h6{font-size:11px}.markdown-body blockquote{margin:0}.markdown-body ol,.markdown-body ul{padding:0;margin-top:0;margin-bottom:0}.markdown-body ol ol,.markdown-body ul ol{list-style-type:lower-roman}.markdown-body ol ol ol,.markdown-body ol ul ol,.markdown-body ul ol ol,.markdown-body ul ul ol{list-style-type:lower-alpha}.markdown-body dd{margin-left:0}.markdown-body code{font-size:12px}.markdown-body pre{margin-top:0;margin-bottom:0;font:12px}.markdown-body .octicon{font:normal normal 16px octicons-anchor;line-height:1;display:inline-block;text-decoration:none;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}.markdown-body .octicon-link:before{content:'\f05c'}.markdown-body>:first-child{margin-top:0!important}.markdown-body>:last-child{margin-bottom:0!important}.markdown-body .anchor{position:absolute;top:0;left:0;display:block;padding-right:6px;padding-left:30px;margin-left:-30px}.markdown-body .anchor:focus{outline:0}.markdown-body h1,.markdown-body h2,.markdown-body h3,.markdown-body h4,.markdown-body h5,.markdown-body h6{position:relative;margin-top:1em;margin-bottom:16px;font-weight:700;line-height:1.4}.markdown-body h1 .octicon-link,.markdown-body h2 .octicon-link,.markdown-body h3 .octicon-link,.markdown-body h4 .octicon-link,.markdown-body h5 .octicon-link,.markdown-body h6 .octicon-link{display:none;color:#000;vertical-align:middle}.markdown-body h1:hover .anchor,.markdown-body h2:hover .anchor,.markdown-body h3:hover .anchor,.markdown-body h4:hover .anchor,.markdown-body h5:hover .anchor,.markdown-body h6:hover .anchor{padding-left:8px;margin-left:-30px;text-decoration:none}.markdown-body h1:hover .anchor .octicon-link,.markdown-body h2:hover .anchor .octicon-link,.markdown-body h3:hover .anchor .octicon-link,.markdown-body h4:hover .anchor .octicon-link,.markdown-body h5:hover .anchor .octicon-link,.markdown-body h6:hover .anchor .octicon-link{display:inline-block}.markdown-body h1{padding-bottom:.3em;font-size:2.25em;line-height:1.2;border-bottom:1px solid #eee}.markdown-body h1 .anchor{line-height:1}.markdown-body h2{padding-bottom:.3em;font-size:1.75em;line-height:1.225;border-bottom:1px solid #eee}.markdown-body h2 .anchor{line-height:1}.markdown-body h3{font-size:1.5em;line-height:1.43}.markdown-body h3 .anchor{line-height:1.2}.markdown-body h4{font-size:1.25em}.markdown-body h4 .anchor{line-height:1.2}.markdown-body h5{font-size:1em}.markdown-body h5 .anchor{line-height:1.1}.markdown-body h6{font-size:1em;color:#777}.markdown-body h6 .anchor{line-height:1.1}.markdown-body blockquote,.markdown-body dl,.markdown-body ol,.markdown-body p,.markdown-body pre,.markdown-body table,.markdown-body ul{margin-top:0;margin-bottom:16px}.markdown-body ol,.markdown-body ul{padding-left:2em}.markdown-body ol ol,.markdown-body ol ul,.markdown-body ul ol,.markdown-body ul ul{margin-top:0;margin-bottom:0}.markdown-body li>p{margin-top:16px}.markdown-body dl{padding:0}.markdown-body dl dt{padding:0;margin-top:16px;font-size:1em;font-style:italic;font-weight:700}.markdown-body dl dd{padding:0 16px;margin-bottom:16px}.markdown-body blockquote{padding:0 15px;color:#777;border-left:4px solid #ddd}.markdown-body blockquote>:first-child{margin-top:0}.markdown-body blockquote>:last-child{margin-bottom:0}.markdown-body table{display:block;width:100%;overflow:auto;word-break:normal;word-break:keep-all}.markdown-body table th{font-weight:700}.markdown-body table td,.markdown-body table th{padding:6px 13px;border:1px solid #ddd}.markdown-body table tr{background-color:#fff;border-top:1px solid #ccc}.markdown-body table tr:nth-child(2n){background-color:#f8f8f8}.markdown-body img{max-width:100%;-moz-box-sizing:border-box;box-sizing:border-box}.markdown-body code{padding:0;padding-top:.2em;padding-bottom:.2em;margin:0;font-size:85%;background-color:rgba(0,0,0,.04);border-radius:3px}.markdown-body code:after,.markdown-body code:before{letter-spacing:-.2em;content:"\00a0"}.markdown-body pre>code{padding:0;margin:0;font-size:100%;word-break:normal;white-space:pre;background:0 0;border:0}.markdown-body .highlight{margin-bottom:16px}.markdown-body .highlight pre,.markdown-body pre{padding:16px;overflow:auto;font-size:85%;line-height:1.45;background-color:#f7f7f7;border-radius:3px}.markdown-body .highlight pre{margin-bottom:0;word-break:normal}.markdown-body pre{word-wrap:normal}.markdown-body pre code{display:inline;max-width:initial;padding:0;margin:0;overflow:initial;line-height:inherit;word-wrap:normal;background-color:transparent;border:0}.markdown-body pre code:after,.markdown-body pre code:before{content:normal}.markdown-body kbd{display:inline-block;padding:3px 5px;font-size:11px;line-height:10px;color:#555;vertical-align:middle;background-color:#fcfcfc;border:solid 1px #ccc;border-bottom-color:#bbb;border-radius:3px;box-shadow:inset 0 -1px 0 #bbb}.markdown-body .pl-c{color:#969896}.markdown-body .pl-c1,.markdown-body .pl-mdh,.markdown-body .pl-mm,.markdown-body .pl-mp,.markdown-body .pl-mr,.markdown-body .pl-s1 .pl-v,.markdown-body .pl-s3,.markdown-body .pl-sc,.markdown-body .pl-sv{color:#0086b3}.markdown-body .pl-e,.markdown-body .pl-en{color:#795da3}.markdown-body .pl-s1 .pl-s2,.markdown-body .pl-smi,.markdown-body .pl-smp,.markdown-body .pl-stj,.markdown-body .pl-vo,.markdown-body .pl-vpf{color:#333}.markdown-body .pl-ent{color:#63a35c}.markdown-body .pl-k,.markdown-body .pl-s,.markdown-body .pl-st{color:#a71d5d}.markdown-body .pl-pds,.markdown-body .pl-s1,.markdown-body .pl-s1 .pl-pse .pl-s2,.markdown-body .pl-sr,.markdown-body .pl-sr .pl-cce,.markdown-body .pl-sr .pl-sra,.markdown-body .pl-sr .pl-sre,.markdown-body .pl-src{color:#df5000}.markdown-body .pl-mo,.markdown-body .pl-v{color:#1d3e81}.markdown-body .pl-id{color:#b52a1d}.markdown-body .pl-ii{background-color:#b52a1d;color:#f8f8f8}.markdown-body .pl-sr .pl-cce{color:#63a35c;font-weight:700}.markdown-body .pl-ml{color:#693a17}.markdown-body .pl-mh,.markdown-body .pl-mh .pl-en,.markdown-body .pl-ms{color:#1d3e81;font-weight:700}.markdown-body .pl-mq{color:teal}.markdown-body .pl-mi{color:#333;font-style:italic}.markdown-body .pl-mb{color:#333;font-weight:700}.markdown-body .pl-md,.markdown-body .pl-mdhf{background-color:#ffecec;color:#bd2c00}.markdown-body .pl-mdht,.markdown-body .pl-mi1{background-color:#eaffea;color:#55a532}.markdown-body .pl-mdr{color:#795da3;font-weight:700}.markdown-body kbd{display:inline-block;padding:3px 5px;font:11px;line-height:10px;color:#555;vertical-align:middle;background-color:#fcfcfc;border:solid 1px #ccc;border-bottom-color:#bbb;border-radius:3px;box-shadow:inset 0 -1px 0 #bbb}.markdown-body .task-list-item{list-style-type:none}.markdown-body .task-list-item+.task-list-item{margin-top:3px}.markdown-body .task-list-item input{float:left;margin:.3em 0 .25em -1.6em;vertical-align:middle}.markdown-body :checked+.radio-label{z-index:1;position:relative;border-color:#4183c4}.editormd-html-preview,.editormd-preview-container{text-align:left;font-size:14px;line-height:1.6;padding:20px;overflow:auto;width:100%;background-color:#fff}.editormd-html-preview blockquote,.editormd-preview-container blockquote{color:#666;border-left:4px solid #ddd;padding-left:20px;margin-left:0;font-size:14px;font-style:italic}.editormd-html-preview p code,.editormd-preview-container p code{margin-left:5px;margin-right:4px}.editormd-html-preview abbr,.editormd-preview-container abbr{background:#ffd}.editormd-html-preview hr,.editormd-preview-container hr{height:1px;border:none;border-top:1px solid #ddd;background:0 0}.editormd-html-preview code,.editormd-preview-container code{border:1px solid #ddd;background:#f6f6f6;padding:3px;border-radius:3px;font-size:14px}.editormd-html-preview pre,.editormd-preview-container pre{border:1px solid #ddd;background:#f6f6f6;padding:10px;-webkit-border-radius:3px;-moz-border-radius:3px;-ms-border-radius:3px;-o-border-radius:3px;border-radius:3px}.editormd-html-preview pre code,.editormd-preview-container pre code{padding:0}.editormd-html-preview code,.editormd-html-preview kbd,.editormd-html-preview pre,.editormd-preview-container code,.editormd-preview-container kbd,.editormd-preview-container pre{}.editormd-html-preview table thead tr,.editormd-preview-container table thead tr{background-color:#F8F8F8}.editormd-html-preview p.editormd-tex,.editormd-preview-container p.editormd-tex{text-align:center}.editormd-html-preview span.editormd-tex,.editormd-preview-container span.editormd-tex{margin:0 5px}.editormd-html-preview .emoji,.editormd-preview-container .emoji{width:24px;height:24px}.editormd-html-preview .katex,.editormd-preview-container .katex{font-size:1.4em}.editormd-html-preview .flowchart,.editormd-html-preview .sequence-diagram,.editormd-preview-container .flowchart,.editormd-preview-container .sequence-diagram{margin:0 auto;text-align:center}.editormd-html-preview .flowchart svg,.editormd-html-preview .sequence-diagram svg,.editormd-preview-container .flowchart svg,.editormd-preview-container .sequence-diagram svg{margin:0 auto}.editormd-html-preview .flowchart text,.editormd-html-preview .sequence-diagram text,.editormd-preview-container .flowchart text,.editormd-preview-container .sequence-diagram text{font-size:15px!important;}
            </style>
            </head><body><div class="markdown-body editormd-preview-container">##content##</div></body>
        </html>
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
            <p class="doc-time">
                <%= list[i].updated_at %>
            </p>
            <p class="doc-hover-icon">
                <span class="list-share-icon" title="分享"></span>
                <span class="list-del-icon" title="删除"></span>
            </p>
        </li>
        <% } %>
    </script>
    <script id="add-input-tpl" type="text/html">
        <li class="child-item">
            <a href="#" class="last-menu-a" data-id="">
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
			<a href="#" class="second-menu-a is-parent on" data-id="<%= list[i].id %>" data-pid="<%= list[i].p_id %>" data-switch="on">
        <% }else{ %>
            <a href="#" class="second-menu-a" data-id="<%= list[i].id %>" data-pid="<%= list[i].p_id %>">
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
@endsection
@section('script')
    <script src="{{asset('/module/doc/js/index.js')}}"></script>
    <script>window._bd_share_config={"common":{onBeforeClick: main.configShare,"bdSnsKey":{},"bdText":"","bdMini":"1","bdMiniList":["sqq"],"bdPic":"","bdStyle":"1","bdSize":"32"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?cdnversion='+~(-new Date()/36e5)];</script>
@endsection