<?php
use yii\helpers\Html;
use app\models\DetalleDiario;
use app\models\NumUnidad;
use app\models\Ruta;
use app\models\Chofer;
use app\models\Colonia;

$this->title = 'Sistema de Reportes de Camiones';

// ========== ESTADÍSTICAS GENERALES ==========
$totalUnidades = NumUnidad::find()->count();
$totalRutas = Ruta::find()->count();
$totalChoferes = Chofer::find()->count();
$totalColonias = Colonia::find()->count();

$hoy = date('Y-m-d');
$reportesHoy = DetalleDiario::find()->where(['fecha_orden' => $hoy])->count();
$kgHoy = DetalleDiario::find()->where(['fecha_orden' => $hoy])->sum('cantidad_kg') ?: 0;
$efectividadHoy = DetalleDiario::find()->where(['fecha_orden' => $hoy])->average('porcentaje_efectividad') ?: 0;

// Top 3 unidades del mes actual
$primerDiaMes = date('Y-m-01');
$topUnidades = DetalleDiario::find()
    ->select(['id_unidad', 'SUM(cantidad_kg) as total_kg'])
    ->where(['>=', 'fecha_orden', $primerDiaMes])
    ->groupBy('id_unidad')
    ->orderBy(['total_kg' => SORT_DESC])
    ->limit(3)
    ->asArray()
    ->all();

// Datos para gráficas (últimos 7 días)
$fechas = [];
$reportesPorDia = [];
$kgPorDia = [];
for ($i = 6; $i >= 0; $i--) {
    $fecha = date('Y-m-d', strtotime("-$i days"));
    $fechas[] = date('d/m', strtotime($fecha));
    $reportesPorDia[] = DetalleDiario::find()->where(['fecha_orden' => $fecha])->count();
    $kgPorDia[] = DetalleDiario::find()->where(['fecha_orden' => $fecha])->sum('cantidad_kg') ?: 0;
}

$this->registerCss("
    :root {
        --primary: #611232;
        --primary-light: #7e1a42;
        --bg-light: #f8f6f4;
        --card-border: #eae2da;
        --text-muted: #6c6c6c;
    }
    .site-index {
        margin: 0;
        padding: 0;
        width: 100%;
        overflow-x: hidden;
        font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
    }
    .container { max-width: 100% !important; padding: 0 !important; }

    /* Carrusel elegante */
    .carousel-item img {
        height: 75vh;
        object-fit: cover;
        filter: brightness(0.65);
    }
    .carousel-caption {
        background: linear-gradient(135deg, rgba(97,18,50,0.9), rgba(97,18,50,0.75));
        border-radius: 20px;
        padding: 1.5rem 2rem;
        max-width: 520px;
        bottom: 18%;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        backdrop-filter: blur(3px);
    }
    .carousel-caption h1 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
        letter-spacing: -0.3px;
    }
    .carousel-caption p {
        font-size: 0.95rem;
        margin-bottom: 1.2rem;
        opacity: 0.9;
    }
    .btn-primary-custom, .btn-outline-custom {
        padding: 6px 20px;
        font-size: 0.85rem;
        border-radius: 40px;
        font-weight: 500;
        transition: 0.2s;
        display: inline-block;
        text-decoration: none;
    }
    .btn-primary-custom {
        background: var(--primary);
        border: none;
        color: white;
    }
    .btn-primary-custom:hover {
        background: var(--primary-light);
        transform: translateY(-2px);
        color: white;
    }
    .btn-outline-custom {
        background: transparent;
        border: 1.5px solid white;
        color: white;
    }
    .btn-outline-custom:hover {
        background: white;
        color: var(--primary);
        transform: translateY(-2px);
    }
    .carousel-control-prev-icon, .carousel-control-next-icon {
        background-color: rgba(97,18,50,0.8);
        border-radius: 50%;
        padding: 12px;
        background-size: 50%;
    }

    /* Estadísticas dashboard */
    .stats-section {
        background: var(--bg-light);
        padding: 3rem 1.5rem;
    }
    .stats-container {
        max-width: 1300px;
        margin: 0 auto;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 1rem;
    }
    .stat-card {
        background: white;
        border-radius: 24px;
        padding: 1.2rem 0.8rem;
        min-width: 120px;
        flex: 1 1 140px;
        text-align: center;
        border: 1px solid var(--card-border);
        transition: 0.25s;
        box-shadow: 0 2px 6px rgba(0,0,0,0.02);
    }
    .stat-card:hover {
        border-color: var(--primary);
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(97,18,50,0.08);
    }
    .stat-number {
        font-size: 1.9rem;
        font-weight: 800;
        color: var(--primary);
        line-height: 1.2;
        margin-bottom: 4px;
    }
    .stat-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--text-muted);
        font-weight: 600;
    }
    .stat-icon {
        font-size: 1.8rem;
        margin-bottom: 8px;
        color: var(--primary-light);
    }

    /* Gráficas */
    .charts-row {
        max-width: 1300px;
        margin: 2.5rem auto 0;
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        justify-content: center;
    }
    .chart-box {
        background: white;
        border-radius: 24px;
        padding: 1.2rem;
        flex: 1 1 380px;
        border: 1px solid var(--card-border);
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }
    .chart-box h3 {
        text-align: center;
        color: var(--primary);
        margin-bottom: 1rem;
        font-size: 1.1rem;
        font-weight: 600;
    }
    canvas {
        max-height: 220px;
        width: 100%;
    }

    /* Top unidades */
    .top-unidades {
        max-width: 1300px;
        margin: 2rem auto 0;
        background: white;
        border-radius: 24px;
        padding: 1.2rem;
        border: 1px solid var(--card-border);
    }
    .top-unidades h3 {
        text-align: center;
        color: var(--primary);
        margin-bottom: 1rem;
        font-size: 1.1rem;
        font-weight: 600;
    }
    .top-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .top-list li {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.8rem 1rem;
        border-bottom: 1px solid #f0eae4;
        font-size: 0.9rem;
    }
    .top-list li:last-child { border-bottom: none; }
    .rank {
        font-weight: 800;
        color: var(--primary);
        width: 36px;
        font-size: 1rem;
    }
    .unit-name { flex: 2; font-weight: 500; color: #2c2c2c; }
    .unit-kg { font-weight: 700; color: #333; background: #f1ede8; padding: 2px 10px; border-radius: 20px; }

    /* Características */
    .features {
        background: white;
        padding: 3rem 1.5rem;
        border-top: 1px solid var(--card-border);
    }
    .features h2 {
        font-size: 1.7rem;
        color: var(--primary);
        margin-bottom: 2rem;
        font-weight: 700;
        text-align: center;
    }
    .cards-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 1.8rem;
        max-width: 1200px;
        margin: 0 auto;
    }
    .card-feature {
        background: var(--bg-light);
        border-radius: 24px;
        padding: 1.5rem 1rem;
        width: 220px;
        text-align: center;
        transition: 0.25s;
        border: 1px solid var(--card-border);
    }
    .card-feature:hover {
        transform: translateY(-5px);
        border-color: var(--primary);
        background: white;
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    }
    .card-feature .icon { font-size: 2.3rem; margin-bottom: 0.8rem; color: var(--primary); }
    .card-feature h3 { color: var(--primary); font-size: 1.2rem; font-weight: 700; margin-bottom: 0.5rem; }
    .card-feature p { font-size: 0.8rem; color: var(--text-muted); line-height: 1.4; }

    @media (max-width: 768px) {
        .carousel-item img { height: 55vh; }
        .carousel-caption { padding: 1rem; max-width: 85%; bottom: 12%; }
        .carousel-caption h1 { font-size: 1.3rem; }
        .stat-card { min-width: 100px; padding: 0.8rem; }
        .stat-number { font-size: 1.4rem; }
        .stat-icon { font-size: 1.4rem; }
        .card-feature { width: 100%; max-width: 260px; }
    }
");
?>

<div class="site-index">
    <!-- Carrusel -->
        <!-- Carrusel corregido (sin duplicados, con indicadores y controles funcionales) -->
    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://matamoros.gob.mx/wp-content/uploads/2025/01/Entrega-Presidente-Municipal-Alberto-Granados-nuevos-camiones-compactadores-para-reforzar-limpieza-publica-en-Matamoros2-1-1024x683.jpg" class="d-block w-100" alt="Control de flota">
                <div class="carousel-caption d-none d-md-block">
                    <h1>Control de flota y rutas</h1>
                    <p>Gestión integral de residuos urbanos</p>
                    <div>
                        <?php if (Yii::$app->user->isGuest): ?>
                            <?= Html::a('Acceder', ['site/login'], ['class' => 'btn-primary-custom']) ?>
                            <?= Html::a('Registro', ['site/signup'], ['class' => 'btn-outline-custom']) ?>
                        <?php else: ?>
                            <?= Html::a('Nuevo reporte', ['detalle-diario/create'], ['class' => 'btn-primary-custom']) ?>
                            <?= Html::a('Buscar reportes', ['detalle-diario/index'], ['class' => 'btn-outline-custom']) ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://matamoros.gob.mx/wp-content/uploads/2025/01/Entrega-Presidente-Municipal-Alberto-Granados-nuevos-camiones-compactadores-para-reforzar-limpieza-publica-en-Matamoros1.1-1024x538.jpeg" class="d-block w-100" alt="Registro eficiente">
                <div class="carousel-caption d-none d-md-block">
                    <h1>Registro eficiente</h1>
                    <p>Kilometraje, combustible, kilogramos y efectividad</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://matamoros.gob.mx/wp-content/uploads/2026/02/Trabajo-constante-del-Gobierno-de-Beto-Granados-fortalece-la-limpieza-urbana-en-Matamoros-p.jpg" class="d-block w-100" alt="Reportes y estadísticas">
                <div class="carousel-caption d-none d-md-block">
                    <h1>Reportes y estadísticas</h1>
                    <p>Exporta a Excel para análisis detallado</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>

    <!-- Indicadores clave (con iconos Bootstrap) -->
    <div class="stats-section">
        <div class="stats-container">
            <div class="stat-card"><div class="stat-icon"><i class="bi bi-truck"></i></div><div class="stat-number"><?= number_format($totalUnidades) ?></div><div class="stat-label">Unidades</div></div>
            <div class="stat-card"><div class="stat-icon"><i class="bi bi-map"></i></div><div class="stat-number"><?= number_format($totalRutas) ?></div><div class="stat-label">Rutas</div></div>
            <div class="stat-card"><div class="stat-icon"><i class="bi bi-person-badge"></i></div><div class="stat-number"><?= number_format($totalChoferes) ?></div><div class="stat-label">Choferes</div></div>
            <div class="stat-card"><div class="stat-icon"><i class="bi bi-building"></i></div><div class="stat-number"><?= number_format($totalColonias) ?></div><div class="stat-label">Colonias</div></div>
            <div class="stat-card"><div class="stat-icon"><i class="bi bi-file-text"></i></div><div class="stat-number"><?= number_format($reportesHoy) ?></div><div class="stat-label">Reportes hoy</div></div>
            <div class="stat-card"><div class="stat-icon"><i class="bi bi-weight"></i></div><div class="stat-number"><?= number_format($kgHoy, 0) ?></div><div class="stat-label">Kg hoy</div></div>
            <div class="stat-card"><div class="stat-icon"><i class="bi bi-graph-up"></i></div><div class="stat-number"><?= number_format($efectividadHoy, 1) ?>%</div><div class="stat-label">Efectividad</div></div>
        </div>

        <!-- Gráficas -->
        <div class="charts-row">
            <div class="chart-box">
                <h3><i class="bi bi-bar-chart-steps"></i> Reportes diarios (últimos 7 días)</h3>
                <canvas id="reportesChart"></canvas>
            </div>
            <div class="chart-box">
                <h3><i class="bi bi-graph-up"></i> Kg recolectados (últimos 7 días)</h3>
                <canvas id="kgChart"></canvas>
            </div>
        </div>

        <!-- Top unidades -->
        <div class="top-unidades">
            <h3><i class="bi bi-trophy-fill"></i> Top 3 unidades del mes (kg recolectados)</h3>
            <ul class="top-list">
                <?php if (empty($topUnidades)): ?>
                    <li><em>Sin datos suficientes</em></li>
                <?php else: ?>
                    <?php foreach ($topUnidades as $index => $item): ?>
                        <?php
                        $unidad = NumUnidad::findOne($item['id_unidad']);
                        $nombreUnidad = $unidad ? $unidad->numero_unidad : 'Unidad #' . $item['id_unidad'];
                        ?>
                        <li>
                            <span class="rank"><?= $index + 1 ?></span>
                            <span class="unit-name"><?= Html::encode($nombreUnidad) ?></span>
                            <span class="unit-kg"><?= number_format($item['total_kg'], 0) ?> kg</span>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <!-- Funcionalidades -->
    <div class="features">
        <h2>Funcionalidades del sistema</h2>
        <div class="cards-grid">
            <div class="card-feature"><div class="icon"><i class="bi bi-truck"></i></div><h3>Unidades</h3><p>Registro de camiones por tipo y número económico</p></div>
            <div class="card-feature"><div class="icon"><i class="bi bi-map"></i></div><h3>Rutas</h3><p>Definición de rutas con colonias y orden de recolección</p></div>
            <div class="card-feature"><div class="icon"><i class="bi bi-file-earmark-text"></i></div><h3>Reportes diarios</h3><p>Captura de kg, kilometraje, combustible, puches y efectividad</p></div>
            <div class="card-feature"><div class="icon"><i class="bi bi-people"></i></div><h3>Personal</h3><p>Gestión de choferes y despachadores</p></div>
        </div>
    </div>
</div>

<?php
// Registro de Chart.js y gráficas
$this->registerJsFile('https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js', ['position' => \yii\web\View::POS_END]);
$script = "
    new Chart(document.getElementById('reportesChart'), {
        type: 'bar',
        data: {
            labels: " . json_encode($fechas) . ",
            datasets: [{
                label: 'Reportes',
                data: " . json_encode($reportesPorDia) . ",
                backgroundColor: '#611232',
                borderRadius: 8,
                barPercentage: 0.65
            }]
        },
        options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { position: 'top', labels: { font: { size: 10 } } } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
    });
    new Chart(document.getElementById('kgChart'), {
        type: 'line',
        data: {
            labels: " . json_encode($fechas) . ",
            datasets: [{
                label: 'Kilogramos',
                data: " . json_encode($kgPorDia) . ",
                borderColor: '#611232',
                backgroundColor: 'rgba(97,18,50,0.05)',
                fill: true,
                tension: 0.3,
                pointBackgroundColor: '#611232'
            }]
        },
        options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { position: 'top', labels: { font: { size: 10 } } } }, scales: { y: { beginAtZero: true } } }
    });
";
$this->registerJs($script);
// Carrusel
$this->registerJs("
    var carouselElement = document.querySelector('#carouselExample');
    if (carouselElement && typeof bootstrap !== 'undefined') new bootstrap.Carousel(carouselElement, { interval: 5000, ride: 'carousel' });
");
?>