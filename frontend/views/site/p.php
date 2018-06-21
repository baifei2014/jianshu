<?php 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\helpers\LinkPagerC;

$this->title = $artical['title'];
?>
<div class="site-p">
    <div class="p-artical">
        <div class="p-top">
            <p class="title"><?php echo $artical['title']; ?></p>
            <div class="artical-infor">
                <div class="row">
                    <div class="col-lg-1 puser-avatar">
                        <img src="<?php echo '/'.$artical['user']['avatar']; ?>">
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
                            <?php echo Html::a('<img src="'.'/'.$artical['user']['avatar'].'" class="focussubject-img-middle">', Yii::$app->urlManager->createAbsoluteUrl(['user/home/u', 'id' => $artical['user']['id']])); ?>
                        </div>
                        <div class="focususerinfor-right">
                            <span><?php echo Html::a($artical['user']['nickname'], Yii::$app->urlManager->createAbsoluteUrl(['user/home/u', 'id' => $artical['user']['id']]), ['class' => 'userfocus-name']); ?></span>
                            <p class="befocus-userinfor"><span>关注 <?php echo $artical['userexinfor']['focus'] ?>，</span><span>粉丝 <?php echo $artical['userexinfor']['fans'] ?>，</span><span>文章 <?php echo $artical['userexinfor']['artical'] ?>，</span></p>
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
                        <?php echo preg_replace('/<br>/', '&nbsp;&nbsp;', $artical['userinfor']['summary']); ?>
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
    <div class="comment-area">
        <div class="comment-blocktitle">
            <span class="comment-title"><?php echo count($rcomments) ?>条评论</span>
        </div>
        <div class="comment-newc">
            <div class="comment-createc">
                <div class="comment-avatar">
                    <?php 
                        if(Yii::$app->user->isGuest){
                    ?>
                        <img src="/statics/images/avatar/guest.png">
                    <?php
                        }else{
                    ?>
                        <img src="<?php echo '/'.Yii::$app->user->identity->avatar ?>">
                    <?php
                        }
                    ?>
                </div>
                <div class="comment-content">
                    <?php echo $this->render('comment', ['model' => $model]) ?>
                </div>

            </div>
        </div>
        <div id="comment-commentd">
        <?php 
            foreach ($rcomments as $key => $value) {
        ?>
            <div id="comment<?php echo $value['id'] ?>" class="comment-commentd-list">
                <div class="comment-avatar" style="padding-top: 4px;">
                    <img src="<?php echo '/'.$value['user']['avatar'] ?>">
                </div>
                <div class="comment-maincontent">
                    <div class="comment-main-levo">
                        <p class="pull-left comment-person" data-pid="<?php echo $value['id'] ?>"><?php echo $value['user']['nickname'] ?></p>
                        <p class="pull-right"><i class="icon-thumbs-up"></i>&nbsp;2225</p>
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
<div class="weixin-code" style="display: none;"><p>扫描二维码</p><p>关注爱阅团微信公众号</p><img src="/statics/images/qrcode.jpg" class="weixin-img"></div>
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
        <p class="tologin-link"><?php echo Html::a('第七感账号登录', Yii::$app->urlManager->createAbsoluteUrl(['/site/login'])) ?></p>
        <p class="toregist-link"><?php echo Html::a('没有账号 ? 现在注册 >', Yii::$app->urlManager->createAbsoluteUrl(['/site/signup'])) ?></p>
        <span class="pop-tologincancel cancel-tologin-btn">
            <i class="icon-remove icon-2x"></i>
        </span>
    </div>
</div>
<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/js/partical.js"></script>
<script type="text/javascript" src="/js/focus.js"></script>
<script type="text/javascript" src="/js/comment.js"></script>
<script type="text/javascript" src="/js/pager.js"></script>
<script type="text/javascript" src="/js/reply.js"></script>
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
<script>
jQuery(document).ready(function(){
    var text = document.getElementsByTagName("textarea");
    jQuery(text).yiiComment({
        "isLogin": '<?php echo Yii::$app->user->isGuest ?>',
    });

    jQuery('#comment-commentd .pagination li').yiiPager({
        "aid": '<?php echo $artical['id']; ?>',
    }, []);

    jQuery('#comment-commentd').yiiReply({
        "preply": "reply-p-btn",
        "creply": "reply-c-btn",
        "addnewreply": "add-new-comment",
        'isLogin': '<?php echo Yii::$app->user->isGuest; ?>',
    }, []);
});
</script>
<script type="text/javascript">
    $('.win-back').css("height", window.innerHeight);
    $('.close-pop')
    .click(function(){
        $('.win-back').css("display", "none");
        $('.pop-win').css("display", "none");
    });
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
