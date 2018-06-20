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
                <div class="articalset-img">
                    <i class="icon-book icon-3x"></i>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="pager-ecc">
                    <span class="fsize22"><?php echo $articalset['name']; ?></span>
                    <p>10篇文章 · 19969字 · 1人关注 </p>
                </div>
            </div>
            <?php ActiveForm::begin(); ?>
            <?php ActiveForm::end(); ?>
            <div class="col-sm-5"> 
                <div class="nbtop-left">
                    <?php 
                        // if($isfans){
                    ?>
                    
                    <?php 
                        // }else{
                    ?>
                    <span class="addfocus-btn focus-btn"><i class="icon-plus"></i>&nbsp;关注</span>
                    <?php 
                        // }
                    ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="pager-dcc">
                    <ul class="pager-menu pager-tabs" id="home-menu">
                        <li><?php echo Html::a("<span class='glyphicon glyphicon-book'></span>&nbsp;&nbsp;最新发布", ['home/artical']);?></li>
                        <li><?php echo Html::a("<span class='glyphicon glyphicon-comment'></span>&nbsp;&nbsp;&nbsp;最新评论", ['home/timeline'], ['class' => 'actived']);?></li>
                        <li><?php echo Html::a("<span class='glyphicon glyphicon-list'></span>&nbsp;&nbsp;&nbsp;目录", ['home/focus']);?></li>
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
                <img src="<?php echo $articalset['auther']['avatar']; ?>" class="nbauther-avatar"><span class="nbauther-name"><?php echo $articalset['auther']['nickname']; ?></span>
            </div>
        </div>
    </div>
    </div>
</div>
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
            url: '<?php echo 'index.php?r=user/home/ofocus' ?>',
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
</script>
