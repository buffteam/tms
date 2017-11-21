@extends('layouts.doc.index')

@section('style')
    <link rel="stylesheet" href="{{asset('libs/editormd/css/editormd.min.css')}}">
    <link rel="stylesheet" href="{{asset('libs/wangEditor-3.0.3/wangEditor.min.css')}}">
    <link rel="stylesheet" href="{{asset('libs/webuploader-0.1.5/webuploader.css')}}">
    <link rel="stylesheet" href="{{asset('libs/jquery-smartMenu/css/smartMenu.css')}}">
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
                        <li class="pure-menu-item nav-share-item">
                            <div class="first-menu-a">我的分享</div>
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
                            <li class="list-move">发布到</li>
                            <li class="list-share">分享</li>
                            <li class="list-unshare" style="display: none;">取消分享</li>
                            <li class="list-line"></li>
                            <li class="list-tomd" style="display: none;">下载文档</li>
                            <li class="list-topdf">导出PDF</li>
                            <li class="list-del">删除笔记</li>
                        </ul>
                    </div>
                </div>
                <div class="doc-content-footer">
                    <div class="attachment-header">附件(点击可收起展开)</div>
                    <div class="attachment-content">
                        <ul class="attachment-content-ul"></ul>
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

    @extends('doc.tpl')
    
@endsection
@section('script')
    <script src="{{asset('/libs/editormd/lib/raphael.min.js')}}"></script>
    <script src="{{asset('/libs/seajs/sea.js')}}"></script>
    <script src="{{asset('/module/doc/js/index.js')}}"></script>
@endsection