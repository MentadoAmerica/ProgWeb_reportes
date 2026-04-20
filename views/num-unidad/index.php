<?php

use app\models\NumUnidad;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\NumUnidadSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Unidades';
$this->params['breadcrumbs'][] = $this->title;

$currentSort = Yii::$app->request->get('sort', '');
?>

<div class="num-unidad-index">

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
                <i class="fas fa-truck" style="margin-right: 10px; color: #621132;"></i>
                <?= Html::encode($this->title) ?>
            </h2>
            <p style="color: #7a6a5a; margin: 0; font-size: 16px; font-family: 'Varela Round', sans-serif;">
                <i class="fas fa-info-circle" style="margin-right: 5px; color: #621132;"></i>
                Administra las unidades y sus detalles
            </p>
        </div>
        <div>
            <?= Html::a(
                '<i class="fas fa-plus-circle" style="margin-right: 8px;"></i> Crear Unidad', 
                ['create'], 
                [
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
            <?php
            $sortCycle = [
                '' => ['label' => 'Ordenar por...', 'icon' => 'fa-sort', 'next' => 'numero_unidad'],
                'numero_unidad' => ['label' => 'Número ↑', 'icon' => 'fa-arrow-up-1-9', 'next' => '-numero_unidad'],
                '-numero_unidad' => ['label' => 'Número ↓', 'icon' => 'fa-arrow-down-9-1', 'next' => ''],
            ];
            
            $current = $currentSort ?: '';
            $nextSort = $sortCycle[$current]['next'] ?? '';
            $currentLabel = $sortCycle[$current]['label'] ?? 'Ordenar por...';
            $currentIcon = $sortCycle[$current]['icon'] ?? 'fa-sort';
            ?>
            
            <?= Html::a(
                '<i class="fas ' . $currentIcon . '" style="margin-right: 8px;"></i>' . $currentLabel, 
                $nextSort ? array_merge(['index'], Yii::$app->request->queryParams, ['sort' => $nextSort]) : ['index'], 
                [
                    'class' => 'btn',
                    'style' => 'background: white; border: 1px solid #d4a373; color: #621132; padding: 9px 20px; border-radius: 30px; font-family: "Varela Round", sans-serif; font-size: 14px; transition: all 0.2s ease; text-decoration: none; box-shadow: 0 2px 6px rgba(98, 17, 50, 0.08);',
                    'onmouseover' => 'this.style.backgroundColor="#f9e4d4"; this.style.borderColor="#621132";',
                    'onmouseout' => 'this.style.backgroundColor="white"; this.style.borderColor="#d4a373";'
                ]
            ) ?>
            
            <?php if ($currentSort): ?>
                <?= Html::a(
                    '<i class="fas fa-times"></i>', 
                    array_merge(['index'], Yii::$app->request->queryParams, ['sort' => null]), 
                    [
                        'class' => 'btn',
                        'style' => 'background: white; border: 1px solid #dc3545; color: #dc3545; width: 38px; height: 38px; border-radius: 50%; padding: 0; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease; text-decoration: none;',
                        'title' => 'Limpiar ordenamiento',
                        'onmouseover' => 'this.style.backgroundColor="#f8d7da";',
                        'onmouseout' => 'this.style.backgroundColor="white";'
                    ]
                ) ?>
            <?php endif; ?>
        </div>
        
        <div>
            <?= Html::a(
                '<i class="fas fa-undo-alt" style="margin-right: 5px;"></i> Limpiar filtros', 
                ['index'], 
                [
                    'class' => 'btn', 
                    'style' => 'background: white; border: 1px solid #d4a373; color: #621132; padding: 9px 18px; border-radius: 30px; font-family: "Varela Round", sans-serif; font-size: 14px; transition: all 0.2s ease; text-decoration: none;',
                    'onmouseover' => 'this.style.backgroundColor="#f9e4d4";',
                    'onmouseout' => 'this.style.backgroundColor="white";'
                ]
            ) ?>
        </div>
    </div>

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
                            Total: <b>".$dataProvider->getTotalCount()."</b> unidades
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
                    'attribute' => 'numero_unidad',
                    'label' => 'Número de Unidad',
                    'headerOptions' => ['style' => 'background-color: #efefef; color: black; font-family: "Varela Round", sans-serif; padding: 15px;'],
                    'contentOptions' => ['style' => 'text-align: center; font-weight: 500; font-family: "Varela Round", sans-serif; padding: 15px;'],
                    'enableSorting' => false,
                    'filterInputOptions' => [
                        'class' => 'form-control',
                        'style' => 'border-radius: 5px; border: 1px solid #d4a373; font-family: "Varela Round", sans-serif;',
                        'placeholder' => 'Buscar...'
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
                                'style' => 'background: linear-gradient(135deg, #5a3a2a 0%, #7a5a4a 100%); color: white; margin: 0 3px; border-radius: 8px; padding: 8px 12px;',
                                'title' => 'Ver',
                            ]);
                        },
                        'update' => function ($url) {
                            return Html::a('<i class="fas fa-edit"></i>', $url, [
                                'class' => 'btn btn-sm',
                                'style' => 'background: linear-gradient(135deg, #d4a373 0%, #e8c4a0 100%); color: white; margin: 0 3px; border-radius: 8px; padding: 8px 12px;',
                                'title' => 'Editar',
                            ]);
                        },
                        'delete' => function ($url) {
                            return Html::a('<i class="fas fa-trash"></i>', $url, [
                                'class' => 'btn btn-sm',
                                'style' => 'background: linear-gradient(135deg, #800020 0%, #a00028 100%); color: white; margin: 0 3px; border-radius: 8px; padding: 8px 12px;',
                                'title' => 'Eliminar',
                                'data-confirm' => '¿Estás seguro de eliminar esta unidad?',
                                'data-method' => 'post',
                            ]);
                        },
                    ],
                    'urlCreator' => function ($action, NumUnidad $model) {
                        return Url::toRoute([$action, 'id_unidad' => $model->id_unidad]);
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