<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TipoUnidad $model */

$this->title = 'Create Tipo Unidad';
$this->params['breadcrumbs'][] = ['label' => 'Tipo Unidads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-unidad-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
