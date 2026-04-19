<?php
namespace app\models;

use Yii;
use yii\base\Model;

class SignupForm extends Model
{
    public $nombre;
    public $email;
    public $password;

    public function rules()
    {
        return [
            [['nombre', 'email', 'password'], 'required'],
            ['email', 'email'],
            ['nombre', 'string', 'min' => 2, 'max' => 255],
            ['password', 'string', 'min' => 6],
            // use custom validators for uniqueness to avoid DB errors when columns missing
            ['email', 'validateUniqueEmail'],
            ['nombre', 'validateUniqueNombre'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'nombre' => 'Nombre',
            'email' => 'Correo electrónico',
            'password' => 'Contraseña',
        ];
    }

    public function signup()
    {
        if (!$this->validate()) return null;
        $user = new Usuarios();
        $user->nombre = $this->nombre;

        $table = Yii::$app->db->schema->getTableSchema('usuarios');
        if ($table !== null && isset($table->columns['email'])) {
            $user->email = $this->email;
        }
        if ($table !== null && isset($table->columns['password_hash'])) {
            $user->password = $this->password;
        } else {
            if ($table !== null && isset($table->columns['password'])) {
                $user->password = $this->password;
            }
        }
        if ($table !== null && isset($table->columns['rol'])) $user->rol = 'operador';
        if ($table !== null && isset($table->columns['status'])) $user->status = 10;
        if ($table !== null && isset($table->columns['created_at'])) $user->created_at = date('Y-m-d H:i:s');

        $saved = $user->save();
        if ($saved && $table !== null && !isset($table->columns['email'])) {
            Yii::$app->session->setFlash('warning', 'Cuenta creada, pero faltan columnas en la tabla `usuarios` (p.ej. `email`). Ejecute las migraciones.');
        }
        return $saved ? $user : null;
    }

    public function validateUniqueEmail($attribute, $params)
    {
        $table = Yii::$app->db->schema->getTableSchema('usuarios');
        if ($table === null || !isset($table->columns['email'])) {
            return;
        }
        try {
            if (\app\models\Usuarios::find()->where(['email' => $this->$attribute])->exists()) {
                $this->addError($attribute, 'Este email ya está registrado.');
            }
        } catch (\Exception $e) {
            // skip on DB errors
        }
    }

    public function validateUniqueNombre($attribute, $params)
    {
        $table = Yii::$app->db->schema->getTableSchema('usuarios');
        if ($table === null || !isset($table->columns['nombre'])) {
            return;
        }
        try {
            if (\app\models\Usuarios::find()->where(['nombre' => $this->$attribute])->exists()) {
                $this->addError($attribute, 'Este nombre ya está registrado.');
            }
        } catch (\Exception $e) {
            // skip
        }
    }
}
