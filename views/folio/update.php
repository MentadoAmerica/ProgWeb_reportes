<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Folio $model */

$this->title = 'Update Folio: ' . $model->id_folio;
$this->params['breadcrumbs'][] = ['label' => 'Folios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_folio, 'url' => ['view', 'id_folio' => $model->id_folio]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="folio-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
