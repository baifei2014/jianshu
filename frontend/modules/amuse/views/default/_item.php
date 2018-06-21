<?php 
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;
?>
<li>
<div class="media-heading">
        <div class="media-title">
            <?= Html::a($model->title,
                ['/topic/default/view', 'id' => $model->id], ['title' => $model->title]
            ); ?><?php echo '['.$model->type.']' ?>
        </div>
        <div class="media-content">
        <?= mb_substr(strip_tags(HtmlPurifier::process(Markdown::process($model->content,'extra'))),0,110,'utf8').'......' ?>
        </div>
        <?= Html::a($model->created_by, ['/user/default/show', 'username' => $model->created_by]) ?>
        于 <?= Html::tag('abbr', Yii::$app->formatter->asRelativeTime($model->created_at), ['title' => Yii::$app->formatter->asDatetime($model->created_at)]) ?>
                        发布

</div>
</li>
