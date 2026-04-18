<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Ruta $model */

$this->title = 'Create Ruta';
$this->params['breadcrumbs'][] = ['label' => 'Rutas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ruta-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
