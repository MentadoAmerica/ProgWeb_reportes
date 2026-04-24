<?php

use app\models\RutaColonia;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\RutaColoniaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Ruta Colonias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ruta-colonia-index">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div>
            <h1 style="color: #621132; font-weight: 600; margin-bottom: 5px; font-family: 'Varela Round', sans-serif; font-size: 32px;"><?= Html::encode($this->title) ?></h1>
        </div>
        <div>
            <?= Html::a(
                '<i class="fas fa-plus-circle" style="margin-right: 8px;"></i> Crear Ruta Colonia',
                ['create'],
                [
                    'style' => 'background-color: #621132; color: white; border: none; padding: 12px 28px; border-radius: 10px; font-weight: 600; font-family: "Varela Round", sans-serif; font-size: 16px; transition: all 0.3s ease; box-shadow: 0 4px 8px rgba(98, 17, 50, 0.2); text-decoration: none; display: inline-flex; align-items: center; cursor: pointer;',
                    'onmouseover' => 'this.style.backgroundColor="#800020"; this.style.transform="translateY(-2px)"; this.style.boxShadow="0 6px 12px rgba(128, 0, 32, 0.3)";',
                    'onmouseout' => 'this.style.backgroundColor="#621132"; this.style.transform="translateY(0)"; this.style.boxShadow="0 4px 8px rgba(98, 17, 50, 0.2)";'
                ]
            ) ?>
        </div>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_ruta_colonia',
            'id_ruta',
            'id_colonia',
            'orden_numeracion',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, RutaColonia $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_ruta_colonia' => $model->id_ruta_colonia]);
                 }
            ],
        ],
    ]); ?>


</div>
