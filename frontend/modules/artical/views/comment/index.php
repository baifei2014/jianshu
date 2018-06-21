<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/20 下午9:16
 * description:
 */
use yii\helpers\Html;
?>
<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <?= \Yii::t('app', 'Received reply') ?>
    </div>

    <div class="list-group-item comment media mt0">
    <?php 
    if(empty($dataProvider)){
        echo "目前还没有评论";
    }else{
    foreach ($dataProvider as $value) {
        echo $this->render('_item',['model' => $model,'comment' => $comment,'value' => $value]);
    }
    }
    ?>
    </div>

</div>
    <script>
        $(function(){
            $('.pull-left a')
            .click(function(){
                var a = $('.pull-left a').index(this);
                $('.reply').css('display','none');
                $('.reply').eq(a).css('display','block');
            });
        });
    </script>
