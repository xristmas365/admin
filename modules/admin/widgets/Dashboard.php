<?php

/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\modules\admin\widgets;

use yii\helpers\Html;
use yii\bootstrap4\Widget;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;

/**
 * Dashboard Cards Widget
 *
 *
 * Row Example [item, item]
 *
 * Item Example
 * [
 *  'title'       => 'Users',
 *  'url'         => ['/user/default/index'],
 *  'description' => 'Click here to manage Users in the database',
 *  'icon'        => 'users',
 *  'bg'          => '#fff',
 *  'color'       => '#ccc',
 * ],
 * @package app\modules\admin\widgets
 */
class Dashboard extends Widget
{
    
    public $items       = [];
    
    public $columnClass = 'col-lg-4';
    
    public $icon        = 'file-text';
    
    public $footerIcon  = 'chevron-right';
    
    
    public function run()
    {
        parent::run();
        echo $this->renderItems();
    }
    
    public function renderItems()
    {
        $html = '';
        foreach($this->items as $rows) {
            $html .= Html::tag('div', $this->renderRow($rows), ['class' => 'row mb-4']);
        }
        
        return $html;
    }
    
    public function renderRow($items)
    {
        $html = '';
        foreach($items as $item) {
            $html .= Html::tag('div', $this->renderCard($item), ['class' => $this->columnClass]);
        }
        
        return $html;
    }
    
    public function renderCard($card)
    {
        if(!isset($card['title'])) {
            throw new InvalidConfigException('The Card must contain a title');
        }
        if(!isset($card['url'])) {
            throw new InvalidConfigException('The Card must contain an URL');
        }
        
        if(isset($card['visible']) && !$card['visible']) {
            return null;
        }
        
        $url = ArrayHelper::getValue($card, 'url', ['/admin/default/index']);
        
        /**
         * Colors
         */
        $bg = ArrayHelper::getValue($card, 'bg', '#e4e5ec');
        $color = ArrayHelper::getValue($card, 'color', '#2a3176');
        
        $style = [
            'color:' . $color . '!important',
            'background-color:' . $bg . '!important',
        ];
        
        return Html::a($this->renderBody($card) . $this->renderFooter($card), $url, ['class' => 'dashboard-card shadow', 'style' => implode(';', $style)]);
    }
    
    public function renderBody($card)
    {
        $icon = Html::tag('div', Html::tag('i', null, ['data-feather' => ArrayHelper::getValue($card, 'icon', $this->icon)]), ['class' => 'dashboard-card-icon']);
        $title = Html::tag('h4', ArrayHelper::getValue($card, 'title', 'Card Title'));
        $description = Html::tag('p', ArrayHelper::getValue($card, 'description', 'Card Description'), ['class' => 'm-0']);
        $textBlock = Html::tag('div', $title . $description);
        $block = Html::tag('div', $icon . $textBlock, ['class' => 'd-flex align-items-center']);
        
        return Html::tag('div', $block, ['class' => 'dashboard-card-body']);
    }
    
    public function renderFooter($card)
    {
        $title = ArrayHelper::getValue($card, 'footerTitle', 'Click here to view ' . ArrayHelper::getValue($card, 'title', 'Card Title'));
        $content = Html::tag('span', $title);
        $icon = Html::tag('i', null, ['data-feather' => ArrayHelper::getValue($card, 'footerIcon', $this->footerIcon)]);
        
        return Html::tag('div', $content . $icon, ['class' => 'dashboard-card-footer']);
    }
}

?>
