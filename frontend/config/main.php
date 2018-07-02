<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/chat' => 'chat/default/index',
            ],
        ],
    ],
    'params' => $params,
    'modules' => [
        'amuse' => [
            'class' => 'frontend\modules\amuse\Module',
        ],
        'sport' => [
            'class' => 'frontend\modules\sport\Module',
        ],
        'cate' => [
            'class' => 'frontend\modules\cate\Module',
        ],
        'user' => [
            'class' => 'frontend\modules\user\Module',
        ],
        'artical' => [
            'class' => 'frontend\modules\artical\Module',
        ],
        'blog' => [
            'class' => 'frontend\modules\blog\Module',
        ],
        'redactor' => 'yii\redactor\RedactorModule',
        'book' => [
            'class' => 'frontend\modules\book\Module',
        ],
        'p' => [
            'class' => 'frontend\modules\p\Module',
        ],
        'nb' => [
            'class' => 'frontend\modules\nb\Module',
        ],
        'subject' => [
            'class' => 'frontend\modules\subject\Module',
        ],
        'subscript' => [
            'class' => 'frontend\modules\subscript\Module',
        ],
        'notification' => [
            'class' => 'frontend\modules\notification\Module',
        ],
        'chat' => [
            'class' => 'frontend\modules\chat\Module',
        ],
    ],
];
