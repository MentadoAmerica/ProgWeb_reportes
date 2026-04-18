<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RutaColonia;

/**
 * RutaColoniaSearch represents the model behind the search form of `app\models\RutaColonia`.
 */
class RutaColoniaSearch extends RutaColonia
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_ruta_colonia', 'id_ruta', 'id_colonia', 'orden_numeracion'], 'integer'],
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
        $query = RutaColonia::find();

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
            'id_ruta_colonia' => $this->id_ruta_colonia,
            'id_ruta' => $this->id_ruta,
            'id_colonia' => $this->id_colonia,
            'orden_numeracion' => $this->orden_numeracion,
        ]);

        return $dataProvider;
    }
}
