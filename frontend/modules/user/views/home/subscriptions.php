<?php 
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '蒋龙豪 - 简书';
?>
<div class="user-index">
    <div class="row">
    <div class="col-sm-8">
        <div class="row userindex-lefttop">
            <div class="col-sm-2">
                <?php if($user){$imgurl = $user['avatar'];}else{$imgurl = Yii::$app->params['avatar'];} ?>
                <?php echo Html::a('<img src="'.'/'.$imgurl.'" class="user-avatar-big">', ['home/u', 'id' => $user['id']]) ?>
            </div>
            <div class="col-sm-5">
                <div class="pager-acc">
                    <span class="fsize22"><?php echo Html::a($user['nickname'], ['home/u', 'id' => $user['id']]); ?><span class="user-sex"><?php if($userinfor['sex'] === '男'){echo '♂';}else{echo '♀';} ?></span></span>
                </div>
                <div class="pager-bcc">
                    <ul class="pager-menu">
                        <li class="rank-menu">
                            <p><span class="fweigcb"><?php echo $user['userexinfor']['focus']; ?></span></p>
                            <p><span class="fweigcs">关注</span></p>
                        </li>
                        <li class="rank-menu">
                            <p><span class="fweigcb"><?php echo $user['userexinfor']['fans']; ?></span></p>
                            <p><span class="fweigcs">粉丝</span></p>
                        </li>
                        <li class="rank-menu">
                            <p><span class="fweigcb"><?php echo $user['userexinfor']['artical']; ?></span></p>
                            <p><span class="fweigcs">文章</span></p>
                        </li>
                        <li class="rank-menu">
                            <p><span class="fweigcb"><?php echo $user['userexinfor']['words']; ?></span></p>
                            <p><span class="fweigcs">字数</span></p>
                        </li>
                    </ul>
                </div>
            </div>
            <?php ActiveForm::begin(); ?>
            <?php ActiveForm::end(); ?>
            <?php 
                if($user['id'] != Yii::$app->user->identity->id){
            ?>
            <div class="col-sm-5">
                <div class="userindexlefttop-right">
                    <?php 
                        if($isfans){
                    ?>
                    <span class="focused-btn focus-btn"><i class="icon-ok"></i>&nbsp;已关注</span>
                    <?php 
                        }else{
                    ?>
                    <span class="addfocus-btn focus-btn"><i class="icon-plus"></i>&nbsp;关注</span>
                    <?php 
                        }
                    ?>
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
                        <li><?php echo Html::a("关注的专题/文集", ['home/subscriptions', 'id' => $user['id']], ['class' => 'actived']);?></li>
                        <li><?php echo Html::a("喜欢的文章", ['home/likenotes', 'id' => $user['id']]);?></li>
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
                        echo Html::a('<i class="icon-comments icon-large"></i>', 'javascript:;', ['id' => 'qrcode']);
                ?>
                    <div class="arrows" id="qrimg">
                        <img src="<?php echo '/'.$userinfor['qrcode'] ?>" class="user-qrcode">
                    </div>
                <?php } ?>
            </div>
            <?php 
                }
            ?>
        </div>
        <?php 
            if($user['id'] == Yii::$app->user->identity->id){ 
                $owner = '我';
            }else if($userinfor['sex'] == '男'){ 
                $owner = '他';
            }else if($userinfor['sex'] == '女'){ 
                $owner = '她';
            }
        ?>
        <div class="focuslike-area">
            <?php echo Html::a('<li><i class="icon-folder-open-alt icon-large"></i><span class="focus-sets">'.$owner.'关注的专题/文集</span></li>', ['home/subscriptions', 'id' => $user['id']]);?>
            <?php echo Html::a('<li><i class="icon-heart-empty icon-large"></i><span class="like-articals">'.$owner.'喜欢的文章</span></li>', ['home/likenotes', 'id' => $user['id']]); ?>
        </div>
        <?php 
            if($user['id'] == Yii::$app->user->identity->id){
        ?>
        <div class="created-subject">
            <div class="createdsubject-top">
                <div class="row"><div class="col-sm-6"><?php echo $owner ?>创建的专题</div><?php if($subjects){ ?><div class="col-sm-6 text-right"><?php echo Html::a('<i class="icon-plus"></i>&nbsp;&nbsp;新建专题', 'index.php?r=subject/default/new', ['class' => 'create-anew']); ?></div><?php } ?></div>
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
                <li><a href="<?php echo Yii::$app->urlManager->createAbsoluteUrl(['/subject/default/c', 'id'=>$value['code']]); ?>" class="subject-img-link"><img src="<?php echo '/'.$value['labelimg']; ?>" class="subject-avatar-small"></a><a href="<?php echo Yii::$app->urlManager->createAbsoluteUrl(['/subject/default/c', 'id'=>$value['code']]); ?>" class="subjectname-link"><?php echo $value['name']; ?></a></li>
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
                <li><a href="<?php echo Yii::$app->urlManager->createAbsoluteUrl(['subject/default/c', 'id'=>$value['code']]); ?>" class="subject-img-link"><img src="<?php echo '/'.$value['labelimg']; ?>" class="subject-avatar-small"></a><a href="<?php echo Yii::$app->urlManager->createAbsoluteUrl(['subject/default/c', 'id'=>$value['code']]); ?>" class="subjectname-link"><?php echo $value['name']; ?></a></li>
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
                <?php if($value['articalset']){ ?><li><i class="icon-book icon-large"></i><span><?php echo $value['name']; ?></span></li><?php } ?>
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
<script type="text/javascript" src="/statics/js/jquery.js"></script>
<script type="text/javascript">
    $.ajax({
        url: '<?php echo '/user/home/subscriptions?id='.$user['id']; ?>',
        type: 'get',
    }).always(function(result){
        $('.pager-content').html(result);
    });
    $('.pager-tabs li a')
    .click(function(){
        $('#home-menu a').removeClass('actived');
        $(this).addClass('actived');
        var url = $(this).prop('href');
        $.ajax({
            url: url,
            type: 'get',
        }).always(function(result){
            $('.pager-content').html(result);
        });
        return false;
    })
    $('.focus-btn')
    .click(function(){
        indexClick();
    })
    function indexClick()
    {
        var formData = new FormData();
        var csrfToken = $('input[name="_csrf-frontend"]').val();
        formData.append('_csrf-frontend', csrfToken);
        var uid = '<?php echo $user['id']; ?>';
        formData.append('uid', uid);
        $.ajax({
            url: '<?php echo '/user/home/ofocus' ?>',
            type: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        }).always(function(result){
            var data = JSON.parse(result);
            if(data['status'] === 'cancel'){
                $('.userindexlefttop-right').html('');
                $('.userindexlefttop-right').html('<span class="addfocus-btn focus-btn"><i class="icon-plus"></i>&nbsp;关注</span>');
                $('.userindexlefttop-right .focus-btn').on('click', function(){
                    indexClick();
                })
            }else if(data['status'] === 'success'){
                $('.userindexlefttop-right').html('');
                $('.userindexlefttop-right').html('<span class="focused-btn focus-btn"><i class="icon-ok"></i>&nbsp;已关注</span>');
                $('.userindexlefttop-right .focus-btn').on('click', function(){
                    indexClick();
                })
                $('.userindexlefttop-right .focused-btn').on('mouseover',function(){
                    $('.userindexlefttop-right .focused-btn').html('');
                    $('.userindexlefttop-right .focused-btn').html('<i class="icon-remove"></i>&nbsp;取消关注');
                })
                $('.userindexlefttop-right .focused-btn').on('mouseout',function(){
                    $('.userindexlefttop-right .focused-btn').html('');
                    $('.userindexlefttop-right .focused-btn').html('<i class="icon-ok"></i>&nbsp;已关注');
                })
            }
        });
    }
    function focusClick(id, i)
    {
        var formData = new FormData();
        var csrfToken = $('input[name="_csrf-frontend"]').val();
        formData.append('_csrf-frontend', csrfToken);
        formData.append('uid', id);
        $.ajax({
            url: '<?php echo '/user/home/ofocus' ?>',
            type: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        }).always(function(result){
            var data = JSON.parse(result);
            if(data['status'] === 'cancel'){
                $('.tabfocus-area').eq(i).html('');
                $('.tabfocus-area').eq(i).html('<span class="addfocus-btn focus-btn"><i class="icon-plus"></i>&nbsp;关注</span>');
                $('.tabfocus-area').off('click');
                $('.tabfocus-area').on('click', function(){
                    var i = $('.opfocus-area .tabfocus-area').index(this);
                    var id = $('input[name="user_id"]').eq(i).val();
                    focusClick(id, i);
                })
            }else if(data['status'] === 'success'){
                $('.tabfocus-area').eq(i).html('');
                $('.tabfocus-area').eq(i).html('<span class="focused-btn focus-btn"><i class="icon-ok"></i>&nbsp;已关注</span>');
                $('.tabfocus-area').off('click');
                $('.tabfocus-area').on('click', function(){
                    var i = $('.opfocus-area .tabfocus-area').index(this);
                    var id = $('input[name="user_id"]').eq(i).val();
                    focusClick(id, i);
                })
                $('.tabfocus-area .focused-btn').on('mouseover',function(){
                    var i = $('.tabfocus-area .focused-btn').index(this);
                    $('.tabfocus-area .focused-btn').eq(i).html('');
                    $('.tabfocus-area .focused-btn').eq(i).html('<i class="icon-remove"></i>&nbsp;取消关注');
                })
                $('.tabfocus-area .focused-btn').on('mouseout',function(){
                    var i = $('.tabfocus-area .focused-btn').index(this);
                    $('.tabfocus-area .focused-btn').eq(i).html('');
                    $('.tabfocus-area .focused-btn').eq(i).html('<i class="icon-ok"></i>&nbsp;已关注');
                })
            }
        });
    }
    function fansClick(id, i)
    {
        var formData = new FormData();
        var csrfToken = $('input[name="_csrf-frontend"]').val();
        formData.append('_csrf-frontend', csrfToken);
        formData.append('uid', id);
        $.ajax({
            url: '<?php echo '/user/home/ofocus' ?>',
            type: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        }).always(function(result){
            var data = JSON.parse(result);
            if(data['status'] === 'cancel'){
                $('.tabfans-area').eq(i).html('');
                $('.tabfans-area').eq(i).html('<span class="addfocus-btn focus-btn"><i class="icon-plus"></i>&nbsp;关注</span>');
                $('.tabfans-area').off('click');
                $('.tabfans-area').on('click', function(){
                    var i = $('.opfocus-area .tabfans-area').index(this);
                    var id = $('input[name="user_id"]').eq(i).val();
                    fansClick(id, i);
                })
            }else if(data['status'] === 'success'){
                $('.tabfans-area').eq(i).html('');
                $('.tabfans-area').eq(i).html('<span class="focused-btn focus-btn"><i class="icon-ok"></i>&nbsp;已关注</span>');
                $('.tabfans-area').off('click');
                $('.tabfans-area').on('click', function(){
                    var i = $('.opfocus-area .tabfans-area').index(this);
                    var id = $('input[name="user_id"]').eq(i).val();
                    fansClick(id, i);
                })
                $('.tabfans-area .focused-btn').on('mouseover',function(){
                    var i = $('.tabfans-area .focused-btn').index(this);
                    $('.tabfans-area .focused-btn').eq(i).html('');
                    $('.tabfans-area .focused-btn').eq(i).html('<i class="icon-remove"></i>&nbsp;取消关注');
                })
                $('.tabfans-area .focused-btn').on('mouseout',function(){
                    var i = $('.tabfans-area .focused-btn').index(this);
                    $('.tabfans-area .focused-btn').eq(i).html('');
                    $('.tabfans-area .focused-btn').eq(i).html('<i class="icon-ok"></i>&nbsp;已关注');
                })
            }
        });
    }
    $('.userindexlefttop-right .focused-btn')
    .mouseenter(function(){
        $('.userindexlefttop-right .focused-btn').html('');
        $('.userindexlefttop-right .focused-btn').html('<i class="icon-remove"></i>&nbsp;取消关注');
    })
    $('.userindexlefttop-right .focused-btn')
    .mouseleave(function(){
        $('.userindexlefttop-right .focused-btn').html('');
        $('.userindexlefttop-right .focused-btn').html('<i class="icon-ok"></i>&nbsp;已关注');
    })
    $('#qrcode')
    .mouseover(function(){
        $('#qrimg').css("display", "block");
    })
    $('#qrcode')
    .mouseout(function(){
        $('#qrimg').css("display", "none");
    })
</script>
