<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Colonia $model */

$this->title = 'Create Colonia';
$this->params['breadcrumbs'][] = ['label' => 'Colonias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="colonia-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
