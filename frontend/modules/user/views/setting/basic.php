<?php 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = '编辑个人资料';
?>
<div class="setting-index">
    <div class="row">
        <div class="col-sm-3">
            <div class="left-menu">
                <ul>
                    <li><a href="" class="actived"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;&nbsp;个人资料</a></li>
                </ul>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="right-content">
                <?php $form = ActiveForm::begin([
                    'layout' => 'inline',
                ]); ?>
                <table class="form-table">
                    <tr style="border-bottom: none;">
                        <td style="padding-left: 0;"><?php if($user['avatar']){$imgurl = $user['avatar'];}else{$imgurl = Yii::$app->params['avatar'];} ?><img src="<?php echo '/'.$imgurl;?>" class="user-avatar-big"></td>
                        <td><span class="radius-btn">更改头像</span><input type="file" class="form-file" id="btn-upload"></td>
                    </tr>
                    <tr>
                        <td>昵称</td>
                        <td class="formtable-content">
                            <div class="form-showarea">
                                <?php 
                                    if($user['nickname']){
                                ?>
                                <span class="content-value"><?php echo $user['nickname']; ?></span>
                                <span class="modifi-area modifi-btn"><i class="icon-pencil"></i>&nbsp;修改</span>
                                <?php }else{ ?>
                                <span class="fill-area fill-btn"><i class="icon-pencil"></i>&nbsp;填写</span>
                                <?php } ?>
                            </div>
                            <div class="form-inputarea">
                                <?php echo $form->field($model, 'nickname')->textInput(['class' => 'form-textinput form-value', 'value' => $user['nickname'], 'placeholder' => '昵称不能为空'])->label(false); ?><br><br>
                                <?= Html::submitButton('提交', ['class' => 'btn btn-primary btn-submits']) ?>&nbsp;&nbsp;&nbsp;<?= Html::resetButton('取消', ['class' => 'btn btn-default btn-cancels']) ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td>性别</td>
                        <td class="formtable-content">
                            <div class="form-showarea">
                                <span class="content-value"><?php echo $userinfor['sex']; ?></span>
                                <span class="modifi-area modifi-btn"><i class="icon-pencil"></i>&nbsp;修改</span>
                            </div>
                            <div class="form-inputarea">
                                <?= $form->field($userinformodel,'sex')->radioList(['男'=>'男','女'=>'女'], ['value' => $userinfor['sex'], 'class' => 'form-value']) ?><br><br>
                                <?= Html::submitButton('提交', ['class' => 'btn btn-primary btn-submits']) ?>&nbsp;&nbsp;&nbsp;<?= Html::resetButton('取消', ['class' => 'btn btn-default btn-cancels']) ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td>个人网站</td>
                        <td class="formtable-content">
                            <div class="form-showarea">
                                <?php 
                                    if($userinfor['web']){
                                ?>
                                <span class="content-value"><?php echo $userinfor['web']; ?></span>
                                <span class="modifi-area modifi-btn"><i class="icon-pencil"></i>&nbsp;修改</span>
                                <?php }else{ ?>
                                <span class="fill-area fill-btn"><i class="icon-pencil"></i>&nbsp;填写</span>
                                <?php } ?>
                            </div>
                            <div class="form-inputarea">
                                <?php echo $form->field($userinformodel, 'web')->textInput(['class' => 'form-textinput form-value', 'placeholder' => '网站格式为http://或https://开头'])->label(false); ?><br><br>
                                <?= Html::submitButton('提交', ['class' => 'btn btn-primary btn-submits']) ?>&nbsp;&nbsp;&nbsp;<?= Html::resetButton('取消', ['class' => 'btn btn-default btn-cancels']) ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td>微信二维码</td>
                        <td class="qrcode-area"><div class="qrcode-img"><?php if($userinfor['qrcode']){ ?><img src="<?php echo '/'.$userinfor['qrcode']; ?>" class="qrcode-img-middle"><?php } ?></div><div class="upqrcode-area"><span class="radius-btn">更改图片</span><input type="file" class="form-file" id="btn-qrcodeupload"></div><div class="delete-area"><?php if($userinfor['qrcode']){?><span class="delete-btn" id="deleteqr-btn">删除</span><?php } ?></div></td>
                    </tr>
                    <tr>
                        <td>个人简介</td>
                        <td class="formtable-content">
                            <div class="form-showarea">
                                <?php 
                                    if($userinfor['summary']){
                                ?>
                                <span class="content-value"><?php echo $userinfor['summary']; ?></span>
                                <span class="modifi-area modifi-btn"><i class="icon-pencil"></i>&nbsp;修改</span>
                                <?php }else{ ?>
                                <span class="fill-area fill-btn"><i class="icon-pencil"></i>&nbsp;填写</span>
                                <?php } ?>
                            </div>
                            <div class="form-inputarea">
                                <?php echo $form->field($userinformodel, 'summary')->textarea(['class' => 'form-textarea form-value', 'value' => $userinfor['summary']])->label(false); ?><br><br>
                                <?= Html::submitButton('提交', ['class' => 'btn btn-primary btn-submits']) ?>&nbsp;&nbsp;&nbsp;<?= Html::resetButton('取消', ['class' => 'btn btn-default btn-cancels']) ?></div>
                        </td>
                    </tr>
                </table>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<div class="alert-infor">
</div>
<script type="text/javascript" src="/statics/js/jquery.js"></script>
<script type="text/javascript">
    $('#btn-upload')
    .change(function(){
        var file = document.getElementById('btn-upload').files[0];
        var imgname = file.name;
        var imgsize = file.size;
        var pattern = /\.(jpg|gif|png)$/;
        if(!(pattern.test(imgname))){
            alertInfor('上传文件类型不合法');
            return false;
        }
        if(imgsize > 3*1024*1024){
            alertInfor('上传文件太大');
            return false;
        }
        var reader = new FileReader();
        reader.onload = function(e){
            var formData = new FormData();
            var csrfToken = $('input[name="_csrf-frontend"]').val();
            formData.append('_csrf-frontend', csrfToken);
            var imgurl = e.target.result;
            formData.append('imgurl', imgurl);
            $.ajax({
                url: '<?php echo '/user/setting/index' ?>',
                type: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
            }).always(function(result){
                    var data = JSON.parse(result);
                    if(data['status'] === 'success'){
                        $('img.user-avatar-big').prop('src', data['imgurl']);
                        $('.user-avatar-top').prop('src', data['imgurl']);
                        $('.form-file').val('');
                    }else{
                        alertInfor(data['message']);
                    }
            });
        }
        reader.readAsDataURL(file);
    })
    $('#deleteqr-btn')
    .click(function(){
        deleteQrcode();
    })
    function deleteQrcode(){
        var formData = new FormData();
        var csrfToken = $('input[name="_csrf-frontend"]').val();
        formData.append('_csrf-frontend', csrfToken);
        var id = '<?php echo $user['id']; ?>';
        formData.append('id', id);
        $.ajax({
            url: '<?php echo '/user/setting/deleteqr' ?>',
            type: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        }).always(function(result){
            var data = JSON.parse(result);
            if(data['status'] === 'success'){
                $('.qrcode-img').html('');
                $('.delete-area').html('');
            }else{
                alertInfor('删除失败');
            }
        });
    }
    $('#btn-qrcodeupload')
    .change(function(){
        var file = document.getElementById('btn-qrcodeupload').files[0];
        var imgname = file.name;
        var imgsize = file.size;
        var pattern = /\.(jpg|gif|png)$/;
        if(!(pattern.test(imgname))){
            alertInfor('上传文件类型不合法');
            return false;
        }
        if(imgsize > 3*1024*1024){
            alertInfor('上传文件太大');
            return false;
        }
        var reader = new FileReader();
        reader.onload = function(e){
            var formData = new FormData();
            var csrfToken = $('input[name="_csrf-frontend"]').val();
            formData.append('_csrf-frontend', csrfToken);
            var imgurl = e.target.result;
            formData.append('imgurl', imgurl);
            $.ajax({
                url: '<?php echo '/user/setting/qrcode' ?>',
                type: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
            }).always(function(result){
                var data = JSON.parse(result);
                if(data['status'] === 'success'){
                    if($('.qrcode-img').find('img').length === 0){
                        $('.qrcode-img').html('<img src="'+data['imgurl']+'" class="qrcode-img-middle">');
                        $('.delete-area').html('<span class="delete-btn" id="deleteqr-btn">删除</span>');
                        $('#deleteqr-btn').on('click', function(){
                            deleteQrcode();
                        })
                    }else{
                        $('img.qrcode-img-middle').prop('src', data['imgurl']);
                    }
                    $('.form-file').val('');
                }else{
                    alertInfor(data['message']);
                }
            });
        }
        reader.readAsDataURL(file);
    })
    function alertInfor(text) {
        $('.alert-infor').css('display', 'block');
        $('.alert-infor').html(text);
        setTimeout("$('.alert-infor').css('display','none')", 2000);
    }
    $('.btn-save')
    .click(function(){
        var nickname = $('.form-user').val();
        if(nickname === ''){
            alertInfor('昵称不能为空');
            return false;
        }
        if(nickname.length < 2){
            alertInfor('昵称至少2个字');
            return false;
        }
        if(nickname.length > 16){
            alertInfor('昵称至多16个字');
            return false;
        }
    })
    $('.formtable-content')
    .mouseenter(function(){
        $(this).find('.modifi-area').css('visibility', 'visible');
    })
    $('.formtable-content')
    .mouseleave(function(){
        $(this).find('.modifi-area').css('visibility', 'hidden');
    })
    $('.modifi-btn')
    .click(function(){
        var that = this;
        showForminput(that);
    })
    $('.fill-btn')
    .click(function(){
        var that = this;
        showForminput(that);
    })
    function showForminput(that){
        $(that).parent('.form-showarea').css('display', 'none');
        $(that).parents('.formtable-content').find('.form-inputarea').css('display','block');
        if($(that).parent('.form-showarea').find('.content-value').length === 0){
            $(that).parents('.formtable-content').find('.form-inputarea').find('.form-value').val('');
        }else{
            var value = $(that).parents('.formtable-content').find('.form-inputarea').find('.form-value').val();
            var reg=new RegExp("<br>","g"); //创建正则RegExp对象
            value=value.replace(reg,"\n");
            $(that).parents('.formtable-content').find('.form-inputarea').find('.form-value').val(value);
        }
        $(that).parents('.formtable-content').find('.form-value').focus();
    }
    $('.btn-cancels')
    .click(function(){
        $(this).parent('.form-inputarea').css('display','none');
        $(this).parents('.formtable-content').find('.form-showarea').css('display', 'block');
    })
    $('.btn-submits')
    .click(function(){
        var i = $('.form-inputarea').index($(this).parents('.form-inputarea'));
        var value = $('.form-value').eq(i).val();
        switch(i){
            case 0: 
                if(value === ''){
                    alertInfor('昵称不能为空');
                    break;
                }
                if(value.length < 2 || value.length > 255){
                    alertInfor('昵称长度不合法');
                    break;
                }
                ajaxPost(0, value, 'nickname');
                break;
            case 1: 
                ajaxPost(1, $('input[name="UserinforForm[sex]"]:checked').val(), 'sex');
                break;
            case 2:
                var pattern = /(https|http):\/\/([^/:]+)(:\d*)?([\S ]*)/;
                if(value != ''){
                    if(pattern.test(value) === false){
                        alertInfor('url地址不合法');
                        break;
                    }
                }
                ajaxPost(2, value, 'web');
                break;
            case 3:
                value = value.replace(/\n|\r\n/g,"<br>");
                ajaxPost(3, value, 'summary');
                break;
        }
        return false;
    })
    function ajaxPost(iI,value, url){
        var formData = new FormData();
        var csrfToken = $('input[name="_csrf-frontend"]').val();
        formData.append('_csrf-frontend', csrfToken);
        formData.append('value', value);
        $.ajax({
            url: '<?php echo '/user/setting/' ?>'+url,
            type: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        }).always(function(result){
            var data = JSON.parse(result);
            if(data['status'] === 'success'){
                var reg=new RegExp("<br>","g"); //创建正则RegExp对象
                var newstr=data['words'].replace(reg,"\n");
                $('.form-value').eq(iI).val(newstr);
                if(data['words'] != ''){
                    if($('.btn-submits').parents('.formtable-content').find('.form-showarea').eq(iI).find('.content-value').length === 0){
                        $('.btn-submits').parents('.formtable-content').find('.form-showarea').eq(iI).html('');
                        $('.btn-submits').parents('.formtable-content').find('.form-showarea').eq(iI).html('<span class="content-value">'+data['words']+'</span><span class="modifi-area modifi-btn"><i class="icon-pencil"></i>&nbsp;修改</span>');
                        $('.modifi-btn').off('click');
                        $('.modifi-btn').on('click', function(){
                            $(this).parent('.form-showarea').css('display', 'none');
                            $(this).parents('.formtable-content').find('.form-inputarea').css('display','block');
                        })
                    }else{
                        $('.btn-submits').parents('.formtable-content').find('.form-showarea').eq(iI).find('.content-value').html(data['words']);
                    }
                }
                if(data['words'] === ''){
                    $('.btn-submits').parents('.formtable-content').find('.form-showarea').eq(iI).html('');
                    $('.btn-submits').parents('.formtable-content').find('.form-showarea').eq(iI).html('<span class="fill-area fill-btn"><i class="icon-pencil"></i>&nbsp;填写</span>');
                    $('.fill-btn').off('click');
                    $('.fill-btn').on('click', function(){
                        $(this).parent('.form-showarea').css('display', 'none');
                        $(this).parents('.formtable-content').find('.form-inputarea').css('display','block');
                    });
                }
                $('.btn-submits').parent('.form-inputarea').eq(iI).css('display','none');
                $('.btn-submits').parents('.formtable-content').find('.form-showarea').eq(iI).css('display', 'block');
            }
        });
    }
    $('.qrcode-area')
    .mouseenter(function(){
        $('.delete-area').css('visibility','visible');
    })
    $('.qrcode-area')
    .mouseleave(function(){
        $('.delete-area').css('visibility','hidden');
    })
</script>
