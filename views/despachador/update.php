<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Despachador $model */

$this->title = 'Update Despachador: ' . $model->id_despachador;
$this->params['breadcrumbs'][] = ['label' => 'Despachadors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_despachador, 'url' => ['view', 'id_despachador' => $model->id_despachador]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="despachador-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
