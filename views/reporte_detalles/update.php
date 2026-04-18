<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ReporteDetalles $model */

$this->title = 'Update Reporte Detalles: ' . $model->id_reporte;
$this->params['breadcrumbs'][] = ['label' => 'Reporte Detalles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_reporte, 'url' => ['view', 'id_reporte' => $model->id_reporte]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="reporte-detalles-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
