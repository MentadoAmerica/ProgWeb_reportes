<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "colonia".
 *
 * @property int $id_colonia
 * @property string $nombre_colonia
 * @property int $num_habitantes
 *
 * @property ReporteDetalles[] $reporteDetalles
 * @property RutaColonia[] $rutaColonias
 * @property Ruta[] $rutas
 */
class Colonia extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'colonia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_colonia', 'num_habitantes'], 'required'],
            [['num_habitantes'], 'integer'],
            [['nombre_colonia'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_colonia' => 'Id Colonia',
            'nombre_colonia' => 'Nombre Colonia',
            'num_habitantes' => 'Num Habitantes',
        ];
    }

    /**
     * Gets query for [[ReporteDetalles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReporteDetalles()
    {
        return $this->hasMany(ReporteDetalles::class, ['id_colonia' => 'id_colonia']);
    }

    /**
     * Gets query for [[RutaColonias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRutaColonias()
    {
        return $this->hasMany(RutaColonia::class, ['id_colonia' => 'id_colonia']);
    }

    /**
     * Gets query for [[Rutas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRutas()
    {
        return $this->hasMany(Ruta::class, ['id_ruta' => 'id_ruta'])->viaTable('ruta_colonia', ['id_colonia' => 'id_colonia']);
    }

}
