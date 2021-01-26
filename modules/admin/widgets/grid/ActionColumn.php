<?php
/**
 * ActionColumn.php
 *
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @package    AX project
 * @version    1.0
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
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
