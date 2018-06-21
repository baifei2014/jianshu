<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<?php 
$a_id = Yii::$app->request->getQueryParam('id');
if(!Yii::$app->user->isGuest){
    $user_id = Yii::$app->user->identity->id;
}else{
    $user_id = null;
}
?>
<form class="new-comment" action="/site/comment&a_id=<?php echo $a_id; ?>&user_id=<?php echo $user_id; ?>" method="post">
    <div class="comment-textform">
        <div class="comment-textarea">
            <input type="hidden" name="_csrf-frontend" value="<?= Yii::$app->request->csrfToken ?>" />
            <input type="hidden" class="form-control" value="0" name="CommentForm[p_id]">
            <input type="hidden" class="form-control" value="" name="CommentForm[bereplyer]">
            
            <textarea class="textarea" name="CommentForm[comment]" placeholder="写下你的评论..." style="height: 52px; overflow-y: hidden;"></textarea>
        </div>
        <div class="comment-btngroups">
            <?php echo Html::resetButton('取消', ['class' => 'cbtn creset-btn']); ?>
            <?php echo Html::Button('评论', ['class' => 'cbtn csubmit-btn', 'disabled' => 'disabled']); ?>
        </div>
    </div>
</form>
