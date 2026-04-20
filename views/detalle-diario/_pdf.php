<?php
use yii\helpers\Html;
use app\models\Colonia;

/* @var $this yii\web\View */
/* @var $reportes array */
/* @var $filtros array */
/* @var $fechaGeneracion string */
/* @var $titulo string */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de camiones</title>
    <style>
        body {
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
            font-size: 10pt;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #800020;
            padding-bottom: 10px;
        }
        .header h1 {
            color: #800020;
            margin: 0;
            font-size: 18pt;
        }
        .header p {
            margin: 5px 0 0;
            color: #555;
            font-size: 9pt;
        }
        .filters-box {
            background: #f5f5f5;
            padding: 8px;
            margin-bottom: 15px;
            font-size: 8pt;
            border-left: 3px solid #800020;
        }
        .report-title {
            font-size: 14pt;
            font-weight: bold;
            color: #800020;
            margin: 15px 0 5px;
            border-bottom: 1px solid #800020;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 6px;
            text-align: left;
            vertical-align: top;
            font-size: 8pt;
        }
        th {
            background-color: #800020;
            color: white;
            font-weight: bold;
        }
        .subtable {
            width: 100%;
            margin: 5px 0;
        }
        .subtable th, .subtable td {
            border: 1px solid #ccc;
            font-size: 7pt;
            padding: 4px;
        }
        .footer {
            text-align: center;
            font-size: 7pt;
            border-top: 1px solid #aaa;
            padding-top: 8px;
            margin-top: 20px;
        }
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
<div class="header">
    <h1>SISTEMA DE REPORTES DE CAMIONES</h1>
    <p>Documento generado: <?= Html::encode($fechaGeneracion) ?></p>
    <p><strong><?= Html::encode($titulo) ?></strong></p>
</div>

<?php if (!empty($filtros) && isset($filtros['DetalleDiarioSearch'])): ?>
<div class="filters-box">
    <strong>Filtros aplicados:</strong><br>
    <?php
    $filtrosTexto = [];
    foreach ($filtros['DetalleDiarioSearch'] as $key => $value) {
        if (!empty($value)) {
            $filtrosTexto[] = "$key: $value";
        }
    }
    echo implode(' | ', $filtrosTexto);
    ?>
</div>
<?php endif; ?>

<?php foreach ($reportes as $index => $reporte): ?>
    <?php if ($index > 0): ?><div class="page-break"></div><?php endif; ?>
    <div class="report-title">
        Reporte Folio: <?= Html::encode($reporte['id_folio']) ?>
    </div>

    <!-- Datos generales -->
    <table>
        <tr><th width="25%">Campo</th><th>Valor</th></tr>
        <tr><td>Fecha de orden</td><td><?= Html::encode($reporte['fecha_orden']) ?></td></tr>
        <tr><td>Fecha de captura</td><td><?= Html::encode($reporte['fecha_captura']) ?></td></tr>
        <tr><td>Turno</td><td><?= Html::encode($reporte['turno']) ?></td></tr>
        <tr><td>Tipo de unidad</td><td><?= Html::encode($reporte['tipo_unidad']) ?></td></tr>
        <tr><td>Unidad</td><td><?= Html::encode($reporte['numero_unidad']) ?></td></tr>
        <tr><td>Ruta</td><td><?= Html::encode($reporte['nombre_ruta']) ?></td></tr>
        <tr><td>Chofer</td><td><?= Html::encode($reporte['nombre_chofer']) ?></td></tr>
        <tr><td>Despachador</td><td><?= Html::encode($reporte['nombre_despachador']) ?></td></tr>
        <tr><td>Usuario captura</td><td><?= Html::encode($reporte['usuario_nombre']) ?></td></tr>
        <tr><td>Cantidad (kg)</td><td><?= number_format($reporte['cantidad_kg'], 2) ?></td></tr>
        <tr><td>Puches</td><td><?= $reporte['num_puches'] ?></td></tr>
        <tr><td>Efectividad (%)</td><td><?= number_format($reporte['porcentaje_efectividad'], 1) ?>%</td></tr>
    </table>

    <!-- Kilometraje y diésel -->
    <table>
        <tr><th colspan="2">Kilometraje y diésel</th></tr>
        <tr><td>Km salida</td><td><?= number_format($reporte['km_salir'], 1) ?> km</td></tr>
        <tr><td>Km entrada</td><td><?= number_format($reporte['km_entrar'], 1) ?> km</td></tr>
        <tr><td>Total km</td><td><?= number_format($reporte['total_km'], 1) ?> km</td></tr>
        <tr><td>Diésel inicio</td><td><?= number_format($reporte['diesel_iniciar'], 1) ?> L</td></tr>
        <tr><td>Diésel final</td><td><?= number_format($reporte['diesel_terminar'], 1) ?> L</td></tr>
        <tr><td>Diésel cargado</td><td><?= number_format($reporte['diesel_cargado'], 1) ?> L</td></tr>
        <tr><td>Consumo estimado</td><td><?= number_format($reporte['diesel_iniciar'] - $reporte['diesel_terminar'], 1) ?> L</td></tr>
    </table>

    <!-- Colonias atendidas -->
    <?php
    $colonias = [];
    for ($i = 1; $i <= ($reporte['cant_colonias'] ?? 0); $i++) {
        $coloniaId = $reporte["colonia_$i"] ?? null;
        if ($coloniaId) {
            $colonia = Colonia::findOne($coloniaId);
            if ($colonia) {
                $colonias[] = [
                    'nombre' => $colonia->nombre_colonia,
                    'habitantes' => $colonia->num_habitantes,
                    'porcentaje' => $reporte["por_colonia_$i"] ?? 0,
                ];
            }
        }
    }
    ?>
    <?php if (!empty($colonias)): ?>
    <div style="margin-top: 10px;">
        <strong>Colonias atendidas:</strong>
        <table class="subtable">
            <thead><tr><th>#</th><th>Colonia</th><th>Habitantes</th><th>Porcentaje (%)</th></tr></thead>
            <tbody>
                <?php foreach ($colonias as $idx => $col): ?>
                <tr>
                    <td><?= $idx+1 ?></td>
                    <td><?= Html::encode($col['nombre']) ?></td>
                    <td><?= number_format($col['habitantes']) ?></td>
                    <td><?= number_format($col['porcentaje'], 1) ?>%</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <!-- Comentarios -->
    <?php if (!empty($reporte['comentarios'])): ?>
    <div style="margin-top: 10px;">
        <strong>Comentarios:</strong><br>
        <?= nl2br(Html::encode($reporte['comentarios'])) ?>
    </div>
    <?php endif; ?>
<?php endforeach; ?>

<div class="footer">
    Sistema de Reportes de Camiones - Documento generado automáticamente
</div>
</body>
</html>