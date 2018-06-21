<?php 
use yii\helpers\Html;
?>
<div class="comment-message">
    <div class="commmess-toper">
        全部关注
    </div>
    <div class="commmess-body">
        <?php 
            foreach ($follows as $key => $value) {
        ?>
        <div class="commmess-list">
            <div class="comm-toper"> 
                <div class="row">
                    <div class="col-sm-1">
                        <?php echo Html::a('<img src="'.'/'.$value['userfans']['avatar'].'" class="user-avatar-small">', Yii::$app->urlManager->createAbsoluteUrl(['user/home/u', 'id' => $value['userfans']['id']])) ?>
                    </div>
                    <div class="col-sm-11">
                        <dd class="comm-infor">
                            <?php echo Html::a($value['userfans']['nickname'], Yii::$app->urlManager->createAbsoluteUrl(['user/home/u', 'id' => $value['userfans']['id']])) ?>&nbsp;&nbsp;关注了你
                        </dd>
                        <dd class="comm-time"><?php echo date('Y.m.d H:i', $value['created_at']) ?></dd>
                    </div>
                </div>
            </div>
        </div>
        <?php 
            }
        ?>
    </div>
</div>
<script type="text/javascript">
    $('.commmess-list:lt('+<?php echo $followsinfor ?>+')').css('backgroundColor', '#F8F8FF');
</script>
