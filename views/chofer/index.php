<?php

use app\models\Chofer;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ChoferSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Chofers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chofer-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Chofer', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_chofer',
            'nombre_chofer',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Chofer $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_chofer' => $model->id_chofer]);
                 }
            ],
        ],
    ]); ?>


</div>
