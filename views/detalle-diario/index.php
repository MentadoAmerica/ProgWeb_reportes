<?php
use yii\helpers\Html;
use yii\grid\GridView;
$this->title = 'Reportes Diarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detalle-diario-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Html::a('Nuevo Reporte', ['create'], ['class' => 'btn btn-success']) ?></p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id_folio',
            'fecha_orden',
            'fecha_captura',
            'turno',
            ['attribute' => 'id_tipo_unidad', 'value' => 'tipoUnidad.nombre_tipo'],
            ['attribute' => 'id_unidad', 'value' => 'numUnidad.numero_unidad'],
            'cantidad_kg',
            'total_km',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>