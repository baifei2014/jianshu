<?php 
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '蒋龙豪 - 简书';
?>
<div class="user-index">
    <div class="row">
    <div class="col-sm-8">
        <div class="row">
            <div class="col-sm-2">
                <?php if($user){$imgurl = $user['avatar'];}else{$imgurl = Yii::$app->params['avatar'];} ?><img src="<?php echo $imgurl;?>" class="user-avatar-big">
            </div>
            <div class="col-sm-6">
                <div class="pager-acc">
                    <span class="fsize22"><?php echo $user['nickname']; ?></span>
                </div>
                <div class="pager-bcc">
                    <ul class="pager-menu">
                        <li class="rank-menu">
                            <p><span class="fweigcb">6</span></p>
                            <p><span class="fweigcs">关注</span></p>
                        </li>
                        <li class="rank-menu">
                            <p><span class="fweigcb">0</span></p>
                            <p><span class="fweigcs">粉丝</span></p>
                        </li>
                        <li class="rank-menu">
                            <p><span class="fweigcb">0</span></p>
                            <p><span class="fweigcs">文章</span></p>
                        </li>
                        <li class="rank-menu">
                            <p><span class="fweigcb">0</span></p>
                            <p><span class="fweigcs">字数</span></p>
                        </li>
                    </ul>
                </div>
            </div>
            <?php ActiveForm::begin(); ?>
            <?php ActiveForm::end(); ?>
            <div class="col-sm-4">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="pager-dcc">
                    <ul class="pager-menu pager-tabs" id="home-menu">
                        <li><?php echo Html::a("文章", ['home/artical', 'id' => $user['id']]);?></li>
                        <li><?php echo Html::a("动态", ['home/timeline', 'id' => $user['id']], ['class' => 'actived']);?></li>
                        <li><?php echo Html::a("关注用户", ['home/focus', 'id' => $user['id']]);?></li>
                        <li><?php echo Html::a("粉丝", ['home/fans', 'id' => $user['id']]);?></li>
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
                    if($userinfor['summary'] || $userinfor['web'] || $userinfor['qrcode']){
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
                <?php if($userinfor['web']){ ?><?php echo Html::a('<i class="icon-home icon-large"></i>', $userinfor['web']) ?><?php } ?>
                <?php 
                    if($userinfor['qrcode']){
                        echo Html::a('<i class="icon-comments icon-large"></i>', ['site/index'], ['id' => 'qrcode']);
                    }
                ?>
                <div class="arrows" id="qrimg">
                    <img src="<?php echo $userinfor['qrcode'] ?>" class="user-qrcode">
                </div>
            </div>
            
            <?php 
                }
            ?>
        </div>
        <div class="focuslike-area">
            <li>
                <i class="icon-folder-open-alt icon-large"></i><span class="focus-sets">我关注的专题/文集</span>
            </li>
            <li>
                <i class="icon-heart-empty icon-large"></i><span class="like-articals">我喜欢的文章</span>
            </li>
        </div>
        <div class="created-subject">
            <div class="createdsubject-top">
                我创建的专题
            </div>
            <div class="createdsubject-middle">
                <?php 
                    if(!$subjects){
                ?>
                <?php echo Html::a('<i class="icon-plus"></i>&nbsp;&nbsp;创建一个新专题', 'index.php?r=subject/default/new', ['class' => 'create-anew']); ?>
                <?php 
                    }else{
                        foreach ($subjects as $key => $value) {
                ?>
                <li><a href="<?php echo Yii::$app->urlManager->createAbsoluteUrl(['subject/default/c', 'id'=>$value['code']]); ?>" class="subject-img-link"><img src="<?php echo $value['labelimg']; ?>" class="subject-avatar-small"></a><a href="<?php echo Yii::$app->urlManager->createAbsoluteUrl(['subject/default/c', 'id'=>$value['code']]); ?>" class="subjectname-link"><?php echo $value['name']; ?></a></li>
                <?php
                        }
                    }
                ?>
            </div>
        </div>
        <div class="created-sets">
            <div class="createdsets-top">
                他的文集
            </div>
            <div class="createdsets-middle">
                <li><i class="icon-book icon-large"></i><span>日记本</span></li>
                <li><i class="icon-book icon-large"></i><span>江湖人生</span></li>
            </div>
        </div>
    </div>
    </div>
</div>
<script src="//code.jquery.com/jquery-1.9.1.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script type="text/javascript" src="statics/js/jquery.js"></script>
<script type="text/javascript">
    $.ajax({
        url: '<?php echo 'index.php?r=user/home/timeline&id='.$user['id']; ?>',
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
    function focusClick(id, i)
    {
        var formData = new FormData();
        var csrfToken = $('input[name="_csrf-frontend"]').val();
        formData.append('_csrf-frontend', csrfToken);
        formData.append('uid', id);
        $.ajax({
            url: '<?php echo 'index.php?r=user/home/ofocus' ?>',
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
            url: '<?php echo 'index.php?r=user/home/ofocus' ?>',
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
    $('#qrcode')
    .mouseover(function(){
        $('#qrimg').css("display", "block");
    })
    $('#qrcode')
    .mouseout(function(){
        $('#qrimg').css("display", "none");
    })
</script>
