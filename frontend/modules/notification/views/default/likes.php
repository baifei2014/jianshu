<?php 
use yii\helpers\Html;
?>
<div class="comment-message">
    <div class="commmess-toper">
        收到的喜欢
    </div>
    <div class="commmess-body">
        <?php 
            foreach ($likes as $key => $value) {
        ?>
        <div class="commmess-list">
            <div class="comm-toper"> 
                <div class="row">
                    <div class="col-sm-1">
                        <?php echo Html::a('<img src="'.'/'.$value['user']['avatar'].'" class="user-avatar-small">', Yii::$app->urlManager->createAbsoluteUrl(['user/home/u', 'id' => $value['user']['id']])) ?>
                    </div>
                    <div class="col-sm-11">
                        <dd class="comm-infor">
                            <?php echo Html::a($value['user']['nickname'], Yii::$app->urlManager->createAbsoluteUrl(['user/home/u', 'id' => $value['user']['id']])) ?>&nbsp;&nbsp;喜欢了你的文章<?php echo Html::a('《'.$value['artical']['title'].'》', Yii::$app->urlManager->createAbsoluteUrl(['site/p', 'id' => $value['artical']['id']])); ?>
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
    $('.commmess-list:lt('+<?php echo $likeinfor ?>+')').css('backgroundColor', '#F8F8FF');
</script>
