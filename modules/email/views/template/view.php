<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use richardfan\widget\JSRegister;

/* @var $this yii\web\View */
/* @var $model app\modules\email\models\EmailTemplate */
/* @var $userList array */

?>


<?= DetailView::widget([
    'model'      => $model,
    'attributes' => [
        'name',
        'subject',
        'content:ntext',
    ],
]) ?>



