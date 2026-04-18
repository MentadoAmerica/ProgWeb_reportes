<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Colonia $model */

$this->title = 'Update Colonia: ' . $model->id_colonia;
$this->params['breadcrumbs'][] = ['label' => 'Colonias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_colonia, 'url' => ['view', 'id_colonia' => $model->id_colonia]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="colonia-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
