<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\models\UserExtend;
use yii\bootstrap\ActiveForm;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
    <div class="form-wrap">
        <div class="form-toper">
            <?php
                NavBar::begin([
                    'brandLabel' => '爱&nbsp;阅',
                    'brandUrl' => Yii::$app->homeUrl,
                    'options' => [
                        'class' => 'navbar-default',
                    ],
                ]);
                $leftmenu = [
                    ['label' => '每天十分钟，看些有意思的', 'url' => ['/site/index']],
                ];
                echo Nav::widget([
                    'options' => ['class' => 'navbar-nav navbar-left'],
                    'items' => $leftmenu,
                ]);
                NavBar::end();
            ?>
        </div>
        <div class="main-content">
            <div class="form-area">
                <div class="form-menu">
                    <?=Html::a('登录', ['site/login']);?><?= Html::a('注册',['site/signup'], ['class' => 'actived']);?>
                </div>
                <div class="form-content">
                    <?php 
                        $form = ActiveForm::begin();
                    ?>
                    <?= $form->field($model, 'nickname', ['inputTemplate' => '<div class="input-area"><span class="input-icon"><span class="glyphicon glyphicon-user"></span></span>{input}</div>',])->textInput(['placeholder' => '请输入您的昵称', 'class' => 'form-control'])->label(false);?>
                    <?= $form->field($model, 'email', ['inputTemplate' => '<div class="input-area"><span class="input-icon"><span class="glyphicon glyphicon-user"></span></span>{input}</div>',])->textInput(['placeholder' => '请输入您的账号邮箱', 'class' => 'form-control'])->label(false);?>
                    <?= $form->field($model,'password', ['inputTemplate' => '<div class="input-area"><span class="input-icon"><span class="glyphicon glyphicon-lock"></span></span>{input}</div>',])->passwordInput(['placeholder' => '请输入您的密码', 'class' => 'form-control'])->label(false);?>
                    <?= Html::submitButton('注册', ['class' => 'btn btn-signup']); ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        <div class="form-footer">
            <div class="container">
                <p>&copy;&nbsp;Copyright&nbsp;<?php echo date('Y');?>&nbsp;likecho.com, All Rights Reserved
            </div>
        </div>
    </div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
