<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Usuarios extends ActiveRecord implements IdentityInterface
{
    public $password;

    public static function tableName()
    {
        return 'usuarios';
    }

    public function rules()
    {
        $rules = [];
        $table = Yii::$app->db->schema->getTableSchema(self::tableName());

        // nombre is expected to exist
        $rules[] = [['nombre'], 'required'];
        $rules[] = [['nombre'], 'string', 'max' => 100];
        $rules[] = [['nombre'], 'unique'];

        // email rules only if column exists
        if ($table !== null && isset($table->columns['email'])) {
            $rules[] = [['email'], 'required'];
            $rules[] = [['email'], 'email'];
            $rules[] = [['email'], 'unique'];
        }

        if ($table !== null && isset($table->columns['rol'])) {
            $rules[] = [['rol'], 'string', 'max' => 20];
        }

        if ($table !== null && isset($table->columns['created_at'])) {
            $rules[] = [['created_at'], 'safe'];
        }

        $rules[] = ['password', 'string', 'min' => 6];
        $rules[] = ['password', 'required', 'on' => 'create'];

        return $rules;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre de usuario',
            'email' => 'Correo electrónico',
            'rol' => 'Rol',
            'created_at' => 'Fecha de creación',
            'password' => 'Contraseña',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }

    public static function findByUsername($username)
    {
        return static::findOne(['nombre' => $username]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->getAttribute('auth_key');
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAttribute('auth_key') === $authKey;
    }

    public function validatePassword($password)
    {
        $hash = $this->getAttribute('password_hash');
        if (empty($hash)) return false;
        return Yii::$app->security->validatePassword($password, $hash);
    }

    public function setPassword($password)
    {
        if ($this->hasAttribute('password_hash')) {
            $this->password_hash = Yii::$app->security->generatePasswordHash($password);
        }
    }

    public function generateAuthKey()
    {
        if ($this->hasAttribute('auth_key')) {
            $this->auth_key = Yii::$app->security->generateRandomString();
        }
    }

    public function isAdmin()
    {
        return $this->getAttribute('rol') === 'admin';
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->generateAuthKey();
            }
            if (!empty($this->password)) {
                $this->setPassword($this->password);
            }
            return true;
        }
        return false;
    }
}