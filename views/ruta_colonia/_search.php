<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\RutaColoniaSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="ruta-colonia-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_ruta_colonia') ?>

    <?= $form->field($model, 'id_ruta') ?>

    <?= $form->field($model, 'id_colonia') ?>

    <?= $form->field($model, 'orden_numeracion') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
