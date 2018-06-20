<?php 
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;
?>
<div class="old-comment-list">
<div class="row">
    <div class="col-lg-1">
        <img src="statics/images/avatar.png" class="avatar-img-big avatar-img">
    </div>
    <div class="col-lg-11 comment-list-right">
        <p class="title17"><?php echo $value['content']; ?></p>
        <p class="title13">
        <?php 
            if($value['parent']){
                echo Html::a($value['nickname'], ['index/index'], ['class' => 'link-style1']).' 回复 '.Html::a($value['parent']['nickname'], ['index/index'], ['class' => 'link-style1']);
            }else{
                echo Html::a($value['nickname'], ['index/index'], ['class' => 'link-style1']);
            } 
        ?>&nbsp;&nbsp;<?php echo date('Y-m-d H:i',$value['created_at']) ;?>&nbsp;&nbsp;<a href="javascript:;" class="link-style1 reply-btn">回复</a></p>
        <div class="artical-reply-comment" style="display: none;">
            <div class="row new-comment-area">
                <?php Pjax::begin(); ?>
                <?php 
                    $form = ActiveForm::begin([
                            'action' => [
                                'index/detail',
                                'id' => Yii::$app->request->getQueryParam('id'),
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
                    <p class="title18weig">HI，请填写昵称和邮箱</p>
                    <li><?php echo $form->field($model,'nickname')->textInput(['placeholder' => '请输入昵称', 'value' => ''])->label(false); ?></li>
                    <li><?php echo $form->field($model,'email')->textInput(['placeholder' => '请输入邮箱', 'value' => ''])->label(false); ?></li>
                    <li><?php echo $form->field($model,'webaddress')->textInput(['placeholder' => '请输入网站', 'value' => ''])->label(false); ?></li>
                    <?php echo $form->field($model, 'pid')->hiddenInput(['value' => $value['id']])->label(false); ?>
                </div>
                <div class="col-lg-12">
                    <?php echo $form->field($model, 'content')->textarea(['class' => 'post-comment-words', 'placeholder' => '客官，确定不来一发吗？', 'value' => ''])->label(false); ?>
                </div>
                <div class="col-lg-12 error-area title15">
                    <?php // echo $error; ?>
                </div>
                <div class="col-lg-12">
                    <?php echo Html::submitButton('<i class="icon-plane color9"></i>&nbsp;&nbsp;'.'发射', ['class' => 'btn btn-primary post-comment-btn title15weig']);?>
                </div>
                <?php ActiveForm::end(); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
</div>
