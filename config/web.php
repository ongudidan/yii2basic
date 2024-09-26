<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'dashboard' => [
            'class' => 'app\modules\dashboard\dashboard',
        ],
        'student' => [
            'class' => 'app\modules\student\student',
        ],
        'staff' => [
            'class' => 'app\modules\staff\staff',
        ],
        'attendance' => [
            'class' => 'app\modules\attendance\attendance',
        ],
        'class' => [
            'class' => 'app\modules\class\class',
        ],
        'exam' => [
            'class' => 'app\modules\exam\exam',
        ],
        'fees' => [
            'class' => 'app\modules\fees\fees',
        ],
        'library' => [
            'class' => 'app\modules\library\library',
        ],
        'timetable' => [
            'class' => 'app\modules\timetable\timetable',
        ],
        'communication' => [
            'class' => 'app\modules\communication\communication',
        ],
        'transport' => [
            'class' => 'app\modules\transport\transport',
        ],
        'hostel' => [
            'class' => 'app\modules\hostel\hostel',
        ],
        'portal' => [
            'class' => 'app\modules\portal\portal',
        ],
        'inventory' => [
            'class' => 'app\modules\inventory\inventory',
        ],
        'event' => [
            'class' => 'app\modules\event\event',
        ],
        'finance' => [
            'class' => 'app\modules\finance\finance',
        ],
        'parent' => [
            'class' => 'app\modules\parent\parent',
        ],
        'health' => [
            'class' => 'app\modules\health\health',
        ],
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'rtPgQRDW2IBADuJwYQ9OPAHjg-gHbITP',
        ],
        'session' => [
            'class' => 'yii\web\Session',
            'timeout' => 1800, // 30 minutes
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'currencyCode' => 'KES', // Set default currency to Kenyan Shilling
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => false,
            'authTimeout' => 1800, // 30 minutes
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
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
                '/'=> '/dashboard',
                '/dash' => '/dashboard/default/index',
                '/dash/student' => '/dashboard/student/index',
                '/dash/student/create' => '/dashboard/student/create',




            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            // 'defaultRoles' => ['guest']
        ],
        'assetManager' => [
            'appendTimestamp' => true,
            'bundles' => [
                'kartik\form\ActiveFormAsset' => [
                    'bsDependencyEnabled' => false // do not load bootstrap assets for a specific asset bundle
                ],
                'yii\web\JqueryAsset' => [
                    'js' => ["/web/dashboard/assets/js/jquery-3.6.0.min.js"],  // Disable Yii2's default jQuery
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
        'allowedIPs' => ['*', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*', '::1'],
    ];
}

return $config;
