(function ($) {
    $.fn.yiiFocus = function (method) {
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
        aid: '',
        wid: '',
        csrfToken: '',
        isGuest: undefined,
        likebtn: {},
    };
    var methods = {
        init: function(attributes, options){
            defaults.isGuest = attributes.isGuest || true;
            defaults.likebtn = attributes.likebtn || {};
            defaults.aid = attributes.aid || '';
            defaults.wid = attributes.wid || '';
            defaults.csrfToken = attributes.csrfToken || '';
            var focusbtn = attributes.focusbtn || {};
            $('.'+focusbtn).each(function(){
                watchClick({'focusbtn': this});
            })
            $.each(this, function(){
                watchClick({'elem': this});
            })

        },
    };
    var watchClick = function(param){
        var elem = param.elem || {},
            focusbtn = param.focusbtn || {};
        if(defaults.isGuest == 1){
            $(elem).off('click.yiiFocus');
            $(elem).on('click.yiiFocus', function(){
                $('.cancel-tologin-btn').on('click', function(){
                    $('.blog-back').css('display', 'none');
                    $('.pop-tologin').css('display', 'none');
                    $("body").css('overflowY', 'auto');
                });
                $(window).on('click', function(){
                    $('.blog-back').css('display', 'none');
                    $('.pop-tologin').css('display', 'none');
                    $("body").css('overflowY', 'auto');
                });
                $('.pop-tologin').on('click', function(){
                    return false;
                })
                popToLogin();
                return false;
            })
        }else{
            $(focusbtn).off('click.yiiFocus');
            $(focusbtn).on('click.yiiFocus', function(){
                var i = $('.opfocus-area').index($(this).parents('.opfocus-area'));
                var id = $('input[name="befocus_id"]').eq(i).val();
                var type = $('input[name="befocus_type"]').eq(i).val();
                toFocus(id, i, type);
            })
            if(defaults.likebtn){
                $('.like-btn').off('click.yiiFocus');
                $('.like-btn').on('click.yiiFocus', function(){
                    likeArtical();
                })
            }
        }
    };
    var toFocus = function(id, i, type){
        var formData = new FormData();
        var csrfToken = $('input[name="_csrf-frontend"]').val();
        formData.append('_csrf-frontend', csrfToken);
        formData.append('uid', id);
        formData.append('type', type);
        $.ajax({
            url: '/user/home/ofocus',
            type: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        }).always(function(result){
            var data = JSON.parse(result);
            if(data['status'] === 'cancel'){
                $('.tabfocus-area').eq(i).html('');
                $('.tabfocus-area').eq(i).html('<span class="addfocus-btn focus-btn need-islogin"><i class="icon-plus"></i>&nbsp;关注</span>');
                $('.tabfocus-area .need-islogin').off('click.yiiFocus');
                $('.tabfocus-area .need-islogin').on('click.yiiFocus', function(){
                    var i = $('.opfocus-area').index($(this).parents('.opfocus-area'));
                    var id = $('input[name="befocus_id"]').eq(i).val();
                    var type = $('input[name="befocus_type"]').eq(i).val();
                    toFocus(id, i, type);
                })
            }else if(data['status'] === 'success'){
                $('.tabfocus-area').eq(i).html('');
                $('.tabfocus-area').eq(i).html('<span class="focused-btn focus-btn"><i class="icon-ok"></i>&nbsp;已关注</span>');
                $('.tabfocus-area .focused-btn').off('click.yiiFocus');
                $('.tabfocus-area .focused-btn').on('click.yiiFocus', function(){
                    var i = $('.opfocus-area').index($(this).parents('.opfocus-area'));
                    var id = $('input[name="befocus_id"]').eq(i).val();
                    var type = $('input[name="befocus_type"]').eq(i).val();
                    toFocus(id, i, type);
                })
                $('.tabfocus-area .focused-btn').on('mouseover',function(){
                    var i = $('.tabfocus-area .focused-btn').index(this);
                    $('.tabfocus-area .focused-btn').eq(i).html('');
                    $('.tabfocus-area .focused-btn').eq(i).html('<i class="icon-remove"></i>&nbsp;取消关注');
                })
                $('.tabfocus-area .focused-btn').on('mouseout',function(){
                    var i = $('.tabfocus-area .focused-btn').index(this);
                    $('.tabfocus-area .focused-btn').eq(i).html('');
                    $('.tabfocus-area .focused-btn').eq(i).html('<i class="icon-ok"></i>&nbsp;已关注');
                })
            }
        });
    }
    var popToLogin = function(){
        $('.blog-back').css('display', 'block');
        $('.pop-tologin').css('display', 'block');
        $("body").css('overflowY', 'hidden');
        $('.tologin-link a').on('click', function(){
            window.location.href = $(this).attr('href');
        })
        $('.toregist-link a').on('click', function(){
            window.location.href = $(this).attr('href');
        })
    };
    var likeArtical = function(){
        var formData = new FormData();
        formData.append('_csrf-frontend', defaults.csrfToken);
        formData.append('aid', defaults.aid);
        formData.append('wid', defaults.wid);
        $.ajax({
            url: '/site/like',
            type: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        }).always(function(result){
            var data = JSON.parse(result);
            if(data['status'] === 'success'){
                $('.like-btn').removeClass('support-like');
                $('.like-btn').addClass('supported-like');
                $('.like-sums').text(data['like']);
            }
            if(data['status'] === 'cancel'){
                $('.like-btn').addClass('support-like');
                $('.like-btn').removeClass('supported-like');
                $('.like-sums').text(data['like']);
            }
        });
    };

})(window.jQuery);
