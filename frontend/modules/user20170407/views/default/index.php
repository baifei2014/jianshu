<?php

use common\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;
use yii\widgets\ListView;
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/4/7
 * Time: 下午6:13
 */
$this->title = '个人中心';
?>
<div class="row">
    <div class="col-lg-9">
        <div class="panel-area">
            <div class="col-lg-2">
                <?= \hyii2\avatar\AvatarWidget::widget(['imageUrl'=>'statics/images/avatar/avatar_1.jpg']); ?>
            </div>
            <div class="col-lg-10">
                <?= Html::a(Yii::$app->user->identity->username,['/user/default'])  ?>
                <li><?= Html::a('填写居住地',['/user/default'])  ?></li>
                <li><?= Html::a('填写工作信息',['/user/default'])  ?></li>
                <li><?= Html::a('填写教育信息',['/user/default'])  ?></li>
                <li><?= Html::a('查看详细资料',['/user/default'])  ?></li>
                <li><?= Html::a('填写个人简介',['/user/default'])  ?></li>
            </div>
            <div class="panel-next">
            <div class="col-lg-10">
                
            </div>
            <div class="col-lg-2">
                <?= Html::a(Yii::$app->user->identity->username,['/user/default'])  ?>
            </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        222
    </div>
</div>
