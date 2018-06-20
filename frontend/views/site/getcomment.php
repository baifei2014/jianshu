<?php
use frontend\helpers\LinkPagerC;
?>
<?php 
    foreach ($rcomments as $key => $value) {
?>
    <div class="comment-commentd-list">
        <div class="comment-avatar">
            <img src="<?php echo $value['user']['avatar'] ?>">
        </div>
        <div class="comment-maincontent">
            <div class="comment-main-levo">
                <p class="pull-left comment-person" data-pid="<?php echo $value['id'] ?>"><?php echo $value['user']['nickname'] ?></p>
                <p class="pull-right">2225</p>
            </div>
            <div class="comment-main-levt">
                <?php echo $value['comment'] ?>
            </div>
            <div class="comment-main-levf">
                <span class="create-time"><?php echo Yii::$app->formatter->asRelativeTime($value['created_at']) ?></span><span class="reply-p-btn">回复</span>
            </div>
            
            <div class="comment-replyed">
            <?php 
                if($value['child']){
                    foreach ($value['child'] as $k => $v) {
            ?>
                <div class="comment-replyed-list">
                    <div class="comment-replyed-maincontent">
                        <div class="comment-main-levg reply-comm" data-comm="<?php echo $v['user']['nickname'] ?>">
                            <a href=""><?php echo $v['user']['nickname'] ?></a><?php if($v['replyer']){ ?> 回复 <a href=""><?php echo $v['replyer']['nickname'] ?></a><?php } ?> : <?php echo $v['comment'] ?>
                        </div>
                        <div class="comment-main-levi">
                            <span class="create-time"><?php echo Yii::$app->formatter->asRelativeTime($v['created_at']) ?></span></span><span class="reply-c-btn">回复</span>
                        </div>
                    </div>
                </div>
            <?php
                    }
            ?>
            <p class="add-comment"><span class="add-new-comment"><i class="icon-pencil"></i>&nbsp;&nbsp;添加新的评论</span></p>
            <?php
                }
            ?>
                <div class="reply-area">
                </div>
            </div>
            
        </div>
    </div>
<?php 
    }
?>
<?php 
echo LinkPagerC::widget([
    'pagination' => $pagination,
]);
?>
<script type="text/javascript">
    jQuery('#comment-commentd .pagination li').yiiPager({
        "aid": '<?php echo $aid; ?>',
    }, []);
    jQuery('#comment-commentd').yiiReply({
        "preply": "reply-p-btn",
        "creply": "reply-c-btn",
        "addnewreply": "add-new-comment",
        'isLogin': '<?php echo Yii::$app->user->isGuest; ?>',
    }, []);
</script>
