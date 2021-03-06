<?php 
use yii\helpers\Html;
?>
<?php 
    foreach ($articals as $key => $value) {
?>
<div class="cont-acc">
    <div class="contacc-top">
        <div class="contacctop-left">
            <img src="<?php echo '/'.$value['user']['avatar']; ?>">
        </div>
        <div class="contacctop-right">
            <span class="contacctop-name"><?php echo $value['user']['nickname']; ?></span><span class="contacctop-behavior"><?php echo date('m月d H:i', $value['artical']['created_at']); ?></span>
        </div>
    </div>
    <div class="contacc-middle">
        <div class="contbcc-area">
            <div class="contbccmiddle-left">
                <div class="contbccmiddle-top">
                    <?php echo $value['artical']['title']; ?>
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
            <span class="articalinfor-area"><span class="artical-infor"><i class="icon-eye-open"></i>&nbsp;<?php echo $value['brower']; ?></span><span class="artical-infor"><i class="icon-comments"></i>&nbsp;<?php echo $value['comment']; ?></span><span class="artical-infor"><i class="icon-heart"></i>&nbsp;<?php echo $value['like']; ?></span></span>
        </div>
    </div>
</div>
<?php 
    }
?>
