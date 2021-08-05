<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\modules\admin\assets;

use yii\web\AssetBundle;
use yii\bootstrap4\BootstrapPluginAsset;

class DashAsset extends AssetBundle
{
    
    public $sourcePath = '@app/resources/admin/dist';
    
    
    public $css     = [
        'dashforge.css',
        'tagsinput.css',
        'dashforge2.css',
        'ionicons/css/ionicons.min.css',
    ];
    
    public $js      = [
        'feather-icons/feather.min.js',
        'perfect-scrollbar.min.js',
        'dashforge.js',
        'dashforge.aside.js',
        'tagsinput.js',
        'typehead.js',
        'admin.js',
    ];
    
    public $depends = [
        BootstrapPluginAsset::class,
    ];
}
