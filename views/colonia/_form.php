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

    <div class="form-group" style="margin-top: 30px; display: flex; gap: 10px;">
        <?php if ($model->isNewRecord): ?>
            <?= Html::submitButton('Guardar', ['class' => 'btn', 'style' => 'background-color: #621132; color: white; border: none; padding: 10px 30px; border-radius: 5px; font-weight: 600; cursor: pointer;']) ?>
        <?php else: ?>
            <?= Html::submitButton('Actualizar', ['class' => 'btn', 'style' => 'background-color: #621132; color: white; border: none; padding: 10px 30px; border-radius: 5px; font-weight: 600; cursor: pointer;']) ?>
        <?php endif; ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
