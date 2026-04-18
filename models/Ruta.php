<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ruta".
 *
 * @property int $id_ruta
 * @property string $nombre_ruta
 *
 * @property Colonia[] $colonias
 * @property DetalleDiario[] $detalleDiarios
 * @property RutaColonia[] $rutaColonias
 */
class Ruta extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ruta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_ruta'], 'required'],
            [['nombre_ruta'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_ruta' => 'Id Ruta',
            'nombre_ruta' => 'Nombre Ruta',
        ];
    }

    /**
     * Gets query for [[Colonias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getColonias()
    {
        return $this->hasMany(Colonia::class, ['id_colonia' => 'id_colonia'])->viaTable('ruta_colonia', ['id_ruta' => 'id_ruta']);
    }

    /**
     * Gets query for [[DetalleDiarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleDiarios()
    {
        return $this->hasMany(DetalleDiario::class, ['id_ruta' => 'id_ruta']);
    }

    /**
     * Gets query for [[RutaColonias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRutaColonias()
    {
        return $this->hasMany(RutaColonia::class, ['id_ruta' => 'id_ruta']);
    }

}
