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
$usuarios = \app\models\Usuarios::find()->all();
// Estilos CSS personalizados
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
        font-weight: bold;
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
    .btn-cafe {
        background-color: #5a3a2a;
        border-color: #5a3a2a;
        color: white;
    }
    .btn-cafe:hover {
        background-color: #7a4a2a;
        border-color: #7a4a2a;
    }
    /* Estilos para la tabla */
    .table thead th {
        background-color: #800020;
        color: white;
        border-color: #5a1a1a;
    }
    .table thead a {
        color: white;
        text-decoration: none;
    }
    .table-striped > tbody > tr:nth-of-type(odd) {
        background-color: #f9e4d4;
    }
    .table-striped > tbody > tr:nth-of-type(even) {
        background-color: #fff;
    }
    /* Paginador personalizado */
    .pagination > li > a, .pagination > li > span {
        background-color: #f9e4d4;
        border-color: #800020;
        color: #5a3a2a;
    }
    .pagination > .active > a, .pagination > .active > span {
        background-color: #800020;
        border-color: #800020;
        color: white;
    }
    .pagination > li > a:hover {
        background-color: #e6ccb3;
        border-color: #800020;
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
                <?= $form->field($searchModel, 'id_tipo_unidad')->dropDownList(
                    ArrayHelper::map($tiposUnidad, 'id_tipo_unidad', 'nombre_tipo'),
                    ['prompt' => 'Todos']
                )->label('Tipo de Unidad') ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($searchModel, 'nombre_colonia')->textInput(['placeholder' => 'Nombre de colonia'])->label('Colonia') ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($searchModel, 'id_usuario')->dropDownList(
                    ArrayHelper::map($usuarios, 'id', 'nombre'),  // 'id' y 'nombre' son columnas de la tabla usuarios
                    ['prompt' => 'Todos']
                )->label('Usuario') ?>
            </div>
            <div class="col-md-3"></div>
            
        </div>

        <div class="row">
            <div class="col-md-12 text-right">
                <?= Html::submitButton('Buscar', ['class' => 'btn btn-guindo']) ?>
                <?= Html::resetButton('Limpiar', ['class' => 'btn btn-cafe', 'onclick' => 'window.location.href="'.Yii::$app->urlManager->createUrl(['detalle-diario/index']).'"; return false;']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

    <!-- Botones de acciones -->
    <p>
        <?= Html::a('Crear nuevo reporte', ['create'], ['class' => 'btn btn-guindo']) ?>
       <?= Html::a('Exportar a Excel', array_merge(['exportar'], Yii::$app->request->queryParams), ['class' => 'btn btn-cafe', 'style' => 'margin-left:10px;']) ?>
    </p>

    <!-- GridView con resultados -->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => null,
        'summary' => '', // Elimina "Showing 1-4 of 19 items."
        'tableOptions' => ['class' => 'table table-striped table-bordered'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn', 'header' => '#'],
            [
                'attribute' => 'id_folio',
                'label' => 'Folio',
                'headerOptions' => ['style' => 'background-color: #800020; color: white;'],
            ],
            [
                'attribute' => 'fecha_orden',
                'label' => 'Fecha de Orden',
                'headerOptions' => ['style' => 'background-color: #800020; color: white;'],
            ],
            [
                'attribute' => 'fecha_captura',
                'label' => 'Fecha de Captura',
                'headerOptions' => ['style' => 'background-color: #800020; color: white;'],
            ],
            [
                'attribute' => 'turno',
                'label' => 'Turno (1-4)',
                'headerOptions' => ['style' => 'background-color: #800020; color: white;'],
            ],
            [
                'attribute' => 'id_tipo_unidad',
                'value' => 'tipoUnidad.nombre_tipo',
                'label' => 'Tipo de Unidad',
                'headerOptions' => ['style' => 'background-color: #800020; color: white;'],
            ],
            [
                'attribute' => 'id_ruta',
                'value' => 'ruta.nombre_ruta',
                'label' => 'Ruta',
                'headerOptions' => ['style' => 'background-color: #800020; color: white;'],
            ],
            [
                'attribute' => 'id_chofer',
                'value' => 'chofer.nombre_chofer',
                'label' => 'Chofer',
                'headerOptions' => ['style' => 'background-color: #800020; color: white;'],
            ],
            [
                'attribute' => 'cantidad_kg',
                'label' => 'Cantidad (kg)',
                'headerOptions' => ['style' => 'background-color: #800020; color: white;'],
            ],
            [
                'attribute' => 'total_km',
                'label' => 'Total Kilómetros',
                'headerOptions' => ['style' => 'background-color: #800020; color: white;'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('Ver', ['view', 'id_folio' => $model->id_folio], ['class' => 'btn btn-sm btn-cafe']);
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
                'contentOptions' => ['style' => 'white-space: nowrap;'],
                'headerOptions' => ['style' => 'background-color: #800020; color: white;'],
            ],
        ],
        'pager' => [
            'options' => ['class' => 'pagination justify-content-center'],
            'linkOptions' => ['class' => 'page-link'],
            'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link'],
        ],
    ]); ?>
</div>