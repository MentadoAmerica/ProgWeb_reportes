<?php

namespace app\models;

use Yii;

class Usuarios extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'usuarios';
    }

    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 100],
            [['nombre'], 'unique'],
            [['created_at'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'created_at' => 'Fecha de creación',
        ];
    }
}