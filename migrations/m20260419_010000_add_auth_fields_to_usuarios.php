<?php

use yii\db\Migration;

class m20260419_010000_add_auth_fields_to_usuarios extends Migration
{
    public function safeUp()
    {
        $table = $this->db->schema->getTableSchema('usuarios');
        if ($table === null) {
            // table does not exist; nothing to do
            return;
        }

        if (!isset($table->columns['auth_key'])) {
            $this->addColumn('usuarios', 'auth_key', $this->string(32));
        }
        if (!isset($table->columns['password_hash'])) {
            $this->addColumn('usuarios', 'password_hash', $this->string());
        }
        if (!isset($table->columns['password_reset_token'])) {
            $this->addColumn('usuarios', 'password_reset_token', $this->string());
            $this->createIndex('idx-usuarios-password_reset_token', 'usuarios', 'password_reset_token', true);
        }
        if (!isset($table->columns['email'])) {
            $this->addColumn('usuarios', 'email', $this->string()->notNull());
            $this->createIndex('idx-usuarios-email', 'usuarios', 'email', true);
        }
        if (!isset($table->columns['rol'])) {
            $this->addColumn('usuarios', 'rol', $this->string(20)->defaultValue('operador'));
        }
        if (!isset($table->columns['status'])) {
            $this->addColumn('usuarios', 'status', $this->smallInteger()->defaultValue(10));
        }
        if (!isset($table->columns['created_at'])) {
            $this->addColumn('usuarios', 'created_at', $this->dateTime());
        }
    }

    public function safeDown()
    {
        $table = $this->db->schema->getTableSchema('usuarios');
        if ($table === null) return;

        if (isset($table->columns['auth_key'])) $this->dropColumn('usuarios', 'auth_key');
        if (isset($table->columns['password_hash'])) $this->dropColumn('usuarios', 'password_hash');
        if (isset($table->columns['password_reset_token'])) {
            $this->dropIndex('idx-usuarios-password_reset_token', 'usuarios');
            $this->dropColumn('usuarios', 'password_reset_token');
        }
        if (isset($table->columns['email'])) {
            $this->dropIndex('idx-usuarios-email', 'usuarios');
            $this->dropColumn('usuarios', 'email');
        }
        if (isset($table->columns['rol'])) $this->dropColumn('usuarios', 'rol');
        if (isset($table->columns['status'])) $this->dropColumn('usuarios', 'status');
        if (isset($table->columns['created_at'])) $this->dropColumn('usuarios', 'created_at');
    }
}
