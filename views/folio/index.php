<?php

use app\models\Folio;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\FolioSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Folios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="folio-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Folio', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_folio',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Folio $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_folio' => $model->id_folio]);
                 }
            ],
        ],
    ]); ?>


</div>
