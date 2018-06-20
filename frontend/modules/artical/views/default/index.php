<?php

/* @var $this yii\web\View */
use yii\widgets\LinkPager;
use yii\helpers\Html;
use frontend\assets\AppAsset;

AppAsset::register($this);
AppAsset::addCss($this,Yii::$app->request->baseUrl."/statics/css/main.css");

$this->title = '博客网';
?>
<div class="col-lg-9">
<?= \frontend\widgets\artical\ArticalWidget::widget() ?>
</div>
<div class="col-lg-3">
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

