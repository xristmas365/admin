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

class CustomAsset extends AssetBundle
{
    
    public $sourcePath = '@app/web/dist/admin';
    
    
    public $css     = [
        'main.css',
    ];
    
    public $js      = [
    ];
}
