<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\modules\store\assets;

use yii\web\AssetBundle;
use yii\bootstrap4\BootstrapAsset;
use yii\bootstrap4\BootstrapPluginAsset;

class CartAsset extends AssetBundle
{
    
    public $baseUrl = '@web/dist/cart';
    
    public $css     = [
        'css/sidebar.min.css',
        'css/cart.css',
    ];
    
    public $js      = [
        'js/sidebar.min.js',
        'js/cart.js',
    ];
    
    public $depends = [
        BootstrapAsset::class,
        BootstrapPluginAsset::class,
    ];
    
}
