<?php
/**
 * index.php
 *
 * @version    1.0
 * @package    AX project
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

use yii\helpers\VarDumper;

require __DIR__ . '/../vendor/autoload.php';

/**
 * .env Project support
 */
(\Dotenv\Dotenv::createImmutable(__DIR__ . '/..'))->load();

/**
 * Yii Development Environment otherwise Production Environment
 */
if(getenv('APP_ENV') == 'dev') {
    define('YII_DEBUG', true);
    define('YII_ENV', 'dev');
}

/**
 * Base Debug VarDump function
 *
 * @param $var
 */
function dd($var)
{
    VarDumper::dump($var, 5, true);
    die;
}

require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

$app = new yii\web\Application($config);

$app->run();
