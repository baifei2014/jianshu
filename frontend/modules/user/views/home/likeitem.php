<?php 
use yii\helpers\Html;
?>
<?php 
    foreach ($articals as $key => $value) {
?>
<div class="cont-acc">
    <div class="contacc-top">
        <div class="contacctop-left">
            <?php echo Html::a('<img src="'.'/'.$value['auther']['avatar'].'">', ['home/u', 'id' => $value['auther']['id']]) ?>
        </div>
        <div class="contacctop-right">
            <span class="contacctop-name"><?php echo Html::a($value['auther']['nickname'], ['home/u', 'id' => $value['auther']['id']]) ?></span><span class="contacctop-behavior"><?php echo date('m月d H:i', $value['artical']['created_at']); ?></span>
        </div>
    </div>
    <div class="contacc-middle">
        <div class="contbcc-area">
            <div class="contbccmiddle-left">
                <div class="contbccmiddle-top">
                    <?php echo Html::a($value['artical']['title'], Yii::$app->urlManager->createAbsoluteUrl(['site/p', 'id' => $value['artical']['id']])) ?>
                </div>
                <div class="contbccmiddle-middle">
                    <?php echo $value['artical']['summary']; ?>
                </div>
            </div>
            <div class="contbccmiddle-right">
                <img src="<?php echo '/'.$value['artical']['img']; ?>">
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
