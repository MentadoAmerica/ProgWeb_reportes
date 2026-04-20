<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\NumUnidad $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="num-unidad-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_tipo_unidad')->textInput() ?>

    <?= $form->field($model, 'numero_unidad')->textInput(['maxlength' => true]) ?>

    <div class="form-group" style="margin-top: 30px; display: flex; gap: 10px;">
        <?php if ($model->isNewRecord): ?>
            <?= Html::submitButton('Guardar', ['class' => 'btn', 'style' => 'background-color: #621132; color: white; border: none; padding: 10px 30px; border-radius: 5px; font-weight: 600; cursor: pointer;']) ?>
        <?php else: ?>
            <?= Html::submitButton('Actualizar', ['class' => 'btn', 'style' => 'background-color: #621132; color: white; border: none; padding: 10px 30px; border-radius: 5px; font-weight: 600; cursor: pointer;']) ?>
        <?php endif; ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
