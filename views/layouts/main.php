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
    <link rel="icon" type="image/png" href="<?= Yii::$app->request->baseUrl ?>/images/logo.png">
    <link rel="shortcut icon" href="<?= Yii::$app->request->baseUrl ?>/images/logo.png" type="image/png">
    <link rel="apple-touch-icon" href="<?= Yii::$app->request->baseUrl ?>/images/logo.png">
    
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        /* Estilos personalizados */
        .navbar {
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            padding: 0.5rem 1rem;
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            letter-spacing: -0.3px;
        }
        .navbar-brand i {
            font-size: 1.6rem;
            margin-right: 6px;
        }
        .navbar-nav .nav-link {
            font-weight: 500;
            padding: 0.6rem 1rem !important;
            transition: all 0.2s ease;
            border-radius: 8px;
        }
        .navbar-nav .nav-link i {
            margin-right: 6px;
        }
        .navbar-nav .nav-link:hover {
            background-color: rgba(255,255,255,0.12);
        }
        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-radius: 12px;
            margin-top: 8px;
            background-color: #fff;
        }
        .dropdown-item {
            padding: 0.5rem 1.2rem;
            font-size: 0.9rem;
            color: #333;
        }
        .dropdown-item i {
            margin-right: 8px;
            color: #611232;
        }
        .dropdown-item:hover {
            background-color: #f8f5f0;
            color: #611232;
        }
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 8px;
            font-weight: bold;
            color: #611232;
            font-size: 0.9rem;
        }
        .navbar-brand img {
            height: 32px;
        }
        
        /* ============================================
           BOTÓN HAMBURGUESA MEJORADO
           ============================================ */
        
        /* Activar hamburguesa en 992px (más temprano que los 768px por defecto) */
        @media (max-width: 992px) {
            .navbar-expand-md .navbar-toggler {
                display: block !important;
            }
            .navbar-expand-md .navbar-collapse {
                display: none !important;
            }
            .navbar-expand-md .navbar-collapse.show {
                display: block !important;
                max-height: 80vh;
                overflow-y: auto;
            }
            .navbar-expand-md .navbar-nav {
                flex-direction: column !important;
                width: 100% !important;
                padding: 10px 0 !important;
            }
            .navbar-expand-md .navbar-nav .nav-item {
                width: 100% !important;
            }
            .navbar-expand-md .navbar-nav .nav-link {
                padding: 12px 15px !important;
            }
            .navbar-expand-md .dropdown-menu {
                position: static !important;
                float: none !important;
                width: 100% !important;
                margin-top: 0 !important;
                background-color: rgba(255, 255, 255, 0.05) !important;
                border: none !important;
                box-shadow: none !important;
                border-radius: 8px !important;
                padding: 5px 0 !important;
            }
            .navbar-expand-md .dropdown-item {
                color: rgba(255, 255, 255, 0.9) !important;
                padding: 10px 30px !important;
            }
            .navbar-expand-md .dropdown-item i {
                color: rgba(255, 255, 255, 0.8) !important;
            }
            .navbar-expand-md .dropdown-item:hover {
                background-color: rgba(255, 255, 255, 0.1) !important;
                color: white !important;
            }
            .navbar-expand-md .dropdown-item:hover i {
                color: white !important;
            }
            .navbar-expand-md .dropdown-divider {
                border-top-color: rgba(255, 255, 255, 0.2) !important;
            }
        }
        
        /* Botón hamburguesa personalizado - Líneas más gruesas */
        .navbar-toggler {
            border: 2px solid rgba(255, 255, 255, 0.5) !important;
            padding: 8px 10px !important;
            border-radius: 10px !important;
            transition: all 0.3s ease !important;
            background-color: rgba(255, 255, 255, 0.1) !important;
        }
        
        .navbar-toggler:hover {
            border-color: white !important;
            background-color: rgba(255, 255, 255, 0.2) !important;
            transform: scale(1.05) !important;
        }
        
        .navbar-toggler:focus {
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.3) !important;
            outline: none !important;
        }
        
        /* Icono de hamburguesa más grueso */
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='3' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e") !important;
            width: 24px !important;
            height: 24px !important;
        }
        
        /* Buscador mejorado */
        .search-form {
            margin-left: 1rem;
            min-width: 240px;
        }
        .search-form .input-group {
            background: rgba(255,255,255,0.15);
            border-radius: 40px;
            padding: 2px;
        }
        .search-form input {
            background: transparent;
            border: none;
            color: white;
            padding: 0.4rem 1rem;
            font-size: 0.9rem;
        }
        .search-form input::placeholder {
            color: rgba(255,255,255,0.7);
        }
        .search-form input:focus {
            background: transparent;
            box-shadow: none;
            color: white;
        }
        .search-form button {
            background: transparent;
            border: none;
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 40px;
        }
        .search-form button:hover {
            background: rgba(255,255,255,0.2);
        }
        @media (max-width: 992px) {
            .search-form {
                margin: 0.5rem 0;
                width: 100%;
            }
            .search-form .input-group {
                background: white;
            }
            .search-form input {
                color: #333;
            }
            .search-form input::placeholder {
                color: #999;
            }
            .search-form button {
                color: #611232;
            }
        }
    </style>
</head>
<body>
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => '<img src="' . Yii::$app->request->baseUrl . '/images/logo.png" alt="Logo"> SIRECAM',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark fixed-top',
            'style' => 'background-color: #611232;',
        ],
        'togglerOptions' => ['class' => 'navbar-toggler', 'aria-label' => 'Toggle navigation'],
    ]);


    $menuItems = [];

    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => '<i class="bi bi-house"></i> Inicio', 'url' => ['/site/index'], 'encode' => false];
        $menuItems[] = ['label' => '<i class="bi bi-search"></i> Buscar reportes', 'url' => ['/detalle-diario/index'], 'encode' => false];
        $menuItems[] = ['label' => '<i class="bi bi-box-arrow-in-right"></i> Iniciar sesión', 'url' => ['/site/login'], 'encode' => false];
        $menuItems[] = ['label' => '<i class="bi bi-person-plus"></i> Registrarse', 'url' => ['/site/signup'], 'encode' => false];
    } else {
        $user = Yii::$app->user->identity;
        $isAdmin = ($user instanceof \app\models\Usuarios && $user->isAdmin());

        $menuItems[] = ['label' => '<i class="bi bi-house"></i> Inicio', 'url' => ['/site/index'], 'encode' => false];
        $menuItems[] = ['label' => '<i class="bi bi-file-earmark-plus"></i> Nuevo reporte', 'url' => ['/detalle-diario/create'], 'encode' => false];
        $menuItems[] = ['label' => '<i class="bi bi-search"></i> Buscar reportes', 'url' => ['/detalle-diario/index'], 'encode' => false];

        if ($isAdmin) {
            $menuItems[] = [
                'label' => '<i class="bi bi-book"></i> Catálogos',
                'encode' => false,
                'items' => [
                    ['label' => '<i class="bi bi-truck"></i> Unidades', 'url' => ['/num-unidad/index'], 'encode' => false],
                    ['label' => '<i class="bi bi-map"></i> Rutas', 'url' => ['/ruta/index'], 'encode' => false],
                    ['label' => '<i class="bi bi-building"></i> Colonias', 'url' => ['/colonia/index'], 'encode' => false],
                    ['label' => '<i class="bi bi-person-badge"></i> Choferes', 'url' => ['/chofer/index'], 'encode' => false],
                    ['label' => '<i class="bi bi-person-check"></i> Despachadores', 'url' => ['/despachador/index'], 'encode' => false],
                    '<hr class="dropdown-divider">',
                    ['label' => '<i class="bi bi-people"></i> Usuarios', 'url' => ['/usuarios/index'], 'encode' => false],
                ],
            ];
        }

        $nombreUsuario = $user->nombre ?? Yii::$app->user->identity->username;
        $inicial = strtoupper(substr($nombreUsuario, 0, 1));
        $avatar = '<span class="user-avatar">' . $inicial . '</span>';
        $menuItems[] = [
            'label' => $avatar . ' ' . Html::encode($nombreUsuario) . ' <i class="bi bi-chevron-down"></i>',
            'encode' => false,
            'items' => [
                ['label' => '<i class="bi bi-person-circle"></i> Mi perfil', 'url' => ['/usuarios/view', 'id' => $user->id], 'visible' => $isAdmin, 'encode' => false],
                '<hr class="dropdown-divider">',
                ['label' => '<i class="bi bi-box-arrow-right"></i> Cerrar sesión', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post'], 'encode' => false],
            ],
        ];
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto align-items-center'],
        'items' => $menuItems,
        'encodeLabels' => false,
        'activateParents' => true,
    ]);

    // Buscador global (solo para usuarios logueados)
    if (!Yii::$app->user->isGuest) {
        echo Html::beginForm(['/detalle-diario/index'], 'get', ['class' => 'search-form']);
        echo '<div class="input-group">';
        echo Html::textInput('global_search', '', [
            'class' => 'form-control',
            'placeholder' => 'Buscar por folio, unidad, ruta, chofer...',
            'aria-label' => 'Búsqueda global',
        ]);
        echo Html::tag('span', '<button type="submit"><i class="bi bi-search"></i></button>', ['class' => 'input-group-text', 'style' => 'background:transparent; border:none;']);
        echo '</div>';
        echo Html::endForm();
    }

    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container mt-5 pt-4">
        <?= $content ?>
    </div>
</main>

<footer class="footer mt-auto py-3 text-muted border-top">
    <div class="container text-center">
        <small>&copy; <?= date('Y') ?> Sistema de Reportes de Camiones - Todos los derechos reservados.</small>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>