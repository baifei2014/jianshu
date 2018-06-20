<?php 
use yii\helpers\Html;
?>
<div class="comment-message">
    <div class="commmess-toper">
        收到的评论
    </div>
    <div class="commmess-body">
        <?php 
            foreach ($comments as $key => $value) {
        ?>
        <div class="commmess-list">
            <div class="comm-toper"> 
                <div class="row">
                    <div class="col-sm-1">
                        <?php echo Html::a('<img src="'.$value['user']['avatar'].'" class="user-avatar-small">', Yii::$app->urlManager->createAbsoluteUrl(['user/home/u', 'id' => $value['user']['id']])) ?>
                    </div>
                    <div class="col-sm-11">
                        <dd class="comm-infor">
                            <?php echo Html::a($value['user']['nickname'], Yii::$app->urlManager->createAbsoluteUrl(['user/home/u', 'id' => $value['user']['id']])) ?>
                            <?php if($value['p_id'] == 0){ ?>
                                评论了你的文章<?php echo Html::a('《'.$value['artical']['title'].'》', Yii::$app->urlManager->createAbsoluteUrl(['site/p', 'id' => $value['artical']['id']])) ?>
                            <?php }else if($value['pcomment']['user_id'] != Yii::$app->user->identity->id  && $value['bereplyer'] == Yii::$app->user->identity->nickname){ ?>
                                在文章<?php echo Html::a('《'.$value['artical']['title'].'》', Yii::$app->urlManager->createAbsoluteUrl(['site/p', 'id' => $value['artical']['id']])) ?>的评论中提到了你
                            <?php }else{ ?>
                                在文章<?php echo Html::a('《'.$value['artical']['title'].'》', Yii::$app->urlManager->createAbsoluteUrl(['site/p', 'id' => $value['artical']['id']])) ?>中写了一条新评论
                            <?php } ?>
                        </dd>
                        <dd class="comm-time"><?php echo date('Y.m.d H:i', $value['created_at']) ?></dd>
                    </div>
                </div>
            </div>
            <div class="comm-middle">
                <?php if($value['bereplyer'] == Yii::$app->user->identity->nickname){ ?><a href="">@<?php echo $value['bereplyer'].' '; ?></a><?php } ?><?php echo $value['comment']; ?>
            </div>
            <div class="comm-footer">
                <span class="comm-reply reply-btn"><i class="icon-comments-alt icon-large"></i>&nbsp;回复</span><span class="comm-through"><i class="icon-share-alt"></i>&nbsp;查看会话</span>
                <div class="commreply-area">
                    <?php 
                        if($value['p_id'] == 0){
                            $pid = $value['id'];
                        }else if($value['pcomment']['p_id'] == 0){
                            $pid = $value['pcomment']['id'];
                        }
                        echo $this->render('reply', ['model' => $model , 'a_id' => $value['artical']['id'], 'pid' => $pid]); 
                    ?>
                </div>
            </div>
        </div>
        <?php 
            }
        ?>
    </div>
</div>
<script type="text/javascript">
    $('.reply-btn')
    .click(function(){
        var i = $('.reply-btn').index(this);
        if($('.commreply-area').eq(i).css("display") === 'none'){
            $('.commreply-area').eq(i).css("display", "block");
        }else{
            $('.commreply-area').eq(i).css("display", "none");
        }
    })

    $('.btn-cancel')
    .click(function(){
        $(this).parents('.commreply-area').css("display", "none");
    })

    $('.commmess-list:lt('+<?php echo $commentinfor ?>+')').css('backgroundColor', '#F8F8FF');
</script>
