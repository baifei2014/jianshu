<?php 
use yii\helpers\Html;
?>
<?php 
    foreach ($fans as $key => $value) {
?>
<div class="focus-user">
    <div class="row">
        <div class="col-sm-8">
            <div class="focususer-infor">
                <div class="focususerinfor-left">
                    <?php echo Html::a('<img src="'.'/'.$value['userfans']['avatar'].'" class="useravatar-square-small">', ['home/u', 'id' => $value['userfans']['id']]) ?>
                </div>
                <div class="focususerinfor-right">
                    <span><?php echo Html::a($value['userfans']['nickname'], ['home/u', 'id' => $value['userfans']['id']], ['class' => 'userfocus-name']); ?></span>
                    <p class="befocus-userinfor"><span>关注 <?php echo $value['userioinfor']['focus']; ?>，</span><span>粉丝 <?php echo $value['userioinfor']['fans']; ?>，</span><span>文章 <?php echo $value['userioinfor']['artical']; ?></span></p>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="opfocus-area">
                <div class="tabfocus-area">
                    <?php 
                        if(!Yii::$app->user->isGuest){
                            if($value['userfans']['id'] != Yii::$app->user->identity->id){
                                if($value['isfocus']){
                    ?>
                    <span class="focused-btn focus-btn"><i class="icon-ok"></i>&nbsp;已关注</span>
                                <?php 
                                    }else{
                                ?>
                    <span class="addfocus-btn focus-btn need-islogin"><i class="icon-plus"></i>&nbsp;关注</span>
                    <?php 
                                }
                            }
                        }else{
                    ?>
                    <span class="addfocus-btn focus-btn need-islogin"><i class="icon-plus"></i>&nbsp;关注</span>
                    <?php
                        }
                    ?>
                </div>
                <input type="hidden" value="<?php echo $value['userfans']['id']; ?>" name="befocus_id">
                <input type="hidden" value="auther" name="befocus_type">
            </div>
        </div>
    </div>
</div>
<?php
    }
?>

