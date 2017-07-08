/**
 * Created by linxin on 2017/6/26.
 */
var $window = $(window),
    $menuBtn = $('.nav-menu-button'),
    $list_ul = $('.list-content-ul'),               // 笔记列表
    $list_box = $('.list-content'),                 // 笔记列表盒子
    $doc_box = $('.doc-content');                   // 笔记详情盒子


var AUTO_TIME = 0.1 * 60 * 1000;

var g_id = null,                // 定义一个全局id 用来存储当前操作目录的id
    $g_folder = null,
    mdeditor = null,            // md 编辑器
    wangeditor = null,          // wangeditor 编辑器
    md_time = null,
    wang_time = null,
    cur_note = null,
    sort_type = localStorage.getItem('sort_type') || 'updated_at',  // 排序类型
    sort_order = localStorage.getItem('sort_order') || 'desc',      // 排序方式
    share_title = null,         // 分享标题
    cur_page = 1,               // 当前笔记列表的页码
    totalPage = null,           // 笔记列表总页码
    isLoading = false;          // 是否正在加载列表

var folder = {
    init: function () {
        folder.initNav();
        folder.clickHandle();
    },
    // 渲染文件夹列表
    initNav: function () {
        var tpl = $('#nav-tpl').html();
        var list = [];
        $.get('/folder/list', function (res) {
            list = res.data.categories;
            var allList = res.data.allCategories, allLen = allList.length;
            if (allLen) {
                for (var i = 0; i < allLen - 1; i++) {
                    for (var j = 1; j < allLen; j++) {
                        if (allList[i].id === allList[j].p_id) {
                            if (!allList[i].child) {
                                allList[i].child = []
                            }
                            allList[i].child.push(allList[j]);
                        }
                    }
                }
                for (i = 0; i < list.length; i++) {
                    for (j = 0; j < allLen; j++) {
                        if (list[i].id === allList[j].p_id) {
                            if (!list[i].child) {
                                list[i].child = []
                            }
                            list[i].child.push(allList[j]);
                        }
                    }
                }
            }
            var html = template('nav-tpl', {list: list, idx: 0, active: list[0].id});
            $('.first-child-list').prepend(html);
            note.getList(list[0].id);
            g_id = list[0].id;
            note.init();
        });
    },
    clickHandle: function () {
        var $layout = $('#layout'),
            $nav = $('#nav'),
            $newDocBtn = $('.new-doc-box'),
            $addDir = $('.add-dir'),
            $input = $('.child-item-input input'),
            $firstParent = $('.first-menu-a.is-parent');
        // 收起侧边栏
        $menuBtn.on('click', function () {
            if ($layout.hasClass('middle')) {
                $layout.removeClass('middle');
                $menuBtn.removeClass('right');
                $firstParent.data('switch', 'on').siblings('ul').slideDown(300);
            } else {
                $layout.addClass('middle');
                $menuBtn.addClass('right');
                $firstParent.data('switch', 'off').siblings('ul').slideUp(300);
            }
        });
        if($window.width() < 1200){
            $menuBtn.click();
        }
        $window.resize(function(){
            var $self = $(this);
            if(($self.width() < 1200 && !$layout.hasClass('middle')) || ($self.width() > 1200 && $layout.hasClass('middle'))){
                $menuBtn.click();
            }
        });

        // 点击新建文档事件
        $newDocBtn.on('click', function (e) {
            e.stopPropagation();
            var $self = $(this);
            $self.hasClass('active') ? $self.removeClass('active') : $self.addClass('active');
            $(document).one('click',function () {
                $self.hasClass('active') ? $self.removeClass('active') : '';
            })
        });

        // 左边栏目录点击事件
        $nav.on('click', '.child-menu-open', function (e) {
                e.stopPropagation();
                var self = $(this).parent(),
                    ul_switch = self.data('switch');
                if (ul_switch == 'on') {
                    self.data('switch', 'off').removeClass('on').siblings('ul').slideUp(300);
                } else {
                    self.data('switch', 'on').addClass('on').siblings('ul').slideDown(300);
                }
            })
            // 点击我的文档目录事件
            .on('click','.nav-doc-a',function () {
                var self = $(this),
                    ul_switch = self.data('switch');
                if ($layout.hasClass('middle')) {
                    $layout.removeClass('middle');
                    $menuBtn.removeClass('right');
                    self.data('switch', 'on').addClass('on').siblings('ul').slideDown(300);
                } else {
                    if (ul_switch == 'on') {
                        self.data('switch', 'off').removeClass('on').siblings('ul').slideUp(300);
                    } else {
                        self.data('switch', 'on').addClass('on').siblings('ul').slideDown(300);
                    }
                }
            })
            .on('click','.second-menu-a',function () {
                var $self = $(this);
                g_id = $self.data('id');
                $('.child-item.active').removeClass('active');
                $self.parent().addClass('active');
                cur_page = 1;
                note.getList(g_id);
            })
            // 点击下拉菜单
            .on('click', '.child-menu-down', function (e) {
                e.stopPropagation();
                var $self = $(this),
                    idx = $self.data('idx'),
                    $downBox = $('.down-box'),
                    $downIcon = $('.child-menu-down');

                g_id = $self.parent().data('id');
                $g_folder = $self.parent().parent();

                if (!$self.hasClass('active')) {
                    $downIcon.removeClass('active');
                    $self.addClass('active');
                    $downBox.fadeIn(200).css('top', e.pageY - e.offsetY - 105);
                    // 如果是第四级目录，则不给添加子文件夹
                    var $add_p = $('.down-box p[data-type="add"]');
                    if(idx == '4'){
                        $add_p.hide();
                    }else{
                        $add_p.show();
                    }
                    // 点击其他地方则隐藏下拉框
                    $(document).one("click", function () {
                        $downBox.fadeOut(200);
                        $downIcon.removeClass('active');
                    });
                } else {
                    $self.removeClass('active');
                    $downBox.fadeOut(200);
                    $g_folder = null;
                }
            })
            // 选中下拉菜单事件
            .on('click', '.down-box p', function (e) {
            e.stopPropagation();
            var $self = $(this),
                type = $self.data('type'),
                id = $self.data('id'),
                $icon = $('.child-menu-down.active'),
                elem = $icon.parent().parent(), text = null;

            $self.parent().hide();
            $icon.removeClass('active');

            switch (type) {
                // 新建子文件夹
                case 'add':
                    text = $('#add-input-tpl').html();
                    if (elem.find('.child-list').length === 0) {
                        elem.append('<ul class="child-list">' + text + '</ul>');
                    } else {
                        elem.children('.child-list').append(text);
                    }
                    // 监听输入框失去焦点和回车事件
                    elem.find('ul input').focus().on('blur keypress', function (e) {
                        var $self = $(this),
                            value = $self.val(),
                            $menu_a = $self.parent().parent();
                        if(e.keyCode === 13){
                            $self.off('blur');
                        }else if(e.type !== 'blur'){
                            return ;
                        }
                        if (value) {
                            $.post('/folder/add', {
                                title: value,
                                p_id: g_id
                            }, function (res) {
                                if(res.code === 200){
                                    var tag = $self.parent().parent().parent().parent().prev('a');
                                    $(this).parent().html(value);
                                    if (!tag.hasClass('is-parent')) {
                                        tag.addClass('is-parent on').data('switch', 'on');
                                    }
                                    $menu_a.removeClass('last-menu-a')
                                        .addClass('second-menu-a')
                                        .data('id',res.data.id);
                                    $menu_a = null;
                                }else if(res.code === 403){
                                    layer.msg(res.msg);
                                    $menu_a.parent().remove();
                                    $menu_a = null;
                                }
                            })
                        } else {
                            $menu_a.parent().remove();
                            $menu_a = null;
                        }
                    });
                    break;
                // 文件夹重命名
                case 'rename':
                    elem = $icon.parent().find('.item-name');
                    text = elem.text();
                    elem.html('<input type="text" value="' + text + '">')
                        .find('input').focus().on('blur keypress', function (e) {
                        var $self = $(this),
                            value = $self.val();
                        if(e.keyCode === 13){
                            $self.off('blur');
                        }else if(e.type !== 'blur'){
                            return ;
                        }
                        if (value) {
                            elem.text(value);
                            $.post('/folder/update', {
                                title: value,
                                id: g_id
                            }, function (res) {
                                console.log(res);
                            })
                        } else {
                            elem.text(text);
                        }
                    }).on('click', function (e) {
                        e.stopPropagation();
                    });
                    break;
                // 删除文件夹
                case 'del':
                    layer.confirm('删除不可恢复，是否确定删除？', {
                        btn: ['确定','取消']
                    }, function(){
                        main.delFolder();
                    });
                    break;
            }
        })
            // 打开我的分享
            .on('click', '.nav-share-item',function () {
                var layer_share = layer.open({
                    type: 2,
                    title: '我的分享',
                    content: '/myshare',
                    area: ['100%', '100%'],
                    maxmin: false
                });
                layer.full(layer_share);
            });

        // 新建文件夹
        $addDir.on('click', function () {
            $(this).prev('.child-item-input').show().find('input').focus();
        });
        // 我的文档下级新建文件夹输入框失去焦点时或回车触发
        $input.on('blur keypress',function (e) {
            var $self = $(this);
            if(e.keyCode === 13){
                $self.off('blur keypress');
            }else if(e.type !== 'blur'){
                return ;
            }
            folder.addFirstFolder($self);
            $self.on('focus',function () {
                $self.off('blur keypress').on('blur keypress',function (e) {
                    var $self = $(this);
                    if (e.keyCode === 13) {
                        $self.off('blur keypress');
                    }else if(e.type !== 'blur'){
                        return ;
                    }
                    folder.addFirstFolder($self);
                })
            })
        });
    },
    // 我的文档下级新建文件夹事件
    addFirstFolder: function(self){
        var value = self.val();
        if (value) {
            $.post('/folder/add',{title: value, p_id: 0}, function (res) {
                if(res.code === 200){
                    var list = [
                        {
                            id: res.data.id,
                            title: value,
                            p_id: 0
                        }
                    ];
                    var html = template('nav-tpl', {list: list, idx: 0});
                    $('.child-item-input').before(html);
                }else{
                    layer.msg(res.msg);
                }
            })
        }
        self.val('').parent().hide();
    }
};

var note = {
    init: function(){
        var $sortLi = $('.sort-down-menu li');

        note.clickListEvent();

        $sortLi.each(function () {
            var $self = $(this);
            if($self.data('type') === sort_type){
                $self.addClass('active ' + sort_order);
            }
        })
    },
    // 加载笔记列表
    getList: function (folder_id) {
        $.get('/note/show', {
            id: folder_id,
            field: sort_type,
            order: sort_order,
            page: cur_page
        }, function (res) {
            isLoading = false;
            if(res.code === 200){
                if(res.data.data.length){
                    $doc_box.removeClass('null');
                    $list_box.removeClass('null');
                    var html = null;
                    if(cur_page === 1){
                        html = template('list-tpl', {list: res.data.data, active: res.data.data[0].id});
                        $list_ul.html(html);
                        note.scorllHandle();
                        note.getNoteDetail(res.data.data[0].id);
                        totalPage = res.data.totalPage;
                    }else{
                        html = template('list-tpl', {list: res.data.data, active: null});
                        $list_ul.append(html);
                        $(".list-content").getNiceScroll().resize()
                    }
                    cur_page ++;
                }else{
                    if(cur_page === 1){
                        $doc_box.addClass('null');
                        $list_box.addClass('null');
                        $list_ul.html('');
                        mdeditor && mdeditor.clear();
                    }
                }
            }
        })
    },
    // 显示笔记内容
    getNoteDetail: function (note_id) {
        $.get('/note/find', {id: note_id}, function (res) {
            if(res.code === 200){
                $('.doc-preview-body').html(res.data.content);
                $doc_box.removeClass('is-edit is-edit-1 is-edit-2').addClass('no-edit');
                $('.doc-title-span').html(res.data.title);
                cur_note = res.data;
                mdeditor && mdeditor.clear();
            }
        })
    },
    // 监听事件
    clickListEvent: function(){
        // 点击列表
        $list_ul.on('click','.doc-item', function () {
            var $self = $(this);
            if(!$self.hasClass('active')){
                $self.addClass('active').siblings().removeClass('active');
                var note_id = $self.data('id');
                note.getNoteDetail(note_id);
            }
        });
        // 点击列表删除图表
        $list_ul.on('click','.list-del-icon', function (e) {
            e.stopPropagation();
            var elem = $(this).parent().parent(),
                note_id = elem.data('id');
            note.delNote(note_id, elem);
        });
        // 点击列表分享图标
        $list_ul.on('click','.list-share-icon', function (e) {
            e.stopPropagation();
            var elem = $(this).parent().parent(),
                note_id = elem.data('id'),
                title = elem.find('.list-title-text').text();
            $('.mask,.share-dialog').show();
            var g_url = window.location.href;
            $('.share-copy-c input').val(g_url);
            new ZeroClipboard( document.getElementById("btnCopy"));

            share_title = title + ' -- 来自云笔记';

            $('.share-close').on('click',function () {
                $('.mask,.share-dialog').hide();
                $(this).off('click');
            })
        });
        // 选择排序方式
        $('.sort-down-menu li').on('click', function () {
            var $self = $(this),
                type = $self.data('type');
            if(type === sort_type){
                if($self.hasClass('desc')){
                    $self.addClass('asc').removeClass('desc');
                    sort_order = 'asc';
                }else{
                    $self.addClass('desc').removeClass('asc');
                    sort_order = 'desc';
                }
            }else{
                sort_type = type;
                if($self.hasClass('desc')){
                    $self.addClass('active asc').removeClass('desc').siblings().removeClass('active');
                    sort_order = 'asc';
                }else{
                    $self.addClass('active desc').removeClass('asc').siblings().removeClass('active');
                    sort_order = 'desc';
                }
            }
            cur_page = 1;
            note.getList(g_id);
        })
    },
    // 笔记列表滚动事件
    scorllHandle: function () {
        $list_box.on('scroll',function () {
            var ul_height = $list_ul.height(),
                box_height = $list_box.height();
            if(totalPage >= cur_page && $list_box.scrollTop() + box_height > ul_height - 50 && !isLoading){
                isLoading = true;
                note.getList(g_id);
            }
        });

        var niceScroll = $('.list-content').niceScroll({
            cursorcolor: '#999',
            autohidemode: 'leave',
            horizrailenabled: false,
            cursorborder: '0'
        });
    },
    // 初始化编辑器
    initEditor: function (type, value) {
        var height = $window.height() - $('.doc-content-header').outerHeight() - 50;
        if(type === '1'){
            if(!!mdeditor){
                value ? mdeditor.setMarkdown(value) : mdeditor.clear();
            }else{
                mdeditor = editormd("editormd", {
                    path: "./libs/editormd/lib/",
                    width: '100%',
                    height: height,
                    markdown: value || '',
                    disabledKeyMaps: ["Ctrl-S"],
                    imageUpload: true,
                    imageFormats: ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
                    imageUploadURL: "/common/mdEditorUpload",
                    toolbarIcons: function () {
                        return ["undo", "redo", "|", "bold", "del", "italic", "quote", "hr", "|", "h1", "h2", "h3",
                            "|", "list-ul", "list-ol", "link", "image", "code-block", "table", "datetime",
                            "watch", "preview", "fullscreen", "clear", "search"
                        ]
                    },
                    onchange : function() {
                        note.autoSaveNote();
                    },
                    onload : function() {
                        var keyMap = {
                            "Ctrl-S": function(cm) {
                                note.saveNote();
                            }
                        };
                        this.addKeyMap(keyMap);
                    }
                });
            }
            md_time = setInterval(main.autoSaveNote, AUTO_TIME);
        }else if(type === '2'){
            if(!!wangeditor){
                wangeditor.txt.html(value || '');
            }else{
                wangeditor = new wangEditor('#editor');
                wangeditor.customConfig.uploadImgServer = '/common/wangEditorUpload';
                wangeditor.customConfig.uploadFileName = 'image-file';
                wangeditor.create();
                wangeditor.txt.html(value || '');
                $('.w-e-text-container').height(height-41);
                $('.w-e-text').keydown(function(e){
                    if( e.ctrlKey  == true && e.keyCode == 83 ){
                        note.saveNote();
                        return false;
                    }
                });
            }

        }
    },
    // 新建笔记
    newNote: function (type) {
        type = type || '1';
        $.post('/note/add',{
            title: '新建笔记',
            f_id: g_id,
            type: type
        },function(res){
            if(res.code === 200){
                $('.doc-item.active').removeClass('active');
                var list = [res.data];
                var html = template('list-tpl', {list: list, active: res.data.id});
                $list_ul.prepend(html);
                $doc_box.removeClass('null no-edit').addClass('is-edit is-edit-'+type);
                $list_box.removeClass('null');
                $('.doc-title-input').val('');
                cur_note = res.data;
                note.initEditor(type);
            }else if(res.code === 403){
                layer.msg(res.msg);
            }
        })
    },
    // 删除笔记
    delNote: function (note_id, elem) {
        $.post('/note/del',{id: note_id}, function (res) {
            if(res.code === 200){
                layer.msg('删除成功');
                elem.remove();
                if(!$('.doc-item.active').length){
                    $doc_box.addClass('null');
                }
                if(!$list_ul.find('.doc-item').length){
                    $list_box.addClass('null');
                }
            }else{
                layer.msg(res.msg);
            }

        })
    },
    // 编辑笔记
    editNote: function () {
        $('.doc-title-input').val(cur_note.title);
        $doc_box.removeClass('no-edit').addClass('is-edit is-edit-'+cur_note.type);
        cur_note.type === '1' ? note.initEditor('1', cur_note.origin_content) : note.initEditor(cur_note.type, cur_note.content);
    },
    // 保存笔记
    saveNote: function () {
        var title = $('.doc-title-input').val(),
            md_cnt = cur_note.type === '1' ? mdeditor.getMarkdown(): '',
            html_cnt = cur_note.type === '1' ? mdeditor.getPreviewedHTML() : wangeditor.txt.html(),
            note_id = $('.doc-item.active').data('id');
        $.post('/note/update', {
            id: note_id,
            f_id: g_id,
            title: title,
            content: html_cnt,
            origin_content: md_cnt
        }, function (res) {
            if(res.code === 200){
                $('.doc-item.active .list-title-text').text(title);
                layer.msg('保存成功');
                $('.doc-preview-body').html(html_cnt);
                $doc_box.removeClass('is-edit is-edit-1 is-edit-2').addClass('no-edit');
                $('.doc-title-span').html(title);
                cur_note = res.data;
            }else if(res.code === 403){
                layer.msg(res.msg);
            }
        })
    },
    // 自动保存笔记
    autoSaveNote: function () {
        console.log('保存了')
    }
};

var main = {
    init: function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // 禁止保存网站
        $(document).keydown(function(e){
            if( e.ctrlKey  == true && e.keyCode == 83 ){
                return false;
            }
        });
        folder.init();
    },
    // 退出登录
    loginOut: function () {
        $.post('/logout', function (res) {
            if(res.code === 200){
                layer.msg(res.msg);
                location.href = '/login';
            }
        })
    },
    // 删除目录事件
    delFolder: function () {
        $.post('/folder/del',{id: g_id}, function (res) {
            if(res.code === 200){
                $g_folder.remove();
                layer.msg('删除成功');
            }
        })
    },
    configShare: function (cmd, config) {
        if(share_title){
            config.bdText = share_title;
        }
        return config;
    }
};
main.init();
