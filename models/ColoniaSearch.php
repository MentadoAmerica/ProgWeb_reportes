<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Colonia;

/**
 * ColoniaSearch represents the model behind the search form of `app\models\Colonia`.
 */
class ColoniaSearch extends Colonia
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_colonia', 'num_habitantes'], 'integer'],
            [['nombre_colonia'], 'safe'],
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
        $query = Colonia::find();

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
            'id_colonia' => $this->id_colonia,
            'num_habitantes' => $this->num_habitantes,
        ]);

        $query->andFilterWhere(['like', 'nombre_colonia', $this->nombre_colonia]);

        return $dataProvider;
    }
}
