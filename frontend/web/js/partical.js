(function ($) {
    $.fn.yiiPartical = function (method) {
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
        csrfToken: '',
        aid: '',
        uid: '',
    };
    var methods = {
        init: function(attributes, options){
            defaults.isGuest = attributes.isGuest;
            defaults.csrfToken = attributes.csrfToken || '';
            defaults.aid = attributes.aid || '';
            defaults.uid = attributes.uid || '';
            var popWin = attributes.popWin;
            var articalPlus = attributes.articalPlus;
            var contriPlus = attributes.contriPlus;
            $(popWin).on('click.yiiPartical', function(){
                return false;
            });
            $(window).on('click.yiiPartical', function(){
                $('.win-back').css("display", "none");
                $('.pop-win').css("display", "none");
            });
            $(articalPlus).on('click.yiiPartical', function(){
                var url = '/site/subject';
                var obj = 'pop-body';
                articalPlusx(url, obj);
                return false;
            })
            $(contriPlus).on('click.yiiPartical', function(){
                var url = '/site/allsubject';
                var obj = 'pop-tbody';
                articalPlusx(url, obj);
                return false;
            });
            $('.search-btn').on('click.yiiPartical', function(){
                var obj = 'pop-body';
                var keyword = $('input[name="keyword-input"]').val();
                var url = '/site/subject';
                keywordFind(obj, url, keyword);
            });
            $('.search-tbtn').on('click.yiiPartical', function(){
                var obj = 'pop-tbody';
                var keyword = $('input[name="keyword-tinput"]').val();
                var url = '/site/searchsubject';
                keywordFind(obj, url, keyword);
            });
            $('input[name="keyword-input"]').on('focus.yiiPartical', function(){
                document.onkeydown = function (e) {
                    if (!e) e = window.event;
                    if ((e.keyCode || e.which) == 13) {
                        var obj = 'pop-body';
                        var keyword = $('input[name="keyword-input"]').val();
                        var url = '/site/subject';
                        keywordFind(obj, url, keyword);
                    }
                }
            });
            $('input[name="keyword-tinput"]').on('click.yiiPartical', function(){
                document.onkeydown = function (e) {
                    if (!e) e = window.event;
                    if ((e.keyCode || e.which) == 13) {
                        var obj = 'pop-tbody';
                        var keyword = $('input[name="keyword-tinput"]').val();
                        var url = '/site/searchsubject';
                        keywordFind(obj, url, keyword);
                    }
                }
            });
            windScrol();
            watchClick();
        },
    };
    var watchClick = function(elem){
        $('.collect-btn').on('click.yiiPartical', function(){
            collectArtical();
            return false;
        });
    };
    var articalPlusx = function(url, obj){
        $('.win-back').css("display", "block");
        $('.pop-win').css("display", "block");
        $('input[name="keyword-input"]').val('');
        $('input[name="keyword-tinput"]').val('');
        var formData = new FormData();
        formData.append('_csrf-frontend', defaults.csrfToken);
        formData.append('aid', defaults.aid);
        $.ajax({
            url: url,
            type: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        }).always(function(result){
            $('.'+obj).html(result);
        });
    };
    var keywordFind = function(obj, url, keyword){
        var formData = new FormData();
        formData.append('aid', defaults.aid);
        formData.append('uid', defaults.uid);
        formData.append('keyword', keyword);
        $.ajax({
            url: url,
            type: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        }).always(function(result){
            $('.'+obj).html(result);
        });
    };
    var collectArtical = function(){
        var formData = new FormData();
        formData.append('_csrf-frontend', defaults.csrfToken);
        formData.append('aid', defaults.aid);
        $.ajax({
            url: '/site/collect',
            type: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        }).always(function(result){
            var data = JSON.parse(result);
            if(data['status'] === 'collect'){
                $('.icon-bookmarks').html('');
                $('.question-feedbacks').text('取消收藏');
                $('.icon-bookmarks').html('<i class="icon-bookmark icon-large" style="color:#f3715c;"></i>');
            }
            if(data['status'] === 'nocollect'){
                $('.icon-bookmarks').html('');
                $('.question-feedbacks').text('收藏文章');
                $('.icon-bookmarks').html('<i class="icon-bookmark-empty icon-large"></i>');
            }
        });
    };
    var windScrol = function(){
        $(window)
        .scroll(function(){
            var height = $(window).height();
            var topheight = $(document).scrollTop();
            if( height < topheight){
                if(defaults.isGuest == 1){
                    $('.outcontainer-content').css("height","50px");
                    $('.outcontainer-content ul li').eq(0).css("display","block");
                    $('.outcontainer-content ul li').eq(0).css("border-bottom","1px solid #ddd");
                }else{
                    $('.outcontainer-content').css("height","250px");
                    $('.outcontainer-content ul li').eq(0).css("display","block");
                    $('.outcontainer-content ul li').eq(0).css("border-bottom","1px solid #ddd");
                }
            }else{
                if(defaults.isGuest == 1){
                    $('.outcontainer-content').css("height","0px");
                    $('.outcontainer-content ul li').eq(0).css("display","none");
                    $('.outcontainer-content ul li').eq(0).css("border-bottom","none");
                }else{
                    $('.outcontainer-content').css("height","200px");
                    $('.outcontainer-content ul li').eq(0).css("display","none");
                    $('.outcontainer-content ul li').eq(0).css("border-bottom","none");
                }
            }
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
