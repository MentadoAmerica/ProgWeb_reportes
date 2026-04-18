<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TipoUnidad $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tipo-unidad-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre_tipo')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
