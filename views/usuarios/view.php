<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Usuarios $model */

$this->title = 'Información del Usuario ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="usuarios-view">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px;">
        <div>
            <h2 style="color: #621132; font-weight: 600; margin-bottom: 5px; font-family: 'Varela Round', sans-serif; font-size: 32px;">
                <i class="fas fa-info-circle" style="margin-right: 10px; color: #621132;"></i>
                <?= Html::encode($this->title) ?>
            </h2>
            <p style="color: #7a6a5a; margin: 0; font-size: 16px; font-family: 'Varela Round', sans-serif;">
                <i class="fas fa-user-tie" style="margin-right: 5px; color: #621132;"></i>
                Detalles del usuario registrado
            </p>
        </div>

        <div>
            <?= Html::a(
                '<i class="fas fa-arrow-left" style="margin-right: 8px;"></i> Volver a Usuarios',
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
                <i class="fas fa-list" style="margin-right: 8px; color: #621132;"></i>
                Datos del usuario
            </div>
        </div>

        <div style="padding: 30px 25px; background: #fff;">
            <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 15px;">
                <!-- ID -->
                <div style="background: linear-gradient(135deg, #f0e0d0 0%, #f9e4d4 100%); border-left: 4px solid #621132; padding: 20px; border-radius: 10px; box-shadow: 0 4px 12px rgba(98, 17, 50, 0.1); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 20px rgba(98, 17, 50, 0.2)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(98, 17, 50, 0.1)';">
                    <div style="display: flex; align-items: center; margin-bottom: 10px;">
                        <i class="fas fa-hashtag" style="color: #621132; font-size: 18px; margin-right: 10px;"></i>
                        <span style="color: #7a6a5a; font-weight: 600; font-family: 'Varela Round', sans-serif; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">ID del Usuario</span>
                    </div>
                    <div style="color: #621132; font-weight: 700; font-family: 'Varela Round', sans-serif; font-size: 28px;"><?= Html::encode($model->id) ?></div>
                </div>

                <!-- Nombre -->
                <div style="background: linear-gradient(135deg, #f0e0d0 0%, #f9e4d4 100%); border-left: 4px solid #621132; padding: 20px; border-radius: 10px; box-shadow: 0 4px 12px rgba(98, 17, 50, 0.1); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 20px rgba(98, 17, 50, 0.2)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(98, 17, 50, 0.1)';">
                    <div style="display: flex; align-items: center; margin-bottom: 10px;">
                        <i class="fas fa-user" style="color: #621132; font-size: 18px; margin-right: 10px;"></i>
                        <span style="color: #7a6a5a; font-weight: 600; font-family: 'Varela Round', sans-serif; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Nombre de Usuario</span>
                    </div>
                    <div style="color: #621132; font-weight: 700; font-family: 'Varela Round', sans-serif; font-size: 20px;"><?= Html::encode($model->nombre) ?></div>
                </div>

                <!-- Email -->
                <div style="background: linear-gradient(135deg, #f0e0d0 0%, #f9e4d4 100%); border-left: 4px solid #621132; padding: 20px; border-radius: 10px; box-shadow: 0 4px 12px rgba(98, 17, 50, 0.1); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 20px rgba(98, 17, 50, 0.2)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(98, 17, 50, 0.1)';">
                    <div style="display: flex; align-items: center; margin-bottom: 10px;">
                        <i class="fas fa-envelope" style="color: #621132; font-size: 18px; margin-right: 10px;"></i>
                        <span style="color: #7a6a5a; font-weight: 600; font-family: 'Varela Round', sans-serif; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Correo Electrónico</span>
                    </div>
                    <div style="color: #621132; font-weight: 700; font-family: 'Varela Round', sans-serif; font-size: 16px; word-break: break-word;"><?= Html::encode($model->email) ?></div>
                </div>

                <!-- Rol -->
                <div style="background: linear-gradient(135deg, #f0e0d0 0%, #f9e4d4 100%); border-left: 4px solid #621132; padding: 20px; border-radius: 10px; box-shadow: 0 4px 12px rgba(98, 17, 50, 0.1); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 20px rgba(98, 17, 50, 0.2)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(98, 17, 50, 0.1)';">
                    <div style="display: flex; align-items: center; margin-bottom: 10px;">
                        <i class="fas fa-shield-alt" style="color: #621132; font-size: 18px; margin-right: 10px;"></i>
                        <span style="color: #7a6a5a; font-weight: 600; font-family: 'Varela Round', sans-serif; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Rol</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <?php if ($model->rol === 'admin'): ?>
                            <i class="fas fa-crown" style="color: #d4af37; font-size: 16px;"></i>
                            <span style="color: #621132; font-weight: 700; font-family: 'Varela Round', sans-serif; font-size: 18px; background: #fff3cd; padding: 4px 12px; border-radius: 20px; display: inline-block;">Administrador</span>
                        <?php else: ?>
                            <i class="fas fa-user-check" style="color: #28a745; font-size: 16px;"></i>
                            <span style="color: #621132; font-weight: 700; font-family: 'Varela Round', sans-serif; font-size: 18px; background: #d1ecf1; padding: 4px 12px; border-radius: 20px; display: inline-block;">Operador</span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Fecha de Creación -->
                <div style="background: linear-gradient(135deg, #f0e0d0 0%, #f9e4d4 100%); border-left: 4px solid #621132; padding: 20px; border-radius: 10px; box-shadow: 0 4px 12px rgba(98, 17, 50, 0.1); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 20px rgba(98, 17, 50, 0.2)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(98, 17, 50, 0.1)';">
                    <div style="display: flex; align-items: center; margin-bottom: 10px;">
                        <i class="fas fa-calendar-alt" style="color: #621132; font-size: 18px; margin-right: 10px;"></i>
                        <span style="color: #7a6a5a; font-weight: 600; font-family: 'Varela Round', sans-serif; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Fecha de Creación</span>
                    </div>
                    <div style="color: #621132; font-weight: 700; font-family: 'Varela Round', sans-serif; font-size: 16px;"><?= Html::encode($model->created_at) ?></div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
?>
