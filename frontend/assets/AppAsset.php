<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'statics/css/site.css',
        'statics/css/sites.css',
        'statics/css/main.css',
        'statics/css/home.css',
        'statics/css/views.css',
        'statics/css/search.css',
        'statics/css/form.css',
        'statics/css/setting.css',
        'statics/css/carousel.css',
        'statics/css/user.css',
        'statics/css/subject.css',
        'statics/css/subscript.css',
        'statics/css/notification.css',
        'statics/css/chat.css',
        'statics/css/font/font-css/font-awesome.css',
        'statics/css/comment.css',
        'statics/css/bootstrap-c.css',
    ];
    public $js = [
        'js/jquery.js',
        'statics/js/slider.js',
        'js/focus.js',
        'js/tab.js',
        'js/partical.js',
        'js/comment.js',
        'js/pager.js',
        'js/reply.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    public static function addCss($view, $cssfile) {  
        $view->registerCssFile($cssfile, [AppAsset::className(), "depends" => "frontend\assets\AppAsset"]);  
    } 
    public static function addJs($view, $jsfile) {  
        $view->registerJsFile($jsfile, [AppAsset::className(), "depends" => "frontend\assets\AppAsset"]);  
    }
    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];
}
