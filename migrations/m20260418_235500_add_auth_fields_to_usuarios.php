<?php

use yii\db\Migration;

class m20260418_235500_add_auth_fields_to_usuarios extends Migration
{
    public function safeUp()
    {
        $this->addColumn('usuarios', 'auth_key', $this->string(32));
        $this->addColumn('usuarios', 'password_hash', $this->string());
        $this->addColumn('usuarios', 'password_reset_token', $this->string()->unique());
        $this->addColumn('usuarios', 'email', $this->string()->notNull()->unique());
        $this->addColumn('usuarios', 'rol', $this->string(20)->defaultValue('operador'));
        $this->addColumn('usuarios', 'status', $this->smallInteger()->defaultValue(10));
    }

    public function safeDown()
    {
        $this->dropColumn('usuarios', 'auth_key');
        $this->dropColumn('usuarios', 'password_hash');
        $this->dropColumn('usuarios', 'password_reset_token');
        $this->dropColumn('usuarios', 'email');
        $this->dropColumn('usuarios', 'rol');
        $this->dropColumn('usuarios', 'status');
    }
}
