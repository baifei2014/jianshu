<?php 
use yii\helpers\Html;
?>
<?php 
    foreach ($userbehavior as $key => $value) {
?>
<div class="cont-acc">
    <div class="contacc-top">
        <div class="contacctop-left">
            <img src="<?php echo $value['user']['avatar']; ?>">
        </div>
        <div class="contacctop-right">
            <span class="contacctop-name"><?php echo $value['user']['nickname']; ?></span><span class="contacctop-behavior"><?php if($value['type'] == 'like'){echo '喜欢了文章';}else if($value['type'] == 'comment'){echo '发表了评论';}else if($value['type'] == 'focus'){if($value['result']['type'] == 'auther'){echo '关注了作者';}else if($value['result']['type'] == 'set'){echo '关注了文集';}else if($value['result']['type']){echo '关注了专题';}} ?> · <?php echo date('m月d H:i', $value['result']['created_at']); ?></span>
        </div>
    </div>
    <div class="contacc-middle">
        <?php if($value['type'] == 'comment'){ ?>
        <div class="contaccmiddle-top">
            <?php if($value['result']['bereplyer']){echo Html::a('@'.$value['result']['bereplyer']['nickname'], ['site/index']).' ';} ?><?php echo $value['result']['comment']; ?>
        </div>
        <div class="contaccmiddle-middle">
            <div class="contaccmiddlemiddle-top">
                <?php echo $value['result']['artical']['title']; ?>
            </div>
            <div class="contaccmiddlemiddle-middle">
                <?php echo $value['result']['artical']['summary']; ?>
            </div>
            <div class="contaccmiddlemiddle-bottom">
                <?php echo Html::a($value['result']['artical']['user']['nickname'], ['site/index'], ['class' => 'auther-name']); ?><span class="articalinfor-area"><span class="artical-infor"><i class="icon-eye-open"></i>&nbsp;<?php echo $value['result']['articalinfor']['brower']; ?></span><span class="artical-infor"><i class="icon-comments"></i>&nbsp;<?php echo $value['result']['articalinfor']['comment']; ?></span><span class="artical-infor"><i class="icon-heart"></i>&nbsp;<?php echo $value['result']['articalinfor']['like']; ?></span></span>
            </div>
        </div>
        <?php 
            }else if($value['type'] == 'like'){
        ?>
        <div class="contbcc-area">
            <div class="contbccmiddle-left">
                <div class="contbccmiddle-top">
                    <?php echo $value['result']['artical']['title']; ?>
                </div>
                <div class="contbccmiddle-middle">
                    <?php echo $value['result']['artical']['summary']; ?>
                </div>
            </div>
            <div class="contbccmiddle-right">
                <img src="<?php echo $value['result']['artical']['img']; ?>">
            </div>
        </div>
        <div class="contbccmiddle-bottom">
            <?php echo Html::a($value['result']['artical']['user']['nickname'], ['site/index'], ['class' => 'auther-name']); ?><span class="articalinfor-area"><span class="artical-infor"><i class="icon-eye-open"></i>&nbsp;<?php echo $value['result']['articalinfor']['brower']; ?></span><span class="artical-infor"><i class="icon-comments"></i>&nbsp;<?php echo $value['result']['articalinfor']['comment']; ?></span><span class="artical-infor"><i class="icon-heart"></i>&nbsp;<?php echo $value['result']['articalinfor']['like']; ?></span></span>
        </div>
        <?php 
            }else if($value['type'] == 'focus'){
        ?>
        <div class="contdcc-area">
        </div>
        <?php 
            }
        ?>
    </div>
</div>
<?php 
    }
?>
