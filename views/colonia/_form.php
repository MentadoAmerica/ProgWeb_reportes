<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Colonia $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="colonia-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre_colonia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'num_habitantes')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
