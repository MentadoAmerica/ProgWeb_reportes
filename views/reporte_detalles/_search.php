<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ReporteDetallesSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="reporte-detalles-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_reporte') ?>

    <?= $form->field($model, 'id_folio') ?>

    <?= $form->field($model, 'id_colonia') ?>

    <?= $form->field($model, 'porcentaje_colonia') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
