<?php

use app\models\NumUnidad;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\NumUnidadSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Num Unidads';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="num-unidad-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Num Unidad', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_unidad',
            'id_tipo_unidad',
            'numero_unidad',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, NumUnidad $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_unidad' => $model->id_unidad]);
                 }
            ],
        ],
    ]); ?>


</div>
