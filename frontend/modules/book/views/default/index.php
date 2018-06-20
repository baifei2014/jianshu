<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\models\Userinfor;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <?php $this->title = '写文章 - 爱阅'; ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <title>写文章 - 爱阅</title>
</head>
<body>
<?php $this->beginBody() ?>
<?=Html::cssFile('@web/statics/css/book.css')?>
<div class="cont-bcc">
    <div class="create-collect">
        <div class="back-area">
            <?php echo Html::a('返回首页','index.php?r=site/index', ['class' => 'back-home']); ?>
        </div>
        <div class="create-newset">
            <a href="javascript:;" id="add-set" class="createset-btn"><i class="icon-plus"></i>&nbsp;新建文集</a>
            <div class="add-collect">
                <input type="text" placeholder="请输入文集名...." class="form-set">
                <?php echo Html::submitButton('提交', ['class' => 'btn btn-submit']); ?>
                <?php echo Html::resetButton('取消', ['class' => 'btn btn-reset']); ?>
            </div>
        </div>
        <?php if(count($articalset) != 0){ ?>
        <div class="set-list">
            <ul>
            <?php foreach ($articalset as $key => $value) {
            ?>
                <?php if($key == 0){ ?>
                    <li><a href="javascript:;" class="list-acc actived"><?php echo $value['name']; ?><input type="hidden" value="<?php echo $value['id']; ?>"></a></li>
                <?php }else{ ?>
                    <li><a href="javascript:;" class="list-acc"><?php echo $value['name']; ?><input type="hidden" value="<?php echo $value['id']; ?>"></a></li>
                <?php } ?>
            <?php } ?>
            </ul>
        </div>
        <?php } ?>
    </div>
    <div class="write-content">
        <div class="write-main">
            <?php $form = ActiveForm::begin(); ?>
            <?php echo $form->field($model, 'set')->hiddenInput(['value' => $articalset[0]['uid'], 'class' => 'artical-set'])->label(false); ?>
            <div class="write-title">
                <div style="margin-bottom: -30px;"><label>标题</label></div><input type="text" class="posttitle-counts" value="0/64" id="title-counts">
                <?= $form->field($model,'title')->label(false)->textInput(['class' => 'post-title','id' => 'post-title','maxLength' => 64,'placeholder' => '请输入标题，标题不多于64字']);?>
            </div>
            <div class="write-img">
                <div style="margin-bottom: -35px;"><label>图片</label></div>
                <div class="upload-img-area">
                    <span class="upload-img-label">上传</span><span class="upload-img-hint">推荐像素 : 900像素 X 500像素</span><span class="upload-img-infor"></span>
                    <?= $form->field($model, 'img')->fileInput(['class' => 'upload-img', 'id' => 'js-upload-img'])->label(false); ?>
                </div>
            </div>
            <div class="write-contents">
                <div><label>正文</label><input type="text" class="compose-content-error" id="compose-content-error"></div>
                <?= $form->field($model,'content', ['template' => '{label} <div class="row"><div class="col-sm-12">{input}{error}{hint}</div></div>'])->widget('pjkui\kindeditor\KindEditor',['clientOptions' => [
                        'height' => '400',
                        //定制菜单
                        'items' => [
                        'undo', 'redo', '|','formatblock', 'fontname', 'fontsize', '|', 'justifyleft', 'justifycenter','justifyright',
                        'justifyfull', '|', 'quickformat', 
                         '|', 'forecolor','bold',
                        'italic', 'underline', 'strikethrough', 'removeformat', '|', 'image',
                         'emoticons', 'baidumap', 'selectall', '|', 'preview','fullscreen',
                        ],]])->label(false)->hiddenInput(['class' => 'compose-main-content']);
                ?>
            </div>
            <div class="write-tags">
                <label>标签<small>（标签最多五个字，输完按回车Enter键即可）</small></label>
                <div class="edit-tags">
                    <span class="edited-group"></span><span style="outline: none;" class="input-tags" contenteditable="true"></span>
                </div>
                <?php echo $form->field($model, 'tag')->hiddenInput(['class' => 'tag-form'])->label(false); ?>
            </div>
            <div class="write-bottom">
                <div class="btn-group">
                    <?php echo Html::submitButton('提交', ['class' => 'btn btn-submits', 'id' => 'js-confirm-btn']); ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="preview-content">
        <div class="right-content-preview">
            <div class="preview-artical-title">
                标题
            </div>
            <div class="preview-cover-img">
                <span class="coverimg-infor">封面图片</span>
            </div>
        </div>
    </div>
</div>
<div class="alert-infor">
</div>
<?php $this->endBody() ?>
</body>
<script type="text/javascript" src="statics/js/jquery.js"></script>
<script type="text/javascript">
    $('#add-set')
    .click(function(){
        if($('.add-collect').css('display') === 'none'){
            $('.add-collect').css('display', 'block');
        }else{
            $('.add-collect').css('display', 'none');
        }
    })
    $('.btn-reset')
    .click(function(){
        $('.add-collect').css('display', 'none');
    })
    $('.btn-submit')
    .click(function(){
        var articalset = $('.form-set').val();
        if(articalset === ''){
            alertInfor('提交的文集名不能为空');
            return false
        }
        if(articalset.length < 2){
            alertInfor('提交的文集名至少两个字');
            return false;
        }
        if(articalset.length > 30){
            alertInfor('提交的文集名最多30个字');
            return false;
        }
        var formData = new FormData();
        var csrfToken = $('input[name="_csrf-frontend"]').val();
        formData.append('_csrf-frontend', csrfToken);
        formData.append('articalset', articalset);
        $.ajax({
            url: '<?php echo 'index.php?r=book/default/articalset' ?>',
            type: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        }).always(function(result){
            var data = JSON.parse(result);
            if(data['status'] === 'success'){
                $('.set-list ul').prepend('<li><a href="javascript:;" class="list-acc">'+articalset+'<input type="hidden" value="'+data['id']+'"></a></li>');
                var title = '';
                history.pushState({ title: title }, title, location.href.split("#")[0] + "#" + data['id']);
                $('.artical-set').val(data['id']);
                $('.list-acc').removeClass('actived');
                $('.list-acc').eq(0).addClass('actived');
                setClick();
                alertInfor(data['message']);
            }else{
                alertInfor(data['message']);
            }
            // alert(result);
        });
        $('.add-collect').css('display', 'none');
        return false;
    })
    function alertInfor(text) {
        $('.alert-infor').css('display', 'block');
        $('.alert-infor').html(text);
        setTimeout("$('.alert-infor').css('display','none')", 2000);
    }
    window.addEventListener("hashchange", function(){
        trigerhash();
    }, false);
    trigerhash();
    function trigerhash()
    {
        var status = false;
        var urls = location.href.split("#")[1];
        if(urls == undefined){
            $('.list-acc').removeClass('actived');
            $('.list-acc').eq(0).addClass('actived');
            $('.artical-set').val($('.set-list input').eq(0).val());
            return;
        }
        $('.set-list li input').each(function(e){
            if($(this).val() === urls){
                $('.list-acc').removeClass('actived');
                var i = $('.set-list li input').index(this);
                $('.list-acc').eq(i).addClass('actived');
                $('.artical-set').val($('.set-list input').eq(i).val());
                status = true;
                return true;
            }
        })
        if(status == false){
            $('.list-acc').removeClass('actived');
            $('.list-acc').eq(0).addClass('actived');
            history.pushState({ title: title }, title, location.href.split("#")[0] + "#" + $('.set-list input').eq(0).val());
            $('.artical-set').val($('.set-list input').eq(0).val());
        }
    }
    setClick();
    function setClick(){
        $(document).on('click', '.list-acc', function(){
            var i = $('.list-acc').index(this);
            $('.list-acc').removeClass('actived');
            $('.list-acc').eq(i).addClass('actived');
            var title = '';
            var ids = $('.set-list input').eq(i).val();
            history.pushState({ title: title }, title, location.href.split("#")[0] + "#" + ids);
            $('.artical-set').val(ids);
        })
    }
</script>
<script type="text/javascript">
    var confirmbtn = document.getElementById('js-confirm-btn');
    confirmbtn.onclick = function(){
        var auther = $('.post-author').val();
        var imginfor = uploadimg.files[0] || '';

        if(imginfor === ''){
            $('.upload-img-infor').css('color','#a94442');
            $('.upload-img-infor').html('上传文件不能为空');
            return false;
        }
        if(imginfor.size > 3*1024*1024){
            $('.upload-img-infor').css('color','#a94442');
            $('.upload-img-infor').html('上传文件太大');
            return false;
        }
        var pattern = /\.(jpg|gif|png)$/;
        if(!(pattern.test(imginfor.name))){
            $('.upload-img-infor').css('color','#a94442');
            $('.upload-img-infor').html('上传文件类型不合法');
            return false;
        }
    }
    var posttitle = document.getElementById('post-title');
    var titlecounts = document.getElementById('title-counts');
    var contenterror = document.getElementById('compose-content-error');
    var uploadimg = document.getElementById('js-upload-img');
    var titlecount = $('.post-title').val().length;
    $('.posttitle-counts').val(titlecount+'/64');
    posttitle.addEventListener('input',function(e){
        var titlecounts = $('.post-title').val().length;
        $('.posttitle-counts').val(titlecounts+'/64');
        if(titlecounts > 0){
            $('.compose-title-error').val('');
            $('.preview-artical-title').text($('.post-title').val());
        }else{
            $('.preview-artical-title').text('标题');
        }
    })
    titlecounts.addEventListener('mousedown',function(e){
        e.preventDefault();
    })
    contenterror.addEventListener('mousedown',function(e){
        e.preventDefault();
    })
    uploadimg.addEventListener('change',function(e){
        var value = $(this).val();
        var imgname = $(this)[0].files[0].name;
        var imgsize = $(this)[0].files[0].size;
        var imgurl = getObjectURL($(this)[0].files[0]);
        $(".preview-cover-img").empty();
        var pattern = /\.(jpg|gif|png)$/;
        if(!(pattern.test(imgname))){
            $('.upload-img-infor').css('color','#a94442');
            $('.upload-img-infor').html('上传文件类型不合法');
            $('<span class="coverimg-infor">封面图片</span>').appendTo(".preview-cover-img");
            return false;
        }
        if(imgsize > 3*1024*1024){
            $('.upload-img-infor').css('color','#a94442');
            $('.upload-img-infor').html('上传文件太大');
            $('<span class="coverimg-infor">封面图片</span>').appendTo(".preview-cover-img");
            return false;
        }
        $('<img src=\"'+imgurl+'\">').appendTo(".preview-cover-img");
        $('.upload-img-infor').css('color','#000');
        $('.upload-img-infor').html(value);
    })
    function getObjectURL(file) {
        var url = null ;
        if (window.createObjectURL!=undefined) { // basic
            url = window.createObjectURL(file) ;
        } else if (window.URL!=undefined) { // mozilla(firefox)
            url = window.URL.createObjectURL(file) ;
        } else if (window.webkitURL!=undefined) { // webkit or chrome
            url = window.webkitURL.createObjectURL(file) ;
        }
        return url ;
    }
    $('.edit-tags')
    .click(function(){
        $('.input-tags').focus();
    })
    var tag = [];
    document.onkeydown = function (e) {  
        if (!e) e = window.event;  
        if ((e.keyCode || e.which) == 13) {  
            if($('.edited-tag').length > 4){
                alertInfor('最多输入五个标签');
                $('.input-tags').text('');
                return false;
            }
            var value = $('.input-tags').text();
            var status = true;
            $('.edited-tag span').each(function(){
                if($(this).text() == value){
                    alertInfor('标签不能重复');
                    status = false;
                    return false;
                }
            })
            if(status === false){
                return false;
            }
            if(value === ''){
                alertInfor('标签不能为空');
                return false;
            }
            if(value.length > 5){
                alertInfor('标签长度不合法');
                return false;
            }
            $('.edited-group').append('<span class="edited-tag"><i class="icon-remove"></i>&nbsp;<span>'+value+'</span></span>');
            tag.push(value);
            $('.tag-form').val(tag);
            $('.icon-remove').off('click');
            $('.icon-remove').on('click', function(){
                var i = $('.icon-remove').index(this);
                tag.splice(i,1);
                $('.tag-form').val(tag);
                $('.edited-tag').eq(i).remove();
            })
            $('.input-tags').text('');
            return false;
        }  
    }
</script>
</html>
<?php $this->endPage() ?>
