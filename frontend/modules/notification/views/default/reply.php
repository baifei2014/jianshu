<?php 
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<?php 
    $form = ActiveForm::begin([
        'action' => [
            'default/reply',
            'a_id' => $a_id,
            'p_id' => $pid,
            'user_id' => Yii::$app->user->identity->id,
        ],
    ]);
?>
<div class="comment-form">
    <div class="comment-content">
        <?php echo $form->field($model, 'comment')->textarea(['class' => 'comment-detail', 'rows' => 3, 'placeholder' => '写下你的评论....'])->label(false); ?>
    </div>
    <div class="btn-groups pull-right">
        <?php echo Html::resetButton('取消', ['class' => 'btns btn-cancel']); ?>
        <?php echo Html::submitButton('发表', ['class' => 'btns btn-post']); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
