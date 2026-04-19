<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\TipoUnidad;
use app\models\NumUnidad;
use app\models\Ruta;
use app\models\Chofer;
use app\models\Despachador;

/** @var yii\web\View $this */
/** @var app\models\DetalleDiarioSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="detalle-diario-search mb-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white py-3" style="border-left: 4px solid #611232;">
            <h5 class="mb-0"><i class="bi bi-funnel"></i> Filtros de búsqueda</h5>
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
                'options' => ['class' => 'row g-3'],
            ]); ?>

            <div class="col-md-3">
                <?= $form->field($model, 'id_folio')->textInput([
                    'placeholder' => 'Folio', 
                    'class' => 'form-control'
                ])->label('<i class="bi bi-hash"></i> Folio') ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'fecha_orden')->input('date', [
                    'class' => 'form-control'
                ])->label('<i class="bi bi-calendar"></i> Fecha') ?>
            </div>
            <div class="col-md-2">
                <?= $form->field($model, 'turno')->dropDownList(
                    [1 => 'Turno 1', 2 => 'Turno 2', 3 => 'Turno 3', 4 => 'Turno 4'],
                    ['prompt' => 'Todos', 'class' => 'form-select']
                )->label('<i class="bi bi-clock"></i> Turno') ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'id_tipo_unidad')->dropDownList(
                    ArrayHelper::map(TipoUnidad::find()->all(), 'id_tipo_unidad', 'nombre_tipo'),
                    ['prompt' => 'Todos', 'class' => 'form-select']
                )->label('<i class="bi bi-truck"></i> Tipo unidad') ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'id_unidad')->dropDownList(
                    ArrayHelper::map(NumUnidad::find()->all(), 'id_unidad', 'numero_unidad'),
                    ['prompt' => 'Todas', 'class' => 'form-select']
                )->label('<i class="bi bi-truck-front"></i> Unidad') ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'id_ruta')->dropDownList(
                    ArrayHelper::map(Ruta::find()->all(), 'id_ruta', 'nombre_ruta'),
                    ['prompt' => 'Todas', 'class' => 'form-select']
                )->label('<i class="bi bi-map"></i> Ruta') ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'id_chofer')->dropDownList(
                    ArrayHelper::map(Chofer::find()->all(), 'id_chofer', 'nombre_chofer'),
                    ['prompt' => 'Todos', 'class' => 'form-select']
                )->label('<i class="bi bi-person-badge"></i> Chofer') ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'id_despachador')->dropDownList(
                    ArrayHelper::map(Despachador::find()->all(), 'id_despachador', 'nombre_despachador'),
                    ['prompt' => 'Todos', 'class' => 'form-select']
                )->label('<i class="bi bi-person-check"></i> Despachador') ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'globalSearch')->textInput([
                    'placeholder' => 'Folio, unidad, ruta, chofer...',
                    'class' => 'form-control'
                ])->label('<i class="bi bi-search"></i> Búsqueda global') ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'fecha_desde')->input('date', [
                    'class' => 'form-control'
                ])->label('<i class="bi bi-calendar-range"></i> Desde') ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'fecha_hasta')->input('date', [
                    'class' => 'form-control'
                ])->label('<i class="bi bi-calendar-range"></i> Hasta') ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'nombre_colonia')->textInput([
                    'placeholder' => 'Nombre de colonia',
                    'class' => 'form-control'
                ])->label('<i class="bi bi-building"></i> Colonia') ?>
            </div>

            <div class="col-12 mt-3">
                <div class="d-flex justify-content-end gap-2">
                    <?= Html::resetButton('<i class="bi bi-arrow-repeat"></i> Limpiar', ['class' => 'btn btn-outline-secondary']) ?>
                    <?= Html::submitButton('<i class="bi bi-search"></i> Buscar', ['class' => 'btn btn-primary', 'style' => 'background-color:#611232; border-color:#611232;']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>