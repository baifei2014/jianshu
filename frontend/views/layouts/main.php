<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\models\User;
use common\models\Infor;
use common\models\Includes;
use common\models\Subjects;

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
<?php 
    if(!Yii::$app->user->isGuest){
        $user = User::find()->where(['id'=>Yii::$app->user->identity->id])->one();
        if(!$user['avatar']){
            $avatarUrl = Yii::$app->params['avatar'];
        }else{
            $avatarUrl = $user['avatar'];
        }
        $infor = Infor::find()->where(['uid' => Yii::$app->user->identity->id])->one();
        $sum = $infor['comments'] + $infor['likes'] + $infor['follows'] + $infor['others'];
        $subjects = Subjects::find()->where(['uid' => Yii::$app->user->identity->id])->all();
        $sids = [];
        foreach ($subjects as $key => $value) {
            $sids[] = $value['id'];
        }
        $includes = Includes::find()->where(['sid' => $sids, 'status' => 3])->all();
        $sum = $sum + count($includes);
    }else{
        $sum = 0;
    }
?>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '爱&nbsp;阅',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-fixed-top navbar-index',
        ],
    ]);
    if(Yii::$app->user->isGUest){
        $leftmenu = [
            ['label' => '主页', 'url' => ['/site/index']],
        ];
    }else{
        $leftmenu = [
            ['label' => '主页', 'url' => ['/site/index']],
            ['label' => '关注', 'url' => ['/subscript/default/index']],
            ['label' => '消息', 'linkOptions' => ['class' => 'notifi-info'], 'url' => ['/notification/default/index']],
            ['label' => '聊天', 'url' => ['/chat/default/index']],
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'encodeLabels' => false,
        'items' => $leftmenu,
    ]);
    if (Yii::$app->user->isGuest) {
        $menuItems[] = [
            'label' => '登录', 
            'url' => ['/site/login'],
            'linkOptions' => ['class' => 'login-nav'],
        ];
        $menuItems[] = [
            'label' => '注册', 
            'url' => ['/site/signup'],
            'linkOptions' => ['class' => 'regist-nav'],
        ];
    } else {
        $menuItems[] = [
            'label' => '<img src="'.'/'.$avatarUrl.'" alt="" class="user-avatar-top">',

            //'label' => '进',
            'linkOptions' => ['class' => 'user-avatar'],
            'items' => [
                ['label' => '<i class="icon-user color-icon"></i>&nbsp;&nbsp;个人主页','url' => ['/user/home/u', 'id' => Yii::$app->user->identity->id],'linkOptions' => ['data-method' => 'post']],
                ['label' => '<i class="icon-bookmark color-icon"></i>&nbsp;&nbsp;收藏的文章','url' => ['/site/collecta'],'linkOptions' => ['data-method' => 'post']],
                ['label' => '<i class="icon-heart color-icon"></i>&nbsp;&nbsp;喜欢的文章','url' => ['/site/likea'],'linkOptions' => ['data-method' => 'post']],
                ['label' => '<i class="icon-cog color-icon"></i>&nbsp;&nbsp;设置','url' => ['/user/setting/basic'],'linkOptions' => ['data-method' => 'post']],
                ['label' => '<i class="icon-signout color-icon"></i>&nbsp;&nbsp;退出','url' => ['/site/logout'],'linkOptions' => ['data-method' => 'post']],
            ],
        ];
    }
    $menuItems[] = [
        'label' => '<i class="icon-pencil"></i>&nbsp;写文章', 
        'url' => ['/book/default/index'],
        'linkOptions' => ['class' => 'post-nav'],
    ];
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'encodeLabels' => false,
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>
<footer class="footer">
    <a href="">关于简书</a>&nbsp;·&nbsp;<a href="">联系我们</a>&nbsp;·&nbsp;<a href="">加入我们</a>&nbsp;·&nbsp;<a href="">作者成书计划</a>&nbsp;·&nbsp;<a href="">帮助中心</a>&nbsp;·&nbsp;<a href="">合作伙伴</a>
    <p>&copy;&nbsp; <?php echo date('Y');?>&nbsp;&nbsp;爱阅博客网站</p>
</footer>

<?php $this->endBody() ?>
</body>
<script type="text/javascript">
    $(function(){
        $('.navbar-right .dropdown')
        .mouseenter(function(){
            $(this).addClass('open');
        })
        $('.navbar-right .dropdown')
        .mouseleave(function(){
            $(this).removeClass('open');
        })
        var isGuest = '<?php echo Yii::$app->user->isGuest ?>';
        if(!isGuest){
            var infors = '<?php echo $sum ?>';
            if(infors != 0){
                $('.notifi-info').html('消息<span class="badge-byself pull-top">'+infors+'</span>');
            }
        }
    })
</script>
</html>
<?php $this->endPage() ?>
