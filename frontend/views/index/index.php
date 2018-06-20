<?php 
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
<div class="row">
    <div class="col-lg-9">
        <div class="stick-articals">
            <div class="stick-articals-toper">
                <span class="title17weig color6">置顶文章</span>
            </div>
            <div class="stick-articals-content">
                <?php 
                    for ($i=0; $i < count($starartical); $i+=2) { 
                        $lartical = $starartical[$i];
                        $rartical = $starartical[$i+1];
                ?>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="stick-artical-list">
                            <div class="stick-artical-cont2">
                                <?= Html::img('statics/images/cat.jpg', ['alt' => 'My logo', 'class' => 'stick-img']) ?>
                            </div>
                            <div class="stick-artical-cont8">
                                <p class="artical-title">
                                <?php 
                                    echo Html::a($lartical['title'], ['index/detail', 'id' => $lartical['id']], ['title' => $lartical['oldtitle'],'class'=>'title15weig']);
                                ?>
                                </p>
                                <span class="title14weig"><i class="icon-tags color"></i>&nbsp;&nbsp;<?php echo Yii::$app->formatter->asRelativeTime($lartical['created_at']).'（'.Yii::$app->formatter->asDate($lartical['created_at'],'php:m-d').'）'; ?>&nbsp;/&nbsp;&nbsp;<i class="icon-eye-open"></i>&nbsp;&nbsp;361℃</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="stick-artical-list">
                            <div class="stick-artical-cont2">
                                <?= Html::img('statics/images/cat.jpg', ['alt' => 'My logo', 'class' => 'stick-img']) ?>
                            </div>
                            <div class="stick-artical-cont8">
                                <p class="artical-title">
                                <?php 
                                    echo Html::a($rartical['title'], ['index/detail', 'id' => $rartical['id']], ['title' => $rartical['oldtitle'],'class'=>'title15weig']);
                                ?>
                                </p>
                                <span class="title14weig"><i class="icon-tags color"></i>&nbsp;&nbsp;<?php echo Yii::$app->formatter->asRelativeTime($rartical['created_at']).'（'.Yii::$app->formatter->asDate($rartical['created_at'],'php:m-d').'）'; ?>&nbsp;/&nbsp;&nbsp;<i class="icon-eye-open"></i>&nbsp;&nbsp;361℃</span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php 
                    }
                ?>
                
            </div>
        </div>
        <div class="lastest-articals">
            <div class="lastest-articals-toper">
                <span class="title24weig">最新发布</span>
            </div>
            <?php 
                foreach ($artical as $key => $value) {
            ?>
            <div class="lastest-artical-list">
                <div class="lastest-list-toper">
                    <span><i class="icon-book colorred title20weig"></i>&nbsp;&nbsp;&nbsp;
                    <?php 
                        echo Html::a($value['title'], ['index/detail', 'id' => $value['id']], ['title' => $value['oldtitle'], 'class' => 'title20weig last-artical-title']) 
                    ?>
                    </span>
                </div>
                <div class="lastest-artical-content">
                    <div class="last-artical-cont1">
                        <img src="statics/images/cat.jpg" class="last-img">
                    </div>
                    <div class="last-artical-cont2">
                        <p class="title14weig">
                            <span><i class="icon-tags"></i>&nbsp;<?php echo Yii::$app->formatter->asRelativeTime($value['created_at']).'（'.Yii::$app->formatter->asDate($value['created_at'],'php:m-d').'）'; ?></span>&nbsp;&nbsp;/&nbsp;&nbsp;
                            <span class="colorred"><i class="icon-user"></i>&nbsp;<?php echo $value['auther']; ?></span>&nbsp;&nbsp;/&nbsp;&nbsp;
                            <span class="colorred"><i class="icon-folder-open-alt"></i>&nbsp;mac技能</span>&nbsp;&nbsp;/&nbsp;&nbsp;
                            <span class="colorred"><i class="icon-comments-alt"></i>&nbsp;16条评论</span>&nbsp;&nbsp;/&nbsp;&nbsp;
                            <span><i class="icon-eye-open"></i>&nbsp;361℃</span>
                        </p>
                        <p class="last-artical-summary">
                            <span><?php echo $value['summary']; ?></span>
                        </p>
                        <p class="read-artical-more"><?php echo Html::a('Read More', ['index/detail', 'id' => $value['id']], ['class' => 'read-artical-link']);?></p>
                    </div>
                </div>
            </div>
            <?php 
                }
            ?>
            <div class="last-artical-pager">
                <?php 
                    echo LinkPager::widget([
                        'pagination' => $pagination,
                    ]);
                ?>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <?php echo \frontend\widgets\leftpanel\LeftpanelWidget::widget(); ?>
    </div>
</div>
<script src="statics/js/jquery.js"></script>
<script type="text/javascript">
    var height = $(window).height();
    $('body').css("height",height);
    $('.menu-list')
    .mouseenter(function(){
        $('.menu-list a').css("color","#000");
    })
    $('.menu-list')
    .mouseleave(function(){
        $('.menu-list a').css("color","#fff");
    })
</script>
