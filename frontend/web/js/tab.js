(function ($) {
    $.fn.yiiTab = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.yiiActiveForm');
            return false;
        }
    };
    var defaults = {
        /**
         * 查找分类url
         */
        classUrl: '/edit/default/classify',
        timeoutRefence: null,
        inforTimeout: null,
        aid: null,
        isGuest: undefined,
    };
    var methods = {
        init: function(attributes, options){
            var uid = attributes.uid;
            defaults.isGuest = attributes.isGuest;
            if(uid){
                tabClick(uid);
            }
            watchClick($(this).find('a'));
            focusTab();
        },
    };
    var watchClick = function(elem){
        elem.on('click.yiiTab', function(){
            tabClick(this);
            return false;
        })
    };
    var focusTab = function(){
        $('.tabfocus-area .focused-btn')
        .mouseenter(function(){
            var i = $('.tabfocus-area .focused-btn').index(this);
            $('.tabfocus-area .focused-btn').eq(i).html('');
            $('.tabfocus-area .focused-btn').eq(i).html('<i class="icon-remove"></i>&nbsp;取消关注');
        })
        $('.tabfocus-area .focused-btn')
        .mouseleave(function(){
            var i = $('.tabfocus-area .focused-btn').index(this);
            $('.tabfocus-area .focused-btn').eq(i).html('');
            $('.tabfocus-area .focused-btn').eq(i).html('<i class="icon-ok"></i>&nbsp;已关注');
        })
    }
    var tabClick = function(param){
        if(typeof param == 'string'){
            var url = '/user/home/timeline?id='+param;
        }else{
            $('#home-menu a').removeClass('actived');
            $(param).addClass('actived');
            var url = $(param).prop('href');
        }
        $.ajax({
            url: url,
            type: 'get',
        }).always(function(result){
            $('.pager-content').html(result);
            jQuery('.need-islogin').yiiFocus({
                "isGuest": defaults.isGuest,
                'focusbtn': 'focus-btn',
            }, []);
            focusTab();
        });
    };

})(window.jQuery);
