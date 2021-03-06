<?php 
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = '蒋龙豪 - 简书';
?>
<div class="cong-acc">
    <div class="row">
        <div class="col-sm-12">
            <div class="row userindex-lefttop">
                <div class="col-sm-2">
                    <div class="user-img">
                        <?php echo Html::a('<img src="'.'/'.$subject['labelimg'].'" class="user-avatar-big">', Yii::$app->urlManager->createAbsoluteUrl(['subject/default/c', 'id' => $subject['code']])) ?>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="pager-ecc">
                        <span class="fsize22"><?php echo Html::a($subject['name'], Yii::$app->urlManager->createAbsoluteUrl(['subject/default/c', 'id' => $subject['code']])) ?></span>
                        <p>写了111111111字 · 获得55555555喜欢 </p>
                    </div>
                </div>
                <?php ActiveForm::begin(); ?>
                <?php ActiveForm::end(); ?>
                <div class="col-sm-5"> 
                    <div class="row">
                        <div class="col-sm-6">
                        </div>
                        <div class="col-sm-6 focus-area">
                                
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="pager-dcc">
                        <ul class="pager-menu pager-tabs" id="home-menu">
                            <li><?php echo Html::a("<span class='glyphicon glyphicon-list'></span>&nbsp;&nbsp;&nbsp;目录", ['default/catelog', 'keyword' => 'subject_id', 'id' => $subject['id']], ['class' => 'actived']);?></li>
                            <li><?php echo Html::a("<span class='glyphicon glyphicon-comment'></span>&nbsp;&nbsp;&nbsp;按评论数", ['default/comment', 'keyword' => 'subject_id', 'id' => $subject['id']]);?></li>
                            <li><?php echo Html::a("<span class='glyphicon glyphicon-heart'></span>&nbsp;&nbsp;&nbsp;按喜欢数", ['default/seq', 'keyword' => 'subject_id', 'id' => $subject['id']]);?></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="usermain-content">
                <div class="pager-content">
                    
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $.ajax({
        url: '<?php echo '/subscript/default/catelog&keyword='.'subject_id'.'&id='.$subject['id']; ?>',
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
</script>
