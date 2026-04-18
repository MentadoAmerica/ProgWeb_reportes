<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\NumUnidad $model */

$this->title = 'Create Num Unidad';
$this->params['breadcrumbs'][] = ['label' => 'Num Unidads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="num-unidad-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
