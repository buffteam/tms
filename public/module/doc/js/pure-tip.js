/**
 * Created by freddy on 2017/6/28.
 */




(function($){
    $.extend({
        pureTip: function (options) {
            var defaultOptions = {
                tip: '提示内容',
                leaveTime: 1800,
                callback: null
            };

            $.extend(defaultOptions,options);

            // tip 池
            var tipPoor = [],
                isShow = false;
            if (tipPoor.length > 0) {
                if (isShow) {
                    tipPoor[0].hide().delay(100).show();

                } else {
                    tipPoor[0].show(function () {
                        doCallback()
                    })
                }

            }

            function doCallback() {
                defaultOptions.callback && defaultOptions.callback();
                var timer = setTimeout(function () {
                    tipPoor[0].hide();
                    isShow = false;
                    clearTimeout(timer);
                },defaultOptions.leaveTime)
            }

            var tpl = '<div class="pure-shade pure-tip" id="pureTip"><div class="pure-tip-container">'+defaultOptions.tip+'</div> </div>';
            $('body').append(tpl);
            tipPoor.push($('#pureTip'));
            isShow = true;
            doCallback();
            return this;
        }
    });
})(window.jQuery);



