<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="usuarios-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rol')->dropDownList(['operador' => 'Operador', 'admin' => 'Administrador'], ['prompt' => 'Selecciona rol...']) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <div class="form-group" style="margin-top: 30px; display: flex; gap: 10px;">
        <?php if ($model->isNewRecord): ?>
            <?= Html::submitButton('Guardar', ['class' => 'btn', 'style' => 'background-color: #621132; color: white; border: none; padding: 10px 30px; border-radius: 5px; font-weight: 600; cursor: pointer;']) ?>
        <?php else: ?>
            <?= Html::submitButton('Actualizar', ['class' => 'btn', 'style' => 'background-color: #621132; color: white; border: none; padding: 10px 30px; border-radius: 5px; font-weight: 600; cursor: pointer;']) ?>
        <?php endif; ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
