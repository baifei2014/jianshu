<?php 
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = '关注 - 简书';
?>
<div class="user-index">
<?php ActiveForm::begin(); ?>
<?php ActiveForm::end(); ?>
    <div class="col-nw-3">
        <ul class="nav nav-pills nav-stacked leftinfor-area">
            <li>
                <?php 
                    if($infor['comments'] != 0){
                        $comments = '<span><i class="icon-comments-alt icon-large"></i></span><span>评论</span><span class="badge-byself">'.$infor['comments'].'</span>';
                    }else{
                        $comments = '<span><i class="icon-comments-alt icon-large"></i></span><span>评论</span>';
                    }
                ?>
                <?php echo Html::a($comments, ['default/comment'], ['class' => 'infor-menu actived']) ?>
            </li>
            <li>
                <?php 
                    if($contri != 0){
                        $contriart = '<span><i class="icon-upload-alt icon-large"></i></span><span>投稿请求</span><span class="badge-byself pull-right contri-sum">'.$contri.'</span>';
                    }else{
                        $contriart = '<span><i class="icon-upload-alt icon-large"></i></span><span>投稿请求</span>';
                    }
                ?>
                <?php echo Html::a($contriart, ['default/requests'], ['class' => 'infor-menu']) ?></li>
            <li>
                <?php 
                    if($infor['likes'] != 0){
                        $likes = '<span><i class="icon-heart-empty icon-large"></i></span><span>喜欢</span><span class="badge-byself pull-right">'.$infor['likes'].'</span>';
                    }else{
                        $likes = '<span><i class="icon-heart-empty icon-large"></i></span><span>喜欢</span>';
                    }
                ?>
                <?php echo Html::a($likes, ['default/likes'], ['class' => 'infor-menu']) ?></li>
            <li>
                <?php 
                    if($infor['follows'] != 0){
                        $follows = '<span><i class="icon-user icon-large"></i></span><span>关注</span><span class="badge-byself pull-right">'.$infor['follows'].'</span>';
                    }else{
                        $follows = '<span><i class="icon-user icon-large"></i></span><span>关注</span>';
                    }
                ?>
                <?php echo Html::a($follows, ['default/follows'], ['class' => 'infor-menu']) ?></li>
            <li>
                <?php 
                    if($infor['others'] != 0){
                        $others = '<span><i class="icon-user icon-large"></i></span><span>其他</span><span class="badge-byself pull-right">'.$infor['others'].'</span>';
                    }else{
                        $others = '<span><i class="icon-user icon-large"></i></span><span>其他</span>';
                    }
                ?>
                <?php echo Html::a($others, ['default/others'], ['class' => 'infor-menu']) ?>
            </li>
        </ul>
    </div>
    <div class="col-nw-9">
        <div class="sub-content">
        </div>
    </div>
</div>
<script type="text/javascript" src="/statics/js/jquery.js"></script>
<script type="text/javascript">
    function ajaxMenu(url){
        $.ajax({
            url: url,
            type: 'get',
        }).always(function(result){
            $('.sub-content').html(result);
        });
    }
    ajaxMenu('<?php echo '/notification/default/comment'; ?>');
    $('.infor-menu')
    .click(function(){
        var i = $('.infor-menu').index(this);
        $('.infor-menu').removeClass("actived");
        $('.infor-menu').eq(i).addClass("actived");
        var url = $('.infor-menu').eq(i).prop('href');
        ajaxMenu(url);
        if(i != 1 && $(this).find('.badge-byself').length > 0){
            var infornumber = $(this).find('.badge-byself').text();
            $(this).find('.badge-byself').remove();
            if($('.notifi-info').find('.badge-byself').length > 0){
                var inforsums = $('.notifi-info').find('.badge-byself').text();
                var infors = inforsums - infornumber;
                if(infors <= 0){
                    $('.notifi-info').html('消息');
                }else{
                    $('.notifi-info').html('消息<span class="badge-byself pull-top">'+infors+'</span>');
                }
            }
        }

        return false;
    })
</script>
