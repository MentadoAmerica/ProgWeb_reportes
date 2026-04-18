<?php

use app\models\Despachador;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\DespachadorSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Despachadors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="despachador-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Despachador', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_despachador',
            'nombre_despachador',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Despachador $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_despachador' => $model->id_despachador]);
                 }
            ],
        ],
    ]); ?>


</div>
