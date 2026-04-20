<?php

use app\models\ReporteDetalles;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ReporteDetallesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Reporte Detalles';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss("
    :root {
        --primary: #800020;
        --primary-light: #f9e6e9;
        --primary-dark: #5c0016;
        --card-shadow: 0 20px 35px rgba(0,0,0,0.05), 0 2px 4px rgba(0,0,0,0.02);
    }

    .reporte-detalles-index {
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
        margin-bottom: 1.5rem;
    }

    .btn-guindo {
        background: var(--primary);
        border: none;
        border-radius: 40px;
        padding: 0.6rem 1.5rem;
        font-weight: 600;
        font-size: 0.9rem;
        color: white;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-guindo:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(128,0,32,0.2);
        color: white;
    }

    .table {
        border-radius: 20px;
        overflow: hidden;
        margin-top: 1rem;
    }

    .table thead th {
        background: var(--primary);
        color: white;
        font-size: 0.8rem;
        text-transform: uppercase;
        border: none;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: var(--primary-light);
    }

    .action-column {
        text-align: center;
        white-space: nowrap;
    }

    .action-column .btn {
        margin: 0 2px;
        border-radius: 30px;
        padding: 4px 10px;
        font-size: 0.75rem;
        border: none;
    }

    .btn-view { background:#5a3a2a; color:white; }
    .btn-edit { background:#800020; color:white; }
    .btn-delete { background:#dc3545; color:white; }

    .btn-view:hover { background:#7a4a2a; color:white; }
    .btn-edit:hover { background:#5c0016; color:white; }
    .btn-delete:hover { background:#bb2d3b; color:white; }

    .pagination {
        justify-content: center;
        margin-top: 1.5rem;
    }
");

?>

<div class="reporte-detalles-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Botón -->
    <div style="margin-bottom: 20px;">
        <?= Html::a(
            '<i class=\"bi bi-plus-circle\"></i> Crear Reporte Detalle',
            ['create'],
            ['class' => 'btn btn-guindo']
        ) ?>
    </div>

    <!-- Tabla -->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => '',
        'tableOptions' => ['class' => 'table table-striped table-bordered'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id_reporte',
                'label' => 'ID Reporte',
                'enableSorting' => false,
            ],
            [
                'attribute' => 'id_folio',
                'label' => 'ID Folio',
                'enableSorting' => false,
            ],
            [
                'attribute' => 'id_colonia',
                'label' => 'ID Colonia',
                'enableSorting' => false,
            ],
            [
                'attribute' => 'porcentaje_colonia',
                'label' => 'Porcentaje',
                'enableSorting' => false,
            ],

            [
                'class' => ActionColumn::className(),
                'header' => 'Acciones',
                'contentOptions' => ['class' => 'action-column'],
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url) {
                        return Html::a('<i class=\"bi bi-eye\"></i>', $url, [
                            'class' => 'btn btn-sm btn-view',
                        ]);
                    },
                    'update' => function ($url) {
                        return Html::a('<i class=\"bi bi-pencil\"></i>', $url, [
                            'class' => 'btn btn-sm btn-edit',
                        ]);
                    },
                    'delete' => function ($url) {
                        return Html::a('<i class=\"bi bi-trash\"></i>', $url, [
                            'class' => 'btn btn-sm btn-delete',
                            'data' => [
                                'confirm' => '¿Eliminar registro?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
                'urlCreator' => function ($action, ReporteDetalles $model) {
                    return Url::toRoute([$action, 'id_reporte' => $model->id_reporte]);
                }
            ],
        ],
    ]); ?>

</div>