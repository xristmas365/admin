<?php
/**
 * FrontAsset.php
 *
 * @version    1.0
 * @package    AX project
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

namespace app\assets;

use yii\web\AssetBundle;

class FrontAsset extends AssetBundle
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
        FontAwesomeAsset::class,
    ];
    
}
