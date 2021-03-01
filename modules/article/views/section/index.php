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

$this->title = 'Article Topics';
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['/article/default/index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['icon'] = 'menu';
?>
<div class="row">
    <div class="col-md-4">
        <?php $form = ActiveForm::begin() ?>
        <div class="shadow p-4">
            <div class="text-heading mb-4">New Topic</div>
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
            <?= Html::submitButton('<i class="fas fa-cloud-upload-alt"></i> Save', ['class' => 'btn btn-white']) ?>
            <?= Html::a('<div class="fas fa-ban"></div> Cancel', ['/article/default/index'], ['class' => 'btn btn-white']) ?>
        </div>
        <?php $form = ActiveForm::end() ?>
    </div>
    <div class="col-md-8">
        <?= AdminGrid::widget([
            'createButton' => '',
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


