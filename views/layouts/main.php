<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

// CSS inline para navbar y fondo general
$this->registerCss("
    body {
        background-color: #fdf8f0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .navbar-guindo {
        background-color: #800020 !important;
    }
    .navbar-guindo .navbar-brand,
    .navbar-guindo .navbar-nav .nav-link {
        color: #fdf8f0 !important;
    }
    .navbar-guindo .navbar-brand:hover,
    .navbar-guindo .navbar-nav .nav-link:hover {
        color: #ffccaa !important;
    }
    .navbar-toggler {
        background-color: #fdf8f0;
    }
    footer {
        background-color: #800020;
        color: #fdf8f0;
        padding: 10px 0;
        text-align: center;
        margin-top: 30px;
    }
");
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => 'Reportes de Camiones',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark fixed-top navbar-guindo',
        ],
    ]);
    $menuItems = [
        ['label' => 'Inicio', 'url' => ['/site/index']],
        ['label' => 'Crear Reporte', 'url' => ['/detalle-diario/create']],
        ['label' => 'Buscar Reportes', 'url' => ['/detalle-diario/index']],
        ['label' => 'Modificar Reporte', 'url' => ['/detalle-diario/index']],
    ];
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container mt-5 pt-4">
        <?= $content ?>
    </div>
</main>

<footer>
    <div class="container">
        <p>&copy; <?= date('Y') ?> Sistema de Reportes de Camiones - Todos los derechos reservados.</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>