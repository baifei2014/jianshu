<?php 
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<?php 
    if(!yii::$app->user->isGuest){
        $userId = Yii::$app->user->identity->id;
    }else{
        $userId = null;
    }
    $form = ActiveForm::begin([
        'action' => [
            'site/comment',
            'a_id' => Yii::$app->request->getQueryParam('id'),
            'p_id' => $pid,
            'user_id' => $userId,
        ],
    ]);
?>
<div class="comment-form">
    <div class="comment-content">
        <?php echo $form->field($model, 'comment')->textarea(['class' => 'comment-detail', 'rows' => 3, 'placeholder' => '写下你的评论....'])->label(false); ?>
    </div>
    <div class="btn-groups pull-right">
        <?php echo Html::resetButton('取消', ['class' => 'btns btn-cancel']); ?>
        <?php 
            if(Yii::$app->user->isGuest){
                echo Html::submitButton('发表', ['class' => 'btns btn-post', 'disabled' => 'disabled']);
            }else{
                echo Html::submitButton('发表', ['class' => 'btns btn-post']);
            }
        ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
