/**
 * Created by linxin on 2017/8/11.
 */
define(function (require, exports, module) {
    var $ = require('jquery');
    var editormd = require('editormd'),
        WebUploader = require('webuploader');

    require("libs/editormd/plugins/link-dialog/link-dialog");
    require("libs/editormd/plugins/reference-link-dialog/reference-link-dialog");
    require("libs/editormd/plugins/image-dialog/image-dialog");
    require("libs/editormd/plugins/code-block-dialog/code-block-dialog");
    require("libs/editormd/plugins/table-dialog/table-dialog");
    require("libs/editormd/plugins/emoji-dialog/emoji-dialog");
    require("libs/editormd/plugins/goto-line-dialog/goto-line-dialog");
    require("libs/editormd/plugins/help-dialog/help-dialog");
    require("libs/editormd/plugins/html-entities-dialog/html-entities-dialog");
    require("libs/editormd/plugins/preformatted-text-dialog/preformatted-text-dialog");
    require('wangEditor');

    var $window = $(window),
        $doc_box = $('.doc-content');                   // 笔记详情盒子

    var editor = {
        // 初始化编辑器
        initEditor: function (type, value) {
            var height = $window.height() - $('.doc-content-header').outerHeight() - 65;
            if (type == 1) {
                if (!!mdeditor) {
                    value ? mdeditor.setMarkdown(value) : mdeditor.clear();
                } else {
                    mdeditor = editormd("editormd", {
                        path: "./libs/editormd/lib/",
                        width: '100%',
                        height: height,
                        markdown: value || '',
                        disabledKeyMaps: ["Ctrl-S"],
                        taskList: true,
                        tocm: true,
                        codeFold: true,
                        tex: true,
                        flowChart: true,
                        sequenceDiagram: true,
                        searchReplace: true,
                        imageUpload: true,
                        imageFormats: ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
                        imageUploadURL: "./common/mdEditorUpload",
                        toolbarIcons: function () {
                            return ["undo", "redo", "|", "bold", "del", "italic", "quote", "hr", "|", "h1", "h2", "h3",
                                "|", "list-ul", "list-ol", "link", "table", "datetime", "clear", "image","file", "code-block", "preview", "fullscreen", "search",  "theme"
                            ]
                        },
                        toolbarIconsClass:{
                            search: '',  fullscreen: '', preview: '', image: '', 'code-block': ''

                        },
                        toolbarIconTexts: {
                            theme: '切换主题 ', search: '搜索',  fullscreen: '全屏', preview: '预览',
                            image: '上传图片', 'code-block': '插入代码', file: '上传附件'
                        },
                        toolbarHandlers: {
                            theme: function () {
                                var $theme = $('.editor-theme'),
                                    $document = $(document);
                                if ($theme.hasClass('active')) {
                                    $theme.removeClass('active');
                                    $document.off('click');
                                } else {
                                    $theme.addClass('active');
                                    $document.one('click', function () {
                                        $theme.removeClass('active');
                                    })
                                }
                            },
                            file: function () {
                                layer.open({
                                    type: 1,
                                    area: ['800px', '500px'], 
                                    title: '上传附件',
                                    content: $('#upload-tpl').html()
                                });
                                var state = '';
                                var uploader = WebUploader.create({
                                    swf:  host + '/libs/webuploader-0.1.5/Uploader.swf',
                                    server: host+'/common/uploadAttachment',
                                    fileVal: 'attachment',
                                    // 选择文件的按钮。可选。
                                    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
                                    pick: '#picker',
                                    resize: false
                                });
                                uploader.on( 'fileQueued', function( file ) {
                                    $('#thelist').append( '<div id="' + file.id + '" class="item">' +
                                        '<h4 class="info">' + file.name + '</h4>' +
                                        '<span class="state">等待上传...</span><span class="remove-btn">移除</span>' +
                                    '</div>' );
                                    state = 'ready';
                                    $("#"+file.id).find('.remove-btn').on('click', function () {
                                        uploader.removeFile(file, true);
                                        $(this).parent().remove();
                                    })
                                });
                                // 开始上传
                                $('#ctlBtn').off('click').on('click', function () {
                                    if ( $(this).hasClass( 'disabled' ) ) {
                                        return false;
                                    }
                                    if ( state === 'ready' ) {
                                        uploader.upload();
                                    } else if ( state === 'paused' ) {
                                        uploader.upload();
                                    } else if ( state === 'uploading' ) {
                                        uploader.stop();
                                    }
                                })
                                // 文件上传过程中创建进度条实时显示。
                                uploader.on( 'uploadProgress', function( file, percentage ) {
                                    var $li = $( '#'+file.id ),
                                        $percent = $li.find('.progress .progress-bar');

                                    // 避免重复创建
                                    if ( !$percent.length ) {
                                        $percent = $('<div class="progress progress-striped active">' +
                                        '<div class="progress-bar" role="progressbar" style="width: 0%">' +
                                        '</div>' +
                                        '</div>').appendTo( $li ).find('.progress-bar');
                                    }
                                    
                                    $li.find('span.state').text('上传中');
                                    state = 'uploading';
                                    $percent.css( 'width', percentage * 100 + '%' );
                                });
                                uploader.on( 'uploadSuccess', function( file, response ) {
                                    $( '#'+file.id ).find('span.state').text('已上传');
                                    state = '';
                                    if(response.code == 200){
                                        var param = response.data;
                                        param.note_id = cur_note.id;
                                        $.post(host+ '/note/addAttach', param, function (res) {
                                            if(res.code == 200){
                                                
                                            }
                                        })
                                    }else{
                                        layer.msg(response.msg);
                                    }
                                });
                                
                                uploader.on( 'uploadError', function( file ) {
                                    $( '#'+file.id ).find('span.state').text('上传出错');
                                    state = 'ready';
                                });
                                
                                uploader.on( 'uploadComplete', function( file ) {
                                    $( '#'+file.id ).find('.progress').fadeOut();
                                });
                                
                            }
                        },
                        onload: function () {
                            var keyMap = {
                                "Ctrl-S": function (cm) {
                                    editor.ctrlSNote();
                                }
                            };
                            this.addKeyMap(keyMap);
                            $('.editor-theme li').each(function (index, item) {
                                var $self = $(this),
                                    theme = localStorage.getItem('editor_theme') || 'default',
                                    text = $self.text();
                                if (theme === text) {
                                    $self.addClass('active');
                                    mdeditor.setEditorTheme(theme);
                                }
                            })
                        }
                    });
                }
            } else if (type == 2) {
                if (!!wangeditor) {
                    wangeditor.txt.html(value || '');
                } else {
                    wangeditor = new wangEditor('#editor');
                    wangeditor.customConfig.uploadImgServer = './common/wangEditorUpload';
                    wangeditor.customConfig.uploadFileName = 'image-file';
                    wangeditor.create();
                    wangeditor.txt.html(value || '');
                    $('.w-e-text-container').height(height - 41);
                    $('.w-e-text').keydown(function (e) {
                        if (e.ctrlKey == true && e.keyCode == 83) {
                            note.ctrlSNote();
                            return false;
                        }
                    });
                }

            }

            timeId = setInterval(editor.autoSaveNote, AUTO_TIME);
        },
        // ctrl-s 保存笔记
        ctrlSNote: function () {
            if (!isCtrlS) {
                var title = $('.doc-title-input').val().trim() || cur_note.title,
                    md_cnt = cur_note.type == 1 ? mdeditor.getMarkdown().trim() : '',
                    html_cnt = cur_note.type == 1 ? mdeditor.getPreviewedHTML().trim() : wangeditor.txt.html().trim(),
                    note_id = cur_note.id;
                if (cur_note.title == title && (cur_note.content || '') == html_cnt) {
                    return false;
                }
                isCtrlS = true;
                $.post(host + '/note/update', {
                    id: note_id,
                    f_id: cur_note.f_id,
                    title: title,
                    content: html_cnt,
                    origin_content: md_cnt
                }, function (res) {
                    isCtrlS = false;
                    if (res.code === 200) {
                        layer.msg('保存成功');
                        $('.doc-item.is-edit .list-title-text').text(res.data.title);
                        $('.doc-preview-body').html(html_cnt);
                        $('.doc-title-span').html(res.data.title);
                        cur_note = res.data;
                        local_note = null;
                        localStorage.removeItem('local_note');
                        editor.unbindUnload();
                    } else if (res.code === 403) {
                        layer.msg(res.msg);
                    }
                })
            }
        },
        // 自动保存笔记
        autoSaveNote: function () {
            local_note = {};
            for (var i in cur_note) {
                local_note[i] = cur_note[i];
            }
            var title = $('.doc-title-input').val().trim(),
                md_cnt = local_note.type == 1 ? mdeditor.getMarkdown().trim() : '',
                html_cnt = local_note.type == 1 ? mdeditor.getPreviewedHTML().trim() : wangeditor.txt.html().trim();
            if (local_note.title == title && local_note.content == html_cnt) {
                return false;
            }
            local_note.title = title;
            local_note.origin_content = md_cnt;
            local_note.content = html_cnt;
            localStorage.setItem('local_note', JSON.stringify(local_note));
            $.post(host + '/note/update', {
                id: local_note.id,
                f_id: local_note.f_id,
                title: title,
                content: html_cnt,
                origin_content: md_cnt
            }, function (res) {
                if (res.code === 200) {
                    cur_note = res.data;
                    local_note = null;
                    editor.unbindUnload();
                }
            })
            editor.bindUnload();
        },
        // 保存笔记
        saveNote: function (callback) {
            var title = $('.doc-title-input').val().trim() || cur_note.title,
                md_cnt = cur_note.type == 1 ? mdeditor.getMarkdown().trim() : '',
                html_cnt = cur_note.type == 1 ? mdeditor.getPreviewedHTML().trim() : wangeditor.txt.html().trim(),
                note_id = cur_note.id;

            if (cur_note.title == title && (cur_note.content || '') == html_cnt) {
                $doc_box.removeClass('is-edit is-edit-1 is-edit-2').addClass('no-edit');
                callback && callback();
                return false;
            }
            $.post(host + '/note/update', {
                id: note_id,
                f_id: cur_note.f_id,
                title: title,
                content: html_cnt,
                origin_content: md_cnt
            }, function (res) {
                callback && callback();
                if (res.code === 200) {
                    $('.doc-item.is-edit').removeClass('is-edit').find('.list-title-text').text(res.data.title);
                    layer.msg('保存成功');
                    $('.doc-preview-body').html(html_cnt);
                    $doc_box.removeClass('is-edit is-edit-1 is-edit-2').addClass('no-edit');
                    clearInterval(timeId);
                    timeId = null;
                    $('.doc-title-span').html(res.data.title);
                    cur_note = res.data;
                    local_note = null;
                    localStorage.removeItem('local_note');
                    editor.unbindUnload();
                } else if (res.code === 403) {
                    layer.msg(res.msg);
                }
            })
        },
        // 监听窗口关闭
        bindUnload: function () {
            editor.unbindUnload();
            $window.bind('beforeunload', function () {
                var localNote = localStorage.getItem('local_note');
                if (localNote) {
                    localNote = JSON.parse(localNote);
                    layer.msg(localNote.title + ' 还未保存，是否要保存？', {
                        time: 0,
                        btn: ['保存', '不保存'],
                        yes: function () {
                            editor.saveNote();
                        },
                        btn2: function () {
                            $doc_box.removeClass('is-edit is-edit-1 is-edit-2').addClass('no-edit');
                            clearInterval(timeId);
                            timeId = null;
                            local_note = null;
                            localStorage.removeItem('local_note');
                            editor.unbindUnload();
                        }
                    });
                    return '您输入的内容尚未保存，确定离开此页面吗？';
                }
            });
        },
        unbindUnload: function () {
            $window.unbind('beforeunload');
        }
    };
    module.exports = editor;
});