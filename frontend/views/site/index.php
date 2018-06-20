<?php
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = '爱阅';
?>
<div class="site-index">
    <div class="carousel-img">
        <div id="banner_tabs" class="flexslider">
            <ul class="slides">
                <li>
                    <a title="" href="#">
                        <img alt="" style="background: url(/statics/images/banner/1.jpg);" src="/statics/images/banner/1.jpg">
                    </a>
                </li>
                <li>
                    <a title="" href="#">
                        <img alt="" style="background: url(/statics/images/banner/2.jpg);" src="/statics/images/banner/2.jpg">
                    </a>
                </li>
                <li>
                    <a title="" href="#">
                        <img alt="" style="background: url(/statics/images/banner/3.jpg);" src="/statics/images/banner/3.jpg">
                    </a>
                </li>
            </ul>
            <ul class="flex-direction-nav">
                <li><a class="flex-prev" href="javascript:;"><i class="icon-chevron-left"></i></a></li>
                <li><a class="flex-next" href="javascript:;"><i class="icon-chevron-right"></i></a></li>
            </ul>
            <ol id="bannerCtrl" class="flex-control-nav flex-control-paging">
                <li><a>1</a></li>
                <li><a>2</a></li>
                <li><a>2</a></li>
            </ol>
        </div>
    </div>
    <div class="major-content">
        <div class="row">
            <div class="col-lg-8">
                <div class="special-subject">
                    <span><a href=""><img src="/statics/images/subject/cartoon.jpg">&nbsp;&nbsp;&nbsp;漫画·手绘</a></span><span><a href=""><img src="/statics/images/subject/life.jpg">&nbsp;&nbsp;&nbsp;生活家</a></span><span><a href=""><img src="/statics/images/subject/edit.jpg">&nbsp;&nbsp;&nbsp;谈写作</a></span><span><a href=""><img src="/statics/images/subject/tool.jpg">&nbsp;&nbsp;&nbsp;工具癖</a></span><span><a href=""><img src="/statics/images/subject/design.jpg">&nbsp;&nbsp;&nbsp;设计</a></span><span><a href=""><img src="/statics/images/subject/educate.jpg">&nbsp;&nbsp;&nbsp;教育</a></span><span><a href=""><img src="/statics/images/subject/programmer.jpg">&nbsp;&nbsp;&nbsp;程序员</a></span><a href="">更多热门专题</a>
                </div>
                <div class="content-items">
                <?php 
                    foreach ($articals as $key => $value) {
                ?>
                    <div class="content-list">
                        <div class="list-top">
                            <a href=""><img src="<?php echo '/'.$value['user']['avatar'] ?>">&nbsp;&nbsp;&nbsp;<?php echo Html::a($value['user']['nickname'], ['user/home/index', 'id' => $value['user']['id']]); ?></a><span><?php echo Yii::$app->formatter->asRelativeTime($value['created_at']); ?></span>
                        </div>
                        <div class="list-middle">
                            <div class="row">
                                <div class="col-lg-9">
                                    <?php echo Html::a($value['title'], ['site/p', 'id' => $value['id']], ['class' => 'title']); ?>
                                    <p><?php echo $value['summary']; ?></p>
                                </div>
                                <div class="col-lg-3">
                                    <div class="label-img">
                                        <img src="<?php echo '/'.$value['img']; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-bottom">
                            <span><i class="icon-eye-open"></i>&nbsp;<?php echo $value['articalinfor']['brower']; ?></span><span><i class="icon-comments"></i>&nbsp;<?php echo $value['articalinfor']['comment']; ?></span>
                        </div>
                    </div>
                <?php 
                    }
                ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="rainbow-menu">
                    <li><a href="">新上榜&nbsp;&nbsp;<i class="icon-angle-right"></i></a></li>
                    <li><a href="">日报&nbsp;&nbsp;<i class="icon-angle-right"></i></a></li>
                    <li><a href="">7日热门&nbsp;&nbsp;<i class="icon-angle-right"></i></a></li>
                    <li><a href="">30日热门&nbsp;&nbsp;<i class="icon-angle-right"></i></a></li>
                </div>
                <div class="recommend-auther">
                    <div class="recommend-top">
                        推荐作者
                    </div>
                    <div class="recommend-middle">
                        <div class="recommend-list">
                            <div class="recomiddle-left">
                                <a href=""><img src="/statics/images/avatar/robot.jpg"></a>
                            </div>
                            <div class="recomiddle-right">
                                <a href="">蒋龙豪</a>
                                <p>沈万三</p>
                            </div>
                        </div>
                        <div class="recommend-list">
                            <div class="recomiddle-left">
                                <a href=""><img src="/statics/images/avatar/guest.png"></a>
                            </div>
                            <div class="recomiddle-right">
                                <a href="">蒋龙豪</a>
                                <p>沈万三</p>
                            </div>
                        </div>
                        <div class="recommend-list">
                            <div class="recomiddle-left">
                                <a href=""><img src="/statics/images/avatar/robot.jpg"></a>
                            </div>
                            <div class="recomiddle-right">
                                <a href="">蒋龙豪</a>
                                <p>沈万三</p>
                            </div>
                        </div>
                        <div class="recommend-list">
                            <div class="recomiddle-left">
                                <a href=""><img src="/statics/images/avatar/guest.png"></a>
                            </div>
                            <div class="recomiddle-right">
                                <a href="">蒋龙豪</a>
                                <p>沈万三</p>
                            </div>
                        </div>
                        <div class="recommend-list">
                            <div class="recomiddle-left">
                                <a href=""><img src="/statics/images/avatar/robot.jpg"></a>
                            </div>
                            <div class="recomiddle-right">
                                <a href="">蒋龙豪</a>
                                <p>沈万三</p>
                            </div>
                        </div>
                    </div>
                    <div class="recommend-bottom">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/statics/js/jquery.js"></script>
<script type="text/javascript">
$(function() {
    var bannerSlider = new Slider($('#banner_tabs'), {
        time: 5000,
        delay: 400,
        event: 'hover',
        auto: true,
        mode: 'fade',
        controller: $('#bannerCtrl'),
        activeControllerCls: 'active'
    });
    $('#banner_tabs .flex-prev').click(function() {
        bannerSlider.prev()
    });
    $('#banner_tabs .flex-next').click(function() {
        bannerSlider.next()
    });
})
</script>
