<?php 
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = '蒋龙豪 - 简书';
?>
<div class="user-index">
    <div class="row">
    <div class="col-sm-8">
        <div class="row userindex-lefttop">
            <div class="col-sm-2">
                <div class="subjects-img">
                    <img src="<?php echo $subject['labelimg']; ?>" class="subject-labelimg">
                </div>
            </div>
            <div class="col-sm-5">
                <div class="pager-ecc">
                    <span class="fsize22"><?php echo $subject['name']; ?></span>
                    <p>收录了<?php echo $subinfor['artical'] ?>篇文章 · <?php echo $subinfor['focus'] ?>人关注 </p>
                </div>
            </div>
            <?php ActiveForm::begin(); ?>
            <?php ActiveForm::end(); ?>
            <div class="col-sm-5"> 
            <div class="row">
                <div class="col-sm-6 include-area">
                    <?php 
                        if(Yii::$app->user->identity->id == $subject['uid']){
                    ?>
                    <span class="contri-btn focus-btn">收录</span>
                    <?php 
                        }else{
                    ?>
                    <span class="contri-btn focus-btn">投稿</span>
                    <?php 
                        }
                    ?>
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
                    <input type="hidden" value="<?php echo $subject['id'] ?>" name="befocus_id">
                    <input type="hidden" value="subject" name="befocus_type">
                </div>
            </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="pager-dcc">
                    <ul class="pager-menu pager-tabs" id="home-menu">
                        <li><?php echo Html::a("<span class='glyphicon glyphicon-list'></span>&nbsp;&nbsp;&nbsp;目录", ['default/added', 'id' => $subject['id']], ['class' => 'actived tab-menu']);?></li>
                        <li><?php echo Html::a("<span class='glyphicon glyphicon-comment'></span>&nbsp;&nbsp;&nbsp;按评论数", ['default/comment', 'id' => $subject['id']], ['class' => 'tab-menu']);?></li>
                        <li><?php echo Html::a("<span class='glyphicon glyphicon-heart'></span>&nbsp;&nbsp;&nbsp;按喜欢数", ['default/seq', 'id' => $subject['id']], ['class' => 'tab-menu']);?></li>
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
                管理员
            </div>
            <div class="peopleintro-middle">
                <img src="<?php echo $subject['admin']['avatar']; ?>" class="nbauther-avatar"><span class="nbauther-name"><?php echo $subject['admin']['nickname']; ?><?php if(Yii::$app->user->identity->id == $subject['uid']){ ?><span class="subject-tag">创建者</span><?php } ?></span>
            </div>
        </div>
        <?php if(!Yii::$app->user->isGuest){ 
            if(Yii::$app->user->identity->id != $subject['uid']){
        ?>
        <div class="editsubject-area">
            <?php echo Html::a('编辑专题', ['default/edit', 'id' => $subject['code']], ['class' => 'edit-subejct']) ?>
        </div>
        <?php } } ?>
    </div>
    </div>
</div>
<div class="win-back">
</div>
<div class="pop-win">
<div class="pop-wins">
    <div class="pop-toper">
        <div class="pop-header">
            <div class="popheader-left">
                <?php 
                    if($subject['uid'] == Yii::$app->user->identity->id){
                ?>
                <span>收录文章到该专题</span>
                <?php 
                    }else{
                ?>
                <span>给该专题投稿</span>
                <?php 
                    }
                ?>
            </div>
            <div class="popheader-right">
                <span class="close-pop"><i class="icon-remove"></i></span>
            </div>
        </div>
        <div class="pop-middle">
            <input type="text" class="search-input" name="keyword-input" placeholder="搜索我的文章"><span class="search-btn search-obtn"><i class="icon-search"></i></span>
        </div>
    </div>
    <div class="pop-body">
    </div>
</div>
</div>
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
<script type="text/javascript">
    $('.win-back').css("height", window.innerHeight);
    $.ajax({
        url: $('.pager-tabs a').eq(0).prop('href'),
        type: 'get',
    }).always(function(result){
        $('.pager-content').html(result);
    });
    $('.contri-btn')
    .click(function(){
        $('.win-back').css("display", "block");
        $('.pop-win').css("display", "block");
        $('input[name="keyword-input"]').val('')
        var formData = new FormData();
        var csrfToken = $('input[name="_csrf-frontend"]').val();
        formData.append('_csrf-frontend', csrfToken);
        var sid = '<?php echo $subject['id'] ?>';
        formData.append('sid', sid);
        $.ajax({
            url: '<?php echo 'index.php?r=subject/default/artical' ?>',
            type: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        }).always(function(result){
            $('.pop-body').html(result);
        });
        return false;
    })
    $('.close-pop')
    .click(function(){
        $('.win-back').css("display", "none");
        $('.pop-win').css("display", "none");
    })
    $('.pop-win')
    .click(function(){
        return false;
    })
    $(window)
    .click(function(){
        $('.win-back').css("display", "none");
        $('.pop-win').css("display", "none");
    })
    $('.search-btn')
    .click(function(){
        keywordFind();
    })
    $('input[name="keyword-input"]')
    .focus(function(){
        document.onkeydown = function (e) {
            if (!e) e = window.event;
            if ((e.keyCode || e.which) == 13) {
                keywordFind();
            }
        }
    })
    function keywordFind(){
        var keyword = $('input[name="keyword-input"]').val();
        var formData = new FormData();
        var csrfToken = $('input[name="_csrf-frontend"]').val();
        formData.append('_csrf-frontend', csrfToken);
        var sid = '<?php echo $subject['id'] ?>';
        formData.append('sid', sid);
        formData.append('keyword', keyword);
        $.ajax({
            url: '<?php echo 'index.php?r=subject/default/artical' ?>',
            type: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        }).always(function(result){
            $('.pop-body').html(result);
        });
    }
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
