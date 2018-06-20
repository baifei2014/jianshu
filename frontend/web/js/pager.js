(function ($) {
    $.fn.yiiPager = function (method) {
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
    };
    var methods = {
        init: function(attributes, options){
            defaults.aid = attributes.aid;
            this.each(function(){
                var elem = $(this);
                var button = $(this).find('button');
                watchClick(elem, button);
            })
        },
    };

    var watchClick = function(elem, button){
        button.on('click.yiiPager', function(){
            updatePager(elem, button);
        })
    }
    var updatePager = function(elem, button){
        if(elem.hasClass('disabled')){
            return false;
        }
        var datapage = $(button).data('page');
        updateContent(datapage+1);

    }
    var updateContent = function(page, aid){
        var formData = new FormData();
        formData.append('aid', defaults.aid);
        var csrf_frontend = $('input[name="_csrf-frontend"]').val();
        formData.append('_csrf-frontend', csrf_frontend);
        $.ajax({
            url: '/site/getcomment&page='+page,
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
    }
})(window.jQuery);
