<?php 
use yii\helpers\Html;
?>
<div class="comment-message">
    <div class="commmess-toper">
        全部投稿请求
    </div>
    <div class="commmess-body">
        <div class="commmess-list">
            <div class="requestlist-area">
                <div class="row">
                    <div class="col-sm-1">
                        <?php echo Html::a('<span class="subject-icon-middle"><i class="icon-upload-alt icon-large"></i></span>', ['default/allsubmissions'], ['class' => 'request-infor']) ?>
                    </div>
                    <div class="col-sm-11">
                        <?php echo Html::a('<span class="subjectname-area">全部未处理请求</span>', ['default/allsubmissions'], ['class' => 'request-infor']) ?>
                    </div>
                </div>
            </div>
        </div>
        <?php 
            foreach ($subjects as $key => $value) {
        ?>
        <div class="commmess-list">
            <div class="requestlist-area">
                <div class="row">
                    <div class="col-sm-1">
                        <?php echo Html::a('<img src="'.'/'.$value['labelimg'].'" class="subject-img-middle">', ['default/untreated', 'id' => $value['id'], 'name' => $value['name']], ['class' => 'request-infor']) ?>
                    </div>
                    <div class="col-sm-11">
                        <?php 
                            if(count($value['includes']) != 0){
                                $subject = '<span class="subjectname-area">'.$value['name'].'</span><span class="badge-byself pull-left">'.count($value['includes']).'</span>';
                            }else{
                                $subject = '<span class="subjectname-area">'.$value['name'].'</span>';
                            }
                        ?>
                        <?php echo Html::a($subject, ['default/untreated', 'id' => $value['id'], 'name' => $value['name'], 'inforsum' => count($value['includes'])], ['class' => 'request-infor']) ?>
                    </div>
                </div>
            </div>
        </div>
        <?php 
            }
        ?>
    </div>
</div>
<script type="text/javascript">
    $('.request-infor')
    .click(function(){
        if($(this).find('.badge-byself').length > 0){
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
            if($('.contri-sum').length > 0){
                var contrisums = $('.contri-sum').text();
                var infors = contrisums - infornumber;
                if(infors <= 0){
                    $('.contri-sum').remove();
                }else{
                    $('.contri-sum').text(infors);
                }
            }
        }
        var url = $(this).prop('href');
        $.ajax({
            url: url,
            type: 'get',
        }).always(function(result){
            $('.sub-content').html(result);
        });

        return false;
    })
</script>
