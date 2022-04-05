<?php

/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

return [
    'request'      => [
        'cookieValidationKey' => 'yL1FydCIbAwf71v9wqUJb7ZSFkn6iIFB',
        'baseUrl'             => '',
    ],
    'db'           => [
        'class'             => 'yii\db\Connection',
        'dsn'               => getenv('DB_DSN'),
        'username'          => getenv('DB_USERNAME'),
        'password'          => getenv('DB_PASSWORD'),
        'charset'           => getenv('DB_CHARSET'),
        'enableSchemaCache' => getenv('DB_SCHEMA_CACHE'),
    ],
    'cache'        => 'yii\caching\FileCache',
    'user'         => [
        'identityClass'   => 'app\modules\user\models\User',
        'accessChecker'   => 'app\modules\user\components\AuthManager',
        'loginUrl'        => ['/user/auth/login'],
        'enableAutoLogin' => true,
        'on afterLogin'   => function()
        {
            Yii::$app->user->identity->touch('last_login_at');
        },
    ],
    'errorHandler' => [
        'errorAction' => 'site/error',
    ],
    'log'          => [
        'traceLevel' => YII_DEBUG ? 3 : 0,
        'targets'    => [
            [
                'class'  => 'yii\log\DbTarget',
                'levels' => ['error'],
            ],
        ],
    ],
    'urlManager'   => [
        'enablePrettyUrl' => true,
        'showScriptName'  => false,
        'rules'           => require __DIR__ . '/urls.php',
    ],
    'formatter'    => [
        'nullDisplay'    => '',
        'datetimeFormat' => 'MM/dd/yyyy HH:mm a',
        'dateFormat'     => 'MM/dd/yyyy',
        'currencyCode'   => 'usd',
    ],
    'assetManager' => [
        'linkAssets' => true,
        'class'      => 'yii\web\AssetManager',
        'bundles'    => [
            'yii\web\JqueryAsset'                 => ['js' => ['jquery.min.js']],
            'extead\autonumeric\AutoNumericAsset' => [
                'depends' => [
                    'yii\web\JqueryAsset',
                    'yii\web\YiiAsset',
                    'yii\bootstrap4\BootstrapAsset',
                ],
            ],
        ],
    
    ],
    /**
     * Storage
     */
    'fsLocal'      => [
        'class' => 'creocoder\flysystem\LocalFilesystem',
        'path'  => '@webroot/upload',
    ],
    'fileStorage'  => [
        'class'               => 'trntv\filekit\Storage',
        'useDirindex'         => true,
        'filesystemComponent' => 'fsLocal',
        'baseUrl'             => '/upload/',
    ],
    
    'cart'                 => [
        'class'  => 'yz\shoppingcart\ShoppingCart',
        'cartId' => 'store',
    ],
    /**
     * Google Auth
     */
    'authClientCollection' => [
        'class'   => 'yii\authclient\Collection',
        'clients' => [
            'google' => [
                'class'        => 'yii\authclient\clients\Google',
                'clientId'     => getenv('GOOGLE_CLIENT_ID'),
                'clientSecret' => getenv('GOOGLE_CLIENT_SECRET'),
            ],
        ],
    ],
    'mailer'               => [
        'class'     => '\yii\symfonymailer\Mailer',
        'transport' => [
            'dsn' => 'smtp://info@its.digits.a2hosted.com:Y2&r{Mdi(I}7@az1-ts9.a2hosting.com:25',
        ],
    ],
    'email'                => [
        'class'     => '\app\modules\email\components\Email',
    ],

];
