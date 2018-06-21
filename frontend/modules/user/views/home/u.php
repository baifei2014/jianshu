<?php 
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $user['nickname'].' - 简书';
?>
<div class="user-index">
    <div class="row">
    <div class="col-sm-8">
        <div class="row userindex-lefttop">
            <div class="col-sm-2">
                <?php if(!$user['avatar']){$imgurl = '/'.Yii::$app->params['avatar'];}else{$imgurl = '/'.$user['avatar'];} ?>
                <?php echo Html::a('<img src="'.$imgurl.'" class="user-avatar-big">', ['home/u', 'id' => $user['id']]) ?>
            </div>
            <div class="col-sm-5">
                <div class="pager-acc">
                    <span class="fsize22"><?php echo Html::a($user['nickname'], ['home/u', 'id' => $user['id']]); ?><span class="user-sex"><?php if($userinfor['sex'] === '男'){echo '♂';}else{echo '♀';} ?></span></span>
                </div>
                <div class="pager-bcc">
                    <ul class="pager-menu">
                        <li class="rank-menu">
                            <p><span class="fweigcb"><?php echo $uexinfor['focus']; ?></span></p>
                            <p><span class="fweigcs">关注</span></p>
                        </li>
                        <li class="rank-menu">
                            <p><span class="fweigcb"><?php echo $uexinfor['fans']; ?></span></p>
                            <p><span class="fweigcs">粉丝</span></p>
                        </li>
                        <li class="rank-menu">
                            <p><span class="fweigcb"><?php echo $uexinfor['artical']; ?></span></p>
                            <p><span class="fweigcs">文章</span></p>
                        </li>
                        <li class="rank-menu">
                            <p><span class="fweigcb"><?php echo $uexinfor['words']; ?></span></p>
                            <p><span class="fweigcs">字数</span></p>
                        </li>
                    </ul>
                </div>
            </div>
            <?php ActiveForm::begin(); ?>
            <?php ActiveForm::end(); ?>
            <?php 
                if(!Yii::$app->user->isGuest){
                    if($user['id'] != Yii::$app->user->identity->id){
            ?>
            <div class="col-sm-5">
                <div class="userindexlefttop-right opfocus-area">
                    <div class="tabfocus-area">
                    <?php 
                        if($isfans){
                    ?>
                    <span class="focused-btn focus-btn"><i class="icon-ok"></i>&nbsp;已关注</span>
                    <?php 
                        }else{
                    ?>
                    <span class="addfocus-btn focus-btn need-islogin"><i class="icon-plus"></i>&nbsp;关注</span>
                    <?php 
                        }
                    ?>
                    </div>
                    <input type="hidden" value="<?php echo $user['id'] ?>" name="befocus_id">
                    <input type="hidden" value="auther" name="befocus_type">
                </div>
            </div>
            <?php 
                    }
                }else{
            ?>
            <div class="col-sm-5">
                <div class="userindexlefttop-right opfocus-area">
                    <div class="tabfocus-area">
                        <span class="addfocus-btn focus-btn need-islogin"><i class="icon-plus"></i>&nbsp;关注</span>
                    </div>
                </div>
            </div>
            <?php 
                }
            ?>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="pager-dcc">
                    <ul class="pager-menu pager-tabs" id="home-menu">
                        <li><?php echo Html::a("文章", ['/user/home/artical', 'id' => $user['id']]);?></li>
                        <li><?php echo Html::a("动态", ['/user/home/timeline', 'id' => $user['id']], ['class' => 'actived']);?></li>
                        <li><?php echo Html::a("关注用户", ['/user/home/focus', 'id' => $user['id']]);?></li>
                        <li><?php echo Html::a("粉丝", ['/user/home/fans', 'id' => $user['id']]);?></li>
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
                <?php 
                    if($userinfor['summary']){
                        echo '个人介绍';
                    }else{
                        echo '暂无个人介绍';
                    }
                ?>
            </div>
            <?php 
                if($userinfor['summary']){
            ?>
            <div class="peopleintro-middle">
                <?php
                    $pattern = '';
                ?>
                <?php echo $userinfor['summary']; ?>
            </div>
            <?php 
                }
            ?>
            <?php 
                if($userinfor['web'] || $userinfor['qrcode']){
            ?>
            <div class="peopleintro-bottom">
                <?php if($userinfor['web']){ ?><?php echo Html::a('<i class="icon-home icon-large"></i>', [$userinfor['web']])?><?php } ?>
                <?php 
                    if($userinfor['qrcode']){
                        echo Html::a('<i class="icon-comments icon-large"></i><div class="arrows" id="qrimg"><img src="'.$userinfor['qrcode'].'" class="user-qrcode"></div>', 'javascript:;', ['id' => 'qrcode', 'class' => 'weixinqrcode']);
                ?>
                <?php } ?>
            </div>
            <?php 
                }
            ?>
        </div>
        <?php 
            if(!Yii::$app->user->isGuest && $user['id'] == Yii::$app->user->identity->id){ 
                $owner = '我';
            }else if($userinfor['sex'] == '男'){ 
                $owner = '他';
            }else if($userinfor['sex'] == '女'){ 
                $owner = '她';
            }
        ?>
        <div class="focuslike-area">
            <?php echo Html::a('<li><i class="icon-folder-open-alt icon-large"></i><span class="focus-sets">'.$owner.'关注的专题/文集</span></li>', ['/user/home/subscriptions', 'id' => $user['id']]);?>
            <?php echo Html::a('<li><i class="icon-heart-empty icon-large"></i><span class="like-articals">'.$owner.'喜欢的文章</span></li>', ['/user/home/likenotes', 'id' => $user['id']]); ?>
        </div>
        <?php 
            if(!Yii::$app->user->isGuest && $user['id'] == Yii::$app->user->identity->id){
        ?>
        <div class="created-subject">
            <div class="createdsubject-top">
                <div class="row"><div class="col-sm-6"><?php echo $owner ?>创建的专题</div><?php if($subjects){ ?><div class="col-sm-6 text-right"><?php echo Html::a('<i class="icon-plus"></i>&nbsp;&nbsp;新建专题', '/subject/default/new', ['class' => 'create-anew']); ?></div><?php } ?></div>
            </div>
            <div class="createdsubject-middle">
                <?php 
                    if(!$subjects){
                ?>
                <?php echo Html::a('<i class="icon-plus"></i>&nbsp;&nbsp;创建一个新专题', '/subject/default/new', ['class' => 'create-anew']); ?>
                <?php 
                    }else{
                        foreach ($subjects as $key => $value) {
                ?>
                <li><a href="<?php echo Yii::$app->urlManager->createAbsoluteUrl(['/subject/default/c', 'id'=>$value['code']]); ?>" class="subject-img-link"><img src="<?php echo '/'.$value['labelimg']; ?>" class="subject-avatar-small"></a><a href="<?php echo Yii::$app->urlManager->createAbsoluteUrl(['subject/default/c', 'id'=>$value['code']]); ?>" class="subjectname-link"><?php echo $value['name']; ?></a></li>
                <?php
                        }
                    }
                ?>
            </div>
        </div>
        <?php 
            }else if($subjects){
        ?>
        <div class="created-subject">
            <div class="createdsubject-top">
                <div class="row"><div class="col-sm-6"><?php echo $owner ?>创建的专题</div></div>
            </div>
            <div class="createdsubject-middle">
                <?php 
                    foreach ($subjects as $key => $value) {
                ?>
                <li><a href="<?php echo Yii::$app->urlManager->createAbsoluteUrl(['/subject/default/c', 'id'=>$value['code']]); ?>" class="subject-img-link"><img src="<?php echo '/'.$value['labelimg']; ?>" class="subject-avatar-small"></a><a href="<?php echo Yii::$app->urlManager->createAbsoluteUrl(['/subject/default/c', 'id'=>$value['code']]); ?>" class="subjectname-link"><?php echo $value['name']; ?></a></li>
                <?php
                    }
                ?>
            </div>
        </div>
        <?php
            }
        ?>
        <?php
            if($issets){
        ?>
        <div class="created-sets">
            <div class="createdsets-top">
                <?php echo $owner ?>的文集
            </div>
            <div class="createdsets-middle">
                <?php 
                    foreach ($sets as $key => $value) {
                ?>
                <?php if($value['articalset']){ ?><?php echo Html::a('<li><i class="icon-book icon-large"></i><span>'.$value['name'].'</span></li>', Yii::$app->urlManager->createAbsoluteUrl(['/nb/default/index', 'id' => $value['id']])) ?><?php } ?>
                <?php 
                    }
                ?>
            </div>
        </div>
        <?php 
            }
        ?>
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
<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/js/tab.js"></script>
<script type="text/javascript" src="/js/focus.js"></script>
<script type="text/javascript">
    $('#qrcode')
    .mouseover(function(){
        $('#qrimg').css("display", "block");
    })
    $('#qrcode')
    .mouseout(function(){
        $('#qrimg').css("display", "none");
    })
</script>
<script>
jQuery(document).ready(function(){
    jQuery('.pager-tabs').yiiTab({
        'uid': '<?php echo $user['id']; ?>',
        "isGuest": '<?php if(Yii::$app->user->isGuest){echo 1;}else{echo 0;} ?>',
    }, []);
    jQuery('.need-islogin').yiiFocus({
        "isGuest": '<?php if(Yii::$app->user->isGuest){echo 1;}else{echo 0;} ?>',
        'focusbtn': 'focus-btn',
    }, []);
});
</script>
