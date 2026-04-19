<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Iniciar sesión';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss("
    body {
        background: linear-gradient(135deg, #f8f6f4 0%, #f0ece8 100%);
        min-height: 100vh;
    }
    .site-login {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        padding: 80px 1rem 2rem;
        margin: 0;
        background: transparent;
    }
    .login-card {
        background: white;
        border-radius: 40px;
        box-shadow: 0 25px 45px rgba(97,18,50,0.15);
        border: 1px solid rgba(97,18,50,0.08);
        max-width: 550px;
        width: 100%;
        transition: transform 0.2s;
    }
    .login-header {
        background: #611232;
        color: white;
        padding: 2rem 1.5rem;
        text-align: center;
        border-radius: 40px 40px 0 0;
    }
    .login-header i {
        font-size: 3.5rem;
        margin-bottom: 0.75rem;
    }
    .login-header h1 {
        margin: 0;
        font-size: 2rem;
        font-weight: 800;
        letter-spacing: -0.5px;
    }
    .login-header p {
        margin-top: 0.75rem;
        opacity: 0.95;
        font-size: 1rem;
    }
    .login-body {
        padding: 2.5rem 2rem 2rem;
    }
    .login-body .form-group {
        margin-bottom: 1.75rem;
    }
    .login-body label {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .login-body label i {
        color: #611232;
        font-size: 1.2rem;
    }
    .login-body .form-control {
        border-radius: 50px;
        border: 1px solid #e0d6cf;
        padding: 0.8rem 1.2rem;
        font-size: 1rem;
        transition: 0.2s;
        height: auto;
    }
    .login-body .form-control:focus {
        border-color: #611232;
        box-shadow: 0 0 0 0.25rem rgba(97,18,50,0.2);
    }
    .checkbox-label {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        font-weight: normal;
        color: #555;
        font-size: 0.95rem;
    }
    .checkbox-label input {
        width: 1.1rem;
        height: 1.1rem;
        margin: 0;
    }
    .btn-login {
        background-color: #611232;
        border: none;
        border-radius: 50px;
        padding: 0.8rem 1.2rem;
        font-weight: 700;
        font-size: 1rem;
        width: 100%;
        transition: 0.2s;
    }
    .btn-login:hover {
        background-color: #7e1a42;
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(97,18,50,0.3);
    }
    .login-footer {
        background: #f9f7f5;
        padding: 1.2rem 2rem;
        border-radius: 0 0 40px 40px;
        text-align: center;
        font-size: 0.9rem;
        color: #6c6c6c;
        border-top: 1px solid rgba(97,18,50,0.05);
    }
    .login-footer a {
        color: #611232;
        text-decoration: none;
        font-weight: 600;
    }
    .login-footer a:hover {
        text-decoration: underline;
    }
    /* Responsive para móviles */
    @media (max-width: 576px) {
        .site-login {
            padding: 60px 0.75rem 1.5rem;
            align-items: flex-start;
        }
        .login-card {
            border-radius: 32px;
            max-width: 100%;
            margin: 0;
        }
        .login-header {
            padding: 1.5rem 1rem;
            border-radius: 32px 32px 0 0;
        }
        .login-header i {
            font-size: 2.5rem;
        }
        .login-header h1 {
            font-size: 1.6rem;
        }
        .login-header p {
            font-size: 0.85rem;
        }
        .login-body {
            padding: 1.5rem 1.2rem;
        }
        .login-body .form-control {
            padding: 0.7rem 1rem;
        }
        .btn-login {
            padding: 0.7rem 1rem;
        }
        .login-footer {
            padding: 1rem 1.2rem;
            font-size: 0.8rem;
        }
    }
");
?>

<div class="site-login">
    <div class="login-card">
        <div class="login-header">
            <i class="bi bi-box-arrow-in-right"></i>
            <h1><?= Html::encode($this->title) ?></h1>
            <p>Accede al sistema de reportes</p>
        </div>

        <div class="login-body">
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'form-label'],
                    'inputOptions' => ['class' => 'form-control'],
                    'errorOptions' => ['class' => 'invalid-feedback d-block'],
                ],
            ]); ?>

            <?= $form->field($model, 'username', [
                'labelOptions' => ['class' => 'form-label'],
                'inputTemplate' => '<div class="input-group"><span class="input-group-text bg-transparent border-end-0"><i class="bi bi-person"></i></span>{input}</div>',
            ])->textInput(['autofocus' => true, 'placeholder' => 'Usuario', 'class' => 'form-control border-start-0']) ?>

            <?= $form->field($model, 'password', [
                'labelOptions' => ['class' => 'form-label'],
                'inputTemplate' => '<div class="input-group"><span class="input-group-text bg-transparent border-end-0"><i class="bi bi-lock"></i></span>{input}</div>',
            ])->passwordInput(['placeholder' => 'Contraseña', 'class' => 'form-control border-start-0']) ?>

            <?= $form->field($model, 'rememberMe')->checkbox([
                'template' => "<div class=\"checkbox-label\">{input} {label}</div>\n<div>{error}</div>",
                'labelOptions' => ['class' => 'form-check-label ms-2'],
                'class' => 'form-check-input',
            ]) ?>

            <div class="form-group mt-4">
                <?= Html::submitButton('<i class="bi bi-box-arrow-in-right"></i> Ingresar', ['class' => 'btn btn-login btn-primary', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="login-footer">
            <i class="bi bi-info-circle"></i> ¿No tienes cuenta? 
            <?= Html::a('Regístrate aquí', ['site/signup']) ?>
            <br>
            <small>Credenciales de prueba: <strong>admin</strong> / <strong>admin123</strong></small>
        </div>
    </div>
</div>