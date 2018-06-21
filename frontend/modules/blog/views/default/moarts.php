<?php 
use yii\helpers\Html;
?>
<div class="wrap">
<div class="blog-default-index">
    <div class="blog-header">
        <h4>蒋龙豪的博客</h4>
    </div>
    <div class="content blog-content">
        <div class="content-left">
            <div class="lastest-area">
                <div class="lastest-area-header title1">
                    <h2><?=Html::a(mb_substr($lastartical->title, 0,20).".....",['default/artical','id' => $lastartical->id],['class' => 'links3'])?></h2>
                </div>
                <div class="lastest-area-content">
                    <h4 class="classify">分类:&nbsp;&nbsp;<a href="##" class="links1">开发者手册</a></h4>
                    <h4 class="last"><?=mb_substr($lastartical->summary, 0, 30) ?></h4>
                    <h4 class="last for-details"><a href="##" class="links2">继续阅读全文<small>>></small></a></h4>
                </div>
                <div class="lastest-area-footer">
                    <h5>Posted By <?=$lastartical->user_name ?> on <?=date('Y年m月d日 H:i',$lastartical->created_at) ?> | 留言（27）</h5>
                </div>
            </div>
            <div class="lastest-lists">
                <div class="lastest-toper">
                    <h4 class="title2">最近的<?=$num?>篇文章</h4>
                </div>
                <div class="lastest-content">
                    <ul>
                        <?php 
                            foreach ($lastarticals as $key => $value) {
                        ?>
                        <li><h4><?=date('Y年m月d日',$value->created_at)?> >> <?=Html::a($value->title,['default/artical','id' => $value->id],['class' => 'title'])?></h4></li>
                        <?php
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="content-right">
            <div class="tabs leave-message">
                <h4 class="caption">最新留言</h4>
                <ul>
                    <li><a href="##">jijsijdijsi</a></li>
                    <li><a href="##">jijsijdijsi</a></li>
                    <li><a href="##">jijsijdijsi</a></li>
                    <li><a href="##">jijsijdijsi</a></li>
                    <li><a href="##">jijsijdijsi</a></li>
                    <li><a href="##">jijsijdijsi</a></li>
                    <li><a href="##">jijsijdijsi</a></li>
                </ul>
            </div>
            <div class="tabs follow-me">
                <h4 class="caption">关注我</h4>
                <ul>
                    <li><a href="##">微信</a></li>
                    <li><a href="##">GitHub</a></li>
                </ul>
            </div>
            <div class="tabs about-me">
                <h4 class="caption">关于</h4>
                <ul>
                    <li><a href="##">个人简介</a></li>
                    <li><a href="##">文章</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
</div>
