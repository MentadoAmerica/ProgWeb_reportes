<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

// CSS inline (opcional)
$this->registerCss("
    body { background-color: #fdf8f0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    .detalle-diario-form { background-color: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 0 15px rgba(0,0,0,0.1); }
    .btn-guindo { background-color: #800020 !important; border-color: #800020 !important; color: white !important; font-weight: bold; }
    .btn-guindo:hover { background-color: #a00028 !important; border-color: #a00028 !important; }
    .form-control:focus { border-color: #800020 !important; box-shadow: 0 0 5px rgba(128,0,32,0.3) !important; }
    .table thead { background-color: #800020 !important; color: white !important; }
    .table-striped>tbody>tr:nth-of-type(odd) { background-color: #f9e4d4 !important; }
    label { font-weight: 600 !important; color: #5a3a2a !important; }
    .alert-info { background-color: #e6ccb3 !important; border-color: #d4a373 !important; color: #5a3a2a !important; }
    .resumen-panel { background-color: #f9e4d4; border-left: 5px solid #800020; padding: 15px; margin-top: 20px; border-radius: 8px; }
    .resumen-panel h4 { color: #800020; margin-top: 0; }
");
?>

<div class="detalle-diario-form">
    <?php $form = ActiveForm::begin(['id' => 'form-reporte']); ?>

    <!-- PRIMERA FILA: 3 COLUMNAS -->
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

    <!-- SEGUNDA FILA: DIÉSEL -->
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

    <!-- TABLA DE COLONIAS -->
    <div id="tabla-colonias-container" style="display: none; margin-top: 30px;">
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

    <!-- PANEL DE RESUMEN (CAMPOS CALCULADOS VISIBLES) -->
    <div class="resumen-panel">
        <h4>Resumen del reporte (datos automáticos)</h4>
        <div class="row">
            <div class="col-md-3">
                <label>Folio</label>
                <input type="text" class="form-control" readonly value="Se generará al guardar" id="resumen-folio">
            </div>
            <div class="col-md-3">
                <label>Fecha de captura</label>
                <input type="text" class="form-control" readonly id="resumen-fecha-captura">
            </div>
            <div class="col-md-2">
                <label>Cant. colonias</label>
                <input type="text" class="form-control" readonly id="resumen-cant-colonias" value="0">
            </div>
            <div class="col-md-2">
                <label>Suma %</label>
                <input type="text" class="form-control" readonly id="resumen-suma-porcentajes" value="0">
            </div>
            <div class="col-md-2">
                <label>Efectividad (%)</label>
                <input type="text" class="form-control" readonly id="resumen-efectividad" value="0">
            </div>
        </div>
    </div>

    <!-- CAMPOS OCULTOS (para enviar los valores al servidor) -->
    <?= $form->field($model, 'id_folio')->hiddenInput(['id' => 'hidden-id-folio'])->label(false) ?>
    <?= $form->field($model, 'fecha_captura')->hiddenInput(['id' => 'hidden-fecha-captura'])->label(false) ?>
    <!-- NOTA: total_km, anio, mes, dia NO se incluyen porque son generados por la BD -->
    <?= $form->field($model, 'cant_colonias')->hiddenInput(['id' => 'hidden-cant-colonias'])->label(false) ?>
    <?= $form->field($model, 'suma_por_atendida')->hiddenInput(['id' => 'hidden-suma-porcentajes'])->label(false) ?>
    <?= $form->field($model, 'por_realizado')->hiddenInput(['id' => 'hidden-efectividad'])->label(false) ?>
    <?= $form->field($model, 'porcentaje_efectividad')->hiddenInput(['id' => 'hidden-efectividad2'])->label(false) ?>
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

// Fecha y hora actual para mostrar en el resumen
$fechaActual = date('Y-m-d H:i:s');

$script = <<<JS
// Mostrar fecha de captura actual en el campo de resumen
$('#resumen-fecha-captura').val('$fechaActual');
$('#hidden-fecha-captura').val('$fechaActual');

// Al seleccionar ruta, actualizar la tabla y la cantidad de colonias
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
                        '</table>';
                    tbody.append(fila);
                });
                actualizarResumen();
            } else {
                $('#tabla-colonias-container').hide();
                $('#resumen-cant-colonias').val(0);
                $('#hidden-cant-colonias').val(0);
                actualizarResumen();
            }
        });
    } else {
        $('#tabla-colonias-container').hide();
        $('#resumen-cant-colonias').val(0);
        $('#hidden-cant-colonias').val(0);
        actualizarResumen();
    }
});

// Función para actualizar el resumen (suma, efectividad, cantidad de colonias)
function actualizarResumen() {
    var suma = 0;
    var numColonias = $('.porcentaje').length;
    $('.porcentaje').each(function() {
        var val = parseFloat($(this).val());
        if(!isNaN(val)) suma += val;
    });
    var maximo = numColonias * 100;
    var efectividad = (maximo > 0) ? (suma / maximo) * 100 : 0;
    
    // Actualizar campos visibles en el resumen
    $('#resumen-cant-colonias').val(numColonias);
    $('#resumen-suma-porcentajes').val(suma.toFixed(2));
    $('#resumen-efectividad').val(efectividad.toFixed(2) + '%');
    
    // Actualizar campos ocultos para enviar al servidor
    $('#hidden-cant-colonias').val(numColonias);
    $('#hidden-suma-porcentajes').val(suma.toFixed(2));
    $('#hidden-efectividad').val(efectividad.toFixed(2));
    $('#hidden-efectividad2').val(efectividad.toFixed(2));
    
    // Actualizar también el div de alerta
    $('#suma-porcentajes').html('Suma de porcentajes: ' + suma.toFixed(2) + ' / ' + maximo + ' | Efectividad: ' + efectividad.toFixed(2) + '%');
}

// Recalcular cada vez que cambia un porcentaje
$(document).on('change', '.porcentaje', function() {
    actualizarResumen();
});

// Cargar unidades según tipo
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
JS;
$this->registerJs($script);
?>