<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "folio".
 *
 * @property int $id_folio
 */
class Folio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'folio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_folio'], 'required'],
            [['id_folio'], 'integer'],
            [['id_folio'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_folio' => 'Número de Folio',
        ];
    }
}