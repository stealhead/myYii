<?php
Yii::setAlias('api', dirname(__DIR__));
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$config = [
    'id' => 'api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'app\api\controller',
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'LmO_gHjefWJZL_NJbccFgheFY63FjsOY',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => false,
            'enableSession' =>false,
            'loginUrl' => null
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'pattern' => 'index',
                    'route' => 'site/index',
                    'verb' => 'GET'
                ],
                [
                    'pattern' => 'swoole',
                    'route' => 'site/swoole',
                    'verb' => 'GET'
                ],
                [
                    'pattern' => 'import',
                    'route' => 'site/import',
                    'verb' => 'GET'
                ],
                [
                    'pattern' => 'import-params',
                    'route' => 'site/import-params',
                    'verb' => 'GET'
                ],
                [
                    'pattern' => 'logout',
                    'route' => 'site/logout',
                    'verb' => 'POST'
                ],
                [
                    'pattern' => 'login',
                    'route' => 'site/login',
                    'verb' => 'POST'
                ],
                [
                    'pattern' => 'hello',
                    'route' => 'site/hello',
                    'verb' => 'GET'
                ],
                [
                    'pattern' => 'errors',
                    'route' => 'site/errors',
                    'verb' => 'GET'
                ],
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
