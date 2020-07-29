<?php
/**
 * FontAwesomeAsset.php
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

class FontAwesomeAsset extends AssetBundle
{
    
    public $sourcePath = '@vendor/fortawesome/font-awesome';
    
    public $css        = [
        'css/all.min.css',
    ];
    
}
