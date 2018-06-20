(function ($) {
    $.fn.yiiComment = function (method) {
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
        isLogin: null,
    };
    var methods = {
        init: function(options){
            defaults.isLogin = options.isLogin;
            this.each(function(){
                var options = options || {},
                    elem = this,
                    maxHeight = options.maxHeight,
                    extra = options.extra;
                extra = extra || 0;
                var isFirefox = !!document.getBoxObjectFor || 'mozInnerScreenX' in window,
                    isOpera = !!window.opera && !!window.opera.toString().indexOf('Opera'),
                    // getStyle = elem.currentStyle ? function (name) {
                    //     var val = elem.currentStyle[name];

                    //     if (name === 'height' && val.search(/px/i) !== 1) {
                    //         var rect = elem.getBoundingClientRect();
                    //         return rect.bottom - rect.top -
                    //             parseFloat(getStyle('paddingTop')) -
                    //             parseFloat(getStyle('paddingBottom')) + 'px';
                    //     };

                    //     return val;
                    // } : function (name) {
                    //     return getComputedStyle(elem, null)[name];
                    // },
                    minHeight = parseFloat(getStyle(elem, 'height'));
                    // minHeight = "44";
                var submitbtn = $(elem).parentsUntil('form').find('.csubmit-btn')[0];
                var cancelbtn = $(elem).parentsUntil('form').find('.creset-btn')[0];
                $(submitbtn).on('click', function(){
                    methods.savecomment(this);
                    return false;
                });
                $(cancelbtn).on('click', function(){
                    methods.hiddenForm(this);
                });
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
                $('.comment-content').find('textarea').on('click', function(){
                    return false;
                })
                addEvent(elem, 'propertychange', change, isFirefox, isOpera, minHeight, maxHeight, extra);
                addEvent(elem, 'input', allinput, isFirefox, isOpera, minHeight, maxHeight, extra);
                addEvent(elem, 'focus', change, isFirefox, isOpera, minHeight, maxHeight, extra);
                addEvent(elem, 'focus', textfocus, isFirefox, isOpera, minHeight, maxHeight, extra);
                addEvent(elem, 'blur', textblur, isFirefox, isOpera, minHeight, maxHeight, extra);
                change(elem, isFirefox, isOpera, minHeight, maxHeight, extra);
            })
        },
        hiddenForm: function(that){
            $(that).parents('.comment-btngroups').css('display', 'none');
        },
        savecomment: function(that){
            var $form = $(that).parents('form');
            $.ajax({
                url: $form.attr('action'),
                type: $form.attr('method'),
                data: $form.serialize(),
                dataType: 'json',
                complete: function (jqXHR, textStatus) {
                    // $form.trigger(events.ajaxComplete, [jqXHR, textStatus]);
                },
                beforeSend: function (jqXHR, settings) {
                    // $form.trigger(events.ajaxBeforeSend, [jqXHR, settings]);
                },
                success: function (msgs) {
                    if(msgs !== null && typeof msgs === 'object'){
                        $form.find('textarea[name="CommentForm[comment]"]').val('');
                        var btn = $form.find('.csubmit-btn');
                        $(btn).attr('disabled', 'disabled');
                        $(btn).removeClass('textnotempty');
                        updateComment(msgs);
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    
                }
            });
        },
    };
    var updateComment = function(messages){
        var aid = messages['aid'];
        var formData = new FormData();
        formData.append('aid', aid);
        var csrf_frontend = $('input[name="_csrf-frontend"]').val();
        formData.append('_csrf-frontend', csrf_frontend);
        $.ajax({
            url: '/site/getcomment',
            type: 'post',
            data: formData,
            processData: false,  // 不处理数据
            contentType: false,   // 不设置内容类型
            complete: function (jqXHR, textStatus) {
                // $form.trigger(events.ajaxComplete, [jqXHR, textStatus]);
            },
            beforeSend: function (jqXHR, settings) {
                // $form.trigger(events.ajaxBeforeSend, [jqXHR, settings]);
            },
            success: function (msgs) {
                $('#comment-commentd').html(msgs);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                
            }
        });
    };
    var addEvent = function (elem, type, callback, isFirefox, isOpera, minHeight, maxHeight, extra) {
        elem.addEventListener ?
        elem.addEventListener(type, function(){callback(elem, isFirefox, isOpera, minHeight, maxHeight, extra)}) :
        elem.attachEvent('on' + type, function(){callback(elem, isFirefox, isOpera, minHeight, maxHeight, extra)});
    };
    var textfocus = function(elem){
        if(!defaults.isLogin){
            $(elem).addClass('commentarea-focus');
            $(elem).parents('.comment-textform').find('.comment-btngroups').css('display', 'block');
        }else{
            $(elem).blur();
            popToLogin();
        }
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
    }
    var textblur = function(elem){
        $(elem).removeClass('commentarea-focus');
    }
    var allinput = function(elem, isFirefox, isOpera, minHeight, maxHeight, extra){
        change(elem, isFirefox, isOpera, minHeight, maxHeight, extra);
        textinput(elem);
    }
    var textinput = function(elem){
        var btn = $(elem).parentsUntil('form').find('.csubmit-btn');
        var reg = new RegExp("\n","g");
        var value = elem.value.replace(reg, '');
        if(value.length > 0){
            btn.removeAttr('disabled');
            btn.addClass('textnotempty');
        }else{
            btn.attr('disabled', 'disabled');
            btn.removeClass('textnotempty');
        }
    }
    var change = function (elem, isFirefox, isOpera, minHeight, maxHeight, extra) {
        var scrollTop, height,
            padding = 0,
            style = elem.style;
        if(!elem.currHeight){
            elem.currHeight = 50;
        }
        if (elem._length === elem.value.length) return;
        elem._length = elem.value.length;

        if (!isFirefox && !isOpera) {
            padding = parseInt(getStyle(elem, 'paddingTop')) + parseInt(getStyle(elem, 'paddingBottom'));
        };
        scrollTop = document.body.scrollTop || document.documentElement.scrollTop;
        elem.style.height = minHeight + 'px';
        if (elem.scrollHeight > minHeight+1 || elem.scrollHeight > minHeight) {
            if (maxHeight && elem.scrollHeight > maxHeight) {
                height = maxHeight - padding;
                style.overflowY = 'auto';
            } else {
                height = elem.scrollHeight + 0.1*padding;
                style.overflowY = 'hidden';
            };
            elem.style.height = height + extra + 'px';
            scrollTop += parseInt(style.height) - elem.currHeight;
            document.body.scrollTop = scrollTop;
            document.documentElement.scrollTop = scrollTop;
            elem.currHeight = parseInt(style.height);
        };
    };
    var getStyle = function(elem, name){
        if(elem.currentStyle === undefined){
            return getComputedStyle(elem, null)[name];
        }else{
            var val = elem.currentStyle[name];
            if (name === 'height' && val.search(/px/i) !== 1) {
                var rect = elem.getBoundingClientRect();
                return rect.bottom - rect.top - parseFloat(getStyle(elem, 'paddingTop')) - parseFloat(getStyle(elem, 'paddingBottom')) + 'px';
            };
            return val;
        }
    };
})(window.jQuery);
