<?php

use app\models\Ruta;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\RutaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Rutas';
$this->params['breadcrumbs'][] = $this->title;

$currentSort = Yii::$app->request->get('sort', '');
?>

<div class="ruta-index">

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div style="background-color: #f0e0d0; border-left: 4px solid #621132; color: #621132; padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; font-family: 'Varela Round', sans-serif; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 8px rgba(98, 17, 50, 0.1);">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-check-circle" style="font-size: 20px;"></i>
                <span style="font-weight: 500;"><?= Yii::$app->session->getFlash('success') ?></span>
            </div>
            <button style="background: none; border: none; color: #621132; cursor: pointer; font-size: 20px; padding: 0;" onclick="this.parentElement.style.display='none';">×</button>
        </div>
    <?php endif; ?>

    <!-- Encabezado -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div>
            <h2 style="color: #621132; font-weight: 600; margin-bottom: 5px; font-family: 'Varela Round', sans-serif; font-size: 32px;">
                <i class="fas fa-route" style="margin-right: 10px; color: #621132;"></i>
                <?= Html::encode($this->title) ?>
            </h2>
            <p style="color: #7a6a5a; margin: 0; font-size: 16px; font-family: 'Varela Round', sans-serif;">
                <i class="fas fa-info-circle" style="margin-right: 5px; color: #621132;"></i>
                Administra las rutas y sus detalles
            </p>
        </div>
        <div>
            <?= Html::a(
                '<i class="fas fa-plus-circle" style="margin-right: 8px;"></i> Crear Ruta', 
                ['create'], 
                [
                    'style' => 'background-color: #621132; color: white; border: none; padding: 12px 28px; border-radius: 10px; font-weight: 600; font-family: "Varela Round", sans-serif; font-size: 16px; transition: all 0.3s ease; box-shadow: 0 4px 8px rgba(98, 17, 50, 0.2); text-decoration: none; display: inline-flex; align-items: center; cursor: pointer;',
                    'onmouseover' => 'this.style.backgroundColor="#800020"; this.style.transform="translateY(-2px)"; this.style.boxShadow="0 6px 12px rgba(128, 0, 32, 0.3)";',
                    'onmouseout' => 'this.style.backgroundColor="#621132"; this.style.transform="translateY(0)"; this.style.boxShadow="0 4px 8px rgba(98, 17, 50, 0.2)";'
                ]
            ) ?>
        </div>
    </div>

    <!-- Filtros y Ordenamiento -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px;">
        <div style="display: flex; gap: 10px; align-items: center;">
            <!-- Dropdown de ordenamiento -->
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false" 
                        style="background: white; border: 1px solid #d4a373; color: #621132; padding: 8px 18px; border-radius: 30px; font-family: 'Varela Round', sans-serif; font-size: 14px; transition: all 0.2s ease; box-shadow: 0 2px 6px rgba(98, 17, 50, 0.08);">
                    <i class="fas fa-arrow-<?= strpos($currentSort, '-') === 0 ? 'down' : 'up' ?>-wide-short" style="margin-right: 8px;"></i>
                    <?php
                    $sortLabels = [
                        'id_ruta' => 'ID (Menor a Mayor)',
                        '-id_ruta' => 'ID (Mayor a Menor)',
                        'nombre_ruta' => 'Nombre (A-Z)',
                        '-nombre_ruta' => 'Nombre (Z-A)',
                    ];
                    echo $currentSort && isset($sortLabels[$currentSort]) ? $sortLabels[$currentSort] : 'Ordenar por...';
                    ?>
                </button>
                <ul class="dropdown-menu" aria-labelledby="sortDropdown" style="border-radius: 12px; border: 1px solid #f0e0d0; box-shadow: 0 6px 16px rgba(98, 17, 50, 0.12); padding: 8px 0; min-width: 200px;">
                    <li><h6 class="dropdown-header" style="color: #621132; font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 8px 16px;"><i class="fas fa-hashtag" style="margin-right: 6px;"></i>ID</h6></li>
                    <li><?= Html::a('<i class="fas fa-arrow-up" style="margin-right: 10px; width: 16px;"></i>Menor a Mayor', ['index', 'sort' => 'id_ruta'] + Yii::$app->request->queryParams, ['class' => 'dropdown-item' . ($currentSort == 'id_ruta' ? ' active' : ''), 'style' => 'padding: 8px 16px; font-family: "Varela Round", sans-serif;']) ?></li>
                    <li><?= Html::a('<i class="fas fa-arrow-down" style="margin-right: 10px; width: 16px;"></i>Mayor a Menor', ['index', 'sort' => '-id_ruta'] + Yii::$app->request->queryParams, ['class' => 'dropdown-item' . ($currentSort == '-id_ruta' ? ' active' : ''), 'style' => 'padding: 8px 16px; font-family: "Varela Round", sans-serif;']) ?></li>
                    
                    <li><hr class="dropdown-divider" style="margin: 5px 0;"></li>
                    <li><h6 class="dropdown-header" style="color: #621132; font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 8px 16px;"><i class="fas fa-font" style="margin-right: 6px;"></i>Nombre</h6></li>
                    <li><?= Html::a('<i class="fas fa-arrow-up" style="margin-right: 10px; width: 16px;"></i>A - Z', ['index', 'sort' => 'nombre_ruta'] + Yii::$app->request->queryParams, ['class' => 'dropdown-item' . ($currentSort == 'nombre_ruta' ? ' active' : ''), 'style' => 'padding: 8px 16px; font-family: "Varela Round", sans-serif;']) ?></li>
                    <li><?= Html::a('<i class="fas fa-arrow-down" style="margin-right: 10px; width: 16px;"></i>Z - A', ['index', 'sort' => '-nombre_ruta'] + Yii::$app->request->queryParams, ['class' => 'dropdown-item' . ($currentSort == '-nombre_ruta' ? ' active' : ''), 'style' => 'padding: 8px 16px; font-family: "Varela Round", sans-serif;']) ?></li>
                    
                    <?php if ($currentSort): ?>
                    <li><hr class="dropdown-divider" style="margin: 5px 0;"></li>
                    <li><?= Html::a('<i class="fas fa-times" style="margin-right: 10px;"></i>Limpiar ordenamiento', array_merge(['index'], Yii::$app->request->queryParams, ['sort' => null]), ['class' => 'dropdown-item text-danger', 'style' => 'padding: 8px 16px; font-family: "Varela Round", sans-serif;']) ?></li>
                    <?php endif; ?>
                </ul>
            </div>
            
            <!-- Indicador de orden activo -->
            <?php if ($currentSort): ?>
                <span style="color: #621132; font-family: 'Varela Round', sans-serif; font-size: 13px; background: #f9e4d4; padding: 5px 12px; border-radius: 30px;">
                    <i class="fas fa-check-circle" style="color: #621132; margin-right: 5px;"></i>Ordenado
                </span>
            <?php endif; ?>
        </div>
        
        <!-- Botón para limpiar filtros -->
        <div>
            <?= Html::a(
                '<i class="fas fa-undo-alt" style="margin-right: 5px;"></i> Limpiar filtros', 
                ['index'], 
                [
                    'class' => 'btn', 
                    'style' => 'background: white; border: 1px solid #d4a373; color: #621132; padding: 8px 16px; border-radius: 30px; font-family: "Varela Round", sans-serif; font-size: 14px; transition: all 0.2s ease; text-decoration: none;',
                    'onmouseover' => 'this.style.backgroundColor="#f9e4d4";',
                    'onmouseout' => 'this.style.backgroundColor="white";'
                ]
            ) ?>
        </div>
    </div>

    <!-- Estilos -->
    <style>
    .dropdown-item.active {
        background-color: #f9e4d4 !important;
        color: #621132 !important;
        font-weight: 600;
    }
    .dropdown-item:hover {
        background-color: #fdf8f4 !important;
        color: #621132 !important;
    }
    .dropdown-toggle:hover {
        background-color: #f9e4d4 !important;
        border-color: #621132 !important;
    }
    
    /* Responsividad para botones */
    .table td:last-child {
        white-space: nowrap !important;
    }
    
    @media (max-width: 768px) {
        .table td:last-child {
            padding: 10px 5px !important;
        }
        .table .btn-sm {
            width: 34px !important;
            height: 34px !important;
            padding: 0 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin: 0 2px !important;
            border-radius: 8px !important;
        }
        .table .btn-sm i {
            margin: 0 !important;
            font-size: 14px !important;
        }
    }
    
    @media (max-width: 480px) {
        .table .btn-sm {
            width: 30px !important;
            height: 30px !important;
        }
        .grid-view {
            overflow-x: auto !important;
        }
    }
    </style>

    <!-- Tabla -->
    <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(98, 17, 50, 0.15); border: 1px solid #f0e0d0;">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'table table-hover', 'style' => 'margin-bottom: 0; font-size: 15px;'],
            'layout' => "
                <div style='padding: 15px 20px; border-bottom: 1px solid #f0e0d0; background: white;'>
                    <div style='display: flex; justify-content: space-between; align-items: center;'>
                        <div style='color: #621132; font-size: 16px; font-family: \"Varela Round\", sans-serif;'>
                            <i class='fas fa-list' style='margin-right: 8px; color: #621132;'></i>
                            Total: <b>".$dataProvider->getTotalCount()."</b> rutas
                        </div>
                        <div style='color: #621132; font-size: 16px; font-family: \"Varela Round\", sans-serif;'>
                            <i class='fas fa-eye' style='margin-right: 8px; color: #621132;'></i>
                            Mostrando <b>".$dataProvider->getCount()."</b> de <b>".$dataProvider->getTotalCount()."</b>
                        </div>
                    </div>
                </div>
                {items}
                <div style='padding: 15px 20px; border-top: 1px solid #f0e0d0; text-align: center; background: white;'>
                    {pager}
                </div>
            ",
            'summary' => '',
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'header' => '#',
                    'headerOptions' => ['style' => 'background-color: #efefef; color: black; text-align: center; font-family: "Varela Round", sans-serif; padding: 15px;'],
                    'contentOptions' => ['style' => 'text-align: center; font-weight: 600; color: #621132; font-family: "Varela Round", sans-serif; padding: 15px;'],
                ],
                [
                    'attribute' => 'id_ruta',
                    'label' => 'ID',
                    'enableSorting' => false,
                    'headerOptions' => ['style' => 'background-color: #efefef; color: black; text-align: center; font-family: "Varela Round", sans-serif; padding: 15px;'],
                    'contentOptions' => ['style' => 'text-align: center; font-weight: 500; font-family: "Varela Round", sans-serif; padding: 15px;'],
                    'filterInputOptions' => [
                        'class' => 'form-control',
                        'style' => 'border-radius: 5px; border: 1px solid #d4a373; font-family: "Varela Round", sans-serif; text-align: center;',
                        'placeholder' => 'Buscar ID...'
                    ],
                ],
                [
                    'attribute' => 'nombre_ruta',
                    'label' => 'Nombre de la Ruta',
                    'enableSorting' => false,
                    'headerOptions' => ['style' => 'background-color: #efefef; color: black; font-family: "Varela Round", sans-serif; padding: 15px;'],
                    'contentOptions' => ['style' => 'font-weight: 500; font-family: "Varela Round", sans-serif; padding: 15px;'],
                    'filterInputOptions' => [
                        'class' => 'form-control',
                        'style' => 'border-radius: 5px; border: 1px solid #d4a373; font-family: "Varela Round", sans-serif;',
                        'placeholder' => 'Buscar ruta...'
                    ],
                ],
                [
                    'class' => ActionColumn::className(),
                    'header' => 'Acciones',
                    'headerOptions' => ['style' => 'background-color: #efefef; color: black; text-align: center; font-family: "Varela Round", sans-serif; padding: 15px;'],
                    'contentOptions' => ['style' => 'text-align: center; padding: 15px;'],
                    'template' => '{view} {update} {delete}',
                    'buttons' => [
                        'view' => function ($url) {
                            return Html::a('<i class="fas fa-eye"></i>', $url, [
                                'class' => 'btn btn-sm',
                                'style' => 'background: #5a3a2a; color: white; margin: 0 3px; border-radius: 8px; padding: 8px 12px;',
                                'title' => 'Ver',
                            ]);
                        },
                        'update' => function ($url) {
                            return Html::a('<i class="fas fa-edit"></i>', $url, [
                                'class' => 'btn btn-sm',
                                'style' => 'background: #d4a373; color: white; margin: 0 3px; border-radius: 8px; padding: 8px 12px;',
                                'title' => 'Editar',
                            ]);
                        },
                        'delete' => function ($url) {
                            return Html::a('<i class="fas fa-trash"></i>', $url, [
                                'class' => 'btn btn-sm',
                                'style' => 'background: #800020; color: white; margin: 0 3px; border-radius: 8px; padding: 8px 12px;',
                                'title' => 'Eliminar',
                                'data-confirm' => '¿Estás seguro de eliminar esta ruta?',
                                'data-method' => 'post',
                            ]);
                        },
                    ],
                    'urlCreator' => function ($action, Ruta $model) {
                        return Url::toRoute([$action, 'id_ruta' => $model->id_ruta]);
                    }
                ],
            ],
            'pager' => [
                'options' => ['class' => 'pagination'],
                'prevPageLabel' => '<i class="fas fa-chevron-left"></i>',
                'nextPageLabel' => '<i class="fas fa-chevron-right"></i>',
                'maxButtonCount' => 5,
            ],
        ]); ?>
    </div>
</div>

<?php
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
?>