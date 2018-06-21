<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\behaviors\TagBehavior;
/* @var $this yii\web\View */
/* @var $model frontend\modules\user\models\Artical */
/* @var $form yii\widgets\ActiveForm */
$this->title = '小贴士';
?>

<div class="config-form">
    <?php $form = ActiveForm::begin(); ?>

    <div class="col-lg-9">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'type')->dropDownList(['Yii2'=>'Yii2','Git'=>'Git','Javascript'=>'Javascript']) ?>
        <?= $form->field($model, 'content')->widget(\yii\redactor\widgets\Redactor::className(),
        [
            'clientOptions' => [
                'imageManagerJson' => ['/redactor/upload/image-json'],
                'imageUpload' => ['/redactor/upload/image'],
                'fileUpload' => ['/redactor/upload/file'],
                'lang' => 'zh_cn',
                'plugins' => ['clips', 'fontcolor','imagemanager'],
            ]
        ]) ?>
            <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
       </div>
        <?php ActiveForm::end(); ?>
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

</div>
