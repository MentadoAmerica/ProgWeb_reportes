<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\DetalleDiario $model */

$this->title = 'Update Detalle Diario: ' . $model->id_folio;
$this->params['breadcrumbs'][] = ['label' => 'Detalle Diarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_folio, 'url' => ['view', 'id_folio' => $model->id_folio]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="detalle-diario-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
