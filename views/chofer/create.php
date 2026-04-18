<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Chofer $model */

$this->title = 'Create Chofer';
$this->params['breadcrumbs'][] = ['label' => 'Chofers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chofer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
