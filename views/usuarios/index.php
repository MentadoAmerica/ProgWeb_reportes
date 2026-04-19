<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Usuarios';
?>
<div class="usuarios-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Usuario', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\\grid\\SerialColumn'],
            'id',
            'nombre',
            'email',
            'rol',
            'created_at',
            ['class' => 'yii\\grid\\ActionColumn'],
        ],
    ]); ?>

</div>
