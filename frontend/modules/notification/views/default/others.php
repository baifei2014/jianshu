<?php 
use yii\helpers\Html;
?>
<div class="comment-message">
    <div class="commmess-toper">
        其他消息
    </div>
    <div class="commmess-body">
        <?php 
            foreach ($otherinfors as $key => $value) {
        ?>
        <div class="commmess-list">
            <div class="comm-toper"> 
                <div class="row">
                    <div class="col-sm-12">
                        <dd class="comm-infor">
                        <?php 
                            if($value['tag'] === 'focus'){
                        ?>
                            <span class="rss-area"><i class="icon-rss"></i></span><?php echo Html::a($value['user']['nickname'], Yii::$app->urlManager->createAbsoluteUrl(['user/home/u', 'id' => $value['user']['id']])) ?>&nbsp;
                            <?php 
                                if($value['type'] === 'set'){
                            ?>
                            订阅了你的文集<?php echo Html::a('《'.$value['set']['name'].'》', Yii::$app->urlManager->createAbsoluteUrl(['nb/default/index', 'id' => $value['set']['id']])); ?>
                            <?php
                                }else if($value['type'] === 'subject'){
                            ?>
                            订阅了你的专题<?php echo Html::a('《'.$value['subject']['name'].'》', Yii::$app->urlManager->createAbsoluteUrl(['subject/default/c', 'id' => $value['subject']['code']])); ?>
                        <?php
                                }
                            }else if($value['tag'] === 'include'){
                        ?>
                            <span class="thophy-area">
                            <?php if($value['status'] == 4){ ?>
                                <i class="icon-remove-circle"></i>
                            <?php }else{ ?>
                                <i class="icon-trophy"></i>
                            <?php } ?>
                                </span><?php if($value['status'] == 2 || $value['status'] == 4){ ?>你投稿的文章<?php }else{ ?>你的文章<?php } ?>
                                <?php echo Html::a('《'.$value['artical']['title'].'》', Yii::$app->urlManager->createAbsoluteUrl(['site/p', 'id' => $value['artical']['id']])) ?>
                            <?php if($value['status'] == 2 || $value['status'] == 1){ ?>
                                已被加入专题
                            <?php }else if($value['status'] == 4){ ?>
                                未能入选专题
                            <?php } ?>
                            <?php echo Html::a('《'.$value['subject']['name'].'》', Yii::$app->urlManager->createAbsoluteUrl(['nb/default/index', 'id' => $value['subject']['id']])); ?><?php if($value['status'] == 4){echo '继续加油~';} ?>
                        <?php
                            }
                        ?>
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
    $('.commmess-list:lt('+<?php echo $othersinfor ?>+')').css('backgroundColor', '#F8F8FF');
</script>
