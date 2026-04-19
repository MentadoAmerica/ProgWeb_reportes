<?php
use yii\helpers\Html;

$this->title = 'Bienvenido al Sistema de Reportes de Camiones';
?>

<div class="site-index" style="text-align: center; margin-top: 50px;">
    <h1><?= Html::encode($this->title) ?></h1>

    <div style="background-color: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 0 15px rgba(0,0,0,0.1);">
        <p style="font-size: 18px; color: #5a3a2a;">
            Sistema para el registro y control de rutas de recolección de residuos.
        </p>

        <!-- Imagen de gobierno -->
        <div style="margin: 30px 0;">
            <?= Html::img('https://www.hoytamaulipas.net/fbfoto/298468/Arrendara-gobierno-de-Madero-cuatro-camiones-recolectores-de-basura.jpg', [
                'alt' => 'Camiones recolectores',
                'style' => 'max-width: 100%; height: auto; border-radius: 8px; border: 2px solid #800020;',
            ]) ?>
        </div>

        <div style="margin-top: 30px;">
            <?php if (Yii::$app->user->isGuest): ?>
                <p>
                    <?= Html::a('Iniciar sesión', ['site/login'], ['class' => 'btn btn-guindo', 'style' => 'margin-right: 10px;']) ?>
                    <?= Html::a('Registrarse', ['site/signup'], ['class' => 'btn btn-default']) ?>
                </p>
                <p style="font-size: 14px; color: #888;">
                    Para acceder a la creación y búsqueda de reportes, debes iniciar sesión.
                </p>
            <?php else: ?>
                <p>
                    <?= Html::a('Crear nuevo reporte', ['detalle-diario/create'], ['class' => 'btn btn-guindo', 'style' => 'margin-right: 10px;']) ?>
                    <?= Html::a('Buscar reportes', ['detalle-diario/index'], ['class' => 'btn btn-default']) ?>
                </p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
// Asegurar que el botón guindo tenga estilo
$this->registerCss("
    .btn-guindo {
        background-color: #800020;
        border-color: #800020;
        color: white;
        font-weight: bold;
    }
    .btn-guindo:hover {
        background-color: #a00028;
        border-color: #a00028;
    }
");
?>