<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ReporteDetalles;

/**
 * ReporteDetallesSearch represents the model behind the search form of `app\models\ReporteDetalles`.
 */
class ReporteDetallesSearch extends ReporteDetalles
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_reporte', 'id_folio', 'id_colonia'], 'integer'],
            [['porcentaje_colonia'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = ReporteDetalles::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_reporte' => $this->id_reporte,
            'id_folio' => $this->id_folio,
            'id_colonia' => $this->id_colonia,
            'porcentaje_colonia' => $this->porcentaje_colonia,
        ]);

        return $dataProvider;
    }
}
