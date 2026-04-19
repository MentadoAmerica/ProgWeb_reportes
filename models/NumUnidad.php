<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "num_unidad".
 *
 * @property int $id_unidad
 * @property int $id_tipo_unidad
 * @property string $numero_unidad
 *
 * @property DetalleDiario[] $detalleDiarios
 * @property TipoUnidad $tipoUnidad
 */
class NumUnidad extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'num_unidad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_tipo_unidad', 'numero_unidad'], 'required'],
            [['id_tipo_unidad'], 'integer'],
            [['numero_unidad'], 'string', 'max' => 20],
            [['id_tipo_unidad'], 'exist', 'skipOnError' => true, 'targetClass' => TipoUnidad::class, 'targetAttribute' => ['id_tipo_unidad' => 'id_tipo_unidad']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_unidad' => 'Id Unidad',
            'id_tipo_unidad' => 'Id Tipo Unidad',
            'numero_unidad' => 'Numero Unidad',
        ];
    }

    /**
     * Gets query for [[DetalleDiarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleDiarios()
    {
        return $this->hasMany(DetalleDiario::class, ['id_unidad' => 'id_unidad']);
    }

    /**
     * Gets query for [[TipoUnidad]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTipoUnidad()
{
    return $this->hasOne(TipoUnidad::class, ['id_tipo_unidad' => 'id_tipo_unidad']);
}

}
