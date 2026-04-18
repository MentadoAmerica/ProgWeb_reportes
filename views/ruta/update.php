<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Ruta $model */

$this->title = 'Update Ruta: ' . $model->id_ruta;
$this->params['breadcrumbs'][] = ['label' => 'Rutas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_ruta, 'url' => ['view', 'id_ruta' => $model->id_ruta]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ruta-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
