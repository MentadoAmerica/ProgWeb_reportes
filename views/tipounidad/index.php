<?php

use app\models\TipoUnidad;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\TipoUnidadSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tipo Unidads';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-unidad-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Tipo Unidad', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_tipo_unidad',
            'nombre_tipo',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, TipoUnidad $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_tipo_unidad' => $model->id_tipo_unidad]);
                 }
            ],
        ],
    ]); ?>


</div>
