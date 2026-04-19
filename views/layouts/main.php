<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php
    $this->registerCss(<<<'CSS'
    body {
        background-color: #fdf8f0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .navbar-guindo {
        background-color: #800020 !important;
    }
    CSS
    );
    ?>
</head>
<body>
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => 'Sistema de Reportes',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark fixed-top navbar-guindo',
        ],
    ]);

    // Construir menú según rol / estado de sesión
    $menuItems = [];
    $menuItems[] = ['label' => 'Inicio', 'url' => ['/site/index']];

    if (Yii::$app->user->isGuest) {
        // Visitante: mostrar sólo opciones públicas
        $menuItems[] = ['label' => 'Buscar Reportes', 'url' => ['/detalle-diario/index']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
        $menuItems[] = ['label' => 'Registro', 'url' => ['/site/signup']];
    } else {
        // Usuario autenticado: mostrar acciones permitidas
        $menuItems[] = ['label' => 'Crear Reporte', 'url' => ['/detalle-diario/create']];
        $menuItems[] = ['label' => 'Buscar Reportes', 'url' => ['/detalle-diario/index']];

        $user = Yii::$app->user->identity;
        if ($user instanceof \app\models\Usuarios) {
            if ($user->isAdmin()) {
                // Admin: acceso a gestión completa
                $menuItems[] = ['label' => 'Usuarios', 'url' => ['/usuarios/index']];
                $menuItems[] = ['label' => 'Catálogos', 'items' => [
                    ['label' => 'Rutas', 'url' => ['/ruta/index']],
                    ['label' => 'Colonias', 'url' => ['/colonia/index']],
                    ['label' => 'Unidades', 'url' => ['/num-unidad/index']],
                ]];
            } else {
                // Operador u otros: menú limitado
                $menuItems[] = ['label' => 'Mis Reportes', 'url' => ['/detalle-diario/index']];
            }
        }

        // Logout como formulario para usar POST
        $displayName = $user instanceof \app\models\Usuarios ? $user->nombre : Yii::$app->user->id;
        $menuItems[] = '<li class="nav-item">'
            . Html::beginForm(['/site/logout'], 'post', ['class' => 'd-inline'])
            . Html::submitButton('Logout (' . Html::encode($displayName) . ')', ['class' => 'btn btn-link nav-link', 'style' => 'color:#fdf8f0; padding:0;'])
            . Html::endForm()
            . '</li>';
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto'],
        'items' => $menuItems,
        'encodeLabels' => false,
    ]);

    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container mt-5 pt-4">
        <?= $content ?>
    </div>
</main>

<footer class="footer mt-auto py-3">
    <div class="container">
        <p class="mb-0">&copy; <?= date('Y') ?> Sistema de Reportes de Camiones - Todos los derechos reservados.</p>
    </div>
</footer>

<?php $this->endBody() ?>
<?php
// Depuración: mostrar en consola si jQuery y yii están disponibles
$this->registerJs("console.log('DEBUG assets: jQuery=', typeof jQuery, ' yii=', typeof yii);");
?>
</body>
</html>
<?php $this->endPage() ?>