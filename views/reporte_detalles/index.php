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
?>
<div class="reporte-detalles-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Reporte Detalles', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_reporte',
            'id_folio',
            'id_colonia',
            'porcentaje_colonia',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, ReporteDetalles $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_reporte' => $model->id_reporte]);
                 }
            ],
        ],
    ]); ?>


</div>
