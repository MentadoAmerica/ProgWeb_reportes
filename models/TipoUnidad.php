<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipo_unidad".
 *
 * @property int $id_tipo_unidad
 * @property string $nombre_tipo
 *
 * @property DetalleDiario[] $detalleDiarios
 * @property NumUnidad[] $numUnidads
 */
class TipoUnidad extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipo_unidad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_tipo'], 'required'],
            [['nombre_tipo'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_tipo_unidad' => 'Id Tipo Unidad',
            'nombre_tipo' => 'Nombre Tipo',
        ];
    }

    /**
     * Gets query for [[DetalleDiarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleDiarios()
    {
        return $this->hasMany(DetalleDiario::class, ['id_tipo_unidad' => 'id_tipo_unidad']);
    }

    /**
     * Gets query for [[NumUnidads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNumUnidads()
    {
        return $this->hasMany(NumUnidad::class, ['id_tipo_unidad' => 'id_tipo_unidad']);
    }

}
