<?php 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = $artical['title'];
?>
<div class="site-p">
    <div class="p-artical">
        <div class="p-top">
            <p class="title"><?php echo $artical['title']; ?></p>
            <div class="artical-infor">
                <div class="row">
                    <div class="col-lg-1 puser-avatar">
                        <img src="<?php echo $artical['user']['avatar']; ?>">
                    </div>
                    <div class="col-lg-11 partical-infor">
                        <span>作者</span><a href=""><?php echo $artical['user']['nickname']; ?></a>
                        <p><?php echo Yii::$app->formatter->asDate($artical['created_at'],'php:Y.m.d H:i'); ?>&nbsp;&nbsp;阅读&nbsp;<?php echo $articalinfor['brower']; ?>&nbsp;&nbsp;评论&nbsp;<?php echo $articalinfor['comment']; ?>&nbsp;&nbsp;喜欢&nbsp;<?php echo $articalinfor['like']; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-middle">
            <?php echo $artical['content']; ?>
        </div>
        <div class="p-bottom">
            <div class="pbottom-left">
                <i class="icon-book"></i>&nbsp;&nbsp;&nbsp;<?php echo Html::a($artical['articalset']['name'], ['nb/default/index', 'id' => $artical['set_id']], ['class' => 'artical-set']);?>
            </div>
            <div class="pbottom-right">
                &copy;&nbsp;著作权归作者所有
            </div>
        </div>
        <div class="auther-infor">
            <div class="row">
                <div class="col-sm-8">
                    <div class="focususer-infor">
                        <div class="focususerinfor-left">
                            <?php echo Html::a('<img src="'.$artical['user']['avatar'].'" class="focussubject-img-middle">', Yii::$app->urlManager->createAbsoluteUrl(['user/home/u', 'id' => $artical['user']['id']])); ?>
                        </div>
                        <div class="focususerinfor-right">
                            <span><?php echo Html::a($artical['user']['nickname'], Yii::$app->urlManager->createAbsoluteUrl(['user/home/u', 'id' => $artical['user']['id']]), ['class' => 'userfocus-name']); ?></span>
                            <p class="befocus-userinfor"><span>关注 12</span><span>粉丝 23</span><span>文章 15</span></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="opfocus-area">
                        <div class="tabfocus-area">
                        <?php 
                            if(!Yii::$app->user->isGuest){
                                if(Yii::$app->user->identity->id != $artical['user']['id']){
                                    if($isfocus){
                        ?>
                            <span class="focused-btn focus-btn"><i class="icon-ok"></i>&nbsp;已关注</span>
                                <?php 
                                    }else{
                                ?>
                            <span class="addfocus-btn focus-btn need-islogin"><i class="icon-plus"></i>&nbsp;关注</span>
                        <?php 
                                }
                                }
                            }else{
                        ?>
                        <span class="addfocus-btn focus-btn need-islogin"><i class="icon-plus"></i>&nbsp;关注</span>
                        <?php
                            }
                        ?>
                        </div>
                        <input type="hidden" value="<?php echo $artical['user']['id']; ?>" name="befocus_id">
                        <input type="hidden" value="auther" name="befocus_type">
                    </div>
                </div>
                <?php if($artical['userinfor']['summary']){ ?>
                <div class="col-sm-12">
                    <div class="brief-introduction">
                        <?php echo $artical['userinfor']['summary']; ?>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="p-support">
        <?php 
            if($islike){
        ?>
        <div class="supported-like like-btn need-islogin">
            <span><i class="icon-heart-empty"></i>&nbsp;&nbsp;喜欢</span><span class="like-sums"><?php echo $articalinfor['like']; ?></span>
        </div>
        <?php
            }else{
        ?>
        <div class="support-like like-btn need-islogin">
            <span><i class="icon-heart-empty"></i>&nbsp;&nbsp;喜欢</span><span class="like-sums"><?php echo $articalinfor['like']; ?></span>
        </div>
        <?php 
            }
        ?>
    </div>
    <div class="p-newcomment">
        <div class="row">
            <div class="p-commentavatar col-lg-1">
                <img src="<?php if(!Yii::$app->user->isGuest){echo Yii::$app->user->identity->avatar;}else{echo 'statics/images/avatar/guest.png';}?>">
            </div>
            <div class="p-newcommentform col-lg-11">
                <?php echo $this->render('comment', ['model' => $model , 'pid' => false]); ?>
            </div>
        </div>
    </div>
    <div class="p-comments">
        <div class="comments-top">
            <span><?php if(count($comments) != 0){echo $articalinfor['comment'].'条';}; ?>评论</span>
        </div>
        <div class="comments-middle">
        <?php 
            foreach ($comments as $key => $value) {
        ?>
            <div class="comments-list">
                <div class="commentslist-top">
                    <div class="commentstop-left">
                        <img src="<?php echo $value['user']['avatar']; ?>">
                    </div>
                    <div class="commentstop-right">
                        <span><?php echo $value['user']['nickname']; ?></span>
                        <p><?php echo Yii::$app->formatter->asDate($value['created_at'],'php:Y.m.d H:i'); ?></p>
                    </div>
                </div>
                <div class="commentslist-middle">
                    <p><?php echo $value['comment']; ?></p>
                </div>
                <div class="commentslist-bottom">
                    <span class="reply-btn"><i class="icon-comment-alt"></i>&nbsp;回复</span>
                </div>
                <div class="replys-area">
                <?php 
                    if(count($value['child']) != 0){
                ?>
                <?php 
                    foreach ($value['child'] as $key => $child) {
                ?>
                    <div class="replys-list">
                        <span class="reply-content"><a href="" class="replyer-name"><?php echo $child['user']['nickname']; ?></a>： <?php if($child['replyer']){echo Html::a('@'.$child['replyer']['nickname'], ['site/index']).' ';} ?><?php echo $child['comment']; ?></span>
                        <p><?php echo Yii::$app->formatter->asDate($child['created_at'],'php:Y.m.d H:i'); ?><span class="replyed-btn"><i class="icon-comment-alt"></i>&nbsp;回复</span></p>
                    </div>
                <?php 
                    }
                ?>
                    <div class="replys-middle">
                        <span class="addnewcomment-btn"><i class="icon-pencil"></i>&nbsp;添加新的评论</span>
                    </div>
                <?php 
                    }
                ?>
                    <div class="replys-bottom">
                        <?php echo $this->render('comment', ['model' => $model , 'pid' => $value['id']]); ?>
                    </div>
                </div>
            </div>
        <?php 
            }
        ?>
        </div>
    </div>
</div>
<?php 
    if(!Yii::$app->user->isGuest){
?>
<div class="outcontainer-content">
    <ul>
        <li style="display: none;border:none;">
            <a href="#" class="back-top" style="border:1px solid #fff;border-bottom: none;"><span class="glyphicon glyphicon-chevron-up" style="display: inline-block;"></span><span style="display: none;color: red;font-size: 15px;line-height: 15px;padding-top: 9px;padding-bottom: 8px;padding-left: 3px;padding-right: 3px;" class="back-top">返回顶部</span></a>
        </li>
        <li>
            <?php if($artical['user']['id'] == Yii::$app->user->identity->id){ ?><a href="javascript:;" class="contri-plus" style="border:1px solid #fff"><?php }else{ ?><a href="javascript:;" class="artical-plus" style="border:1px solid #fff"><?php } ?><span class="icon-pluss" style="display: inline-block;"><?php if($artical['user']['id'] == Yii::$app->user->identity->id){ ?><i class="icon-upload-alt icon-large"></i><?php }else{ ?><i class="icon-plus icon-large"></i><?php } ?></span><span style="display: none;color: red;font-size: 15px;line-height: 15px;padding-top: 9px;padding-bottom: 8px;padding-left: 3px;padding-right: 3px;" class="artical-pluss"><?php if($artical['user']['id'] == Yii::$app->user->identity->id){ ?>文章投稿<?php }else{ ?>加入专题<?php } ?></span></a>
        </li>
        <li>
            <a href="javascript:;" class="advice-feedback" style="border:1px solid #fff"><span class="icon-infosigns" style="display: inline-block;"><i class="icon-info-sign icon-large"></i></span><span style="display: none;color: red;font-size: 15px;line-height: 15px;padding-top: 9px;padding-bottom: 8px;padding-left: 3px;padding-right: 3px;" class="advice-feedbacks">意见反馈</span></a>
        </li>
        <li>
            <a href="javascript:;" class="question-feedback collect-btn" style="border:1px solid #fff"><span class="icon-bookmarks" style="display: inline-block;"><?php if($collect){ ?><i class="icon-bookmark icon-large" style="color:#f3715c;"></i><?php }else{ ?><i class="icon-bookmark-empty icon-large"></i><?php } ?></span><span style="display: none;color: red;font-size: 15px;line-height: 15px;padding-top: 9px;padding-bottom: 8px;padding-left: 3px;padding-right: 3px;" class="question-feedbacks"><?php if($collect){ ?>取消收藏<?php }else{ ?>收藏文章<?php } ?></span></a>
        </li>
        <li style="border:none;">
            <a href="javascript:;" class="weixin-follow" style="border:1px solid #fff;border-bottom: none;"><span class="icon-qrcodes" style="display: inline-block;"><i class="icon-qrcode icon-large"></i></span><span style="display: none;color: red;font-size: 15px;line-height: 15px;padding-top: 9px;padding-bottom: 8px;padding-left: 3px;padding-right: 3px;" class="weixin-follow">官方微信</span></a>
        </li>
    </ul>
</div>
<?php 
    }else{
?>
<div class="outcontainer-content">
    <ul>
        <li style="display: none;border:none;">
            <a href="#" class="back-top" style="border:1px solid #fff;border-bottom: none;"><span class="glyphicon glyphicon-chevron-up" style="display: inline-block;"></span><span style="display: none;color: red;font-size: 15px;line-height: 15px;padding-top: 9px;padding-bottom: 8px;padding-left: 3px;padding-right: 3px;" class="back-top">返回顶部</span></a>
        </li>
    </ul>
</div>
<?php
    }
?>
<div class="weixin-code" style="display: none;"><p>扫描二维码</p><p>关注爱阅团微信公众号</p><img src="statics/images/qrcode.jpg" class="weixin-img"></div>
<div class="win-back">
</div>
<?php
    if(!Yii::$app->user->isGuest){
    if($artical['user']['id'] == Yii::$app->user->identity->id){
?>
<div class="pop-win">
<div class="pop-wint">
    <div class="pop-ttoper">
        <div class="pop-theader">
            <div class="row">
                <div class="col-sm-7">
                    <div class="poptheader-left">
                        <span>投稿</span>
                    </div>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="search-tinput" name="keyword-tinput" placeholder="搜索专题投稿"><span class="search-btn search-tbtn"><i class="icon-search"></i></span>
                </div>
                <div class="col-sm-1">
                    <div class="poptheader-right">
                        <span class="close-pop"><i class="icon-remove"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pop-tbody">
    </div>
</div>
</div>
<?php 
    }else{
?>
<div class="pop-win">
<div class="pop-wins">
    <div class="pop-toper">
        <div class="pop-header">
            <div class="popheader-left">
                <span>加入到我管理的专题</span>
            </div>
            <div class="popheader-right">
                <span class="close-pop"><i class="icon-remove"></i></span>
            </div>
        </div>
        <div class="pop-middle">
            <input type="text" class="search-input" name="keyword-input" placeholder="搜索我管理的专题"><span class="search-btn search-obtn"><i class="icon-search"></i></span>
        </div>
    </div>
    <div class="pop-body">
    </div>
</div>
</div>
<?php
    }
    }
?>
<div class="blog-back">
    <div class="pop-tologin">
        <p class="tologin-h1">请登录</p>
        <p class="tologin-link"><?php echo Html::a('第七感账号登录', Yii::$app->urlManager->createAbsoluteUrl(['site/login'])) ?></p>
        <p class="toregist-link"><?php echo Html::a('没有账号 ? 现在注册 >', Yii::$app->urlManager->createAbsoluteUrl(['site/signup'])) ?></p>
        <span class="pop-tologincancel cancel-tologin-btn">
            <i class="icon-remove icon-2x"></i>
        </span>
    </div>
</div>
<script type="text/javascript" src="js/jquery.js"></script>
<script>
jQuery(document).ready(function(){
    jQuery().yiiPartical({
        "isGuest": '<?php if(Yii::$app->user->isGuest){echo 1;}else{echo 0;} ?>',
        'csrfToken': $('input[name="_csrf-frontend"]').val(),
        'aid': '<?php echo Yii::$app->request->getQueryParam('id'); ?>',
        'uid': '<?php if(!Yii::$app->user->isGuest){echo Yii::$app->user->identity->id;} ?>',
        'popWin': $('.pop-win'),
        'articalPlus': $('a.artical-plus'),
        'contriPlus': $('a.contri-plus'),
    }, []);
    jQuery('.need-islogin').yiiFocus({
        "isGuest": '<?php if(Yii::$app->user->isGuest){echo 1;}else{echo 0;} ?>',
        'focusbtn': 'focus-btn',
        'likebtn': 'like-btn',
        'csrfToken': $('input[name="_csrf-frontend"]').val(),
        'aid': '<?php echo Yii::$app->request->getQueryParam('id'); ?>',
        'wid': '<?php echo $artical['user_id']; ?>',
    }, []);
});
</script>
<script type="text/javascript">
    $('.win-back').css("height", window.innerHeight);
    $('.close-pop')
    .click(function(){
        $('.win-back').css("display", "none");
        $('.pop-win').css("display", "none");
    })

    var reply = [];
    var replyed = [];
    var addnew = [];
    for(var j = 0 ; j < $('.comments-list').length; j++){
        reply[j] = 0;
        addnew[j] = 0;
        replyed[j] = [];
        for(var k = 0 ; k < $('.comments-list').eq(j).find('.replys-list').length; k++){
            replyed[j][k] = 0;
        }
    }
    $('.reply-btn')
    .click(function(){
        var i = $('.reply-btn').index(this);
        for( var j = 0; j< $('.comments-list').eq(i).find('.replys-list').length; j++){
            replyed[i][j] = 0;
        }
        addnew[i] = 0;
        if(reply[i] === 0){
            $('.replys-bottom').eq(i).css('display','block');
            reply[i] =1;
        }else{
            $('.replys-bottom').eq(i).css('display','none');
            reply[i] = 0;
        }
        $('.comments-list').eq(i).find('.comment-detail').val('');
        $('.comments-list').eq(i).find('.comment-detail').focus();
    })
    $('.replyed-btn')
    .click(function(){
        var i = $('.comments-list').index($(this).parents(".comments-list"));
        var j = $('.comments-list').eq(i).find('.replyed-btn').index($(this));
        addnew[i] = 0;
        reply[i] = 0;
        for( var k = 0; k< $('.comments-list').eq(i).find('.replys-list').length; k++){
            if(replyed[i][k] === 1){
                if(k === j){
                    replyed[i][k] = 1;
                }else{
                    replyed[i][k] = 0;
                }
            }
        }
        if(replyed[i][j] === 0){
            $('.replys-bottom').eq(i).css('display','block');
            var name = $(this).parents('.replys-list').find('.replyer-name').text();
            $('.comments-list').eq(i).find('.comment-detail').focus();
            $('.comments-list').eq(i).find('.comment-detail').val('@'+name+' ');
            replyed[i][j] = 1;
        }else{
            $('.replys-bottom').eq(i).css('display','none');
            replyed[i][j] = 0;
        }
    })
    $('.addnewcomment-btn')
    .click(function(){
        var i = $('.replys-area').index($(this).parents('.replys-area'));
        for( var j = 0; j< $('.comments-list').eq(i).find('.replys-list').length; j++){
            replyed[i][j] = 0;
        }
        reply[i] = 0;
        if(addnew[i] === 0){
            $('.replys-bottom').eq(i).css('display','block');
            addnew[i] = 1;
        }else{
            $('.replys-bottom').eq(i).css('display','none');
            addnew[i] = 0;
        }
        $('.comments-list').eq(i).find('.comment-detail').val('');
        $('.comments-list').eq(i).find('.comment-detail').focus();
    })
    
    $('a.advice-feedback')
    .mouseenter(function(){
        $('span.icon-infosigns').css("display","none");
        $('span.advice-feedbacks').css("display","block");
    })
    $('a.advice-feedback')
    .mouseleave(function(){
        $('span.icon-infosigns').css("display","inline-block");
        $('span.advice-feedbacks').css("display","none");
    })
    $('a.artical-plus')
    .mouseenter(function(){
        $('span.icon-pluss').css("display","none");
        $('span.artical-pluss').css("display","block");
    })
    $('a.artical-plus')
    .mouseleave(function(){
        $('span.icon-pluss').css("display","inline-block");
        $('span.artical-pluss').css("display","none");
    })
    $('a.contri-plus')
    .mouseenter(function(){
        $('span.icon-pluss').css("display","none");
        $('span.artical-pluss').css("display","block");
    })
    $('a.contri-plus')
    .mouseleave(function(){
        $('span.icon-pluss').css("display","inline-block");
        $('span.artical-pluss').css("display","none");
    })
    $('a.question-feedback')
    .mouseenter(function(){
        $('span.icon-bookmarks').css("display","none");
        $('span.question-feedbacks').css("display","block");
    })
    $('a.question-feedback')
    .mouseleave(function(){
        $('span.icon-bookmarks').css("display","inline-block");
        $('span.question-feedbacks').css("display","none");
    })
    $('a.weixin-follow')
    .mouseenter(function(){
        $('span.icon-qrcodes').css("display","none");
        $('span.weixin-follow').css("display","block");
        $('.weixin-code').css("display","block");
    })
    $('a.weixin-follow')
    .mouseleave(function(){
        $('span.icon-qrcodes').css("display","inline-block");
        $('span.weixin-follow').css("display","none");
        $('.weixin-code').css("display","none");
    })
    $('a.back-top')
    .mouseenter(function(){
        $('span.glyphicon-chevron-up').css("display","none");
        $('span.back-top').css("display","block");
    })
    $('a.back-top')
    .mouseleave(function(){
        $('span.glyphicon-chevron-up').css("display","inline-block");
        $('span.back-top').css("display","none");
    })
</script>
