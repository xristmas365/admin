<?php
/**
 * FrontAsset.php
 *
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @package    AX project
 * @version    1.0
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

namespace app\assets;

use yii\web\AssetBundle;
use yii\bootstrap4\BootstrapPluginAsset;

class AppAsset extends AssetBundle
{
    
    public $sourcePath = '@app/web/dist/app';
    
    public $css        = [
        'bootstrap.css',
        'app.css',
    ];
    
    public $js         = [
        'app.js',
    ];
    
    public $depends    = [
        BootstrapPluginAsset::class,
        FontAwesomeAsset::class,
    ];
    
}
