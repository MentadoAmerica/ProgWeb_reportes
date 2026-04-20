<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$this->registerCss("
    :root {
        --primary: #800020;
        --primary-light: #f9e6e9;
        --primary-dark: #5c0016;
        --gray-bg: #faf9f8;
        --card-shadow: 0 20px 35px rgba(0,0,0,0.05), 0 2px 4px rgba(0,0,0,0.02);
    }

    .detalle-diario-form {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem;
        background: white;
        border-radius: 32px;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(128,0,32,0.08);
    }

    h1 {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--primary);
        letter-spacing: -0.01em;
        margin-bottom: 1.5rem;
    }

    /* Secciones */
    h4 {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--primary);
        margin: 1.5rem 0 1rem;
        border-left: 4px solid var(--primary);
        padding-left: 0.75rem;
    }

    /* Campos de formulario */
    .form-group {
        margin-bottom: 1.2rem;
    }

    label {
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.85rem;
        margin-bottom: 0.3rem;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .form-control, .form-select {
        border-radius: 20px;
        border: 1px solid #e0e0e0;
        padding: 0.5rem 1rem;
        transition: 0.2s;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(128,0,32,0.15);
    }

    /* Botones */
    .btn-guindo {
        background: var(--primary);
        border: none;
        border-radius: 40px;
        padding: 0.5rem 1.5rem;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.2s;
        color: white;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-guindo:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(128,0,32,0.2);
    }

    .btn-cafe {
        background: #5a3a2a;
        border: none;
        border-radius: 40px;
        padding: 0.5rem 1.5rem;
        font-weight: 600;
        font-size: 0.9rem;
        color: white;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-cafe:hover {
        background: #7a4a2a;
        transform: translateY(-1px);
    }

    /* Tabla de colonias */
    .table {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        margin-top: 1rem;
    }

    .table thead th {
        background: var(--primary);
        color: white;
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        border: none;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: var(--primary-light);
    }

    .table-striped tbody tr:nth-of-type(even) {
        background-color: white;
    }

    /* Panel de resumen */
    .resumen-panel {
        background: linear-gradient(135deg, #fff5ee, #fef0e6);
        border-radius: 24px;
        padding: 1.25rem 1.5rem;
        margin-top: 1.5rem;
        border: 1px solid rgba(128,0,32,0.15);
        box-shadow: 0 8px 20px rgba(128,0,32,0.05);
    }

    .resumen-panel h4 {
        margin-top: 0;
        border-left-color: var(--primary);
    }

    .resumen-panel input {
        background: white;
        border: 1px solid #e0c8b8;
        font-weight: 600;
        color: var(--primary);
        text-align: center;
    }

    /* Alerta de suma */
    .alert-info {
        background: var(--primary-light);
        border: 1px solid #d4a373;
        border-radius: 20px;
        color: var(--primary-dark);
        font-weight: 500;
        padding: 0.75rem 1rem;
        margin-top: 1rem;
    }

    /* Ajustes responsivos */
    @media (max-width: 768px) {
        .detalle-diario-form {
            padding: 1rem;
        }
        .resumen-panel .row {
            flex-direction: column;
            gap: 0.5rem;
        }
    }
");
?>

<div class="detalle-diario-form">
    <h1>Nuevo Reporte</h1>

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
            <tbody>
                <?php if (!empty(isset($detalleColonias) ? $detalleColonias : [])):
                    $i = 0;
                    foreach (($detalleColonias ?? []) as $d):
                        $i++;
                        $idc = isset($d['id_colonia']) ? $d['id_colonia'] : '';
                        $hab = isset($d['habitantes']) ? $d['habitantes'] : '';
                        $por = isset($d['porcentaje']) ? $d['porcentaje'] : 0;
                ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= Html::encode(isset($d['nombre']) ? $d['nombre'] : $idc) ?>
                            <input type="hidden" name="detalle_colonias[<?= $i-1 ?>][id_colonia]" value="<?= $idc ?>">
                            <input type="hidden" name="detalle_colonias[<?= $i-1 ?>][habitantes]" value="<?= $hab ?>">
                        </td>
                        <td><?= $hab ?></td>
                        <td><input type="number" name="detalle_colonias[<?= $i-1 ?>][porcentaje]" class="form-control porcentaje" step="any" min="0" max="100" value="<?= $por ?>"></td>
                    </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
        <div id="suma-porcentajes" class="alert alert-info"></div>
    </div>

    <!-- PANEL DE RESUMEN -->
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

    <!-- CAMPOS OCULTOS -->
    <?= $form->field($model, 'id_folio')->hiddenInput(['id' => 'hidden-id-folio'])->label(false) ?>
    <?= $form->field($model, 'fecha_captura')->hiddenInput(['id' => 'hidden-fecha-captura'])->label(false) ?>
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
        <?= Html::submitButton('Guardar Reporte', ['class' => 'btn btn-guindo']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php
$urlGetUnidades = Url::to(['detalle-diario/get-unidades']);
$urlGetColonias = Url::to(['detalle-diario/get-colonias']);
$fechaActual = date('Y-m-d H:i:s');

$script = <<<JS
$('#resumen-fecha-captura').val('$fechaActual');
$('#hidden-fecha-captura').val('$fechaActual');

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

function actualizarResumen() {
    var suma = 0;
    var numColonias = $('.porcentaje').length;
    $('.porcentaje').each(function() {
        var val = parseFloat($(this).val());
        if(!isNaN(val)) suma += val;
    });
    var maximo = numColonias * 100;
    var efectividad = (maximo > 0) ? (suma / maximo) * 100 : 0;
    
    $('#resumen-cant-colonias').val(numColonias);
    $('#resumen-suma-porcentajes').val(suma.toFixed(2));
    $('#resumen-efectividad').val(efectividad.toFixed(2) + '%');
    
    $('#hidden-cant-colonias').val(numColonias);
    $('#hidden-suma-porcentajes').val(suma.toFixed(2));
    $('#hidden-efectividad').val(efectividad.toFixed(2));
    $('#hidden-efectividad2').val(efectividad.toFixed(2));
    
    $('#suma-porcentajes').html('Suma de porcentajes: ' + suma.toFixed(2) + ' / ' + maximo + ' | Efectividad: ' + efectividad.toFixed(2) + '%');
}

$(document).on('change', '.porcentaje', function() {
    actualizarResumen();
});

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