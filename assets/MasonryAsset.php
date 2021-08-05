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

class MasonryAsset extends AssetBundle
{
    
    public $baseUrl = '@web/dist/masonry';
    
    public $js      = [
        'masonry.min.js',
    ];
    
    public $depends = [
        AppAsset::class,
    ];
    
}
