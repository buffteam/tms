/**
 * pure-tip
 * @param options
 * tip: 提示内容
 * leaveTime: 多少时间后关闭 单位毫秒
 * callback: 会调函数
 * created by dobbinFeng at 2017/06/29
 */
(function ($) {
    $.extend({
        pureTip: function (options) {

            var defaultOptions = {
                tip: '提示内容',
                leaveTime: 1500,
                callback: null
            };

            $.extend(defaultOptions,options);
            // 当前显示的提示框

            var currentTip;
            if ($('#pureTip').length == 1) {
                throw "不支持同时多个全屏tip框";
            }

            /**
             * 处理回调
             */
            function doCallback() {
                var timer = setTimeout(function () {
                    currentTip.remove();
                    defaultOptions.callback && defaultOptions.callback();
                    clearTimeout(timer);
                },defaultOptions.leaveTime)
            }

            /**
             * 添加并显示
             */
            function showTip() {
                var tpl = '<div class="pure-shade pure-tip" id="pureTip"><div class="pure-tip-container">' + defaultOptions.tip + '</div></div>';
                $('body').append(tpl);
                currentTip = $('#pureTip');
                doCallback();
            }

            return showTip();

        },
        pureAlert: function () {
            
        }
    });
})(jQuery);




