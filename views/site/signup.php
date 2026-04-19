<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Crear cuenta';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss("
    body {
        background: linear-gradient(135deg, #f8f6f4 0%, #f0ece8 100%);
        min-height: 100vh;
    }
    .site-signup {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        padding: 80px 1rem 2rem;
        margin: 0;
        background: transparent;
    }
    .signup-card {
        background: white;
        border-radius: 40px;
        box-shadow: 0 25px 45px rgba(97,18,50,0.15);
        border: 1px solid rgba(97,18,50,0.08);
        max-width: 550px;
        width: 100%;
        transition: transform 0.2s;
    }
    .signup-header {
        background: #611232;
        color: white;
        padding: 2rem 1.5rem;
        text-align: center;
        border-radius: 40px 40px 0 0;
    }
    .signup-header i {
        font-size: 3.5rem;
        margin-bottom: 0.75rem;
    }
    .signup-header h1 {
        margin: 0;
        font-size: 2rem;
        font-weight: 800;
        letter-spacing: -0.5px;
    }
    .signup-header p {
        margin-top: 0.75rem;
        opacity: 0.95;
        font-size: 1rem;
    }
    .signup-body {
        padding: 2.5rem 2rem 2rem;
    }
    .signup-body .form-group {
        margin-bottom: 1.75rem;
    }
    .signup-body label {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .signup-body label i {
        color: #611232;
        font-size: 1.2rem;
    }
    .signup-body .form-control {
        border-radius: 50px;
        border: 1px solid #e0d6cf;
        padding: 0.8rem 1.2rem;
        font-size: 1rem;
        transition: 0.2s;
        height: auto;
    }
    .signup-body .form-control:focus {
        border-color: #611232;
        box-shadow: 0 0 0 0.25rem rgba(97,18,50,0.2);
    }
    .btn-signup {
        background-color: #611232;
        border: none;
        border-radius: 50px;
        padding: 0.8rem 1.2rem;
        font-weight: 700;
        font-size: 1rem;
        width: 100%;
        transition: 0.2s;
    }
    .btn-signup:hover {
        background-color: #7e1a42;
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(97,18,50,0.3);
    }
    .signup-footer {
        background: #f9f7f5;
        padding: 1.2rem 2rem;
        border-radius: 0 0 40px 40px;
        text-align: center;
        font-size: 0.9rem;
        color: #6c6c6c;
        border-top: 1px solid rgba(97,18,50,0.05);
    }
    .signup-footer a {
        color: #611232;
        text-decoration: none;
        font-weight: 600;
    }
    .signup-footer a:hover {
        text-decoration: underline;
    }
    @media (max-width: 576px) {
        .site-signup {
            padding: 60px 0.75rem 1.5rem;
            align-items: flex-start;
        }
        .signup-card {
            border-radius: 32px;
            max-width: 100%;
        }
        .signup-header {
            padding: 1.5rem 1rem;
            border-radius: 32px 32px 0 0;
        }
        .signup-header i {
            font-size: 2.5rem;
        }
        .signup-header h1 {
            font-size: 1.6rem;
        }
        .signup-header p {
            font-size: 0.85rem;
        }
        .signup-body {
            padding: 1.5rem 1.2rem;
        }
        .signup-body .form-control {
            padding: 0.7rem 1rem;
        }
        .btn-signup {
            padding: 0.7rem 1rem;
        }
        .signup-footer {
            padding: 1rem 1.2rem;
            font-size: 0.8rem;
        }
    }
");
?>

<div class="site-signup">
    <div class="signup-card">
        <div class="signup-header">
            <i class="bi bi-person-plus"></i>
            <h1><?= Html::encode($this->title) ?></h1>
            <p>Completa los datos para crear tu cuenta</p>
        </div>

        <div class="signup-body">
            <?php $form = ActiveForm::begin([
                'id' => 'signup-form',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'form-label'],
                    'inputOptions' => ['class' => 'form-control'],
                    'errorOptions' => ['class' => 'invalid-feedback d-block'],
                ],
            ]); ?>

            <?= $form->field($model, 'nombre', [
                'labelOptions' => ['class' => 'form-label'],
                'inputTemplate' => '<div class="input-group"><span class="input-group-text bg-transparent border-end-0"><i class="bi bi-person"></i></span>{input}</div>',
            ])->textInput(['autofocus' => true, 'placeholder' => 'Nombre de usuario', 'class' => 'form-control border-start-0']) ?>

            <?= $form->field($model, 'email', [
                'labelOptions' => ['class' => 'form-label'],
                'inputTemplate' => '<div class="input-group"><span class="input-group-text bg-transparent border-end-0"><i class="bi bi-envelope"></i></span>{input}</div>',
            ])->textInput(['placeholder' => 'correo@ejemplo.com', 'class' => 'form-control border-start-0']) ?>

            <?= $form->field($model, 'password', [
                'labelOptions' => ['class' => 'form-label'],
                'inputTemplate' => '<div class="input-group"><span class="input-group-text bg-transparent border-end-0"><i class="bi bi-lock"></i></span>{input}</div>',
            ])->passwordInput(['placeholder' => 'Mínimo 6 caracteres', 'class' => 'form-control border-start-0']) ?>

            <div class="form-group mt-4">
                <?= Html::submitButton('<i class="bi bi-check-circle"></i> Registrarse', ['class' => 'btn btn-signup btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="signup-footer">
            <i class="bi bi-box-arrow-in-right"></i> ¿Ya tienes cuenta? 
            <?= Html::a('Inicia sesión aquí', ['site/login']) ?>
        </div>
    </div>
</div>