<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\assets;

use yii\web\AssetBundle;
use yii\bootstrap4\BootstrapPluginAsset;

class AppAsset extends AssetBundle
{
    
    public $sourcePath = '@app/web/dist/app';
    
    public $css        = [
        //'app.css',
    ];
    
    public $js         = [
        'app.js',
    ];
    
    public $depends    = [
        BootstrapPluginAsset::class,
        FontAwesomeAsset::class,
    ];
    
}
