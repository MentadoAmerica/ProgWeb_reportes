<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\DetalleDiario $model */
/** @var app\models\TipoUnidad[] $tiposUnidad */
/** @var app\models\Ruta[] $rutas */
/** @var app\models\Chofer[] $choferes */
/** @var app\models\Despachador[] $despachadores */

/**$this->title = 'Nuevo Reporte';**/
$this->params['breadcrumbs'][] = ['label' => 'Reportes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detallediario-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
        'tiposUnidad' => $tiposUnidad,
        'rutas' => $rutas,
        'choferes' => $choferes,
        'despachadores' => $despachadores,
    ]) ?>
</div>
