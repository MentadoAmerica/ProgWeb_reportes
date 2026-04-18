<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\NumUnidad;

/**
 * NumUnidadSearch represents the model behind the search form of `app\models\NumUnidad`.
 */
class NumUnidadSearch extends NumUnidad
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_unidad', 'id_tipo_unidad'], 'integer'],
            [['numero_unidad'], 'safe'],
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
        $query = NumUnidad::find();

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
            'id_unidad' => $this->id_unidad,
            'id_tipo_unidad' => $this->id_tipo_unidad,
        ]);

        $query->andFilterWhere(['like', 'numero_unidad', $this->numero_unidad]);

        return $dataProvider;
    }
}
