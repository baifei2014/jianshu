<?php 
use yii\bootstrap\ActiveForm;

$this->title = '聊天室';
?>
<?php $form = ActiveForm::begin(); ?>
<?php ActiveForm::end(); ?>
<div class="chat-index" id="chat">
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
                        <div class="load-more" :class="{load-more-hidden: isHidden}">
                            <span class="load-more-btn" v-on:click="getMessage()">点击加载更多</span>
                        </div>
                    </div>
                </div>
                <div class="form-bottom">
                    <input type="text" name="message-form" class="message-input" @keyup.enter="sendMessage()"><span class="submit-button" v-on:click="sendMessage()">发送</span>
                </div>
            </div>
        </div>
        <div class="col-cm-4">
            <div class="chat-types">
                <div class="main-types">
                    <ul class="chatroom-block">
                        <li v-for="chatroom in chatrooms">
                            <div :class="{active: activeRoomId == chatroom.id}" class="chatroom-item" v-on:click="selectCurrentChatRoom(chatroom.id)">
                                <div>
                                    <img class="chatroom-img" :src="chatroom.avatar">
                                </div>
                                <div class="chatroom-info">
                                    <div>
                                        <div>{{ chatroom.room_name }}</div>
                                        <div class="chatroom-lastmessage"><span>今天是小明刚来学校</span></div>
                                    </div>
                                    <div class="chat-time">
                                        <span>2018-09-01</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
</div>
<script src="/js/jquery.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script type="text/javascript">
    var app = new Vue({
      el: '#chat',
      data: {
        chatrooms: null,
        activeRoomId: 1,
        ws: null,
        bindUrl: '/chat/default/bind',
        sendMessageUrl: '/chat/default/sentmessage',
        clientId: null,
        isHidden: false
      },
      created: function() {
        var _this = this
        axios.get('/chat/default/chat-rooms')
          .then(function (response) {
            _this.chatrooms = response.data;
          })
        _this.ws = new WebSocket("ws://47.98.130.177:1235");
        _this.ws.onmessage = function(e){
            var data = eval("("+e.data+")");
            var type = data.type || '';
            _this.clientId = data.client_id;
            switch(type){
                case 'init':
                    ajaxRequest(
                        _this.bindUrl,
                        _this.activeRoomId,
                        _this.clientId
                    );
                    break;
                default :
                    if(data.uid == id){
                        var mess_position = 'right-message';
                    }else{
                        var mess_position = 'left-message';
                    }
                    showMessage(mess_position, data.avatar, data.message);
            }
        };
      },
      methods: {
        selectCurrentChatRoom: function(roomId) {
            this.activeRoomId = roomId;
            ajaxRequest(
                this.bindUrl,
                roomId,
                this.clientId
            );
        },
        sendMessage: function() {
            var message = getValue();

            var uid = '<?php echo Yii::$app->user->identity->id ?>';
            if(message != ''){
                ajaxRequest(this.sendMessageUrl, this.activeRoomId, uid, message)
            }
        },
        getMessage: function(){
            $('.chat-content').children('.load-more').remove()
            var formData = new FormData();
            var csrfToken = $('input[name="_csrf-frontend"]').val();
            formData.append('_csrf-frontend', csrfToken);

            if(getCookie('info_page')){
                var page =  getCookie('info_page');
                setCookie('info_page', parseInt(page) + parseInt(10))
            }else{
                var page = 0;
                setCookie('info_page', 10)
            }

            formData.append('info_page', page);
            var id = '<?php echo Yii::$app->user->identity->id ?>';
            formData.append('id', id);
            formData.append('room_id', this.activeRoomId);

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
                }
            });
        }
      }
    })
</script>
<script type="text/javascript">
    setCookie('info_page', "", -1); 
    // $('.chat-content').scrollTop( $('.chat-content')[0].scrollHeight );
    var id = '<?php echo Yii::$app->user->identity->id ?>';
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
    function ajaxRequest(url, roomId, id, message = ''){
        
        var formData = new FormData();
        var csrfToken = $('input[name="_csrf-frontend"]').val();
        formData.append('_csrf-frontend', csrfToken);
        if(message != ''){
            formData.append('message', message);
        }
        formData.append('id', id);
        formData.append('room_id', roomId);
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
