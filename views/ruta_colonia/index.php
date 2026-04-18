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

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Ruta Colonia', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

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
