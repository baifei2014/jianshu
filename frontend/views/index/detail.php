<?php 
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap\Alert;
?>
<div class="row">
    <div class="col-lg-9">
        <div class="detail-artical">
            <div class="detail-artical-toper">
                <p class="title24weig"><?php echo $artical->title; ?></p>
                <p class="title14weig">
                    <span><i class="icon-tags"></i>&nbsp;<?php echo Yii::$app->formatter->asRelativeTime($artical['created_at']).'（'.Yii::$app->formatter->asDate($artical['created_at'],'php:m-d').'）'; ?></span>&nbsp;&nbsp;/&nbsp;&nbsp;
                    <span class="colorred"><i class="icon-user"></i>&nbsp;<?php echo $artical['auther']; ?></span>&nbsp;&nbsp;/&nbsp;&nbsp;
                    <span class="colorred"><i class="icon-folder-open-alt"></i>&nbsp;mac技能</span>&nbsp;&nbsp;/&nbsp;&nbsp;
                    <span class="colorred"><i class="icon-comments-alt"></i>&nbsp;<?php echo count($comment); ?>条评论</span>&nbsp;&nbsp;/&nbsp;&nbsp;
                    <span><i class="icon-eye-open"></i>&nbsp;361℃</span>
                </p>
            </div>
            <div class="detail-artical-maincontent">
                <div class="detail-detail-fill">
                    <?php echo $artical['content']; ?>
                </div>
                <div class="detail-detail-widget">
                    <a href="" class="detail-artical-tag">本文Tags：</a>&nbsp;&nbsp;&nbsp;<a href="" class="detail-artical-tag">喜欢分享</a>
                    <div class="artical-praise">
                        <a href="javascript:;" class="artical-praise-btn title17">赞</a>
                    </div>
                    <div class="artical-given">
                        <div class="artical-given-toper">
                            <span class="title15weig">如无特殊说明，文章均为本站原创，转载请注明出处</span>
                        </div>
                        <div class="artical-given-content">
                            <li><i class="icon-warning-sign color8"></i>&nbsp;&nbsp;转载请注明来源：<?php echo $artical->title; ?></li>
                            <li><i class="icon-warning-sign color8"></i>&nbsp;&nbsp;本文永久链接地址：http://www.likecho.com/archives/263/mac-phpstorm-%e9%85%8d%e7%bd%aeless%e5%bc%80%e5%8f%91/</li>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="other-artical-area">
            <div class="row">
                <div class="col-lg-6">
                <?php 
                    if($nextartical['preartical']['title']){
                ?>
                    <?php echo Html::a('<i class="icon-double-angle-left"></i>'.'&nbsp;&nbsp;&nbsp;'.$nextartical['preartical']['title'], ['index/detail', 'id' => $nextartical['preartical']['id']], ['class' => 'previous-artical upon-artical']);?>
                <?php
                    }else{
                ?>
                    <span class="previous-artical upon-artical">已经没有内容了</span>
                <?php 
                    }
                ?>
                </div>
                <div class="col-lg-6">
                <?php 
                    if($nextartical['nextartical']['title']){
                ?>
                    <?php echo Html::a($nextartical['nextartical']['title'].'&nbsp;&nbsp;&nbsp;'.'<i class="icon-double-angle-right"></i>', ['index/detail', 'id' => $nextartical['nextartical']['id']], ['class' => 'next-artical upon-artical']);?>
                <?php
                    }else{
                ?>
                    <span class="next-artical upon-artical">已经没有内容了</span>
                <?php 
                    }
                ?>
                </div>
            </div>
        </div>
        <div class="artical-comments-area">
            <div class="artical-new-comment" id="a0">
                <?php echo $this->render('comment', ['pid' => 0, 'place' => 'a0', 'model' => $model]); ?>
            </div>
            <div class="old-comment-area">
                <div class="old-comment-toper">
                    <span class="title16weig color10"><i class="icon-comments-alt icon-large"></i>&nbsp;&nbsp;<span class="colorred">（<?php echo count($comment); ?>）</span>条精彩评论：</span>
                </div>
                <?php 
                    if(count($comment) == 0){
                ?>
                <div class="empty-comment-list">
                    <div class="row">
                        <span><img src="statics/images/timg.jpg" class="avatar-img-empty avatar-img">这篇文章很寂寞，它还没有一个人评论</span>
                    </div>
                </div>
                <?php
                    }else{
                        foreach ($comment as $key => $value) {
                            $pl = $key+1;
                            $pla = 'a'.$pl;
                ?>
                <div class="old-comment-list" id="a<?php echo $pl; ?>">
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
                            <?php echo $this->render('comment', ['pid' => $value['id'], 'place' => $pla, 'model' => $model]); ?>
                        </div>
                    </div>
                </div>
                </div>
                <?php
                        }
                    }
                ?>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <?php echo \frontend\widgets\leftpanel\LeftpanelWidget::widget();?>
    </div>
</div>
<script type="text/javascript">
    $('.avatar-img').mouseenter(function(){
        $(this).css("transition","1s");
        $(this).css("transform","rotate(360deg)");
    })
    $('.avatar-img').mouseleave(function(){
        $(this).css("transition","1s");
        $(this).css("transform","rotate(0deg)");
    })
    $('.reply-btn')
    .click(function(){
        if($(this).text() === '回复'){
            var i = $('.reply-btn').index(this);
            $('.reply-btn').text('回复');
            $('.comment-list-right .artical-reply-comment').css('display','none');
            $(this).text('取消回复');
            $('.comment-list-right .artical-reply-comment').eq(i).css('display','block');
        }else{
            var i = $('.reply-btn').index(this);
            $(this).text('回复');
            $('.comment-list-right .artical-reply-comment').eq(i).css('display','none');
        }
    })
</script>
<script type="text/javascript">
    $('.post-comment-btn')
    .click(function(){
        var i = $('.post-comment-btn').index(this);
        var nickname = $('.nickname-form').eq(i).val();
        var email = $('.email-form').eq(i).val();
        var webaddress = $('.webaddress-form').eq(i).val();
        var content = $('.content-form').eq(i).val();
        var emailpattern = /^[A-Za-z\d]+([-_.][A-Za-z\d]+)*@([A-Za-z\d]+[-.])+(com|cn|net)$/;
        var urlpattern = /http(s)?:\/\/([\w-]+\.)+[\w-]+(\/[\w- .\/?%&=]*)?/;
        if(nickname === ''){
            $('.error-area').eq(i).text('昵称不能为空');
            return false;
        }
        if(nickname.length < 2 || nickname.length > 16){
            $('.error-area').eq(i).text('昵称长度不合法');
            return false;
        }
        if(email === ''){
            $('.error-area').eq(i).text('邮箱不能为空');
            return false;
        }
        if(!emailpattern.test(email)){
            $('.error-area').eq(i).text('不是一个有效的邮箱');
            return false;
        }
        if(webaddress != ''){
            if(!urlpattern.test(webaddress)){
                $('.error-area').eq(i).text('不是一个有效的url');
                return false;
            }
        }
        if(content === ''){
            $('.error-area').eq(i).text('评论内容不能为空');
            return false;
        }
        var status = true;
        $.ajax({
            url: '<?php echo 'index.php?r=index/comment' ?>'+'&email='+email+'&nickname='+nickname,
            type: 'get',
            success: function (data) {
                if(data != ''){
                    $('.error-area').eq(i).text(data);
                    return status = false;
                }else{
                    status = true;
                }
            },
            async: false,
        })
        if(status === false){
            return false;
        }
    })
</script>
