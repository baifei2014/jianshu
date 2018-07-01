<?php 
use yii\bootstrap\ActiveForm;
?>
<?php $form = ActiveForm::begin(); ?>
<?php ActiveForm::end(); ?>
<div class="chat-index">
        <div class="col-cm-2">
            <div class="chatp-infor">
                <div class="chatp-top">
                    <img src="<?php echo '/'.$user['avatar'] ?>" class="chat-avatar-big">
                    <p class="chat-name"><?php echo $user['nickname']; ?></p>
                </div>
                <div class="chatp-middle">
                    <div class="like-thing">
                        <p>喜欢的事</p>
                        <span class="interest-tag1 interest-tag">爱聊天</span>
                        <span class="interest-tag2 interest-tag">见义勇为</span>
                        <span class="interest-tag3 interest-tag">工作狂</span>
                        <span class="interest-tag4 interest-tag">唱歌</span>
                    </div>
                    <div class="hate-thing">
                        <p>讨厌的事</p>
                        <span class="interest-tag1 interest-tag">被冤枉</span>
                        <span class="interest-tag2 interest-tag">无所事事</span>
                        <span class="interest-tag3 interest-tag">没钱花</span>
                        <span class="interest-tag4 interest-tag">吵架</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-cm-8">
            <div class="chat-body">
                <div class="main-body">
                    <div class="chat-content" id="chat-main">
                        <div class="load-more">
                            <span class="load-more-btn">点击加载更多</span>
                        </div>
                    </div>
                </div>
                <div class="form-bottom">
                    <input type="text" name="message-form" class="message-input"><span class="submit-button">发送</span>
                </div>
            </div>
        </div>
        <div class="col-cm-2">
            <div class="chat-types">
                <div class="main-types">
                    <span class="chat-type1 list-type">聊天</span>
                    <span class="chat-type6 list-type">笑话</span>
                    <span class="chat-type5 list-type">问答</span>
                    <span class="chat-type3 list-type">图片</span>
                    <span class="chat-type4 list-type">天气</span>
                    <span class="chat-type6 list-type">百科</span>
                    <span class="chat-type2 list-type">故事</span>
                    <span class="chat-type6 list-type">新闻</span>
                    <span class="chat-type4 list-type">菜谱</span>
                    <span class="chat-type1 list-type">星座</span>
                    <span class="chat-type3 list-type">凶吉</span>
                    <span class="chat-type6 list-type">计算</span>
                    <span class="chat-type5 list-type">快递</span>
                    <span class="chat-type2 list-type">飞机</span>
                </div>
            </div>
        </div>
</div>
<script src="/js/jquery.js"></script>
<script type="text/javascript">
    setCookie('info_page', "", -1); 
    $('.chat-content').scrollTop( $('.chat-content')[0].scrollHeight );
    var id = '<?php echo Yii::$app->user->identity->id ?>';
    $('input[name="message-form"]')
    .focus(function(){
        document.onkeydown = function (e) {
            if (!e) e = window.event;
            if ((e.keyCode || e.which) == 13) {
                var message = getValue();
                $('.chat-content').scrollTop( $('.chat-content')[0].scrollHeight );
                var url = '<?php echo '/chat/default/sentmessage' ?>';
                var uid = '<?php echo Yii::$app->user->identity->id ?>';
                if(message != ''){
                    ajaxRequest(url, uid, message)
                }
            }
        }
    })
    $('.submit-button')
    .click(function(){
        var message = getValue();
        var url = '<?php echo '/chat/default/sentmessage' ?>';

        var uid = '<?php echo Yii::$app->user->identity->id ?>';
        if(message != ''){
            ajaxRequest(url, uid, message)
        }
    })
    function getValue()
    {
        var message = $('input[name="message-form"]').val();
        $('input[name="message-form"]').val('');
        return message;
    }
    function showMessage(mess_position, avatar, message)
    {
        $('.chat-content').append('<div class="message-list '+mess_position+'"><span><img src="'+'/'+avatar+'" class="chat-avatar-small"></span><p>'+message+'<i></i></p></div>');
        $('.chat-content').scrollTop( $('.chat-content')[0].scrollHeight );
    }
    /**
     * 与GatewayWorker建立websocket连接，域名和端口改为你实际的域名端口，
     * 其中端口为Gateway端口，即start_gateway.php指定的端口。
     * start_gateway.php 中需要指定websocket协议，像这样
     * $gateway = new Gateway(websocket://0.0.0.0:7272);
    */
    ws = new WebSocket("ws://127.0.0.1:1235");
    // 服务端主动推送消息时会触发这里的onmessage
    
    ws.onmessage = function(e){
        // json数据转换成js对象
        // console.log(e);
        var data = eval("("+e.data+")");
     
        var type = data.type || '';
        switch(type){
            // Events.php中返回的init类型的消息，将client_id发给后台进行uid绑定
            case 'init':
                // 利用jquery发起ajax请求，将client_id发给后端进行uid绑定
                // $.post('./bind.php', {client_id: data.client_id}, function(data){}, 'json');
                var url = '<?php echo '/chat/default/bind' ?>';
                ajaxRequest(url, data.client_id);
                break;
            // 当mvc框架调用GatewayClient发消息时直接alert出来
            default :
                if(data.uid == id){
                    var mess_position = 'right-message';
                }else{
                    var mess_position = 'left-message';
                }
                showMessage(mess_position, data.avatar, data.message);
        }
    };
    function ajaxRequest(url, id, message = ''){
        
        var formData = new FormData();
        var csrfToken = $('input[name="_csrf-frontend"]').val();
        formData.append('_csrf-frontend', csrfToken);
        if(message != ''){
            formData.append('message', message);
        }
        formData.append('id', id);
        $.ajax({
            url: url,
            type: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        }).always(function(result){
        });
    }
    $(document).on('click', '.load-more-btn', getMessage)
    function getMessage(){
        $('.chat-content').children('.load-more').remove()
        var formData = new FormData();
        var csrfToken = $('input[name="_csrf-frontend"]').val();
        formData.append('_csrf-frontend', csrfToken);

        if(getCookie('info_page')){
            var page =  getCookie('info_page');
            setCookie('info_page', page + 10)
        }else{
            var page = 0;
            setCookie('info_page', 10)
        }

        formData.append('info_page', page);
        var id = '<?php echo Yii::$app->user->identity->id ?>';
        formData.append('id', id);

        $.ajax({
            url: '/chat/default/get-message',
            type: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        }).always(function(response){
            var result = JSON.parse(response)

            if(!result['code']) {
                return;
            }
            if(page == 0) {
                $('.chat-content').prepend('<div class="load-info"><span>以上是历史消息</span></div>')
            }
            var infos = result['infos']
            for (var i = 0; i < infos.length; i++) {
                if(i != 0) {
                    if((infos[i-1]['created_at'] - infos[i]['created_at']) > 1500) {
                        var creaetd_at = formatDate(infos[i-1]['created_at'])
                        $('.chat-content').prepend('<div class="load-info"><span>'+ creaetd_at +'</span></div>')
                    }
                }
                if(infos[i]['uid'] == id){
                    var mess_position = 'right-message';
                }else{
                    var mess_position = 'left-message';
                }
                $('.chat-content').prepend('<div class="message-list '+mess_position+'"><span><img src="'+'/' + infos[i]['avatar'] + '" class="chat-avatar-small"></span><p>'+infos[i]['message']+'<i></i></p></div>');
            }

            var creaetd_at = formatDate(infos[infos.length - 1]['created_at'])
            $('.chat-content').prepend('<div class="load-info"><span>'+ creaetd_at +'</span></div>')

            if(result['code'] == 1) {
                $('.chat-content').prepend('<div class="load-more"><span class="load-more-btn">点击加载更多</span></div>')
                $(document).on('click', '.load-more-btn', getMessage)
            }
        });
    }
    function formatDate(now) {
        var now = new Date(now*1000)
    　　var year = now.getFullYear(),
    　　month = now.getMonth() + 1,
    　　date = now.getDate(),
    　　hour = now.getHours(),
    　　minute = now.getMinutes(),
    　　second = now.getSeconds();
     
    　　return year + "/" + month + "/" + date + " " + hour + ":" + minute + ":" + second;
    }
    function getCookie(c_name) {
        if (document.cookie.length > 0) {
            c_start = document.cookie.indexOf(c_name + "=")
            if (c_start != -1) {
                c_start = c_start + c_name.length + 1
                c_end = document.cookie.indexOf(";", c_start)
                if (c_end == -1)
                    c_end = document.cookie.length
                return unescape(document.cookie.substring(c_start, c_end))
            }
        }
        return ""
    }

    function setCookie(name, value) {
        var exp = new Date();
        exp.setTime(exp.getTime() + 1 * 24 * 60 * 60 * 1000); //3天过期  
        document.cookie = name + "=" + encodeURIComponent(value) + ";expires=" + exp.toGMTString() + ";path=/";
        return true;
    };
</script>
