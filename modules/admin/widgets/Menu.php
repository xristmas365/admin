<?php
/**
 * Menu.php
 *
 * @version    1.0
 * @package    AX project
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

namespace app\modules\admin\widgets;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

class Menu extends \yii\widgets\Menu
{
    
    public $encodeLabels    = false;
    
    public $activateParents = true;
    
    public $linkTemplate    = '<a class="nav-link" href="{url}">{label}</a>';
    
    //public $submenuTemplate = '<nav class="nav">{items}</nav>';
    
    public $options         = [
        'class' => 'nav nav-aside',
    ];
    
    public $itemOptions     = [
        'class' => 'nav-item',
    ];
    
    protected function isItemActive($item)
    {
        if(isset($item['url']) && is_array($item['url']) && isset($item['url'][0])) {
            $route = Yii::getAlias($item['url'][0]);
            if($route[0] !== '/' && Yii::$app->controller) {
                $route = Yii::$app->controller->module->getUniqueId() . '/' . $route;
            }
            if(ltrim($route, '/') !== $this->route) {
                return false;
            }
            unset($item['url']['#']);
            if(count($item['url']) > 1) {
                $params = $item['url'];
                unset($params[0]);
                foreach($params as $name => $value) {
                    if($value !== null && (!isset($this->params[$name]) || $this->params[$name] != $value)) {
                        return false;
                    }
                }
            }
            
            return true;
        }
        
        return false;
    }
    
    protected function renderItems($items)
    {
        $lines = [];
        foreach($items as $i => $item) {
            $options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
            $tag = ArrayHelper::remove($options, 'tag', 'li');
            $class = [];
            if($item['active']) {
                $class[] = 'show';
                $class[] = 'active';
            }
            if(isset($item['items'])) {
                $class[] = 'with-sub';
            }
            
            Html::addCssClass($options, $class);
            
            $menu = $this->renderItem($item);
            
            if(!empty($item['items'])) {
                $submenuTemplate = ArrayHelper::getValue($item, 'submenuTemplate', $this->submenuTemplate);
                $menu .= strtr($submenuTemplate, [
                    '{items}' => $this->renderSubItems($item['items']),
                ]);
            }
            $lines[] = Html::tag($tag, $menu, $options);
        }
        
        return implode("\n", $lines);
    }
    
    protected function renderItem($item)
    {
        if(isset($item['url'])) {
            $activeClass = $item['active'] ? $this->activeCssClass : '';
            $showClass = !empty($item['items']) ? 'with-sub' : '';
            
            $link = '<a class="nav-link ' . $activeClass . ' ' . $showClass . '" href="{url}">{label}</a>';
            
            $template = ArrayHelper::getValue($item, 'template', $link);
            
            return strtr($template, [
                '{url}'   => Html::encode(Url::to($item['url'])),
                '{label}' => $item['label'],
            ]);
        }
        
        $template = ArrayHelper::getValue($item, 'template', $this->labelTemplate);
        
        return strtr($template, [
            '{label}' => $item['label'],
        ]);
    }
    
    protected function renderSubItems($items)
    {
        $lines = [];
        foreach($items as $i => $item) {
            $options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
            
            $class = [];
            
            Html::addCssClass($options, $class);
            
            $menu = $this->renderSubItem($item);
            
            $lines[] = $menu;
        }
        
        return implode("\n", $lines);
    }
    
    protected function renderSubItem($item)
    {
        if(isset($item['url'])) {
            $activeClass = $item['active'] ? 'active sub-active' : '';
            
            $link = '<a class=" ' . $activeClass . '" href="{url}">{label}</a>';
            
            $template = ArrayHelper::getValue($item, 'template', $link);
            
            return strtr($template, [
                '{url}'   => Html::encode(Url::to($item['url'])),
                '{label}' => $item['label'],
            ]);
        }
        
        $template = ArrayHelper::getValue($item, 'template', $this->labelTemplate);
        
        return strtr($template, [
            '{label}' => $item['label'],
        ]);
    }
}
