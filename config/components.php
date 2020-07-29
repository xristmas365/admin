<?php

/**
 *  PHP version 7.3
 *
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @package    AX project
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @version    1.0
 * @link       https://github.com/xristmas365/basic
 * @since      File available since v1.0
 */

return [
    'request'              => [
        'cookieValidationKey' => 'yL1FydCIbAwf71v9wqUJb7ZSFkn6iIFB',
        'baseUrl'             => '',
    ],
    'db'                   => [
        'class'             => 'yii\db\Connection',
        'dsn'               => getenv('DB_DSN'),
        'username'          => getenv('DB_USERNAME'),
        'password'          => getenv('DB_PASSWORD'),
        'charset'           => getenv('DB_CHARSET'),
        'enableSchemaCache' => getenv('DB_SCHEMA_CACHE'),
    ],
    'cache'                => 'yii\caching\FileCache',
    'user'                 => [
        'identityClass' => 'app\modules\user\models\User',
        'accessChecker' => 'app\modules\user\components\AuthManager',
        'loginUrl'      => ['/user/auth/login'],
        'on afterLogin' => function()
        {
            Yii::$app->user->identity->touch('last_login_at');
        },
    ],
    'errorHandler'         => [
        'errorAction' => 'site/error',
    ],
    'log'                  => [
        'traceLevel' => YII_DEBUG ? 3 : 0,
        'targets'    => [
            [
                'class'  => 'yii\log\DbTarget',
                'levels' => ['error'],
            ],
        ],
    ],
    'urlManager'           => [
        'enablePrettyUrl' => true,
        'showScriptName'  => false,
        'rules'           => require __DIR__ . '/urls.php',
    ],
    'formatter'            => [
        'nullDisplay'    => '',
        'datetimeFormat' => 'MM/dd/yyyy HH:mm a',
        'dateFormat'     => 'MM/dd/yyyy',
        'currencyCode'   => 'usd',
    ],
    'assetManager'         => [
        'linkAssets' => true,
        'class'      => 'yii\web\AssetManager',
        'bundles'    => [
            'yii\web\JqueryAsset'                 => ['js' => ['jquery.min.js']],
            'yii\bootstrap4\BootstrapAsset'       => ['css' => ['css/bootstrap.min.css']],
            'yii\bootstrap4\BootstrapPluginAsset' => ['js' => ['js/bootstrap.bundle.min.js']],
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
    'fsLocal'              => [
        'class' => 'creocoder\flysystem\LocalFilesystem',
        'path'  => '@webroot/upload',
    ],
    'fileStorage'          => [
        'class'               => 'trntv\filekit\Storage',
        'filesystemComponent' => 'fsLocal',
        'baseUrl'             => '/upload/',
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

];
