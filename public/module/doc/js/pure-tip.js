/**
 * Created by freddy on 2017/6/28.
 */



;(function ($) {
    $.extend({
        pureTip: function (options) {

            var defaultOptions = {
                tip: '提示内容',
                callback: function () {
                    alert(this.tip);
                }
            };
            // tip 池
            var tipPoor = [];
            $.extend(defaultOptions,options);

            var tpl = '<div class="pure-shade pure-tip" id="pureTip"><div class="pure-tip-content">'+defaultOptions.tip+'</div> </div>';
            if (tipPoor.length > 0) {
                tipPoor[0].fadeIn();
            }
            $('body').append(tpl);
            tipPoor.push($('#pureTip'));



        }
    })

})(jQuery);




