<?php
/**
 * @link      http://industrialax.com/
 * @email     xristmas365@gmail.com
 * @author    isteil
 * @copyright Copyright (c) 2020 INDUSTRIALAX SOLUTIONS LLC
 * @license   https://industrialax.com/license
 */

$config = [
    'id'         => 'basic',
    'name'       => 'AXbasic',
    'basePath'   => dirname(__DIR__),
    'bootstrap'  => ['log'],
    'modules'    => require __DIR__ . '/modules.php',
    'params'    => require __DIR__ . '/params.php',
    'components' => require __DIR__ . '/components.php',
    'container'  => require __DIR__ . '/container.php',
    'aliases'    => require __DIR__ . '/aliases.php',
];

if(YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        //'allowedIPs' => ['1.2.3.4', '127.0.0.1', '::1', 'localhost:8000'],
    ];
    
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
