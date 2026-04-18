<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Folio $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="folio-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_folio')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
