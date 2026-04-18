<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Despachador $model */

$this->title = $model->id_despachador;
$this->params['breadcrumbs'][] = ['label' => 'Despachadors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="despachador-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_despachador' => $model->id_despachador], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_despachador' => $model->id_despachador], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_despachador',
            'nombre_despachador',
        ],
    ]) ?>

</div>
