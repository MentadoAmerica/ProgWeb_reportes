<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class UsuariosSearch extends Usuarios
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['nombre', 'email', 'rol', 'created_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Usuarios::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 20],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id])
            ->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'rol', $this->rol]);

        return $dataProvider;
    }
}
