<?php

use app\models\Colonia;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ColoniaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Crear Colonias';
$this->params['breadcrumbs'][] = $this->title;

// Obtener el parámetro de ordenamiento actual
$currentSort = Yii::$app->request->get('sort', '');
?>

<div class="colonia-index">

    <!-- Encabezado -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div>
            <h2 style="color: #621132; font-weight: 600; margin-bottom: 5px; font-family: 'Varela Round', sans-serif; font-size: 32px;">
                <i class="fas fa-city" style="margin-right: 10px; color: #621132;"></i>
                <?= Html::encode($this->title) ?>
            </h2>
            <p style="color: #7a6a5a; margin: 0; font-size: 16px; font-family: 'Varela Round', sans-serif;">
                <i class="fas fa-info-circle" style="margin-right: 5px; color: #621132;"></i>
                Administra las colonias y su número de habitantes
            </p>
        </div>
        <div>
            <?= Html::a(
                '<i class="fas fa-plus-circle" style="margin-right: 8px;"></i> Crear Colonia', 
                ['create'], 
                [
                    'class' => 'btn btn-create-colonia', 
                    'style' => 'background-color: #621132; color: white; border: none; padding: 12px 24px; border-radius: 10px; font-weight: 600; font-family: "Varela Round", sans-serif; font-size: 16px; transition: all 0.3s ease; box-shadow: 0 4px 8px rgba(98, 17, 50, 0.2); text-decoration: none;',
                    'onmouseover' => 'this.style.backgroundColor="#800020"; this.style.transform="translateY(-2px)"; this.style.boxShadow="0 6px 12px rgba(128, 0, 32, 0.3)";',
                    'onmouseout' => 'this.style.backgroundColor="#621132"; this.style.transform="translateY(0)"; this.style.boxShadow="0 4px 8px rgba(98, 17, 50, 0.2)";'
                ]
            ) ?>
        </div>
    </div>

    <!-- Filtros y Ordenamiento -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px;">
    <div style="display: flex; gap: 10px; align-items: center;">
        <!-- Botón único de ordenamiento -->
        <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false" 
                    style="background: white; border: 1px solid #d4a373; color: #621132; padding: 8px 18px; border-radius: 30px; font-family: 'Varela Round', sans-serif; font-size: 14px; transition: all 0.2s ease; box-shadow: 0 2px 6px rgba(98, 17, 50, 0.08);">
                <i class="fas fa-arrow-<?= strpos($currentSort, '-') === 0 ? 'down' : 'up' ?>-wide-short" style="margin-right: 8px;"></i>
                <?php
                $sortLabels = [
                    'id_colonia' => 'ID (Menor a Mayor)',
                    '-id_colonia' => 'ID (Mayor a Menor)',
                    'nombre_colonia' => 'Nombre (A-Z)',
                    '-nombre_colonia' => 'Nombre (Z-A)',
                    'num_habitantes' => 'Habitantes (Menor a Mayor)',
                    '-num_habitantes' => 'Habitantes (Mayor a Menor)',
                ];
                echo $currentSort && isset($sortLabels[$currentSort]) ? $sortLabels[$currentSort] : 'Ordenar por...';
                ?>
            </button>
            <ul class="dropdown-menu" aria-labelledby="sortDropdown" style="border-radius: 12px; border: 1px solid #f0e0d0; box-shadow: 0 6px 16px rgba(98, 17, 50, 0.12); padding: 8px 0; min-width: 220px;">
                <li><h6 class="dropdown-header" style="color: #621132; font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 8px 16px;"><i class="fas fa-hashtag" style="margin-right: 6px;"></i>ID</h6></li>
                <li><?= Html::a('<i class="fas fa-arrow-up" style="margin-right: 10px; width: 16px;"></i>Menor a Mayor', ['index', 'sort' => 'id_colonia'] + Yii::$app->request->queryParams, ['class' => 'dropdown-item' . ($currentSort == 'id_colonia' ? ' active' : ''), 'style' => 'padding: 8px 16px; font-family: "Varela Round", sans-serif;']) ?></li>
                <li><?= Html::a('<i class="fas fa-arrow-down" style="margin-right: 10px; width: 16px;"></i>Mayor a Menor', ['index', 'sort' => '-id_colonia'] + Yii::$app->request->queryParams, ['class' => 'dropdown-item' . ($currentSort == '-id_colonia' ? ' active' : ''), 'style' => 'padding: 8px 16px; font-family: "Varela Round", sans-serif;']) ?></li>
                
                <li><hr class="dropdown-divider" style="margin: 5px 0;"></li>
                <li><h6 class="dropdown-header" style="color: #621132; font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 8px 16px;"><i class="fas fa-font" style="margin-right: 6px;"></i>Nombre</h6></li>
                <li><?= Html::a('<i class="fas fa-arrow-up" style="margin-right: 10px; width: 16px;"></i>A - Z', ['index', 'sort' => 'nombre_colonia'] + Yii::$app->request->queryParams, ['class' => 'dropdown-item' . ($currentSort == 'nombre_colonia' ? ' active' : ''), 'style' => 'padding: 8px 16px; font-family: "Varela Round", sans-serif;']) ?></li>
                <li><?= Html::a('<i class="fas fa-arrow-down" style="margin-right: 10px; width: 16px;"></i>Z - A', ['index', 'sort' => '-nombre_colonia'] + Yii::$app->request->queryParams, ['class' => 'dropdown-item' . ($currentSort == '-nombre_colonia' ? ' active' : ''), 'style' => 'padding: 8px 16px; font-family: "Varela Round", sans-serif;']) ?></li>
                
                <li><hr class="dropdown-divider" style="margin: 5px 0;"></li>
                <li><h6 class="dropdown-header" style="color: #621132; font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 8px 16px;"><i class="fas fa-users" style="margin-right: 6px;"></i>Habitantes</h6></li>
                <li><?= Html::a('<i class="fas fa-arrow-up" style="margin-right: 10px; width: 16px;"></i>Menor a Mayor', ['index', 'sort' => 'num_habitantes'] + Yii::$app->request->queryParams, ['class' => 'dropdown-item' . ($currentSort == 'num_habitantes' ? ' active' : ''), 'style' => 'padding: 8px 16px; font-family: "Varela Round", sans-serif;']) ?></li>
                <li><?= Html::a('<i class="fas fa-arrow-down" style="margin-right: 10px; width: 16px;"></i>Mayor a Menor', ['index', 'sort' => '-num_habitantes'] + Yii::$app->request->queryParams, ['class' => 'dropdown-item' . ($currentSort == '-num_habitantes' ? ' active' : ''), 'style' => 'padding: 8px 16px; font-family: "Varela Round", sans-serif;']) ?></li>
                
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

<!-- Estilo para el dropdown activo -->
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
</style>

    <!-- Tabla con bordes redondeados y sombra -->
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
                            Total: <b>".$dataProvider->getTotalCount()."</b> colonias
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
                    'headerOptions' => ['style' => 'background-color: #efefef; color: black; text-align: center; font-family: "Varela Round", sans-serif; padding: 15px; font-size: 15px;'],
                    'contentOptions' => ['style' => 'text-align: center; font-weight: 600; color: #621132; font-family: "Varela Round", sans-serif; padding: 15px; font-size: 15px;'],
                    'filterOptions' => ['style' => 'padding: 10px;'],
                ],
                [
                    'attribute' => 'id_colonia',
                    'label' => 'ID',
                    'headerOptions' => ['style' => 'background-color: #efefef; color: black; font-family: "Varela Round", sans-serif; padding: 15px; font-size: 15px;'],
                    'contentOptions' => ['style' => 'text-align: center; font-weight: 500; font-family: "Varela Round", sans-serif; padding: 15px; font-size: 15px;'],
                    'filterOptions' => ['style' => 'padding: 10px;'],
                    'enableSorting' => false,
                    'filterInputOptions' => [
                        'class' => 'form-control',
                        'style' => 'border-radius: 5px; border: 1px solid #d4a373; font-family: "Varela Round", sans-serif; font-size: 14px;',
                        'placeholder' => 'Buscar ID...'
                    ],
                ],
                [
                    'attribute' => 'nombre_colonia',
                    'label' => 'Nombre de la Colonia',
                    'headerOptions' => ['style' => 'background-color: #efefef; color: black; font-family: "Varela Round", sans-serif; padding: 15px; font-size: 15px;'],
                    'contentOptions' => ['style' => 'font-weight: 500; font-family: "Varela Round", sans-serif; padding: 15px; font-size: 15px;'],
                    'filterOptions' => ['style' => 'padding: 10px;'],
                    'enableSorting' => false,
                    'filterInputOptions' => [
                        'class' => 'form-control',
                        'style' => 'border-radius: 5px; border: 1px solid #d4a373; font-family: "Varela Round", sans-serif; font-size: 14px;',
                        'placeholder' => 'Buscar colonia...'
                    ],
                ],
                [
                    'attribute' => 'num_habitantes',
                    'label' => 'Habitantes',
                    'headerOptions' => ['style' => 'background-color: #efefef; color: black; font-family: "Varela Round", sans-serif; padding: 15px; font-size: 15px;'],
                    'contentOptions' => ['style' => 'text-align: center; font-weight: 500; font-family: "Varela Round", sans-serif; padding: 15px; font-size: 15px;'],
                    'filterOptions' => ['style' => 'padding: 10px;'],
                    'enableSorting' => false,
                    'filterInputOptions' => [
                        'class' => 'form-control',
                        'style' => 'border-radius: 5px; border: 1px solid #d4a373; font-family: "Varela Round", sans-serif; font-size: 14px; text-align: right;',
                        'placeholder' => 'Buscar...'
                    ],
                    'value' => function ($model) {
                        return number_format($model->num_habitantes, 0, ',', '.');
                    }
                ],
                [
                    'class' => ActionColumn::className(),
                    'header' => 'Acciones',
                    'headerOptions' => ['style' => 'background-color: #efefef; color: black; text-align: center; font-family: "Varela Round", sans-serif; padding: 15px; font-size: 15px;'],
                    'contentOptions' => ['style' => 'text-align: center; padding: 15px;'],
                    'filterOptions' => ['style' => 'padding: 10px;'],
                    'template' => '{view} {update} {delete}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a('<i class="fas fa-eye"></i>', $url, [
                                'class' => 'btn btn-sm',
                                'style' => 'background: linear-gradient(135deg, #5a3a2a 0%, #7a5a4a 100%); color: white; margin: 0 3px; border-radius: 8px; padding: 8px 12px; font-size: 13px; transition: all 0.3s ease; border: none;',
                                'title' => 'Ver',
                                'onmouseover' => 'this.style.transform="translateY(-2px)"; this.style.boxShadow="0 4px 8px rgba(90, 58, 42, 0.3)";',
                                'onmouseout' => 'this.style.transform="translateY(0)"; this.style.boxShadow="none";'
                            ]);
                        },
                        'update' => function ($url, $model) {
                            return Html::a('<i class="fas fa-edit"></i>', $url, [
                                'class' => 'btn btn-sm',
                                'style' => 'background: linear-gradient(135deg, #d4a373 0%, #e8c4a0 100%); color: white; margin: 0 3px; border-radius: 8px; padding: 8px 12px; font-size: 13px; transition: all 0.3s ease; border: none;',
                                'title' => 'Editar',
                                'onmouseover' => 'this.style.transform="translateY(-2px)"; this.style.boxShadow="0 4px 8px rgba(212, 163, 115, 0.3)";',
                                'onmouseout' => 'this.style.transform="translateY(0)"; this.style.boxShadow="none";'
                            ]);
                        },
                        'delete' => function ($url, $model) {
                            return Html::a('<i class="fas fa-trash"></i>', $url, [
                                'class' => 'btn btn-sm',
                                'style' => 'background: linear-gradient(135deg, #800020 0%, #a00028 100%); color: white; margin: 0 3px; border-radius: 8px; padding: 8px 12px; font-size: 13px; transition: all 0.3s ease; border: none;',
                                'title' => 'Eliminar',
                                'data-confirm' => '¿Estás seguro de eliminar esta colonia?',
                                'data-method' => 'post',
                                'onmouseover' => 'this.style.transform="translateY(-2px)"; this.style.boxShadow="0 4px 8px rgba(128, 0, 32, 0.3)";',
                                'onmouseout' => 'this.style.transform="translateY(0)"; this.style.boxShadow="none";'
                            ]);
                        },
                    ],
                    'urlCreator' => function ($action, Colonia $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id_colonia' => $model->id_colonia]);
                    }
                ],
            ],
            'pager' => [
                'options' => ['class' => 'pagination'],
                'prevPageLabel' => '<i class="fas fa-chevron-left"></i>',
                'nextPageLabel' => '<i class="fas fa-chevron-right"></i>',
                'maxButtonCount' => 5,
                'linkOptions' => ['style' => 'font-size: 14px; padding: 10px 15px;'],
            ],
        ]); ?>
    </div>

</div>

<!-- CSS adicional para el dropdown activo -->
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
</style>

<?php
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
?>