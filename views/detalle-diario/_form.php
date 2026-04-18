<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

// CSS para colores beige y guindo
$this->registerCss("
    body { background-color: #fdf8f0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    .detalle-diario-form { background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    .btn-guindo { background-color: #800020; border-color: #800020; color: white; }
    .btn-guindo:hover { background-color: #a00028; border-color: #a00028; }
    .form-control:focus { border-color: #800020; box-shadow: 0 0 5px rgba(128,0,32,0.3); }
    .table thead { background-color: #800020; color: white; }
    .table-striped>tbody>tr:nth-of-type(odd) { background-color: #f9e4d4; }
    label { font-weight: 600; color: #5a3a2a; }
    .navbar-inverse { background-color: #800020; border-color: #5a1a1a; }
    .navbar-inverse .navbar-brand, .navbar-inverse .navbar-nav>li>a { color: #fdf8f0; }
    .navbar-inverse .navbar-brand:hover, .navbar-inverse .navbar-nav>li>a:hover { color: #ffccaa; }
");
?>

<div class="detalle-diario-form">
    <?php $form = ActiveForm::begin(['id' => 'form-reporte']); ?>

    <!-- PRIMERA FILA: 3 columnas con los campos esenciales -->
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'fecha_orden')->input('date') ?>
            <?= $form->field($model, 'turno')->dropDownList([1=>1,2=>2,3=>3,4=>4], ['prompt'=>'Seleccione turno']) ?>
            <?= $form->field($model, 'id_tipo_unidad')->dropDownList(
                ArrayHelper::map($tiposUnidad, 'id_tipo_unidad', 'nombre_tipo'),
                ['prompt' => 'Seleccione tipo', 'id' => 'tipo-unidad']
            ) ?>
            <?= $form->field($model, 'id_unidad')->dropDownList(
                [],
                ['prompt' => 'Primero seleccione tipo', 'id' => 'num-unidad']
            ) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'id_ruta')->dropDownList(
                ArrayHelper::map($rutas, 'id_ruta', function($r) { return $r->id_ruta . ' - ' . $r->nombre_ruta; }),
                ['prompt' => 'Seleccione ruta', 'id' => 'ruta']
            ) ?>
            <?= $form->field($model, 'id_chofer')->dropDownList(
                ArrayHelper::map($choferes, 'id_chofer', 'nombre_chofer'),
                ['prompt' => 'Seleccione chofer']
            ) ?>
            <?= $form->field($model, 'id_despachador')->dropDownList(
                ArrayHelper::map($despachadores, 'id_despachador', 'nombre_despachador'),
                ['prompt' => 'Seleccione despachador']
            ) ?>
            <?= $form->field($model, 'cantidad_kg')->textInput(['type' => 'number', 'step' => 'any', 'placeholder' => 'kg']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'num_puches')->textInput(['type' => 'number', 'min' => 0]) ?>
            <?= $form->field($model, 'km_salir')->textInput(['type' => 'number', 'step' => 'any', 'placeholder' => 'km']) ?>
            <?= $form->field($model, 'km_entrar')->textInput(['type' => 'number', 'step' => 'any', 'placeholder' => 'km']) ?>
            <?= $form->field($model, 'comentarios')->textarea(['rows' => 3, 'placeholder' => 'Observaciones...']) ?>
        </div>
    </div>

    <!-- SEGUNDA FILA: 3 columnas para diésel -->
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'diesel_iniciar')->textInput(['type' => 'number', 'step' => 'any']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'diesel_terminar')->textInput(['type' => 'number', 'step' => 'any']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'diesel_cargado')->textInput(['type' => 'number', 'step' => 'any']) ?>
        </div>
    </div>

    <!-- TABLA DE COLONIAS (aparece al seleccionar ruta) -->
    <div id="tabla-colonias-container" style="display: none; margin-top: 20px;">
        <h4>Confirmación de colonias y porcentajes</h4>
        <table class="table table-bordered table-striped" id="tabla-colonias">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Colonia</th>
                    <th>Habitantes</th>
                    <th>Porcentaje (%)</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <div id="suma-porcentajes" class="alert alert-info"></div>
    </div>

    <!-- Campos ocultos -->
    <?= $form->field($model, 'id_folio')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'fecha_captura')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'total_km')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'anio')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'mes')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'dia')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'cant_colonias')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'suma_por_atendida')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'por_realizado')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'porcentaje_efectividad')->hiddenInput()->label(false) ?>
    <?php for($i=1;$i<=11;$i++): ?>
        <?= $form->field($model, "colonia_$i")->hiddenInput()->label(false) ?>
        <?= $form->field($model, "por_colonia_$i")->hiddenInput()->label(false) ?>
        <?= $form->field($model, "habitantes_$i")->hiddenInput()->label(false) ?>
    <?php endfor; ?>

    <div class="form-group text-center" style="margin-top: 20px;">
        <?= Html::submitButton('Guardar Reporte', ['class' => 'btn btn-guindo btn-lg']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php
$urlGetUnidades = Url::to(['detalle-diario/get-unidades']);
$urlGetColonias = Url::to(['detalle-diario/get-colonias']);
$script = <<<JS
$('#tipo-unidad').change(function() {
    var id_tipo = $(this).val();
    if(id_tipo) {
        $.get('{$urlGetUnidades}&id_tipo=' + id_tipo, function(data) {
            $('#num-unidad').html(data);
        });
    } else {
        $('#num-unidad').html('<option>Seleccione tipo primero</option>');
    }
});

$('#ruta').change(function() {
    var id_ruta = $(this).val();
    if(id_ruta) {
        $.getJSON('{$urlGetColonias}&id_ruta=' + id_ruta, function(data) {
            var tbody = $('#tabla-colonias tbody');
            tbody.empty();
            if(data.length > 0) {
                $('#tabla-colonias-container').show();
                $.each(data, function(index, colonia) {
                    var fila = '<tr>' +
                        '<td>' + (index+1) + '</td>' +
                        '<td>' + colonia.nombre + 
                            '<input type="hidden" name="detalle_colonias['+index+'][id_colonia]" value="'+colonia.id_colonia+'">' +
                            '<input type="hidden" name="detalle_colonias['+index+'][habitantes]" value="'+colonia.habitantes+'">' +
                        '</td>' +
                        '<td>' + colonia.habitantes + '</td>' +
                        '<td><input type="number" name="detalle_colonias['+index+'][porcentaje]" class="form-control porcentaje" step="any" min="0" max="100" value="0"></td>' +
                        '</tr>';
                    tbody.append(fila);
                });
                actualizarSuma();
            } else {
                $('#tabla-colonias-container').hide();
            }
        });
    } else {
        $('#tabla-colonias-container').hide();
    }
});

function actualizarSuma() {
    var suma = 0;
    $('.porcentaje').each(function() {
        var val = parseFloat($(this).val());
        if(!isNaN(val)) suma += val;
    });
    var numColonias = $('.porcentaje').length;
    var maximo = numColonias * 100;
    var efectividad = (suma / maximo) * 100;
    $('#suma-porcentajes').html('Suma de porcentajes: ' + suma + ' / ' + maximo + ' | Efectividad: ' + efectividad.toFixed(2) + '%');
}

$(document).on('change', '.porcentaje', function() {
    actualizarSuma();
});
JS;
$this->registerJs($script);
?>