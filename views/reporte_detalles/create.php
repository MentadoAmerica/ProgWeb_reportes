<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ReporteDetalles $model */

$this->title = 'Crear Reporte Detalle';
$this->params['breadcrumbs'][] = ['label' => 'Reporte Detalles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss("
    :root {
        --primary: #800020;
        --primary-light: #f9e6e9;
        --primary-dark: #5c0016;
        --card-shadow: 0 20px 35px rgba(0,0,0,0.05), 0 2px 4px rgba(0,0,0,0.02);
    }

    .reporte-detalles-create {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
        background: white;
        border-radius: 32px;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(128,0,32,0.08);
    }

    .reporte-detalles-create h1 {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 1.5rem;
    }

    .form-panel {
        background-color: #fefaf7;
        padding: 1.8rem;
        border-radius: 24px;
        border: 1px solid rgba(128,0,32,0.1);
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .form-panel h3 {
        margin-top: 0;
        color: var(--primary);
        font-weight: 600;
        font-size: 1.2rem;
        border-left: 4px solid var(--primary);
        padding-left: 0.75rem;
        margin-bottom: 1.2rem;
    }

    .top-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .btn-guindo {
        background: var(--primary);
        border: none;
        border-radius: 40px;
        padding: 0.6rem 1.5rem;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.2s;
        color: white;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-guindo:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(128,0,32,0.2);
        color: white;
    }

    .btn-cafe {
        background: #5a3a2a;
        border: none;
        border-radius: 40px;
        padding: 0.6rem 1.5rem;
        font-weight: 600;
        font-size: 0.9rem;
        color: white;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-cafe:hover {
        background: #7a4a2a;
        color: white;
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {
        .reporte-detalles-create {
            padding: 1rem;
        }

        .form-panel {
            padding: 1rem;
        }
    }
");
?>

<div class="reporte-detalles-create">

    <div class="top-actions">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= Html::a(
            '<i class="bi bi-arrow-left"></i> Volver',
            ['index'],
            ['class' => 'btn btn-cafe']
        ) ?>
    </div>

    <div class="form-panel">
        <h3>Captura de datos</h3>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>