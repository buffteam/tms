<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="">
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
                            <a href="#" class="first-menu-a toggle-item">我的文档</a>
                            <ul class="child-list">
                                <li class="child-item active"><a href="#" class="">IOS</a></li>
                                <li class="child-item"><a href="#" class="">Android</a></li>
                                <li class="child-item"><a href="#" class="">HTML5</a></li>
                                <li class="child-item child-item-input">
                                    <input type="text" name="add_dir1">
                                </li>
                                <li class="child-item  add-dir"><a href="#" class="">新建文件夹</a></li>
                            </ul>
                        </li>
                        <li class="pure-menu-item nav-doc-item">
                            <a href="#" class="first-menu-a toggle-item">个人笔记</a>
                            <ul class="child-list">
                                <li class="child-item"><a href="#" class="">IOS</a></li>
                                <li class="child-item"><a href="#" class="">Android</a></li>
                                <li class="child-item"><a href="#" class="">HTML5</a></li>
                                <li class="child-item child-item-input">
                                    <input type="text" name="add_dir2">
                                </li>
                                <li class="child-item  add-dir"><a href="#" class="">新建文件夹</a></li>
                            </ul>
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

    <script src="{{asset('/libs/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('/libs/editormd/editormd.min.js')}}"></script>
    <script>
        var height = $(window).height() - $('.doc-content-header').outerHeight() - 50;
        var editor = editormd("editormd", {
            path: "/libs/editormd/lib/",
            width: '100%',
            height: height,
            toolbarIcons: function () {
                return ["undo", "redo", "|", "bold", "del", "italic", "quote", "hr", "|", "h1", "h2", "h3",
                    "|", "list-ul", "list-ol", "link", "image", "code-block", "table", "datetime",
                    "watch", "preview", "fullscreen", "clear", "search"
                ]
            },
        });
        var $input = $('.child-item-input input'),
            $layout = $('#layout'),
            $menuBtn = $('.nav-menu-button');

        $('.toggle-item').on('click', function () {
            var self = $(this);
            if ($layout.hasClass('middle')) {
                $layout.removeClass('middle');
                $menuBtn.removeClass('right');
                self.next('.child-list').slideDown(300);
            } else {
                self.next('.child-list').toggle(300);
            }
        })
        // 新建文件夹
        $('.add-dir').on('click', function () {
            $(this).prev('.child-item-input').show().find('input').focus();
        })
        // 输入框失去焦点时触发
        $input.blur(function () {
            var value = $(this).val();
            if (value) {
                console.log(value);
            }
            $(this).val('').parent().hide();
        })

        // 收起左边栏
        $menuBtn.on('click', function () {
            if ($layout.hasClass('middle')) {
                $layout.removeClass('middle');
                $menuBtn.removeClass('right');
            } else {
                $layout.addClass('middle');
                $menuBtn.addClass('right');
            }
        })
    </script>




</body>

</html>