/**
 * Created by linxin on 2017/8/11.
 */
define(function (require, exports, module) {
    var $ = require('jquery');
    var template = require('template');
    require('nicescroll');
    var note = require('./note');

    var $window = $(window),
        $nav = $('#nav'),
        $menuBtn = $('.nav-menu-button'),
        $search = $('.search-input'),
        $doc_box = $('.doc-content');                   // 笔记详情盒子

    var folder = {
        init: function () {
            folder.navHelper();
            folder.initNav();
            folder.clickHandle();
        },
        // 渲染文件夹列表
        initNav: function () {
            var tpl = $('#nav-tpl').html();
            var list = [];
            $.get(host + '/group/list', function (res) {
                // var html = template('group-tpl', {list: list, idx: 0, active: list[0].id});
                var html = template('group-tpl', {group: res.data, idx: 1});
                $('.nav-newest-item').after(html);

                $nav.niceScroll({
                    cursorcolor: '#aaa',
                    autohidemode: 'scroll',
                    horizrailenabled: false,
                    cursorborder: '0'
                });
                note.getNewList();
                note.init();
            });
        },
        navHelper: function () {
            template.helper('renderNav', function (data) {
                var list = [];
                if (data.length) {
                    for (var i = 0; i < data.length - 1; i++) {
                        for (var j = 1; j < data.length; j++) {
                            if (data[i].id === data[j].p_id) {
                                if (!data[i].child) {
                                    data[i].child = []
                                }
                                data[i].child.push(data[j]);
                            }
                        }
                    }
                    for (i = 0; i < data.length; i++) {
                        (data[i].p_id === 0) ? list.push(data[i]) : null;
                    }
                }
                return list;
            })
        },
        clickHandle: function () {
            var $layout = $('#layout'),
                $newDocBtn = $('.new-doc-box');
            // 收起侧边栏
            $menuBtn.on('click', function () {
                var isEdit = $doc_box.hasClass('is-edit-1');
                var $firstParent = $('.first-menu-a.is-parent');
                if (isEdit) {
                    var $code = $('.CodeMirror'),
                        $preview = $('.editormd-preview'),
                        width = $code.width();
                }
                if ($layout.hasClass('middle')) {
                    $layout.removeClass('middle');
                    $menuBtn.removeClass('right');
                    $firstParent.data('switch', 'on').siblings('ul').slideDown(300);
                    if (isEdit) {
                        $code.animate({'width': width - 100}, 300);
                        $preview.animate({'width': width - 100}, 300);
                    }
                    folder.navScrollResize();
                } else {
                    $layout.addClass('middle');
                    $menuBtn.addClass('right');
                    $firstParent.data('switch', 'off').siblings('ul').slideUp(300);
                    if (isEdit) {
                        $code.animate({'width': width + 100}, 300);
                        $preview.animate({'width': width + 100}, 300);
                    }
                }
            });
            if ($window.width() < 1200) {
                $menuBtn.click();
            }
            $window.resize(function () {
                var $self = $(this);
                if (($self.width() < 1200 && !$layout.hasClass('middle')) || ($self.width() > 1200 && $layout.hasClass('middle'))) {
                    $menuBtn.click();
                    folder.navScrollResize();
                }
            });

            // 点击新建文档事件
            $newDocBtn.on('click', function (e) {
                e.stopPropagation();
                var $list = $('.add-list');
                if ($list.is(':visible')) {
                    $list.hide();
                } else {
                    $('.more-ul').hide();
                    $list.show();
                }
                folder.navScrollResize();
                $(document).off('click').one('click', function () {
                    $list.hide();
                })
            });
            // 收起侧边栏后点击新建笔记图标，直接创建 type 为 1 的笔记
            $('.middle-add-item').on('click', function () {
                note.newNote('1');
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
                folder.navScrollResize();
            })
            // 点击我的文档目录事件
                .on('click', '.nav-doc-a', function () {
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
                    folder.navScrollResize();
                })
                .on('click', '.second-menu-a', function () {
                    var $self = $(this);
                    g_id = $self.data('id');
                    $self.find('.child-menu-open').click();
                    $('.child-item.active,.pure-menu-item').removeClass('active');
                    $self.parent().addClass('active');
                    cur_page = 1;
                    isShare = isRecycle = isNewest = isSearch = false;
                    $search.val('');
                    note.getList(g_id);
                })
                // 点击下拉菜单
                .on('click', '.child-menu-down', function (e) {
                    e.stopPropagation();
                    var scrollTop = $nav.getNiceScroll(0).getScrollTop();
                    var $self = $(this),
                        idx = $self.data('idx'),
                        $downBox = $('.down-box'),
                        $downIcon = $('.child-menu-down');

                    $('.down-box p').data('id', $self.parent().data('id'));
                    $g_folder = $self.parent().parent();

                    if (!$self.hasClass('active')) {
                        $downIcon.removeClass('active');
                        $self.addClass('active');
                        $downBox.fadeIn(200).css('top', e.pageY - e.offsetY - 45 + scrollTop);
                        // 如果是第四级目录，则不给添加子文件夹
                        var $add_p = $('.down-box p[data-type="add"]');
                        if (idx == '4') {
                            $add_p.hide();
                        } else {
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
                        event = $self.data('type'),
                        f_id = $self.data('id'),
                        $icon = $('.child-menu-down.active'),
                        elem = $icon.parent().parent(), text = null,
                        idx = parseInt($icon.data('idx'));
                    $self.parent().hide();
                    $icon.removeClass('active');

                    switch (event) {
                        // 新建子文件夹
                        case 'add':
                            text = $('#add-input-tpl').html()
                                .replace('##idx##', idx + 1)
                                .replace('##type##', $icon.data('type'))
                                .replace('##gid##', $icon.data('gid'));
                            if (elem.find('.child-list').length === 0) {
                                elem.append('<ul class="child-list" style="display: block">' + text + '</ul>');
                            } else {
                                elem.children('.child-list').show().append(text)
                                    .prev('.second-menu-a').addClass('on').data('data-switch','on');
                            }
                            // 监听输入框失去焦点和回车事件
                            elem.find('ul input').focus().on('blur keypress', function (e) {
                                var $self = $(this),
                                    value = $self.val(),
                                    $menu_a = $self.parent().parent();
                                if (e.keyCode === 13) {
                                    $self.off('blur');
                                } else if (e.type !== 'blur') {
                                    return;
                                }
                                if (value && value.length < 13) {
                                    $.post(host + '/folder/add', {
                                        title: value,
                                        type: $icon.data('type'),
                                        g_id: $icon.data('gid'),
                                        p_id: f_id
                                    }, function (res) {
                                        if (res.code === 200) {
                                            layer.msg('添加成功');
                                            var tag = $self.parent().parent().parent().parent().prev('.second-menu-a');
                                            $self.parent().html(res.data.title);
                                            if (!tag.hasClass('is-parent')) {
                                                tag.addClass('is-parent on').data('switch', 'on');
                                            }
                                            $menu_a.removeClass('last-menu-a')
                                                .addClass('second-menu-a')
                                                .data({'id': res.data.id, 'pid': res.data.p_id})
                                                .find('.item-count').addClass('g_' + res.data.id);
                                            $menu_a = null;
                                        } else if (res.code === 403) {
                                            layer.msg(res.msg);
                                            $menu_a.parent().remove();
                                            $menu_a = null;
                                        }
                                    })
                                } else {
                                    if (value.length > 12) {
                                        layer.msg('文件夹名称不能超过12个字符');
                                    }
                                    $menu_a.parent().remove();
                                    $menu_a = null;
                                }
                            })
                                .on('click', function (e) {
                                    e.stopPropagation();
                                });
                            break;
                        // 文件夹重命名
                        case 'rename':
                            var pid = $icon.parent().data('pid');
                            elem = $icon.parent().find('.item-name');
                            text = elem.text();
                            elem.html('<input type="text" value="' + text + '">')
                                .find('input').focus().on('blur keypress', function (e) {
                                var $self = $(this),
                                    value = $self.val();
                                if (e.keyCode === 13) {
                                    $self.off('blur');
                                } else if (e.type !== 'blur') {
                                    return;
                                }
                                if (value && value !== text && value.length < 13) {
                                    $.post(host + '/folder/update', {
                                        title: value,
                                        id: f_id,
                                        pid: pid
                                    }, function (res) {
                                        if (res.code === 200) {
                                            elem.html(res.data.title);
                                            layer.msg('修改成功');
                                        } else {
                                            elem.html(text);
                                            layer.msg(res.msg);
                                        }
                                    })
                                } else {
                                    if (value.length > 12) {
                                        layer.msg('文件夹名称不能超过12个字符');
                                    }
                                    elem.html(text);
                                }
                            }).on('click', function (e) {
                                e.stopPropagation();
                            });
                            break;
                        // 删除文件夹
                        case 'del':
                            layer.confirm('删除不可恢复，是否确定删除？', {
                                btn: ['确定', '取消']
                            }, function () {
                                folder.delFolder(f_id);
                            });
                            break;
                    }
                })
                //打开回收站
                .on('click', '.nav-del-item', function () {
                    $(this).addClass('active').siblings().removeClass('active');
                    $('.child-item.active').removeClass('active');
                    $doc_box.addClass('null');
                    g_id = null;
                    cur_page = 1;
                    isRecycle = true;
                    isShare = isSearch = isNewest = false;
                    note.getRecycle();
                })
                //打开我的分享列表
                .on('click', '.nav-share-item', function () {
                    $(this).addClass('active').siblings().removeClass('active');
                    $('.child-item.active').removeClass('active');
                    g_id = null;
                    cur_page = 1;
                    isShare = true;
                    isRecycle = isSearch = isNewest = false;
                    note.getMyShare();
                })
                // 打开最新笔记
                .on('click', '.nav-newest-item', function () {
                    $(this).addClass('active').siblings().removeClass('active');
                    $('.child-item.active').removeClass('active');
                    g_id = null;
                    note.getNewList();
                });

            // 新建文件夹
            $nav.on('click', '.add-dir', function () {
                $(this).prev('.child-item-input').show().find('input').focus()
                // 我的文档下级新建文件夹输入框失去焦点时或回车触发
                    .on('blur keypress', function (e) {
                        var $self = $(this);
                        if (e.keyCode === 13) {
                            $self.off('blur keypress');
                        } else if (e.type !== 'blur') {
                            return;
                        }
                        folder.addFirstFolder($self);
                    });
            });

        },
        // 我的文档下级新建文件夹事件
        addFirstFolder: function (self) {
            var value = self.val();
            if (value) {
                $.post(host + '/folder/add', {
                    title: value,
                    type: self.data('type'),
                    g_id: self.data('gid'),
                    p_id: 0
                }, function (res) {
                    if (res.code === 200) {
                        var list = [
                            {
                                id: res.data.id,
                                title: res.data.title,
                                p_id: 0,
                                currentCount: 0,
                                totalCount: 0
                            }
                        ];
                        var html = template('nav-tpl', {list: list, idx: 0, type: res.data.type, gid: res.data.g_id});
                        self.parent().before(html);
                    } else {
                        layer.msg(res.msg);
                    }
                })
            }
            self.val('').parent().hide();
        },
        navScrollResize: function () {
            setTimeout(function () {
                $nav.getNiceScroll().resize();
            }, 300);
        },

        // 删除目录事件
        delFolder: function (fid) {
            $.post(host + '/folder/del', {id: fid}, function (res) {
                if (res.code === 200) {
                    $g_folder.remove();
                    g_id = fid === g_id ? null : g_id;
                    layer.msg('删除成功');
                } else {
                    layer.msg(res.msg);
                }
            })
        }
    };
    module.exports = folder;
});