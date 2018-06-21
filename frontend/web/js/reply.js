(function ($) {
    $.fn.yiiReply = function (method) {
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
        areaIsEmpty: true,
        areaPIsUse: false,
        areaCIsUse: false,
        isLogin: null,
    };
    var methods = {
        init: function(options){
            var $container = $(this);
            var options = options || {},
                preply = options.preply,
                creply = options.creply,
                addnewreply = options.addnewreply;
            defaults.isLogin = options.isLogin;
            $container.find('.comment-commentd-list').each(function(){
                $(this).data('areaUse', {
                    areaIsEmpty: true,
                    areaPIsUse: false,
                    areaCIsUse: false,
                });
            })
            var preplybtn = $container.find('span.'+preply);
            preplybtn.each(function(){
                preplyWatchClick($container, this);
            })
            var creplybtn = $container.find('span.'+creply);
            creplybtn.each(function(){
                $(this).data('areaCmUse', false);
                creplyWatchClick($container, this);
            })
            var addnewreplybtn = $container.find('span.'+addnewreply);
            addnewreplybtn.each(function(){
                preplyWatchClick($container, this);
            })

        },
    };
    var creplyWatchClick = function($container, creplybtn){
        $(creplybtn).on('click.yiiReply', function(){
            if(!defaults.isLogin){
                creplyOperate($container, this);
            }else{
                $('.blog-back').css('display', 'block');
                $('.pop-tologin').css('display', 'block');
                $("body").css('overflowY', 'hidden');
            }
            return false;
        })
    }
    var creplyOperate = function($container, btn){
        var replylist = $(btn).parents('.comment-commentd-list');
        var replyarea = $(btn).parents('.comment-commentd-list').find('.reply-area');
        var replycomm = $(btn).parents('.comment-replyed-maincontent').find('.reply-comm').data('comm');
        if(replylist.data('areaUse').areaIsEmpty == true){
            replylist.data('areaUse').areaIsEmpty = false;
            replylist.data('areaUse').areaCIsUse = true;
            $(btn).data('areaCmUse', true);
            var replyform = $('.comment-content').html();
            var pid = $(btn).parents('.comment-maincontent').find('.comment-person').data('pid');
            replyarea.html(replyform);
            replyarea.find('form').find('textarea[name="CommentForm[comment]"]').attr('placeholder', '回复'+replycomm);
            replyarea.find('form').find('input[name="CommentForm[p_id]"]').val(pid);
            replyarea.find('form').find('input[name="CommentForm[bereplyer]"]').val(replycomm);
        } 
        else if(replylist.data('areaUse').areaIsEmpty == false){
            if(replylist.data('areaUse').areaPIsUse == true){
                replylist.data('areaUse').areaPIsUse = false;
                replylist.data('areaUse').areaCIsUse = true;
                $(btn).data('areaCmUse', true);
                replyarea.find('form').find('textarea[name="CommentForm[comment]"]').attr('placeholder', '回复'+replycomm);
                replyarea.find('form').find('input[name="CommentForm[bereplyer]"]').val(replycomm);
            }else if(replylist.data('areaUse').areaCIsUse == true){
                if($(btn).data('areaCmUse') == true){
                    replylist.data('areaUse').areaIsEmpty = true;
                    replylist.data('areaUse').areaCIsUse = false;
                    $(btn).data('areaCmUse', false);
                    replyarea.html('');
                }else{
                    replylist.data('areaUse').areaPIsUse = false;
                    $('.comment-replyed').find('span.reply-c-btn').each(function(){
                        $(this).data('areaCmUse', false);
                    })
                    $(btn).data('areaCmUse', true);
                    replyarea.find('form').find('textarea[name="CommentForm[comment]"]').attr('placeholder', '回复'+replycomm);
                    replyarea.find('form').find('input[name="CommentForm[bereplyer]"]').val(replycomm);
                }
            }
        }
        var text = document.getElementsByTagName("textarea");
        jQuery(text).yiiComment({
            
        });
    }
    var preplyWatchClick = function($container, preplybtn){
        $(preplybtn).on('click.yiiReply', function(){
            if(!defaults.isLogin){
                preplyOperate($container, this);
            }else{
                $('.blog-back').css('display', 'block');
                $('.pop-tologin').css('display', 'block');
                $("body").css('overflowY', 'hidden');
            }
            return false;
        })
    };
    var preplyOperate = function($container, btn){
        var replylist = $(btn).parents('.comment-commentd-list');
        var replyarea = $(btn).parents('.comment-commentd-list').find('.reply-area');
        if(replylist.data('areaUse').areaIsEmpty == true){
            replylist.data('areaUse').areaIsEmpty = false;
            replylist.data('areaUse').areaPIsUse = true;
            var replyform = $('.comment-content').html();
            var pid = $(btn).parents('.comment-maincontent').find('.comment-person').data('pid');
            replyarea.html(replyform);
            replyarea.find('form').find('input[name="CommentForm[p_id]"]').val(pid);
            replyarea.find('form').find('input[name="CommentForm[bereplyer]"]').val('');
            replyarea.find('form').find('.comment-btngroups').css('display', 'none');
        } 
        else if(replylist.data('areaUse').areaIsEmpty == false){
            if(replylist.data('areaUse').areaCIsUse == true){
                replylist.data('areaUse').areaCIsUse = false;
                replylist.data('areaUse').areaPIsUse = true;
                replyarea.find('form').find('textarea[name="CommentForm[comment]"]').prop('placeholder', '写下你的评论...');
                replyarea.find('form').find('input[name="CommentForm[bereplyer]"]').val('');
                replyarea.find('form').find('.comment-btngroups').css('display', 'none');
            }else if(replylist.data('areaUse').areaPIsUse == true){
                replylist.data('areaUse').areaIsEmpty = true;
                replylist.data('areaUse').areaPIsUse = false;
                replyarea.html('');
            }
        }
        var text = document.getElementsByTagName("textarea");
        jQuery(text).yiiComment({
            
        });
    }
})(window.jQuery);
