<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\modules\admin\widgets\grid;

use yii\helpers\Html;
use yii\base\InvalidConfigException;

class ActionColumn extends \kartik\grid\ActionColumn
{
    
    public $template       = '{update}{delete}';
    
    public $contentOptions = [
        'class' => 'actions',
    ];
    
    public $deleteOptions  = [
        'class' => 'text-danger grid-delete-btn',
    ];
    
    /**
     * Sets a default button configuration based on the button name (bit different than [[initDefaultButton]] method)
     *
     * @param string $name button name as written in the [[template]]
     * @param string $title the title of the button
     * @param string $icon the meaningful glyphicon suffix name for the button
     * @throws InvalidConfigException
     */
    protected function setDefaultButton($name, $title, $icon)
    {
        $isBs4 = $this->grid->isBs4();
        if (isset($this->buttons[$name])) {
            return;
        }
        $this->buttons[$name] = function ($url) use ($name, $title, $icon, $isBs4) {
            $opts = "{$name}Options";
            $options = ['title' => $title, 'aria-label' => $title, 'data-pjax' => '0'];
            $options = array_replace_recursive($options, $this->buttonOptions, $this->$opts);
            $label = $this->renderLabel($options, $title, ['class' => $this->grid->getDefaultIconPrefix() . $icon, 'aria-hidden' => 'true']);
            $link = Html::a($label, $url, $options);
            if ($this->_isDropdown) {
                $options['tabindex'] = '-1';
                return $isBs4 ? $link : "<li>{$link}</li>\n";
            } else {
                return $link;
            }
        };
    }
}
