<?php 
use yii\helpers\Html;
?>
<div class="wraps">
<div class="blog-default-artical">
    <div class="blog-header">
        <h4>蒋龙豪的博客<small>&nbsp;>>&nbsp;</small><?=Html::a('首页',['default/index'],['class' => 'bread links1'])?><small>&nbsp;>>&nbsp;</small><a href="##" class="bread links1">档案</a></h4>
    </div>
    <div class="content artical-content">
        <div class="banner">
            <h4 style="float: left;">分类:&nbsp;<a href="##" class="links2">开发者手册</a></h4>
            <h4 style="float: right;">上一篇:&nbsp;<?=Html::a(mb_substr($preartical->title, 0,15),['default/artical','id' => $preartical->id],['class' => 'links2','title'=>$preartical->title]) ?></h4>
        </div>
        <div class="detail-artical">
            <div class="detail-area-header title1">
                <h2><?=$artical->title?></h2>
            </div>
            <div class="detail-area-content content2">
                <div class="author-infor">
                    <h4 class="infor">作者:&nbsp;&nbsp;<?=$artical->user_name ?></h4>
                    <h4 class="infor">日期:&nbsp;&nbsp;<?=date('Y年m月d日',$artical->created_at) ?></h4>
                </div>
                <div class="complete-artical">
                <?=$artical->content?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
