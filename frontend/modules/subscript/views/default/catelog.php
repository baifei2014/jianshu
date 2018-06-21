<?php 
use yii\helpers\Html;
?>
<?php 
    foreach ($articals as $key => $value) {
?>
<div class="cont-acc">
    <div class="contacc-top">
        <div class="contacctop-left">
            <?php echo Html::a('<img src="'.$value['user']['avatar'].'">', Yii::$app->urlManager->createAbsoluteUrl(['user/home/u', 'id' => $value['user']['id']])) ?>
        </div>
        <div class="contacctop-right">
            <span class="contacctop-name"><?php echo Html::a($value['user']['nickname'], Yii::$app->urlManager->createAbsoluteUrl(['user/home/u', 'id' => $value['user']['id']])) ?></span><span class="contacctop-behavior"><?php echo date('m月d H:i', $value['created_at']); ?></span>
        </div>
    </div>
    <div class="contacc-middle">
        <div class="contbcc-area">
            <div class="contbccmiddle-left">
                <div class="contbccmiddle-top">
                    <?php echo Html::a($value['title'], Yii::$app->urlManager->createAbsoluteUrl(['site/p', 'id' => $value['id']])); ?>
                </div>
                <div class="contbccmiddle-middle">
                    <?php echo $value['summary']; ?>
                </div>
            </div>
            <div class="contbccmiddle-right">
                <img src="<?php echo $value['img']; ?>">
            </div>
        </div>
        <div class="contbccmiddle-bottom">
            <span class="articalinfor-area"><span class="artical-infor"><i class="icon-eye-open"></i>&nbsp;<?php echo $value['articalinfor']['brower']; ?></span><span class="artical-infor"><i class="icon-comments"></i>&nbsp;<?php echo $value['articalinfor']['comment']; ?></span><span class="artical-infor"><i class="icon-heart"></i>&nbsp;<?php echo $value['articalinfor']['like']; ?></span></span>
        </div>
    </div>
</div>
<?php 
    }
?>
