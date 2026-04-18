<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ruta_colonia".
 *
 * @property int $id_ruta_colonia
 * @property int $id_ruta
 * @property int $id_colonia
 * @property int $orden_numeracion
 *
 * @property Colonia $colonia
 * @property Ruta $ruta
 */
class RutaColonia extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ruta_colonia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_ruta', 'id_colonia', 'orden_numeracion'], 'required'],
            [['id_ruta', 'id_colonia', 'orden_numeracion'], 'integer'],
            [['id_ruta', 'id_colonia'], 'unique', 'targetAttribute' => ['id_ruta', 'id_colonia']],
            [['id_ruta'], 'exist', 'skipOnError' => true, 'targetClass' => Ruta::class, 'targetAttribute' => ['id_ruta' => 'id_ruta']],
            [['id_colonia'], 'exist', 'skipOnError' => true, 'targetClass' => Colonia::class, 'targetAttribute' => ['id_colonia' => 'id_colonia']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_ruta_colonia' => 'Id Ruta Colonia',
            'id_ruta' => 'Id Ruta',
            'id_colonia' => 'Id Colonia',
            'orden_numeracion' => 'Orden Numeracion',
        ];
    }

    /**
     * Gets query for [[Colonia]].
     *
     * @return \yii\db\ActiveQuery
     */
   public function getColonia()
{
    return $this->hasOne(Colonia::class, ['id_colonia' => 'id_colonia']);
}
    /**
     * Gets query for [[Ruta]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRuta()
    {
        return $this->hasOne(Ruta::class, ['id_ruta' => 'id_ruta']);
    }

}
