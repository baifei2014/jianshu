<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;

use frontend\assets\AppAsset;

AppAsset::register($this);
AppAsset::addCss($this,Yii::$app->request->baseUrl."/css/main.css");
AppAsset::addJs($this,Yii::$app->request->baseUrl."/js/jquery-1.9.1.js");
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
                            ['/artical/default/index', 'node' => '222'],
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
                'comment',
                ['model' => $model,'dataProvider' => $dataProvider]) ?>
            <?= $this->render(
            'create',
            ['model' => $comment, 'post' => $model]
        ) ?>
</div>
</div>
