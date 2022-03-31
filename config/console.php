<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

$config = [
    'id'                  => 'basic',
    'name'                => 'AX Project',
    'basePath'            => dirname(__DIR__),
    'controllerNamespace' => 'app\commands',
    'components'          => [
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\DbTarget',
                    'levels' => ['error'],
                ],
            ],
        ],
        'db'  => [
            'class'             => 'yii\db\Connection',
            'dsn'               => getenv('DB_DSN'),
            'username'          => getenv('DB_USERNAME'),
            'password'          => getenv('DB_PASSWORD'),
            'charset'           => getenv('DB_CHARSET'),
            'enableSchemaCache' => getenv('APP_ENV') === 'prod',
        ],
    ],
    'controllerMap'       => [
        'migrate' => [
            'class'         => 'yii\console\controllers\MigrateController',
            'migrationPath' => [
                '@app/migrations',
                '@app/modules/storage/migrations',
                '@app/modules/file/migrations',
                '@app/modules/admin/migrations',
                '@app/modules/user/migrations',
                '@app/modules/page/migrations',
                '@app/modules/store/migrations',
                '@app/modules/article/migrations',
                '@app/modules/system/migrations',
                '@app/modules/warehouse/migrations',
                '@app/modules/email/migrations',
                '@yii/log/migrations/',
            ],
        ],
    ],

];

return $config;
