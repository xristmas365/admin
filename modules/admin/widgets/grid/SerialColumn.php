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
