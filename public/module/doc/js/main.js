/**
 * Created by linxin on 2017/8/11.
 */
define(function (require, exports, module) {
    var $ = require('jquery');
    var folder = require('./folder');

    module.exports = {
        init: function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                complete: function (XMLHttpRequest) {
                    if (XMLHttpRequest.status === 401) {
                        layer.msg('登录信息验证失败，请重新登录');
                    } else if (XMLHttpRequest.status === 503) {
                        var res = JSON.parse(XMLHttpRequest.responseText);
                        layer.msg(res.msg);
                    } else if (XMLHttpRequest.status !== 200) {
                        layer.msg('服务器出错了 ' + XMLHttpRequest.status);
                    }
                }
            });
            // 禁止保存网站
            $(document).keydown(function (e) {
                if (e.ctrlKey == true && e.keyCode == 83) {
                    return false;
                }
            });
            folder.init();
        }
    };
});