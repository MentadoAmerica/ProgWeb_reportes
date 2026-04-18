<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DetalleDiarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Buscar Reportes';
$this->params['breadcrumbs'][] = $this->title;

// Cargar listas para los dropdowns
$tiposUnidad = \app\models\TipoUnidad::find()->all();
$rutas = \app\models\Ruta::find()->all();
$choferes = \app\models\Chofer::find()->all();
$despachadores = \app\models\Despachador::find()->all();

// CSS inline para estilos (opcional, puedes usar site.css)
$this->registerCss("
    .filters-panel {
        background-color: #f9e4d4;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 25px;
        border-left: 5px solid #800020;
    }
    .filters-panel h3 {
        margin-top: 0;
        color: #800020;
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
    .table thead {
        background-color: #800020;
        color: white;
    }
");
?>

<div class="detalle-diario-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Panel de filtros/búsqueda -->
    <div class="filters-panel">
        <h3>Filtros de búsqueda</h3>
        <?php $form = ActiveForm::begin([
            'method' => 'get',
            'action' => ['index'],
            'options' => ['class' => 'form-inline', 'style' => 'flex-wrap: wrap; gap: 10px;'],
        ]); ?>

        <div class="row">
            <div class="col-md-3">
                <?= $form->field($searchModel, 'id_folio')->textInput(['placeholder' => 'Número de folio', 'class' => 'form-control'])->label('Folio') ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($searchModel, 'fecha_desde')->input('date', ['placeholder' => 'Desde'])->label('Fecha desde') ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($searchModel, 'fecha_hasta')->input('date', ['placeholder' => 'Hasta'])->label('Fecha hasta') ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($searchModel, 'id_ruta')->dropDownList(
                    ArrayHelper::map($rutas, 'id_ruta', 'nombre_ruta'),
                    ['prompt' => 'Todas']
                )->label('Ruta') ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <?= $form->field($searchModel, 'id_chofer')->dropDownList(
                    ArrayHelper::map($choferes, 'id_chofer', 'nombre_chofer'),
                    ['prompt' => 'Todos']
                )->label('Chofer') ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($searchModel, 'id_unidad')->dropDownList(
                    ArrayHelper::map(\app\models\NumUnidad::find()->all(), 'id_unidad', 'numero_unidad'),
                    ['prompt' => 'Todas']
                )->label('Unidad') ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($searchModel, 'id_tipo_unidad')->dropDownList(
                    ArrayHelper::map($tiposUnidad, 'id_tipo_unidad', 'nombre_tipo'),
                    ['prompt' => 'Todos']
                )->label('Tipo') ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($searchModel, 'nombre_colonia')->textInput(['placeholder' => 'Nombre de colonia'])->label('Colonia') ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-right">
                <?= Html::submitButton('Buscar', ['class' => 'btn btn-guindo']) ?>
                <?= Html::resetButton('Limpiar', ['class' => 'btn btn-default', 'onclick' => 'window.location.href="'.Yii::$app->urlManager->createUrl(['detalle-diario/index']).'"; return false;']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

    <!-- Botón para nuevo reporte -->
    <p>
        <?= Html::a('Crear nuevo reporte', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <!-- GridView con resultados -->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => null, // Los filtros ya están en el panel superior
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id_folio',
            'fecha_orden',
            'fecha_captura',
            'turno',
            [
                'attribute' => 'id_tipo_unidad',
                'value' => 'tipoUnidad.nombre_tipo',
                'label' => 'Tipo'
            ],
            [
                'attribute' => 'id_unidad',
                'value' => 'numUnidad.numero_unidad',
                'label' => 'Unidad'
            ],
            [
                'attribute' => 'id_ruta',
                'value' => 'ruta.nombre_ruta',
                'label' => 'Ruta'
            ],
            [
                'attribute' => 'id_chofer',
                'value' => 'chofer.nombre_chofer',
                'label' => 'Chofer'
            ],
            'cantidad_kg',
            'total_km',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('Ver', ['view', 'id_folio' => $model->id_folio], ['class' => 'btn btn-sm btn-info']);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('Eliminar', ['delete', 'id_folio' => $model->id_folio], [
                            'class' => 'btn btn-sm btn-danger',
                            'data' => [
                                'confirm' => '¿Estás seguro de eliminar este reporte?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>