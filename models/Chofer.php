<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "chofer".
 *
 * @property int $id_chofer
 * @property string $nombre_chofer
 *
 * @property DetalleDiario[] $detalleDiarios
 */
class Chofer extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chofer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_chofer'], 'required'],
            [['nombre_chofer'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_chofer' => 'Id Chofer',
            'nombre_chofer' => 'Nombre Chofer',
        ];
    }

    /**
     * Gets query for [[DetalleDiarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleDiarios()
    {
        return $this->hasMany(DetalleDiario::class, ['id_chofer' => 'id_chofer']);
    }

}
