<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reporte_detalles".
 *
 * @property int $id_reporte
 * @property int $id_folio
 * @property int $id_colonia
 * @property float $porcentaje_colonia
 *
 * @property Colonia $colonia
 * @property DetalleDiario $folio
 */
class ReporteDetalles extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reporte_detalles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_folio', 'id_colonia', 'porcentaje_colonia'], 'required'],
            [['id_folio', 'id_colonia'], 'integer'],
            [['porcentaje_colonia'], 'number'],
            [['id_folio'], 'exist', 'skipOnError' => true, 'targetClass' => DetalleDiario::class, 'targetAttribute' => ['id_folio' => 'id_folio']],
            [['id_colonia'], 'exist', 'skipOnError' => true, 'targetClass' => Colonia::class, 'targetAttribute' => ['id_colonia' => 'id_colonia']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_reporte' => 'Id Reporte',
            'id_folio' => 'Id Folio',
            'id_colonia' => 'Id Colonia',
            'porcentaje_colonia' => 'Porcentaje Colonia',
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
     * Gets query for [[Folio]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFolio()
    {
        return $this->hasOne(DetalleDiario::class, ['id_folio' => 'id_folio']);
    }

}
