<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Despachador $model */

$this->title = 'Create Despachador';
$this->params['breadcrumbs'][] = ['label' => 'Despachadors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="despachador-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
