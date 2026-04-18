<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\RutaColonia $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="ruta-colonia-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_ruta')->textInput() ?>

    <?= $form->field($model, 'id_colonia')->textInput() ?>

    <?= $form->field($model, 'orden_numeracion')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
