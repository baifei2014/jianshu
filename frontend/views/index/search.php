<?php 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="row">
    <div class="col-lg-9">
        <div class="search-result-toper">
            <p class="title20weig">关于&nbsp;“<span class="colorred"><?php echo $keyword; ?></span>”&nbsp;的搜索结果</p>
            <p class="title16">共为您找到 <?php echo count($data);?> 篇相关文章</p>
        </div>
        <div class="search-result-area">
        <?php 
            $form = ActiveForm::begin([
                    'action' => [
                        'index/search',
                    ],
                ]);
            echo $form->field($model, 'keyword')->textInput(['class' => 'search-form-big', 'placeholder' => '请输入关键词搜索'])->label(false); 
            ActiveForm::end();
        ?>
        </div>
        <div class="lastest-articals">
        <?php 
            if(count($data) === 0){
        ?>
            <span class="title16weig">空空如也，换个搜索词试试</span>
        <?php 
            }else{
        ?>
        <?php 
            foreach ($data as $key => $value) {
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
            }
        ?>
        </div>
    </div>
    <div class="col-lg-3">
        <?php echo \frontend\widgets\leftpanel\LeftpanelWidget::widget(); ?>
    </div>
</div>
<script type="text/javascript">
    $('.artical-search-btn')
    .click(function(){
        var keyword = $('.artical-search-form').val();
        if(keyword === ''){
            return false;
        }
    })
</script>
