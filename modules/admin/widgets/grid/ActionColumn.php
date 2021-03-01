<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   NACR project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\modules\admin\widgets\grid;

use yii\helpers\Html;

class ActionColumn extends \kartik\grid\ActionColumn
{
    
    public $mergeHeader = false;
    
    public $template    = '<div class="d-flex actions justify-content-around">{update}<span class="action-delete">{delete}</span></div>';
    
    public $clearAction = ['index'];
    
    public function init()
    {
        parent::init();
        
        $this->header = Html::a('<i class="fas fa-filter"></i> Clear', $this->clearAction, ['class' => 'btn btn-white']);
        
    }
    
    protected function renderHeaderCellContent()
    {
        return;
    }
    
    protected function renderFilterCellContent()
    {
        return parent::renderHeaderCellContent();
    }
}
