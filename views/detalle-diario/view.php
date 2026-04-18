<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DetalleDiario */

$this->title = 'Reporte Folio: ' . $model->id_folio;
$this->params['breadcrumbs'][] = ['label' => 'Reportes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// Cálculo del total de kilómetros (por si la BD no lo calcula)
$totalKm = $model->km_entrar - $model->km_salir;

// CSS inline para la vista de detalle
$this->registerCss("
    .reporte-container {
        background-color: #fff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        margin-top: 20px;
    }
    .btn-guindo {
        background-color: #800020;
        border-color: #800020;
        color: white;
    }
    .btn-guindo:hover {
        background-color: #a00028;
        border-color: #a00028;
    }
    .panel-guindo {
        border-left: 5px solid #800020;
        background-color: #f9e4d4;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 8px;
    }
    .panel-guindo h3 {
        margin-top: 0;
        color: #800020;
    }
    .table thead {
        background-color: #800020;
        color: white;
    }
    .table-striped > tbody > tr:nth-of-type(odd) {
        background-color: #f9e4d4;
    }
    .info-label {
        font-weight: bold;
        color: #5a3a2a;
    }
");
?>

<div class="detalle-diario-view">
    <div class="reporte-container">
        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Eliminar', ['delete', 'id_folio' => $model->id_folio], [
                'class' => 'btn btn-guindo',
                'data' => [
                    'confirm' => '¿Estás seguro de eliminar este reporte?',
                    'method' => 'post',
                ],
            ]) ?>
            <?= Html::a('Nuevo Reporte', ['create'], ['class' => 'btn btn-default']) ?>
        </p>

        <!-- Panel de información general -->
        <div class="panel-guindo">
            <h3>Información general</h3>
            <div class="row">
                <div class="col-md-3">
                    <div class="info-label">Folio:</div>
                    <p><?= Html::encode($model->id_folio) ?></p>
                </div>
                <div class="col-md-3">
                    <div class="info-label">Fecha de orden:</div>
                    <p><?= Html::encode($model->fecha_orden) ?></p>
                </div>
                <div class="col-md-3">
                    <div class="info-label">Fecha de captura:</div>
                    <p><?= Html::encode($model->fecha_captura) ?></p>
                </div>
                <div class="col-md-3">
                    <div class="info-label">Turno:</div>
                    <p><?= Html::encode($model->turno) ?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="info-label">Tipo de unidad:</div>
                    <p><?= $model->tipoUnidad ? Html::encode($model->tipoUnidad->nombre_tipo) : 'No definido' ?></p>
                </div>
                <div class="col-md-3">
                    <div class="info-label">Número de unidad:</div>
                    <p><?= $model->unidad ? Html::encode($model->unidad->numero_unidad) : 'No definido' ?></p>
                </div>
                <div class="col-md-3">
                    <div class="info-label">Ruta:</div>
                    <p><?= $model->ruta ? Html::encode($model->ruta->nombre_ruta) : 'No definida' ?></p>
                </div>
                <div class="col-md-3">
                    <div class="info-label">Chofer:</div>
                    <p><?= $model->chofer ? Html::encode($model->chofer->nombre_chofer) : 'No definido' ?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="info-label">Despachador:</div>
                    <p><?= $model->despachador ? Html::encode($model->despachador->nombre_despachador) : 'No definido' ?></p>
                </div>
                <div class="col-md-3">
                    <div class="info-label">Cantidad (kg):</div>
                    <p><?= Html::encode($model->cantidad_kg) ?> kg</p>
                </div>
                <div class="col-md-3">
                    <div class="info-label">Número de puches:</div>
                    <p><?= Html::encode($model->num_puches) ?></p>
                </div>
                <div class="col-md-3">
                    <div class="info-label">Usuario captura:</div>
                    <p><?= $model->usuario ? Html::encode($model->usuario->nombre) : 'Sistema' ?></p>
                </div>
            </div>
        </div>

        <!-- Panel de kilómetros y diésel -->
        <div class="panel-guindo">
            <h3>Kilometraje y diésel</h3>
            <div class="row">
                <div class="col-md-3">
                    <div class="info-label">Km salida:</div>
                    <p><?= Html::encode($model->km_salir) ?> km</p>
                </div>
                <div class="col-md-3">
                    <div class="info-label">Km entrada:</div>
                    <p><?= Html::encode($model->km_entrar) ?> km</p>
                </div>
                <div class="col-md-3">
                    <div class="info-label">Total km:</div>
                    <p><strong><?= Html::encode($totalKm) ?> km</strong></p>
                </div>
                <div class="col-md-3"></div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="info-label">Diésel inicio:</div>
                    <p><?= Html::encode($model->diesel_iniciar) ?> L</p>
                </div>
                <div class="col-md-3">
                    <div class="info-label">Diésel final:</div>
                    <p><?= Html::encode($model->diesel_terminar) ?> L</p>
                </div>
                <div class="col-md-3">
                    <div class="info-label">Diésel cargado:</div>
                    <p><?= Html::encode($model->diesel_cargado) ?> L</p>
                </div>
                <div class="col-md-3">
                    <div class="info-label">Consumo aprox:</div>
                    <p><?= Html::encode($model->diesel_iniciar - $model->diesel_terminar) ?> L</p>
                </div>
            </div>
        </div>

        <!-- Panel de efectividad -->
        <div class="panel-guindo">
            <h3>Efectividad de recolección</h3>
            <div class="row">
                <div class="col-md-3">
                    <div class="info-label">Cantidad de colonias:</div>
                    <p><?= Html::encode($model->cant_colonias) ?></p>
                </div>
                <div class="col-md-3">
                    <div class="info-label">Suma de porcentajes:</div>
                    <p><?= Html::encode($model->suma_por_atendida) ?> %</p>
                </div>
                <div class="col-md-3">
                    <div class="info-label">Porcentaje realizado:</div>
                    <p><?= Html::encode($model->por_realizado) ?> %</p>
                </div>
                <div class="col-md-3">
                    <div class="info-label">Efectividad final:</div>
                    <p><strong><?= Html::encode($model->porcentaje_efectividad) ?> %</strong></p>
                </div>
            </div>
        </div>

        <!-- Detalle de colonias -->
        <div class="panel-guindo">
            <h3>Detalle de colonias atendidas</h3>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Colonia</th>
                        <th>Habitantes</th>
                        <th>Porcentaje (%)</th>
                    </tr>
                </thead>
                <tbody>
                <?php for ($i = 1; $i <= $model->cant_colonias; $i++): ?>
                    <?php $coloniaId = $model->{"colonia_$i"}; ?>
                    <?php $colonia = \app\models\Colonia::findOne($coloniaId); ?>
                    <?php if ($colonia): ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= Html::encode($colonia->nombre_colonia) ?></td>
                            <td><?= Html::encode($colonia->num_habitantes) ?></td>
                            <td><?= Html::encode($model->{"por_colonia_$i"}) ?> %</td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td colspan="3">Colonia no encontrada</td>
                        </tr>
                    <?php endif; ?>
                <?php endfor; ?>
                </tbody>
            </table>
        </div>

        <!-- Comentarios -->
        <?php if (!empty($model->comentarios)): ?>
            <div class="panel-guindo">
                <h3>Comentarios</h3>
                <p><?= Html::encode($model->comentarios) ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>