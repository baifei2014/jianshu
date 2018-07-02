<?php 
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = '日记本 - 简书';
?>
<div class="user-index">
    <div class="row">
    <div class="col-sm-8">
        <div class="row userindex-lefttop">
            <div class="col-sm-2">
                <div class="articalset-img">
                    <i class="icon-book icon-3x"></i>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="pager-ecc">
                    <span class="fsize22"><?php echo $articalset['name']; ?></span>
                    <p><?php echo $setinfor['artical']; ?>篇文章 · <?php echo $setinfor['words']; ?>字 · <?php echo $setinfor['focus']; ?>人关注 </p>
                </div>
            </div>
            <?php ActiveForm::begin(); ?>
            <?php ActiveForm::end(); ?>
            <div class="col-sm-5"> 
                <div class="row">
                    <div class="col-sm-6">
                    </div>
                    <div class="col-sm-6 focus-area opfocus-area">
                        <div class="tabfocus-area">
                            <?php 
                                if(!Yii::$app->user->isGuest){
                                    if($isfocus){
                            ?>
                            <span class="focused-btn focus-btn"><i class="icon-ok"></i>&nbsp;已关注</span>
                            <?php 
                                    }else{
                            ?>
                            <span class="addfocus-btn focus-btn need-islogin"><i class="icon-plus"></i>&nbsp;关注</span>
                            <?php 
                                    }
                                }else{
                            ?>
                            <span class="addfocus-btn focus-btn need-islogin"><i class="icon-plus"></i>&nbsp;关注</span>
                            <?php 
                                }
                            ?>
                        </div>
                        <input type="hidden" value="<?php echo $articalset['id'] ?>" name="befocus_id">
                        <input type="hidden" value="set" name="befocus_type">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="pager-dcc">
                    <ul class="pager-menu pager-tabs" id="home-menu">
                        <li><?php echo Html::a("<span class='glyphicon glyphicon-list'></span>&nbsp;&nbsp;&nbsp;目录", ['default/added', 'id' => $articalset['id']], ['class' => 'actived']);?></li>
                        <li><?php echo Html::a("<span class='glyphicon glyphicon-comment'></span>&nbsp;&nbsp;&nbsp;按评论数", ['default/comment', 'id' => $articalset['id']]);?></li>
                        <li><?php echo Html::a("<span class='glyphicon glyphicon-heart'></span>&nbsp;&nbsp;&nbsp;按喜欢数", ['default/seq', 'id' => $articalset['id']]);?></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="usermain-content">
            <div class="pager-content">
                
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="people-intro">
            <div class="peopleintro-top">
                文集作者
            </div>
            <div class="peopleintro-middle">
                <img src="<?php echo '/'.$articalset['auther']['avatar']; ?>" class="nbauther-avatar"><span class="nbauther-name"><?php echo $articalset['auther']['nickname']; ?></span>
            </div>
        </div>
    </div>
    </div>
</div>
<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/js/partical.js"></script>
<script type="text/javascript" src="/js/focus.js"></script>
<script type="text/javascript" src="/js/comment.js"></script>
<script type="text/javascript" src="/js/pager.js"></script>
<script type="text/javascript" src="/js/reply.js"></script>
<script type="text/javascript" src="/js/tab.js"></script>
<script type="text/javascript">
    $.ajax({
        url: '<?php echo '/nb/default/added?id='.$articalset['id']; ?>',
        type: 'get',
    }).always(function(result){
        $('.pager-content').html(result);
    });
</script>
<script>
jQuery(document).ready(function(){
    jQuery('.pager-tabs').yiiTab({
        "isGuest": '<?php if(Yii::$app->user->isGuest){echo 1;}else{echo 0;} ?>',
    }, []);
    jQuery('.need-islogin').yiiFocus({
        "isGuest": '<?php if(Yii::$app->user->isGuest){echo 1;}else{echo 0;} ?>',
        'focusbtn': 'focus-btn',
    }, []);
});
</script>
