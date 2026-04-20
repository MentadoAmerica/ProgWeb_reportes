<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\grid\ActionColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DetalleDiarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Buscar Reportes';
$this->params['breadcrumbs'][] = $this->title;

$tiposUnidad = \app\models\TipoUnidad::find()->all();
$rutas = \app\models\Ruta::find()->all();
$choferes = \app\models\Chofer::find()->all();
$despachadores = \app\models\Despachador::find()->all();
$usuarios = \app\models\Usuarios::find()->all();

$this->registerCss("
    :root {
        --primary: #800020;
        --primary-light: #f9e6e9;
        --primary-dark: #5c0016;
        --gray-bg: #faf9f8;
        --card-shadow: 0 20px 35px rgba(0,0,0,0.05), 0 2px 4px rgba(0,0,0,0.02);
    }

    body {
        background: var(--gray-bg);
        font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
    }

    .detalle-diario-index {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem;
        background: white;
        border-radius: 32px;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(128,0,32,0.08);
    }

    h1 {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--primary);
        letter-spacing: -0.01em;
        margin-bottom: 1.5rem;
    }

    /* Panel de filtros */
    .filters-panel {
        background-color: #fefaf7;
        padding: 1.5rem;
        border-radius: 24px;
        margin-bottom: 2rem;
        border: 1px solid rgba(128,0,32,0.1);
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .filters-panel h3 {
        margin-top: 0;
        color: var(--primary);
        font-weight: 600;
        font-size: 1.2rem;
        border-left: 4px solid var(--primary);
        padding-left: 0.75rem;
        margin-bottom: 1rem;
    }

    /* Campos de formulario */
    .form-group {
        margin-bottom: 1rem;
    }

    label {
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.85rem;
        margin-bottom: 0.3rem;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .form-control, .form-select {
        border-radius: 20px;
        border: 1px solid #e0e0e0;
        padding: 0.5rem 1rem;
        transition: 0.2s;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(128,0,32,0.15);
    }

    /* Botones */
    .btn-guindo {
        background: var(--primary);
        border: none;
        border-radius: 40px;
        padding: 0.5rem 1.5rem;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.2s;
        color: white;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-guindo:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(128,0,32,0.2);
    }

    .btn-cafe {
        background: #5a3a2a;
        border: none;
        border-radius: 40px;
        padding: 0.5rem 1.5rem;
        font-weight: 600;
        font-size: 0.9rem;
        color: white;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-cafe:hover {
        background: #7a4a2a;
        transform: translateY(-1px);
    }

    .btn-pdf {
        background: #dc3545;
        border: none;
        border-radius: 40px;
        padding: 0.5rem 1.5rem;
        font-weight: 600;
        font-size: 0.9rem;
        color: white;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-pdf:hover {
        background: #bb2d3b;
        transform: translateY(-1px);
    }

    /* Tabla moderna */
    .table {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        margin-top: 1rem;
    }

    .table thead th {
        background: var(--primary);
        color: white;
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        border: none;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: var(--primary-light);
    }

    .table-striped tbody tr:nth-of-type(even) {
        background-color: white;
    }

    /* Acciones en tabla */
    .action-column .btn {
        margin: 0 2px;
        border-radius: 30px;
        padding: 4px 10px;
        font-size: 0.75rem;
    }

    /* Paginador */
    .pagination {
        justify-content: center;
        margin-top: 1.5rem;
    }

    .pagination .page-link {
        border-radius: 40px;
        border: none;
        margin: 0 3px;
        color: var(--primary);
        background: #f9e4d4;
        font-weight: 500;
    }

    .pagination .page-link:hover {
        background: var(--primary-light);
    }

    .pagination .active .page-link {
        background: var(--primary);
        color: white;
    }

    @media (max-width: 768px) {
        .detalle-diario-index {
            padding: 1rem;
        }
        .filters-panel {
            padding: 1rem;
        }
        .action-column .btn {
            padding: 2px 6px;
            font-size: 0.7rem;
        }
    }
");
?>

<div class="detalle-diario-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Panel de filtros -->
    <div class="filters-panel">
        <h3>Filtros de búsqueda</h3>
        <?php $form = ActiveForm::begin([
            'method' => 'get',
            'action' => ['index'],
            'options' => ['class' => 'row g-3'],
        ]); ?>

        <div class="row">
            <div class="col-md-3">
                <?= $form->field($searchModel, 'id_folio')->textInput(['placeholder' => 'Folio', 'class' => 'form-control'])->label('Folio') ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($searchModel, 'fecha_desde')->input('date', ['class' => 'form-control'])->label('Fecha desde') ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($searchModel, 'fecha_hasta')->input('date', ['class' => 'form-control'])->label('Fecha hasta') ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($searchModel, 'id_ruta')->dropDownList(
                    ArrayHelper::map($rutas, 'id_ruta', 'nombre_ruta'),
                    ['prompt' => 'Todas', 'class' => 'form-select']
                )->label('Ruta') ?>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-3">
                <?= $form->field($searchModel, 'id_chofer')->dropDownList(
                    ArrayHelper::map($choferes, 'id_chofer', 'nombre_chofer'),
                    ['prompt' => 'Todos', 'class' => 'form-select']
                )->label('Chofer') ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($searchModel, 'id_tipo_unidad')->dropDownList(
                    ArrayHelper::map($tiposUnidad, 'id_tipo_unidad', 'nombre_tipo'),
                    ['prompt' => 'Todos', 'class' => 'form-select']
                )->label('Tipo de Unidad') ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($searchModel, 'nombre_colonia')->textInput(['placeholder' => 'Colonia', 'class' => 'form-control'])->label('Colonia') ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($searchModel, 'id_usuario')->dropDownList(
                    ArrayHelper::map($usuarios, 'id', 'nombre'),
                    ['prompt' => 'Todos', 'class' => 'form-select']
                )->label('Usuario') ?>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12 text-end">
                <?= Html::submitButton('<i class="bi bi-search"></i> Buscar', ['class' => 'btn btn-guindo']) ?>
                <?= Html::resetButton('<i class="bi bi-arrow-repeat"></i> Limpiar', ['class' => 'btn btn-cafe', 'onclick' => 'window.location.href="'.Yii::$app->urlManager->createUrl(['detalle-diario/index']).'"; return false;']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

    <!-- Botones de acciones principales -->
    <div class="d-flex flex-wrap gap-2 mb-3">
        <?= Html::a('<i class="bi bi-plus-circle"></i> Crear nuevo reporte', ['create'], ['class' => 'btn btn-guindo']) ?>
        <?= Html::a('<i class="bi bi-file-earmark-excel"></i> Exportar Excel', array_merge(['exportar'], Yii::$app->request->queryParams), ['class' => 'btn btn-cafe']) ?>
        <?= Html::a('<i class="bi bi-file-pdf"></i> Descargar PDF', array_merge(['pdf', 'type' => 'filtered'], Yii::$app->request->queryParams), ['class' => 'btn btn-pdf']) ?>
    </div>

    <!-- GridView -->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => null,
        'summary' => '',
        'tableOptions' => ['class' => 'table table-striped table-bordered'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn', 'header' => '#'],

            [
                'attribute' => 'id_folio',
                'label' => 'Folio',
            ],
            [
                'attribute' => 'fecha_orden',
                'label' => 'Fecha Orden',
                'format' => ['date', 'php:d/m/Y'],
            ],
            [
                'attribute' => 'fecha_captura',
                'label' => 'Fecha Captura',
                'format' => ['date', 'php:d/m/Y H:i'],
            ],
            'turno',
            [
                'attribute' => 'id_tipo_unidad',
                'value' => 'tipoUnidad.nombre_tipo',
                'label' => 'Tipo',
            ],
            [
                'attribute' => 'id_ruta',
                'value' => 'ruta.nombre_ruta',
                'label' => 'Ruta',
            ],
            [
                'attribute' => 'id_chofer',
                'value' => 'chofer.nombre_chofer',
                'label' => 'Chofer',
            ],
            'cantidad_kg',
            'total_km',

            [
                'class' => ActionColumn::class,
                'header' => 'Acciones',
                'headerOptions' => ['style' => 'text-align: center;'],
                'contentOptions' => ['style' => 'text-align: center; white-space: nowrap;'],
                'template' => '{view} {delete} {pdf}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<i class="bi bi-eye"></i>', ['view', 'id_folio' => $model->id_folio], [
                            'class' => 'btn btn-sm btn-cafe',
                            'title' => 'Ver',
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<i class="bi bi-trash3"></i>', ['delete', 'id_folio' => $model->id_folio], [
                            'class' => 'btn btn-sm btn-danger',
                            'title' => 'Eliminar',
                            'data' => [
                                'confirm' => '¿Estás seguro de eliminar este reporte?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                    'pdf' => function ($url, $model) {
                        return Html::a('<i class="bi bi-file-pdf"></i>', ['pdf', 'type' => 'single', 'id_folio' => $model->id_folio], [
                            'class' => 'btn btn-sm btn-pdf',
                            'title' => 'Descargar PDF individual',
                            'target' => '_blank',
                        ]);
                    },
                ],
            ],
        ],
        'pager' => [
            'options' => ['class' => 'pagination justify-content-center'],
            'linkOptions' => ['class' => 'page-link'],
            'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link'],
        ],
    ]); ?>
</div>