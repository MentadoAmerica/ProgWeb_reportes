<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "despachador".
 *
 * @property int $id_despachador
 * @property string $nombre_despachador
 *
 * @property DetalleDiario[] $detalleDiarios
 */
class Despachador extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'despachador';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_despachador'], 'required'],
            [['nombre_despachador'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_despachador' => 'Id Despachador',
            'nombre_despachador' => 'Nombre Despachador',
        ];
    }

    /**
     * Gets query for [[DetalleDiarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleDiarios()
    {
        return $this->hasMany(DetalleDiario::class, ['id_despachador' => 'id_despachador']);
    }

}
