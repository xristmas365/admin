<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

$config = [
    'id'         => 'ax',
    'name'       => 'AX Admin',
    'basePath'   => dirname(__DIR__),
    'bootstrap'  => ['log'],
    'modules'    => require __DIR__ . '/modules.php',
    'params'     => require __DIR__ . '/params.php',
    'components' => require __DIR__ . '/components.php',
    'container'  => require __DIR__ . '/container.php',
    'aliases'    => require __DIR__ . '/aliases.php',
];

if(YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];
    
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
