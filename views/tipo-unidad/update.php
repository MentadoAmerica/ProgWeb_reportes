<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TipoUnidad $model */

$this->title = 'Update Tipo Unidad: ' . $model->id_tipo_unidad;
$this->params['breadcrumbs'][] = ['label' => 'Tipo Unidads', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_tipo_unidad, 'url' => ['view', 'id_tipo_unidad' => $model->id_tipo_unidad]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tipo-unidad-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
