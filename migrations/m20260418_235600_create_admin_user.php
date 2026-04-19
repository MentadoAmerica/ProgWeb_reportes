<?php

use yii\db\Migration;
use app\models\Usuarios;

class m20260418_235600_create_admin_user extends Migration
{
    public function safeUp()
    {
        // Insert admin only if not exists
        $exists = (new \yii\db\Query())->from('usuarios')->where(['nombre' => 'admin'])->exists();
        if (!$exists) {
            $this->insert('usuarios', [
                'nombre' => 'admin',
                'email' => 'admin@ejemplo.com',
                'rol' => 'admin',
                'status' => 10,
                'created_at' => date('Y-m-d H:i:s'),
                'auth_key' => Yii::$app->security->generateRandomString(),
                'password_hash' => Yii::$app->security->generatePasswordHash('admin123'),
            ]);
        }
    }

    public function safeDown()
    {
        $this->delete('usuarios', ['nombre' => 'admin']);
    }
}
