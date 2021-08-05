<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\modules\user\assets;

use yii\web\AssetBundle;
use app\assets\FontAwesomeAsset;
use yii\bootstrap4\BootstrapAsset;

class AuthAsset extends AssetBundle
{
    
    public $baseUrl = '@web/dist/auth';
    
    public $css     = [
        'css/auth.css',
    ];
    
    public $depends = [
        BootstrapAsset::class,
        FontAwesomeAsset::class
    ];
    
}
