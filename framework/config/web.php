<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

//$dbhost = 'mysql:host=127.0.0.1;';
$dbhost = $params['data_ctrl']['dbhost'];
$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'timeZone' => 'Asia/Bangkok',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'IP_zstcYT6LrNZ7AsUzf_8Zz5Xt_EtX1',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'enableSession' => true,
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
        ],/*
        'user'=> [
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'class' => 'app\components\CustomWebUser',
        ],*/
        #'db' => $db,
        'dbdpis' => [
            'class' => 'yii\db\Connection',
            'dsn' => $params['data_ctrl']['dbhostdpis'],
            'username' => 'DPIS',
            'password' => 'APP@dpis',
            'attributes' => [
                PDO::ATTR_TIMEOUT => 100000, // timeout value in seconds
            ]
        ],
        'dbdpisemp' => [
            'class' => 'yii\db\Connection',
            'dsn' => $params['data_ctrl']['dbhostdpis'],
            'username' => 'DPISEMP1',
            'password' => 'APP@dpisemp1',
            'attributes' => [
                PDO::ATTR_TIMEOUT => 100000, // timeout value in seconds
            ]
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => $dbhost . 'dbname=dpis6agent',
            'username' => 'appdpis',
            'password' => 'APP@dpis',
            'charset' => 'utf8',
        ],
        'logdb' => [
            'class' => 'yii\db\Connection',
            'dsn' => $dbhost . 'dbname=dpis6agent_log',
            'username' => 'appdpis',
            'password' => 'APP@dpis',
            'charset' => 'utf8',
        ],
        'rptdb' => [
            'class' => 'yii\db\Connection',
            'dsn' => $dbhost . 'dbname=ssoline_report',
            'username' => 'appdpis',
            'password' => 'APP@dpis',
            'charset' => 'utf8',
        ],
        'dynamicdb' => [
            'class' => 'yii\db\Connection',
            /*'connectionString' => 'mysql:host=172.16.19.176;dbname=itr_log_db', */
            'dsn' => $dbhost . 'dbname=ssoline',
            'username' => 'appdpis',
            'password' => 'APP@dpis',
            'charset' => 'utf8',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<action>' => 'site/<action>',
                '<controller:[\w\-]+>/<id:\d+>' => '<controller>/view',
                '<controller:[\w\-]+>/<action:[\w\-]+>/<id:\d+>' => '<controller>/<action>',
                '<controller:[\w\-]+>/<action:[\w\-]+' => '<controller>/<action>',
            ],
        ],

        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'rules' => [
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
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
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
