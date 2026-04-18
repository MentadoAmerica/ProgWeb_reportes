<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ReporteDetalles $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="reporte-detalles-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_folio')->textInput() ?>

    <?= $form->field($model, 'id_colonia')->textInput() ?>

    <?= $form->field($model, 'porcentaje_colonia')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
