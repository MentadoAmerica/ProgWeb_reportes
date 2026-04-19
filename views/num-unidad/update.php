<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\NumUnidad $model */

$this->title = 'Update Num Unidad: ' . $model->id_unidad;
$this->params['breadcrumbs'][] = ['label' => 'Num Unidads', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_unidad, 'url' => ['view', 'id_unidad' => $model->id_unidad]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="num-unidad-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
