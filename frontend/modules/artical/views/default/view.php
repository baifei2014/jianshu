<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;

/* @var $this yii\web\View */
/* @var $model common\Models\Post */
/* @var $donate array|\frontend\modules\user\models\Donate */

$this->title = $model['title'];

?>

    <div class="col-md-9 topic-view" contenteditable="false" style="">
        <div class="panel panel-default">
            <div class="panel-heading media clearfix">
                <div class="media-body">
                    <?= Html::tag('h4', Html::encode($model['title'])); ?>
                    <div class="info">
                        <?= Html::a(
                            $model['type'],
                            ['/topic/default/index', 'node' => '222'],
                            ['class' => 'node']
                        ) ?>
                        ·
                        <?= Html::a($model['created_by'], ['/user/default/show', 'username' => $model['created_by']]) ?>
                        ·
                        于 <?= Html::tag('abbr', Yii::$app->formatter->asRelativeTime($model['created_at']), ['title' => Yii::$app->formatter->asDatetime($model['created_at'])]) ?>
                        发布
                        ·
                        2次阅读
                    </div>
                </div>
            </div>
            <div class="panel-body article">
                <?= HtmlPurifier::process(Markdown::process($model['content'], 'gfm')) ?>
            </div>
            <div class="panel-footer clearfix opts">
            11111
            </div>
        </div>
            <?= $this->render(
                '@frontend/modules/artical/views/comment/index',
                ['model' => $model,'comment' => $comment,'dataProvider' => $dataProvider]) ?>
            <?= $this->render(
            '@frontend/modules/artical/views/comment/create',
            ['model' => $comment, 'post' => $model]
        ) ?>
</div>
<div class="col-md-3 topic-view">
<div class="panel">
            <a href="#" class="list-group-item active">免费域名注册</a>
            <a href="#" class="list-group-item">24*7 支持</a>
            <a href="#" class="list-group-item">免费 Window 空间托管<span class="badge">新</span></a>
            <a href="#" class="list-group-item">图像的数量</a>
            <a href="#" class="list-group-item">每年更新成本</a>
</div>
<div class="panel panel-default">
            <div class="panel-heading clearfix">
                <?= $this->title ?>
            </div>
            <div class="panel-body side-bar">
            <ul class="list">
                <?php
                $models = ['哈哈' => '123','嘻嘻' => '234'];
                    foreach ($models as $key => $value) {
                    echo Html::tag('li', Html::a(Html::encode($key), $value));
                }
                ?>
            </ul>
            </div>
</div>
</div>
