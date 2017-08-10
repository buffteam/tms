/**
 * Created by linxin on 2017/7/18.
 */
var DEFAULE_SKIN = 'purple';
var header = {
    init: function () {
        $('#skin').attr('class', localStorage.getItem('local_skin') || DEFAULE_SKIN ).animate({'opacity': 1},1000);
        header.switchTheme();
    },
    // 用户名下拉
    userDropDown: function (elem, event) {
        event.stopPropagation();
        var $self = $(elem),
            $downList = $('.user-down-list');
        $self.siblings().removeClass('active');
        if($downList.is(':visible')){
            $downList.hide();
        }else{
            $('.more-ul').hide();
            $downList.show();
        }
        $(document).off('click').one('click', function () {
            $downList.hide();
        })
    },
    // 切换主题
    switchTheme: function () {
        $('.theme-li').on('click', function (e) {
            e.stopPropagation();
            var $self = $(this),
                theme = $self.find('.theme-span').text();
            $('#skin').attr('class', theme);
            localStorage.setItem('local_skin', theme);
        });
        $('.theme-box').on('click', function (e) {
            e.stopPropagation();
            var $self = $(this);
            var $downList = $('.user-down-list');
            if($downList.is(':visible')){
                $downList.hide();
            }
            $self.hasClass('active') ? $self.removeClass('active') : $self.addClass('active');
            $(document).off('click').one('click', function () {
                $self.removeClass('active');
            })
        })
    }
};
header.init();