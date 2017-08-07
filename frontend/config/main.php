<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
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
        //默认路由
        'defaultRoute'=>'goods/category-goods',
        'user' => [
            'loginUrl'=>['member/login'],
            'identityClass' => 'frontend\models\Member',
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
            //'suffix' => '.html',	// 伪静态后缀
            'rules' => [
            ],
        ],
        'sms'=>[
            'class'=>\frontend\components\AliyunSms::className(),
            'accessKeyId'=>'LTAIruYIqy1lWmZ3',
            'accessKeySecret'=>'9abinkzPCypamgSuDzi7ciQMPWlmiY',
            'signName'=>'正品火锅',
            'templateCode'=>'SMS_80185053'
        ]

    ],
    'params' => $params,
];
