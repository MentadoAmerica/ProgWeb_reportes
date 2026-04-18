<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\DetalleDiarioSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="detalle-diario-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_folio') ?>

    <?= $form->field($model, 'fecha_orden') ?>

    <?= $form->field($model, 'fecha_captura') ?>

    <?= $form->field($model, 'turno') ?>

    <?= $form->field($model, 'id_tipo_unidad') ?>

    <?php // echo $form->field($model, 'id_unidad') ?>

    <?php // echo $form->field($model, 'id_ruta') ?>

    <?php // echo $form->field($model, 'id_chofer') ?>

    <?php // echo $form->field($model, 'cantidad_kg') ?>

    <?php // echo $form->field($model, 'porcentaje_efectividad') ?>

    <?php // echo $form->field($model, 'comentarios') ?>

    <?php // echo $form->field($model, 'num_puches') ?>

    <?php // echo $form->field($model, 'km_salir') ?>

    <?php // echo $form->field($model, 'km_entrar') ?>

    <?php // echo $form->field($model, 'total_km') ?>

    <?php // echo $form->field($model, 'diesel_iniciar') ?>

    <?php // echo $form->field($model, 'diesel_terminar') ?>

    <?php // echo $form->field($model, 'diesel_cargado') ?>

    <?php // echo $form->field($model, 'id_despachador') ?>

    <?php // echo $form->field($model, 'colonia_1') ?>

    <?php // echo $form->field($model, 'colonia_2') ?>

    <?php // echo $form->field($model, 'colonia_3') ?>

    <?php // echo $form->field($model, 'colonia_4') ?>

    <?php // echo $form->field($model, 'colonia_5') ?>

    <?php // echo $form->field($model, 'colonia_6') ?>

    <?php // echo $form->field($model, 'colonia_7') ?>

    <?php // echo $form->field($model, 'colonia_8') ?>

    <?php // echo $form->field($model, 'colonia_9') ?>

    <?php // echo $form->field($model, 'colonia_10') ?>

    <?php // echo $form->field($model, 'colonia_11') ?>

    <?php // echo $form->field($model, 'por_colonia_1') ?>

    <?php // echo $form->field($model, 'por_colonia_2') ?>

    <?php // echo $form->field($model, 'por_colonia_3') ?>

    <?php // echo $form->field($model, 'por_colonia_4') ?>

    <?php // echo $form->field($model, 'por_colonia_5') ?>

    <?php // echo $form->field($model, 'por_colonia_6') ?>

    <?php // echo $form->field($model, 'por_colonia_7') ?>

    <?php // echo $form->field($model, 'por_colonia_8') ?>

    <?php // echo $form->field($model, 'por_colonia_9') ?>

    <?php // echo $form->field($model, 'por_colonia_10') ?>

    <?php // echo $form->field($model, 'por_colonia_11') ?>

    <?php // echo $form->field($model, 'anio') ?>

    <?php // echo $form->field($model, 'mes') ?>

    <?php // echo $form->field($model, 'dia') ?>

    <?php // echo $form->field($model, 'cant_colonias') ?>

    <?php // echo $form->field($model, 'suma_por_atendida') ?>

    <?php // echo $form->field($model, 'por_realizado') ?>

    <?php // echo $form->field($model, 'habitantes_1') ?>

    <?php // echo $form->field($model, 'habitantes_2') ?>

    <?php // echo $form->field($model, 'habitantes_3') ?>

    <?php // echo $form->field($model, 'habitantes_4') ?>

    <?php // echo $form->field($model, 'habitantes_5') ?>

    <?php // echo $form->field($model, 'habitantes_6') ?>

    <?php // echo $form->field($model, 'habitantes_7') ?>

    <?php // echo $form->field($model, 'habitantes_8') ?>

    <?php // echo $form->field($model, 'habitantes_9') ?>

    <?php // echo $form->field($model, 'habitantes_10') ?>

    <?php // echo $form->field($model, 'habitantes_11') ?>

    <?php // echo $form->field($model, 'id_usuario') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
