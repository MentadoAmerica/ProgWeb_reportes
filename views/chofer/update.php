<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Chofer $model */

$this->title = 'Update Chofer: ' . $model->id_chofer;
$this->params['breadcrumbs'][] = ['label' => 'Chofers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_chofer, 'url' => ['view', 'id_chofer' => $model->id_chofer]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="chofer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
