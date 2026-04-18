<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\ReporteDetalles $model */

$this->title = $model->id_reporte;
$this->params['breadcrumbs'][] = ['label' => 'Reporte Detalles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="reporte-detalles-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_reporte' => $model->id_reporte], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_reporte' => $model->id_reporte], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_reporte',
            'id_folio',
            'id_colonia',
            'porcentaje_colonia',
        ],
    ]) ?>

</div>
