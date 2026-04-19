<?php

use app\models\Usuarios;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\UsuariosSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;

$currentSort = Yii::$app->request->get('sort', '');
$isAdmin = Yii::$app->user->identity->isAdmin();
?>

<div class="usuarios-index">

    <!-- Encabezado -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div>
            <h2 style="color: #621132; font-weight: 600; margin-bottom: 5px; font-family: 'Varela Round', sans-serif; font-size: 32px;">
                <i class="fas fa-users" style="margin-right: 10px; color: #621132;"></i>
                <?= Html::encode($this->title) ?>
            </h2>
            <p style="color: #7a6a5a; margin: 0; font-size: 16px; font-family: 'Varela Round', sans-serif;">
                <i class="fas fa-info-circle" style="margin-right: 5px; color: #621132;"></i>
                Administra los usuarios del sistema
            </p>
        </div>
        <?php if ($isAdmin): ?>
        <div>
            <?= Html::a(
                '<i class="fas fa-plus-circle" style="margin-right: 8px;"></i> Crear Usuario', 
                ['create'], 
                [
                    'style' => 'background-color: #621132; color: white; border: none; padding: 12px 24px; border-radius: 10px; font-weight: 600; font-family: "Varela Round", sans-serif; font-size: 16px; transition: all 0.3s ease; box-shadow: 0 4px 8px rgba(98, 17, 50, 0.2); text-decoration: none;',
                    'onmouseover' => 'this.style.backgroundColor="#800020"; this.style.transform="translateY(-2px)"; this.style.boxShadow="0 6px 12px rgba(128, 0, 32, 0.3)";',
                    'onmouseout' => 'this.style.backgroundColor="#621132"; this.style.transform="translateY(0)"; this.style.boxShadow="0 4px 8px rgba(98, 17, 50, 0.2)";'
                ]
            ) ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- Filtros y Ordenamiento -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px;">
        <div style="display: flex; gap: 10px; align-items: center;">
            <?php
            $sortCycle = [
                '' => ['label' => 'Ordenar por...', 'icon' => 'fa-sort', 'next' => 'nombre'],
                'nombre' => ['label' => 'Nombre (A-Z)', 'icon' => 'fa-arrow-up-a-z', 'next' => '-nombre'],
                '-nombre' => ['label' => 'Nombre (Z-A)', 'icon' => 'fa-arrow-down-z-a', 'next' => 'rol'],
                'rol' => ['label' => 'Rol (A-Z)', 'icon' => 'fa-arrow-up-a-z', 'next' => '-rol'],
                '-rol' => ['label' => 'Rol (Z-A)', 'icon' => 'fa-arrow-down-z-a', 'next' => ''],
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
                            Total: <b>".$dataProvider->getTotalCount()."</b> usuarios
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
                ['class' => 'yii\grid\SerialColumn'],
                
                [
                    'attribute' => 'id',
                    'label' => 'ID',
                    'enableSorting' => false,
                    'headerOptions' => ['style' => 'background-color: #efefef; color: black; text-align: center;'],
                    'contentOptions' => ['style' => 'text-align: center; font-weight: 500;'],
                    'filterInputOptions' => ['class' => 'form-control', 'style' => 'border-radius: 5px; border: 1px solid #d4a373;', 'placeholder' => 'Buscar...'],
                ],
                
                [
                    'attribute' => 'nombre',
                    'label' => 'Nombre',
                    'enableSorting' => false,
                    'headerOptions' => ['style' => 'background-color: #efefef; color: black; text-align: center;'],
                    'filterInputOptions' => ['class' => 'form-control', 'style' => 'border-radius: 5px; border: 1px solid #d4a373;', 'placeholder' => 'Buscar...'],
                ],
                
                [
                    'attribute' => 'email',
                    'label' => 'Correo',
                    'enableSorting' => false,
                    'headerOptions' => ['style' => 'background-color: #efefef; color: black; text-align: center;'],
                    'filterInputOptions' => ['class' => 'form-control', 'style' => 'border-radius: 5px; border: 1px solid #d4a373;', 'placeholder' => 'Buscar...'],
                ],
                
                [
                    'attribute' => 'rol',
                    'label' => 'Rol',
                    'enableSorting' => false,
                    'headerOptions' => ['style' => 'background-color: #efefef; color: black; text-align: center;'],
                    'filter' => ['admin' => 'Administrador', 'usuario' => 'Usuario'],
                    'filterInputOptions' => ['class' => 'form-control', 'style' => 'border-radius: 5px; border: 1px solid #d4a373;'],
                    'value' => function ($model) {
                        return $model->rol == 'admin' ? 'Administrador' : 'Usuario';
                    },
                    'contentOptions' => function ($model) {
                        return ['style' => 'font-weight: 600; color: ' . ($model->rol == 'admin' ? '#621132' : '#7a6a5a') . ';'];
                    }
                ],
                
                [
                    'class' => ActionColumn::className(),
                    'header' => 'Acciones',
                    'visible' => $isAdmin,
                    'headerOptions' => ['style' => 'background-color: #efefef; color: black; text-align: center;'],
                    'contentOptions' => ['style' => 'text-align: center;'],
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
                                'data-confirm' => '¿Estás seguro de eliminar este usuario?',
                                'data-method' => 'post',
                            ]);
                        },
                    ],
                    'urlCreator' => function ($action, Usuarios $model) {
                        return Url::toRoute([$action, 'id' => $model->id]);
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