<?php 
use yii\helpers\Html;
?>
<?php 
    foreach ($userbehavior as $key => $value) {
?>
<div class="cont-acc">
    <div class="contacc-top">
        <div class="contacctop-left">
            <?php echo Html::a('<img src="'.'/'.$value['user']['avatar'].'">', ['home/u', 'id' => $value['user']['id']]); ?>
        </div>
        <div class="contacctop-right">
            <span class="contacctop-name"><?php echo Html::a($value['user']['nickname'], ['home/u', 'id' => $value['user']['id']]) ?></span><span class="contacctop-behavior"><?php if($value['type'] == 'like'){echo '喜欢了文章';}else if($value['type'] == 'comment'){echo '发表了评论';}else{if($value['result']['type'] == 'auther'){echo '关注了作者';}else if($value['result']['type'] == 'set'){echo '关注了文集';}else if($value['result']['type']){echo '关注了专题';}} ?> · <?php echo date('m月d H:i', $value['result']['created_at']); ?></span>
        </div>
    </div>
    <div class="contacc-middle">
        <?php if($value['type'] == 'comment'){ ?>
        <div class="contaccmiddle-top">
            <?php if($value['result']['bereplyer']){echo Html::a('@'.$value['result']['bereplyer']['nickname'], Yii::$app->urlManager->createAbsoluteUrl(['home/u', 'id' => $value['result']['bereplyer']['id']])).' ';} ?><?php echo $value['result']['comment']; ?>
        </div>
        <div class="contaccmiddle-middle">
            <div class="contaccmiddlemiddle-top">
                <?php echo Html::a($value['result']['artical']['title'], Yii::$app->urlManager->createAbsoluteUrl(['site/p', 'id' => $value['result']['artical']['id']])); ?>
            </div>
            <div class="contaccmiddlemiddle-middle">
                <?php echo $value['result']['artical']['summary']; ?>
            </div>
            <div class="contaccmiddlemiddle-bottom">
                <?php echo Html::a($value['result']['artical']['user']['nickname'], Yii::$app->urlManager->createAbsoluteUrl(['user/home/u', 'id' => $value['result']['artical']['user']['id']]), ['class' => 'auther-name']); ?><span class="articalinfor-area"><span class="artical-infor"><i class="icon-eye-open"></i>&nbsp;<?php echo $value['result']['articalinfor']['brower']; ?></span><span class="artical-infor"><i class="icon-comments"></i>&nbsp;<?php echo $value['result']['articalinfor']['comment']; ?></span><span class="artical-infor"><i class="icon-heart"></i>&nbsp;<?php echo $value['result']['articalinfor']['like']; ?></span></span>
            </div>
        </div>
        <?php 
            }else if($value['type'] == 'like'){
        ?>
        <div class="contbcc-area">
            <div class="contbccmiddle-left">
                <div class="contbccmiddle-top">
                    <?php echo Html::a($value['result']['artical']['title'], Yii::$app->urlManager->createAbsoluteUrl(['site/p', 'id' => $value['result']['artical']['id']])); ?>
                </div>
                <div class="contbccmiddle-middle">
                    <?php echo $value['result']['artical']['summary']; ?>
                </div>
            </div>
            <div class="contbccmiddle-right">
                <img src="<?php echo '/'.$value['result']['artical']['img']; ?>">
            </div>
        </div>
        <div class="contbccmiddle-bottom">
            <?php echo Html::a($value['result']['artical']['user']['nickname'], Yii::$app->urlManager->createAbsoluteUrl(['home/u', 'id' => $value['result']['artical']['user']['id']]), ['class' => 'auther-name']); ?><span class="articalinfor-area"><span class="artical-infor"><i class="icon-eye-open"></i>&nbsp;<?php echo $value['result']['articalinfor']['brower']; ?></span><span class="artical-infor"><i class="icon-comments"></i>&nbsp;<?php echo $value['result']['articalinfor']['comment']; ?></span><span class="artical-infor"><i class="icon-heart"></i>&nbsp;<?php echo $value['result']['articalinfor']['like']; ?></span></span>
        </div>
        <?php 
            }else{
        ?>
        <div class="contdcc-area">
            <div class="row">
                <?php 
                    if($value['result']['type'] === 'subject'){
                ?>
                <div class="col-sm-8">
                    <div class="focususer-infor">
                        <div class="focususerinfor-left">
                            <img src="<?php echo '/'.$value['result']['infor']['labelimg']; ?>" class="focussubject-img-middle">
                        </div>
                        <div class="focususerinfor-right">
                            <span><?php echo Html::a($value['result']['infor']['name'], Yii::$app->urlManager->createAbsoluteUrl(['subject/default/c', 'id' => $value['result']['infor']['code']]), ['class' => 'userfocus-name']); ?></span>
                            <p class="befocus-userinfor"><span><?php echo $value['result']['infor']['maker']['nickname'] ?> 编，</span><span>文章 <?php echo $value['result']['subinfor']['artical'] ?>，</span><span>关注 <?php echo $value['result']['subinfor']['focus'] ?></span></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="opfocus-area">
                        <div class="tabfocus-area">
                        <?php 
                            if(!Yii::$app->user->isGuest){
                            if($value['result']['isfocus']){
                        ?>
                            <span class="focused-btn focus-btn"><i class="icon-ok"></i>&nbsp;已关注</span>
                        <?php 
                            }else{
                        ?>
                            <span class="addfocus-btn focus-btn need-islogin"><i class="icon-plus"></i>&nbsp;关注</span>
                        <?php 
                            }
                            }else{
                        ?>
                        <span class="addfocus-btn focus-btn need-islogin"><i class="icon-plus"></i>&nbsp;关注</span>
                        <?php
                            }
                        ?>
                        </div>
                        <input type="hidden" value="<?php echo $value['result']['infor']['id']; ?>" name="befocus_id">
                        <input type="hidden" value="<?php echo $value['result']['type']; ?>" name="befocus_type">
                    </div>
                </div>
                <?php if($value['result']['infor']['describe']){ ?>
                <div class="col-sm-12">
                    <div class="brief-introduction">
                        <?php echo $value['result']['infor']['describe']; ?>
                    </div>
                </div>
                <?php } ?>
                <?php 
                    }else if($value['result']['type'] === 'set'){
                ?>
                <div class="col-sm-8">
                    <div class="focususer-infor">
                        <div class="focususerinfor-left">
                            <div class="focusset-img-middle">
                                <i class="icon-book icon-2x"></i>
                            </div>
                        </div>
                        <div class="focususerinfor-right">
                            <span><?php echo Html::a($value['result']['infor']['name'], Yii::$app->urlManager->createAbsoluteUrl(['nb/default/index', 'id' => $value['result']['infor']['id']]), ['class' => 'userfocus-name']); ?></span>
                            <p class="befocus-userinfor"><span><?php echo $value['result']['infor']['maker']['nickname'] ?> 编，</span><span>文章 <?php echo $value['result']['setinfor']['artical'] ?>，</span><span>字数 <?php echo $value['result']['setinfor']['words'] ?>，</span><span>关注 <?php echo $value['result']['setinfor']['focus'] ?></span></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="opfocus-area">
                        <div class="tabfocus-area">
                        <?php 
                            if(!Yii::$app->user->isGuest){
                            if($value['result']['isfocus']){
                        ?>
                            <span class="focused-btn focus-btn"><i class="icon-ok"></i>&nbsp;已关注</span>
                            <?php 
                                }else{
                            ?>
                            <span class="addfocus-btn focus-btn need-islogin"><i class="icon-plus"></i>&nbsp;关注</span>
                        <?php 
                            }
                            }else{
                        ?>
                        <span class="addfocus-btn focus-btn need-islogin"><i class="icon-plus"></i>&nbsp;关注</span>
                        <?php
                            }
                        ?>
                        </div>
                        <input type="hidden" value="<?php echo $value['result']['infor']['id']; ?>" name="befocus_id">
                        <input type="hidden" value="<?php echo $value['result']['type']; ?>" name="befocus_type">
                    </div>
                </div>
                <?php 
                    }else if($value['result']['type'] === 'auther'){
                ?>
                <div class="col-sm-8">
                    <div class="focususer-infor">
                        <div class="focususerinfor-left">
                            <?php echo Html::a('<img src="'.'/'.$value['result']['infor']['avatar'].'" class="focussubject-img-middle">', ['home/u', 'id' => $value['result']['infor']['id']]); ?>
                        </div>
                        <div class="focususerinfor-right">
                            <span><?php echo Html::a($value['result']['infor']['nickname'], ['home/u', 'id' => $value['result']['infor']['id']], ['class' => 'userfocus-name']); ?></span>
                            <p class="befocus-userinfor"><span>关注 <?php echo $value['result']['uexinfor']['focus'] ?>，</span><span>粉丝 <?php echo $value['result']['uexinfor']['fans'] ?>，</span><span>文章 <?php echo $value['result']['uexinfor']['artical'] ?></span></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="opfocus-area">
                        <div class="tabfocus-area">
                        <?php 
                            if(!Yii::$app->user->isGuest){
                            if($value['result']['infor']['id'] != Yii::$app->user->identity->id){
                                if($value['result']['isfocus']){
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
                        <input type="hidden" value="<?php echo $value['result']['infor']['id']; ?>" name="befocus_id">
                        <input type="hidden" value="<?php echo $value['result']['type']; ?>" name="befocus_type">
                    </div>
                </div>
                <?php if($value['result']['infor']['userinfor']['summary']){ ?>
                <div class="col-sm-12">
                    <div class="brief-introduction">
                        <?php echo preg_replace('/<br>/', '&nbsp;&nbsp;', $value['result']['infor']['userinfor']['summary']); ?>
                    </div>
                </div>
                <?php } ?>
                <?php
                    }
                ?>
                </div>
        </div>
        <?php 
            }
        ?>
    </div>
</div>
<?php 
    }
?>
