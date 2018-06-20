<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = '您要找的页面不存在 - 简书';
?>
<div class="site-error">

    <img src="statics/images/error.jpg" class="error-notfound-img">

    <h3 class="error-name">您要找的页面不存在</h3>

    <p class="error-message">可能是因为您的链接地址有误、该文章已经被作者删除或转为私密状态。</p>

    <p class="back-index"><?php echo Html::a('返回「爱阅」首页', ['site/index'])?></p>
</div>
