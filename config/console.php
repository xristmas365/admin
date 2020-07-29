<?php

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
                '@app/modules/user/migrations',
                '@app/modules/page/migrations',
                '@app/modules/store/migrations',
                '@yii/log/migrations/',
            ],
        ],
    ],

];

return $config;
