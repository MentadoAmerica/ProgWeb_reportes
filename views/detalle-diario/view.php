<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
$this->title = 'Reporte Folio: ' . $model->id_folio;
$this->params['breadcrumbs'][] = ['label' => 'Reportes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detalle-diario-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Html::a('Eliminar', ['delete', 'id_folio' => $model->id_folio], [
        'class' => 'btn btn-danger',
        'data' => ['confirm' => '¿Estás seguro?', 'method' => 'post'],
    ]) ?></p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_folio',
            'fecha_orden',
            'fecha_captura',
            'turno',
            ['label' => 'Tipo Unidad', 'value' => $model->tipoUnidad->nombre_tipo ?? ''],
            ['label' => 'Número Unidad', 'value' => $model->numUnidad->numero_unidad ?? ''],
            ['label' => 'Ruta', 'value' => $model->ruta->nombre_ruta ?? ''],
            ['label' => 'Chofer', 'value' => $model->chofer->nombre_chofer ?? ''],
            ['label' => 'Despachador', 'value' => $model->despachador->nombre_despachador ?? ''],
            'cantidad_kg',
            'porcentaje_efectividad',
            'comentarios',
            'km_salir','km_entrar','total_km',
            'diesel_iniciar','diesel_terminar','diesel_cargado',
            'cant_colonias',
            'suma_por_atendida',
            'por_realizado',
            ['label' => 'Usuario', 'value' => $model->usuario->nombre ?? ''],
        ],
    ]); ?>
    <h3>Detalle de Colonias</h3>
    <table class="table table-bordered">
        <thead><tr><th>#</th><th>Colonia</th><th>Habitantes</th><th>Porcentaje</th></tr></thead>
        <tbody>
        <?php for ($i=1; $i<=$model->cant_colonias; $i++): ?>
            <?php $colonia = \app\models\Colonia::findOne($model->{"colonia_$i"}); ?>
            <?php if ($colonia): ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= $colonia->nombre_colonia ?></td>
                    <td><?= $colonia->num_habitantes ?></td>
                    <td><?= $model->{"por_colonia_$i"} ?>%</td>
                </tr>
            <?php endif; ?>
        <?php endfor; ?>
        </tbody>
    </table>
</div>