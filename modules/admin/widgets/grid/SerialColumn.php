<?php
/**
 * SerialColumn.php
 *
 * @version    1.0
 * @package    AX project
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

namespace app\modules\admin\widgets\grid;

use yii\helpers\Html;
use kartik\grid\GridView;

class SerialColumn extends \kartik\grid\SerialColumn
{
    
    public function init()
    {
        $this->header = Html::a('<i class="fas fa-plus"></i>', ['create'], ['class' => 'btn btn-light']);
        $this->initColumnSettings([
            'mergeHeader' => true,
            'hAlign'      => GridView::ALIGN_CENTER,
            'vAlign'      => GridView::ALIGN_BOTTOM,
            'width'       => '50px',
        ]);
        parent::init();
    }
}
