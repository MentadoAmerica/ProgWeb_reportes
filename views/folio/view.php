<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Folio $model */

$this->title = $model->id_folio;
$this->params['breadcrumbs'][] = ['label' => 'Folios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="folio-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_folio' => $model->id_folio], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_folio' => $model->id_folio], [
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
            'id_folio',
        ],
    ]) ?>

</div>
