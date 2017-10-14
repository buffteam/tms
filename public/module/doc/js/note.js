/**
 * Created by linxin on 2017/8/11.
 */
define(function (require, exports, module) {
    var $ = require('jquery');
    var template = require('template');
    var editor = require('./editor');

    var $search = $('.search-input'),
        $searchClose = $('.search-close'),
        $list_ul = $('.list-content-ul'),               // 笔记列表
        $list_box = $('.list-content'),                 // 笔记列表盒子
        $doc_box = $('.doc-content');                   // 笔记详情盒子

    var note = {
        init: function () {
            note.clickListEvent();
            var $sortLi = $('.sort-down-menu li');
            $sortLi.each(function () {
                var $self = $(this);
                if ($self.data('type') === sort_type) {
                    $self.addClass('active ' + sort_order);
                }
            });
        },
        // 获取最新笔记
        getNewList: function () {
            isNewest = true;
            isShare = isSearch = isRecycle = false;
            $.get(host + '/note/latest', function (res) {
                isLoading = false;
                if (res.code === 200) {
                    if (res.data.length) {
                        $doc_box.removeClass('null');
                        $list_box.removeClass('null is-search-null');
                        var html = template('list-tpl', {list: res.data, active: res.data[0].id});
                        $list_ul.html(html);
                        niceScroll ? $list_box.getNiceScroll().resize() : note.scorllHandle();
                        note.getNoteDetail(res.data[0].id);
                    } else {
                        $doc_box.addClass('null');
                        $list_box.addClass('null').removeClass('is-search-null');
                        $list_ul.html('');
                        mdeditor && mdeditor.clear();
                    }
                }
            })
        },
        // 加载笔记列表
        getList: function (folder_id) {
            $.get(host + '/note/show', {
                id: folder_id,
                field: sort_type,
                order: sort_order,
                page: cur_page
            }, function (res) {
                isLoading = false;
                if (res.code === 200) {
                    if (res.data.data.length || res.data.folders.length) {
                        $doc_box.removeClass('null');
                        $list_box.removeClass('null is-search-null');
                        var html = template('folder-list-tpl', {list: res.data.folders});
                        if(res.data.data.length){
                            if (cur_page === 1) {
                                html += template('list-tpl', {list: res.data.data, active: res.data.data[0].id});
                                $list_ul.html(html);
                                note.scorllHandle();
                                note.getNoteDetail(res.data.data[0].id);
                                totalPage = res.data.totalPage;
                            } else {
                                html += template('list-tpl', {list: res.data.data, active: null});
                                $list_ul.append(html);
                                $list_box.getNiceScroll().resize()
                            }
                        }else{
                            $list_ul.html(html);
                            $doc_box.addClass('null');
                            cur_note = null;
                            note.scorllHandle();
                            totalPage = res.data.totalPage;
                        }
                        cur_page++;
                    } else {
                        if (cur_page === 1) {
                            $doc_box.addClass('null');
                            $list_box.addClass('null').removeClass('is-search-null');
                            $list_ul.html('');
                            mdeditor && mdeditor.clear();
                        }
                    }
                } else {
                    layer.msg(res.msg);
                }
            })
        },
        // 获取回收站列表
        getRecycle: function () {
            $.get(host + '/note/recycle', {
                page: cur_page,
                field: sort_type,
                order: sort_order
            }, function (res) {
                isLoading = false;
                if (res.code === 200) {
                    if (res.data.data.length) {
                        $list_box.removeClass('null is-search-null');
                        var html = template('recycle-tpl', {list: res.data.data});
                        if (cur_page === 1) {
                            $list_ul.html(html);
                            note.scorllHandle();
                            totalPage = res.data.totalPage;
                        } else {
                            $list_ul.append(html);
                            $list_box.getNiceScroll().resize()
                        }
                        cur_page++;
                    } else {
                        if (cur_page === 1) {
                            $doc_box.addClass('null');
                            $list_box.addClass('null').removeClass('is-search-null');
                            $list_ul.html('');
                            mdeditor && mdeditor.clear();
                        }
                    }
                } else {
                    layer.msg(res.msg);
                }
            })
        },
        // 获取我的分享列表
        getMyShare: function () {
            $.get(host + '/share/index', {
                page: cur_page
            }, function (res) {
                isLoading = false;
                if (res.code === 200) {
                    if (res.data.data.length) {
                        $list_box.removeClass('null is-search-null');
                        var html = template('list-tpl', {list: res.data.data, active: res.data.data[0].id});
                        if (cur_page === 1) {
                            $list_ul.html(html);
                            note.scorllHandle();
                            totalPage = res.data.totalPage;
                            note.getNoteDetail(res.data.data[0].id);
                        } else {
                            $list_ul.append(html);
                            $list_box.getNiceScroll().resize();
                        }
                        cur_page++;
                    } else {
                        if (cur_page === 1) {
                            $doc_box.addClass('null');
                            $list_box.addClass('null').removeClass('is-search-null');
                            $list_ul.html('');
                            mdeditor && mdeditor.clear();
                        }
                    }
                } else {
                    layer.msg(res.msg);
                }
            })
        },
        // 搜索功能
        getSearch: function () {
            var value = $search.val();
            if (!value.trim()) {
                return false;
            }
            $.get(host + '/note/search', {
                keywords: value,
                type: $('.search-type').data('type'),
                field: sort_type,
                order: sort_order,
                page: cur_page
            }, function (res) {
                isLoading = false;
                if (res.code === 200) {
                    if (res.data.data.length) {
                        $doc_box.removeClass('null');
                        $list_box.removeClass('null is-search-null');
                        var html = null;
                        if (cur_page === 1) {
                            html = template('list-tpl', {list: res.data.data, active: res.data.data[0].id});
                            $list_ul.html(html);
                            note.scorllHandle();
                            note.getNoteDetail(res.data.data[0].id);
                            totalPage = res.data.totalPage;
                        } else {
                            html = template('list-tpl', {list: res.data.data, active: null});
                            $list_ul.append(html);
                            $list_box.getNiceScroll().resize()
                        }
                        cur_page++;
                    } else {
                        if (cur_page === 1) {
                            $doc_box.addClass('null');
                            $list_box.addClass('null is-search-null');
                            $list_ul.html('');
                            mdeditor && mdeditor.clear();
                        }
                    }
                }
            })
        },
        // 显示笔记内容
        getNoteDetail: function (note_id) {
            $.get(host + '/note/find', {id: note_id, active: isRecycle ? '0' : '1'}, function (res) {
                if (res.code === 200) {
                    $doc_box.removeClass('null');
                    $('.doc-preview-body').html(res.data.content)
                        .on('click', 'img', function () {
                            var $self = $(this),
                                json = {
                                    "title": "",
                                    "id": 123,
                                    "start": 0,
                                    "data": [
                                        {
                                            "alt": "",
                                            "pid": 666,
                                            "src": $self.attr('src'),
                                            "thumb": ""
                                        }
                                    ]
                                };
                            // 查看大图
                            layer.photos({
                                photos: json
                                , anim: 5
                            });
                        });
                    $doc_box.removeClass('is-edit is-edit-1 is-edit-2 null').addClass('no-edit');
                    clearInterval(timeId);
                    timeId = null;
                    $('.doc-title-span').html(res.data.title);
                    var $unshare = $('.list-unshare'),
                        $tomd = $('.list-tomd');
                    res.data.share == 1 ? $unshare.show() : $unshare.hide();
                    if(res.data.isPrivate === '1'){
                        res.data.lock ? $('.list-unlock').show().prev('.list-lock').hide() : $('.list-lock').show().next('.list-unlock').hide();
                    }else{
                        $('.list-unlock,.list-lock').hide();
                    }
                    res.data.type == '1' ? $tomd.show() : $tomd.hide();
                    note.getAttachment(note_id);
                    cur_note = res.data;
                    mdeditor && mdeditor.clear();
                    if (isRecycle) {
                        $doc_box.addClass('is-recycle');
                    } else {
                        $doc_box.removeClass('is-recycle');
                    }
                } else {
                    layer.msg(res.msg);
                    $('.doc-item.active').remove();
                    $doc_box.addClass('null');
                }
            })
        },
        // 获取笔记附件
        getAttachment: function(note_id){
            $.get(host+'/note/getAttach/'+note_id, function(res){
                if(res.code == 200){
                    if(res.data.length){
                        var html = template('attachment-tpl',{list: res.data});
                        $('.attachment-content-ul').html(html);
                        $('.doc-content-footer').addClass('active');
                    }else{
                        $('.doc-content-footer').removeClass('active');
                    }
                }
            })
        },
        // 监听事件
        clickListEvent: function () {
            var $searchType = $('.search-type'),
                $searchTypeUl = $('.search-type-ul'),
                $moreList = $('.more-list');
            // 新建笔记事件
            $('.add-list li').on('click', function () {
                var idx = $(this).data('idx');
                note.newNote(idx);
            });
            // 点击编辑笔记按钮
            $('.edit-btn').on('click', function () {
                note.editNote()
            });
            // 点击保存笔记按钮
            $('.save-btn').on('click', function () {
                editor.saveNote()
            });
            // 点击还原笔记按钮
            $('.restore-btn').on('click', function () {
                note.restoreNote()
            });
            // 点击列表
            $list_ul.on('click', '.doc-item', function () {
                var $self = $(this);
                if (!$self.hasClass('active')) {
                    $self.addClass('active').siblings().removeClass('active');
                    var note_id = $self.data('id');
                    if ($doc_box.hasClass('is-edit')) {
                        editor.saveNote(function () {
                            note.getNoteDetail(note_id);
                        })
                    } else {
                        note.getNoteDetail(note_id);
                    }
                }
            });
            // 点击文件夹列表
            $list_ul.on('click', '.folder-item', function () {
                var id = $(this).data('id');
                cur_page = 1;
                isShare = isRecycle = isNewest = isSearch = false;
                note.getList(id);
            });
            // 点击更多按钮
            $('.more-btn').on('click', function (e) {
                e.stopPropagation();
                var $moreList = $('.more-list');
                if ($moreList.is(':visible')) {
                    $moreList.hide();
                } else {
                    $('.more-ul').hide();
                    $moreList.show();
                    $(document).off('click').one('click', function () {
                        $moreList.hide();
                    })
                }
            });
            // 点击删除功能
            $moreList.on('click', '.list-del', function (e) {
                e.stopPropagation();
                var elem = $('.doc-item.active'),
                    note_id = cur_note.id;
                layer.confirm('是否确定删除？', {
                    btn: ['确定', '取消']
                }, function () {
                    note.delNote(note_id, elem);
                });
            });
            // 点击上锁功能
            $moreList.on('click', '.list-lock', function (e) {
                e.stopPropagation();
                var $self = $(this), _id = cur_note.id;
                $.post(host + '/note/lockNote', {id: _id}, function (res) {
                    if (res.code === 200) {
                        $self.hide().next('.list-unlock').show();
                        layer.msg('上锁成功，其他人无法进行操作');
                    } else {
                        layer.msg(res.msg);
                    }
                })
            });
            // 点击导出pdf
            $moreList.on('click', '.list-topdf', function (e) {
                note.htmlToPDF();
            });
            // 点击下载md文档
            $moreList.on('click', '.list-tomd', function (e) {
                $.get(host+'/note/download/'+cur_note.id, function(res){
                    if(res.code == 200){
                        var atag = document.createElement('a');
                        atag.download = res.data.title;
                        atag.href = res.data.path;
                        atag.click();
                    }
                })
            });
            // 点击解锁功能
            $moreList.on('click', '.list-unlock', function (e) {
                e.stopPropagation();
                var $self = $(this), _id = cur_note.id;
                $.post(host + '/note/unlockNote', {id: _id}, function (res) {
                    if (res.code === 200) {
                        $self.hide().prev('.list-lock').show().parent().hide();
                        layer.msg('解锁成功，其他人可以进行操作');
                    } else {
                        layer.msg(res.msg);
                    }
                })
            });
            // 点击移动功能
            $moreList.on('click', '.list-move', function (e) {
                e.stopPropagation();
                note.getFolderList(function(str){
                    layer.open({
                        type: 1,
                        title: cur_note.title,
                        content: str,
                        btn: ['确定','取消'],
                        area: ['400px', '400px'],
                        yes: function (index) {
                            note.moveNote(index);
                        }
                    });
                    $('.folder-parent-list').off('click').on('click', function () {
                        var $self = $(this);
                        $self.hasClass('on') ? $self.removeClass('on') : $self.addClass('on');
                        $self.next('ul').toggle(300);
                        if(!$self.hasClass('folder-group-list') && !$self.hasClass('active')){
                            $('.folder-parent-list').removeClass('active');
                            $self.addClass('active');
                        }
                    })
                });
            });
            // 取消分享
            function cancelShare() {
                $.post(host+'/share/cancel/'+cur_note.id, function (res) {
                    if(res.code === 200){
                        $('.list-unshare').hide();
                        layer.msg('取消分享成功');
                    }else{
                        layer.msg(res.msg);
                    }
                })
            }
            // 点击分享功能
            $moreList.on('click', '.list-share', function (e) {
                $.post(host + '/share/add/' + cur_note.id, function (res) {
                    if(res.code === 200){
                        $('.list-unshare').show();
                        var skin = localStorage.getItem('local_skin');
                        var html = template('share-dialog', {value: host + '/share?token=' + res.data.token + '&skin=' + skin});
                        layer.open({
                            type: 1,
                            title: '分享链接',
                            area: ['500px', '250px'],
                            content: html,
                            success: function (layero, index) {
                                new Clipboard('.share-btn');
                                $('.share-btn').on('click', function () {
                                    layer.tips('复制成功', '.share-btn');
                                });
                                $('.cancel-share').on('click', function () {
                                    cancelShare();
                                    layer.close(index);
                                })
                            }
                        });
                    }else{
                        layer.msg(res.msg);
                    }
                })
            });
            // 点击取消分享功能
            $moreList.on('click', '.list-unshare', function (e){
                cancelShare();
            });
            // 选择排序方式
            $('.sort-down-menu li').on('click', function () {
                if (isNewest) {
                    layer.msg('最新笔记不需要排序哦！');
                    return '';
                }
                if (isRecycle) {
                    layer.msg('回收站不需要排序哦！');
                    return '';
                }
                if (isShare) {
                    layer.msg('我的分享不需要排序哦！');
                    return '';
                }
                var $self = $(this),
                    type = $self.data('type');
                if (type === sort_type) {
                    if ($self.hasClass('desc')) {
                        $self.addClass('asc').removeClass('desc');
                        sort_order = 'asc';
                    } else {
                        $self.addClass('desc').removeClass('asc');
                        sort_order = 'desc';
                    }
                } else {
                    sort_type = type;
                    if ($self.hasClass('desc')) {
                        $self.addClass('active asc').removeClass('desc').siblings().removeClass('active');
                        sort_order = 'asc';
                    } else {
                        $self.addClass('active desc').removeClass('asc').siblings().removeClass('active');
                        sort_order = 'desc';
                    }
                }
                cur_page = 1;
                isSearch ? note.getSearch() : (isRecycle ? note.getRecycle() : note.getList(g_id));
            });
            // 监听搜索框回车事件
            $search.on('keydown', function (e) {
                if (e.keyCode === 13) {
                    cur_page = 1;
                    isSearch = true;
                    isShare = isRecycle = isNewest = false;
                    note.getSearch();
                }
            })
                .on('cut paste', function () {
                    var $self = $(this);
                    setTimeout(function () {
                        $self.val().trim() ? $searchClose.show() : '';
                    }, 0)
                })
                .on('input', function () {
                    var $self = $(this);
                    $self.val().trim() ? $searchClose.show() : '';
                });
            // 搜索类型事件
            $searchType.on('click', function (e) {
                e.stopPropagation();
                if ($searchTypeUl.is(':visible')) {
                    $searchTypeUl.hide();
                } else {
                    $('.more-ul').hide();
                    $searchTypeUl.show();
                    $(document).off('click').one('click', function () {
                        $searchTypeUl.hide();
                    })
                }
            });
            // 选择搜索类型
            $searchTypeUl.on('click', 'li', function () {
                var $self = $(this),
                    type = $self.data('type'),
                    text = $self.text();
                $searchType.data('type', type).text(text);
                $searchTypeUl.hide();
            });
            // 关闭搜索事件
            $searchClose.on('click', function () {
                $searchClose.hide();
                $search.val('');
                if (isSearch) {
                    isSearch = false;
                    cur_page = 1;
                    if ($('.nav-newest-item').hasClass('active')) {
                        isNewest = true;
                        note.getNewList();
                    } else if ($('.nav-del-item').hasClass('active')) {
                        isRecycle = true;
                        note.getRecycle();
                    } else if($('.nav-share-item').hasClass('active')){
                        isShare = true;
                        note.getMyShare();
                    } else {
                        isShare = isRecycle = isNewest = false;
                        note.getList(g_id);
                    }
                }
            });
            // 标题失去焦点事件
            $('.doc-title-span').on('blur', function () {
                note.saveTitle();
            });

            // 切换主题
            $('.editor-theme li').on('click', function (e) {
                e.stopPropagation();
                var $self = $(this),
                    theme = $self.text();
                $self.addClass('active').siblings().removeClass('active');
                mdeditor.setEditorTheme(theme);
                localStorage.setItem('editor_theme', theme);
            })

            // 点击删除附件事件
            var $attachment_ul = $('.attachment-content-ul'),
                $box = $('.doc-content-footer');
            $attachment_ul.on('click','.del-span', function(){
                var $self = $(this)
                id = $self.data('id');
                $.get(host+'/note/delAttach/'+id, function(res){
                    if(res.code == 200){
                        layer.msg('删除附件成功');
                        $self.parent().remove();
                        if(!$attachment_ul.find('li').length){
                            $box.removeClass('active');
                            var $editormd = $('#editormd'),
                                $CodeMirror = $('.CodeMirror')
                                $preview = $editormd.find('.editormd-preview');

                            $editormd.height($editormd.height()+130);
                            $CodeMirror.height($CodeMirror.height()+130);
                            $preview.height($preview.height()+130);
                        }
                    }
                })
            })

            $('.attachment-header').on('click', function(){
                var $box = $('.doc-content-footer'),
                    $editormd = $('#editormd'),
                    $CodeMirror = $('.CodeMirror')
                    $preview = $editormd.find('.editormd-preview');
                if($box.hasClass('on')){
                    $box.removeClass('on');
                    $editormd.height($editormd.height()-100);
                    $CodeMirror.height($CodeMirror.height()-100);
                    $preview.height($preview.height()-100);
                }else{
                    $box.addClass('on');
                    $editormd.height($editormd.height()+100);
                    $CodeMirror.height($CodeMirror.height()+100);
                    $preview.height($preview.height()+100);
                }
            })

        },
        // 笔记列表滚动事件
        scorllHandle: function () {
            if (!isNewest) {
                $list_box.on('scroll', function () {
                    var ul_height = $list_ul.height(),
                        box_height = $list_box.height();
                    if (totalPage >= cur_page && $list_box.scrollTop() + box_height > ul_height - 50 && !isLoading) {
                        isLoading = true;
                        isSearch ? note.getSearch() : (isRecycle ? note.getRecycle() : (isShare ? note.getMyShare() :note.getList(g_id)));
                    }
                });
            }

            niceScroll = $('.list-content').niceScroll({
                cursorcolor: '#aaa',
                autohidemode: 'leave',
                horizrailenabled: false,
                cursorborder: '0'
            });
        },

        // 新建笔记
        newNote: function (type) {
            type = type || '1';
            $.post(host + '/note/add', {
                title: NEW_TITLE,
                f_id: g_id,
                type: type
            }, function (res) {
                if (res.code === 200) {
                    $('.doc-item.active').removeClass('active');
                    var list = [res.data];
                    var html = template('list-tpl', {list: list, active: res.data.id});
                    $list_ul.find('.folder-item').length ? $list_ul.find('.folder-item:last').after(html) : $list_ul.prepend(html);
                    $('.doc-item.active').addClass('is-edit').siblings().removeClass('is-edit');;
                    $doc_box.removeClass('null no-edit').addClass('is-edit is-edit-' + type);
                    $list_box.removeClass('null');
                    $('.doc-title-input').val('');
                    $('.doc-title-span').html(res.data.title);
                    $('.doc-preview-body').html(res.data.content || '');
                    var $count = $('.g_' + res.data.f_id);
                    $count && note.navCountHandle($count, 'add');
                    cur_note = res.data;
                    editor.initEditor(type);
                    $('.list-unshare').hide();
                } else {
                    layer.msg(res.msg);
                }
            })
        },
        // 删除笔记
        delNote: function (note_id, elem) {
            $.post(host + '/note/del', {id: note_id}, function (res) {
                if (res.code === 200) {
                    layer.msg('删除成功');
                    elem.remove();
                    var $count = $('.g_' + cur_note.f_id);
                    $count && note.navCountHandle($count, 'minus');
                    clearInterval(timeId);
                    cur_note = timeId = null;
                    if (!$('.doc-item.active').length) {
                        $doc_box.addClass('null');
                    }
                    if (!$list_ul.find('.doc-item').length) {
                        $list_box.addClass('null');
                    }
                } else {
                    layer.msg(res.msg);
                }
            })
        },
        // 还原已删笔记
        restoreNote: function (note_id, elem) {
            var id = note_id || cur_note.id,
                e = elem || $('.doc-item.active');
            $.post(host + '/note/recovery', {id: id}, function (res) {
                if (res.code === 200) {
                    layer.msg('还原笔记成功');
                    e.remove();
                    $doc_box.addClass('null');
                } else {
                    layer.msg(res.msg);
                }
            })
        },
        // 编辑笔记
        editNote: function () {
            $('.doc-title-input').val(cur_note.title);
            $doc_box.removeClass('no-edit').addClass('is-edit is-edit-' + cur_note.type);
            $('.doc-item.active').addClass('is-edit').siblings().removeClass('is-edit');
            cur_note.type === '1' ? editor.initEditor('1', cur_note.origin_content) : editor.initEditor(cur_note.type, cur_note.content);
        },
        // 目录下笔记数量操作
        navCountHandle: function (elem, event, type) {
            var text = elem.text().replace('(', '').replace(')', ''),
                idx = text.indexOf('/');
            if (idx === -1) {
                text = event == 'add' ? parseInt(text) + 1 : parseInt(text) - 1;
                elem.text('(' + text + ')');
                var pElem = elem.parents('.child-list').prev('[data-pid="0"]').eq(0).find('.item-count');
                pElem && (event == 'add' ? note.navCountHandle(pElem, 'add', true) : note.navCountHandle(pElem, 'minus', true));
            } else {
                var first = null, last = null;
                if (event == 'add') {
                    first = type ? parseInt(text.substring(0, idx)) : parseInt(text.substring(0, idx)) + 1;
                    last = parseInt(text.substring(idx + 1)) + 1;
                } else {
                    first = type ? parseInt(text.substring(0, idx)) : parseInt(text.substring(0, idx)) - 1;
                    last = parseInt(text.substring(idx + 1)) - 1;
                }
                elem.text('(' + first + '/' + last + ')');
            }
        },
        // 导出PDF
        htmlToPDF: function () {
            var form = document.createElement('form'),
                input = document.createElement('input'),
                textArea = document.createElement('textarea'),
                button = document.createElement('button'),
                tpl = $('#pdf-tpl').html();
            form.action = 'http://tool.omwteam.com';
            form.method = 'post';
            form.target = '_blank';
            input.name = 'title';
            input.value = cur_note.title;
            textArea.name = 'content';
            textArea.value = tpl.replace('##content##', cur_note.content);
            button.type = 'submit';
            button.innerHTML = '提交';
            form.appendChild(input);
            form.appendChild(textArea);
            form.appendChild(button);
            form.style.display = 'none';
            document.body.appendChild(form);
            button.click();
        },
        // 保存标题
        saveTitle: function () {
            var $span = $('.doc-title-span'),
                title = $span.html();
            if (title === cur_note.title) {
                return false;
            } else if (title.length === 0) {
                $span.html(cur_note.title);
                return false;
            }
            $.post(host + '/note/update', {
                id: cur_note.id,
                f_id: cur_note.f_id,
                title: title
            }, function (res) {
                if (res.code === 200) {
                    if (cur_note.id === res.data.id) {
                        $('.doc-title-span,.doc-item.active .list-title-text').text(res.data.title);
                        cur_note.title = res.data.title;
                    }
                }
            })
        },
        // 移动笔记获取目录
        getFolderList: function (callback) {
            $.get(host + '/group/list', function (res) {
                var html = template('folder-tpl', {group: res.data});
                callback && callback(html);
            });
        },
        // 移动笔记
        moveNote: function (index) {
            var $folder = $('.folder-parent-list.active'),
                type = $folder.data('type'),
                fid = $folder.data('fid');
            if(cur_note.f_id == fid){
                layer.close(index);
                return layer.msg('当前笔记已经在该目录下');
            }
            $.post(host + '/note/move', {
                id: cur_note.id,
                f_id: fid,
                type: type
            }, function (res) {
                layer.close(index);
                if(res.code === 200){
                    layer.msg('移动成功');
                    var $count1 = $('.g_'+cur_note.f_id),
                        $count2 = $('.g_'+res.data.f_id);
                    cur_note = res.data;
                    note.navCountHandle($count1, 'minus');
                    note.navCountHandle($count2, 'add');
                }else{
                    layer.msg(res.msg);
                }
            })
        }
    };

    module.exports = note;
});