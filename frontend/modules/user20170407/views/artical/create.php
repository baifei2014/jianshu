<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\user\models\Artical */

$this->title = '投稿';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="artical-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
