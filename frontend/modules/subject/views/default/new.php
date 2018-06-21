<?php 
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = '简书';
?>
<div class="site-p">
    <div class="create-subject">
        <h3 style="margin-left: 10px;">新建专题</h3>
        <?php 
            $form = ActiveForm::begin([
                'layout' => 'inline',
            ]);
        ?>
        <table class="subject-table">
            <tr>
                <td><img src="statics/images/placeholder.png" class="subject-img"></td>
                <td><span class="radius-btn">上传专题封面</span><?php echo $form->field($model, 'file')->fileInput(['class' => 'form-file', 'id' => 'btn-upload'])->label(false); ?></td>
            </tr>
            <tr>
                <td>名称</td>
                <td><?php echo $form->field($model, 'name')->textInput(['placeholder' => '不超过50个字', 'class' => 'subject-value name-input'])->label(false); ?></td>
            </tr>
            <tr>
                <td style="vertical-align: top;">描述</td>
                <td><?php echo $form->field($model, 'describe')->textarea(['placeholder' => '填写描述' , 'class' => 'subject-value describe-input' ,'cols' => 55, 'rows' => 3])->label(false); ?></td>
            </tr>
            <tr>
                <td>是否允许投稿</td>
                <td><?php echo $form->field($model, 'submit')->radioList(['1' => '允许', '2' => '不允许'], ['value' => 1, 'class' => 'subject-value'])->label(false); ?></td>
            </tr>
            <tr>
                <td>投稿是否需要审核</td>
                <td><?php echo $form->field($model, 'audit')->radioList(['1' => '需要', '2' => '不需要'], ['value' => 1, 'class' => 'subject-value'])->label(false); ?></td>
            </tr>
            <tr>
                <td><?php echo Html::submitButton('创建专题', ['class' => 'btn btn-create']); ?></td>
                <td></td>
            </tr>
        </table>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<div class="alert-infor">
</div>
<script type="text/javascript" src="statics/js/jquery.js"></script>
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
            var image = new Image();
            image.src = e.target.result;
            image.onload = function(){
                if(image.width < 100){
                    alertInfor('图片太小,请上传宽高至少100像素的图片');
                    $('.form-file').val('');
                    return false;
                }
                if(image.height < 100){
                    alertInfor('图片太小,请上传宽高至少100像素的图片');
                    $('.form-file').val('');
                    return false;
                }
            }
            $('.subject-img').prop('src', image.src);
        }
        reader.readAsDataURL(file);
    })
    function alertInfor(text) {
        $('.alert-infor').css('display', 'block');
        $('.alert-infor').html(text);
        setTimeout("$('.alert-infor').css('display','none')", 2000);
    }
    $('.btn-create')
    .click(function(){
        var file = document.getElementById('btn-upload').files[0];
        if(typeof file === 'undefined' || file === ''){
            alertInfor('请上传封面图片');
            return false;
        }
        var name = $('.name-input').val();
        if(name === ''){
            alertInfor('名称不能为空');
            return false;
        }
        if(name.length > 50){
            alertInfor('名称不能超过50个字');
            return false;
        }
    })
</script>
