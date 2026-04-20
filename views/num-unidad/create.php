<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\NumUnidad $model */

$this->title = 'Crear Unidad';
$this->params['breadcrumbs'][] = ['label' => 'Unidades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="num-unidad-create">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px;">
        <div>
            <h2 style="color: #621132; font-weight: 600; margin-bottom: 5px; font-family: 'Varela Round', sans-serif; font-size: 32px;">
                <i class="fas fa-plus-circle" style="margin-right: 10px; color: #621132;"></i>
                <?= Html::encode($this->title) ?>
            </h2>
            <p style="color: #7a6a5a; margin: 0; font-size: 16px; font-family: 'Varela Round', sans-serif;">
                <i class="fas fa-info-circle" style="margin-right: 5px; color: #621132;"></i>
                Registra una nueva unidad en el sistema
            </p>
        </div>

        <div>
            <?= Html::a(
                '<i class="fas fa-arrow-left" style="margin-right: 8px;"></i> Volver a Unidades',
                ['index'],
                [
                    'style' => 'background: white; border: 1px solid #d4a373; color: #621132; padding: 12px 22px; border-radius: 10px; font-weight: 600; font-family: "Varela Round", sans-serif; font-size: 15px; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 4px 8px rgba(98, 17, 50, 0.08);',
                    'onmouseover' => 'this.style.backgroundColor="#f9e4d4"; this.style.transform="translateY(-2px)";',
                    'onmouseout' => 'this.style.backgroundColor="white"; this.style.transform="translateY(0)";'
                ]
            ) ?>
        </div>
    </div>

    <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(98, 17, 50, 0.15); border: 1px solid #f0e0d0;">
        
        <div style="padding: 18px 24px; border-bottom: 1px solid #f0e0d0; background: white;">
            <div style="color: #621132; font-size: 16px; font-family: 'Varela Round', sans-serif;">
                <i class="fas fa-truck" style="margin-right: 8px; color: #621132;"></i>
                Captura los datos de la nueva unidad
            </div>
        </div>

        <div style="padding: 30px 25px; background: #fff;">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>

</div>

<?php
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
?>