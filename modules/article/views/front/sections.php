<?php
/**
 *
 * @author    Paul Stolyarov <teajeraker@gmail.com>
 * @copyright industrialax.com
 * @license   https://industrialax.com/crm-general-license
 */

use yii\web\View;
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;
use app\modules\article\models\search\SectionSearch;

/**
 * @var $this         View
 * @var $searchModel  SectionSearch
 * @var $dataProvider ActiveDataProvider
 */

$this->title = Yii::$app->name . ' - Sections';

?>


<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView'     => '_section_item',
    'summary'      => false,
    'layout'       => "<div class='row'>{items}</div>\n{pager}",
    'itemOptions'  => [
        'class' => 'col-md-3',
    ],
    'options'      => [
        'class' => 'row',
    ],
]) ?>

