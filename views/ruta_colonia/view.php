<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\RutaColonia $model */

$this->title = $model->id_ruta_colonia;
$this->params['breadcrumbs'][] = ['label' => 'Ruta Colonias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="ruta-colonia-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_ruta_colonia' => $model->id_ruta_colonia], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_ruta_colonia' => $model->id_ruta_colonia], [
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
            'id_ruta_colonia',
            'id_ruta',
            'id_colonia',
            'orden_numeracion',
        ],
    ]) ?>

</div>
