/*
 * @Author: linxin 
 * @Date: 2017-10-13 11:19:13 
 * @Last Modified time: 2017-10-13 11:19:13 
 * @Desc: 附件上传功能
 */
define(function(require, exports, module) {
    'use strict';
    var $ = require('jquery'),
        template = require('template'),
        WebUploader = require('webuploader');

    module.exports = function () {
        var state = '';
        var uploader = WebUploader.create({
            swf:  host + '/libs/webuploader-0.1.5/Uploader.swf',
            server: host+'/common/uploadAttachment',
            fileVal: 'attachment',
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
                        var $box = $('.doc-content-footer'),
                            $ul = $('.attachment-content-ul'),
                            $editormd = $('#editormd'),
                            $CodeMirror = $('.CodeMirror'),
                            $preview = $editormd.find('.editormd-preview'),
                            html = template('attachment-tpl', {list: [res.data]});
                        if(!$box.hasClass('active')){
                            $box.addClass('active');
                            $ul.html(html);
                            // var height = $box.hasClass('on') ? 30 : 130;
                            // $editormd.height($editormd.height()-height);
                            // $CodeMirror.height($CodeMirror.height()-height);
                            // $preview.height($preview.height()-height);
                        }else{
                            $ul.append(html);
                        }
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

});