<?php 
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;
?>
<div class="row new-comment-area">
    <?php 
        $form = ActiveForm::begin([
                'action' => [
                    'index/comment',
                    'id' => Yii::$app->request->getQueryParam('id'),
                    'place' => $place,
                ],
                'options' => ['data-pjax' => true ],
                'fieldConfig' => [
                    'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                ],
            ]);
    ?>
    <div class="col-lg-1">
        <img src="statics/images/avatar.png" class="avatar-img-small avatar-img">
    </div>
    <div class="col-lg-11 post-comment-right">
        <span class="title16 colorred">发表我的评论</span>
        <p class="title18weig">HI，请填写以下内容<small>(昵称和邮箱必填，网站选填)</small></p>
        <li><?php echo $form->field($model,'nickname')->textInput(['placeholder' => '请输入昵称', 'value' => '', 'class' => 'nickname-form'])->label(false); ?></li>
        <li><?php echo $form->field($model,'email')->textInput(['placeholder' => '请输入邮箱', 'value' => '', 'class' => 'email-form'])->label(false); ?></li>
        <li><?php echo $form->field($model,'webaddress')->textInput(['placeholder' => '请输入网站', 'value' => '', 'class' => 'webaddress-form'])->label(false); ?></li>
        <?php echo $form->field($model, 'pid')->hiddenInput(['value' => $pid])->label(false); ?>
    </div>
    <div class="col-lg-12">
        <?php echo $form->field($model, 'content')->textarea(['class' => 'post-comment-words content-form', 'placeholder' => '客官，确定不来一发吗？', 'value' => ''])->label(false); ?>
    </div>
    <div class="col-lg-12 error-area title15">
    </div>
    <div class="col-lg-12">
        <?php echo Html::submitButton('<i class="icon-plane color9"></i>&nbsp;&nbsp;'.'发射', ['class' => 'btn btn-primary post-comment-btn title15weig']);?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
