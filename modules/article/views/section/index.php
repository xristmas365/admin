<?php

use yii\web\View;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\data\ActiveDataProvider;
use trntv\filekit\widget\Upload;
use app\modules\article\models\Section;
use app\modules\admin\widgets\grid\AdminGrid;
use app\modules\admin\widgets\grid\SwitchColumn;
use app\modules\article\models\search\SectionSearch;

/**
 * @var $this          View
 * @var $model         Section
 * @var $searchModel   SectionSearch
 * @var $dataProvider  ActiveDataProvider
 */

$this->title = 'Sections';
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['/article/default/index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['icon'] = 'menu';
?>
<div class="row">
    <div class="col-md-4">
        <?php $form = ActiveForm::begin() ?>
        <div class="card">
            <div class="card-header bg-light text-center text-heading"> New Section</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'name') ?>
                        <?= $form->field($model, 'home')->checkbox() ?>
                        <?= $form->field($model, 'visible')->checkbox() ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'files')->widget(Upload::class, [
                            'url'        => ['/storage/default/upload'],
                            'uploadPath' => 'section/',
                            'multiple'   => true,
                        ])->label('Cover') ?>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light">
                <?= Html::submitButton('Add', ['class' => 'btn btn-white']) ?>
            </div>
        </div>
        <?php $form = ActiveForm::end() ?>
    </div>
    <div class="col-md-8">
        <?= AdminGrid::widget([
            'createButton' => Html::a('<div class="fas fa-arrow-left"></div> Articles', ['/article/default/index'], ['class' => 'btn btn-white', 'data-pjax' => 0]),
            'dataProvider' => $dataProvider,
            'filterModel'  => $searchModel,
            'columns'      => [
                AdminGrid::COLUMN_SERIAL,
                AdminGrid::COLUMN_IMAGE,
                
                'name',
                [
                    'class'     => SwitchColumn::class,
                    'attribute' => 'home',
                ],
                [
                    'class'     => SwitchColumn::class,
                    'attribute' => 'visible',
                ],
                AdminGrid::COLUMN_ACTION,
            ],
        ]); ?>
    </div>
</div>


