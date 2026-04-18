<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DetalleDiario;

/**
 * DetalleDiarioSearch represents the model behind the search form of `app\models\DetalleDiario`.
 */
class DetalleDiarioSearch extends DetalleDiario
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_folio', 'turno', 'id_tipo_unidad', 'id_unidad', 'id_ruta', 'id_chofer', 'num_puches', 'id_despachador', 'colonia_1', 'colonia_2', 'colonia_3', 'colonia_4', 'colonia_5', 'colonia_6', 'colonia_7', 'colonia_8', 'colonia_9', 'colonia_10', 'colonia_11', 'anio', 'mes', 'dia', 'cant_colonias', 'habitantes_1', 'habitantes_2', 'habitantes_3', 'habitantes_4', 'habitantes_5', 'habitantes_6', 'habitantes_7', 'habitantes_8', 'habitantes_9', 'habitantes_10', 'habitantes_11', 'id_usuario'], 'integer'],
            [['fecha_orden', 'fecha_captura', 'comentarios'], 'safe'],
            [['cantidad_kg', 'porcentaje_efectividad', 'km_salir', 'km_entrar', 'total_km', 'diesel_iniciar', 'diesel_terminar', 'diesel_cargado', 'por_colonia_1', 'por_colonia_2', 'por_colonia_3', 'por_colonia_4', 'por_colonia_5', 'por_colonia_6', 'por_colonia_7', 'por_colonia_8', 'por_colonia_9', 'por_colonia_10', 'por_colonia_11', 'suma_por_atendida', 'por_realizado'], 'number'],
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
        $query = DetalleDiario::find();

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
            'id_folio' => $this->id_folio,
            'fecha_orden' => $this->fecha_orden,
            'fecha_captura' => $this->fecha_captura,
            'turno' => $this->turno,
            'id_tipo_unidad' => $this->id_tipo_unidad,
            'id_unidad' => $this->id_unidad,
            'id_ruta' => $this->id_ruta,
            'id_chofer' => $this->id_chofer,
            'cantidad_kg' => $this->cantidad_kg,
            'porcentaje_efectividad' => $this->porcentaje_efectividad,
            'num_puches' => $this->num_puches,
            'km_salir' => $this->km_salir,
            'km_entrar' => $this->km_entrar,
            'total_km' => $this->total_km,
            'diesel_iniciar' => $this->diesel_iniciar,
            'diesel_terminar' => $this->diesel_terminar,
            'diesel_cargado' => $this->diesel_cargado,
            'id_despachador' => $this->id_despachador,
            'colonia_1' => $this->colonia_1,
            'colonia_2' => $this->colonia_2,
            'colonia_3' => $this->colonia_3,
            'colonia_4' => $this->colonia_4,
            'colonia_5' => $this->colonia_5,
            'colonia_6' => $this->colonia_6,
            'colonia_7' => $this->colonia_7,
            'colonia_8' => $this->colonia_8,
            'colonia_9' => $this->colonia_9,
            'colonia_10' => $this->colonia_10,
            'colonia_11' => $this->colonia_11,
            'por_colonia_1' => $this->por_colonia_1,
            'por_colonia_2' => $this->por_colonia_2,
            'por_colonia_3' => $this->por_colonia_3,
            'por_colonia_4' => $this->por_colonia_4,
            'por_colonia_5' => $this->por_colonia_5,
            'por_colonia_6' => $this->por_colonia_6,
            'por_colonia_7' => $this->por_colonia_7,
            'por_colonia_8' => $this->por_colonia_8,
            'por_colonia_9' => $this->por_colonia_9,
            'por_colonia_10' => $this->por_colonia_10,
            'por_colonia_11' => $this->por_colonia_11,
            'anio' => $this->anio,
            'mes' => $this->mes,
            'dia' => $this->dia,
            'cant_colonias' => $this->cant_colonias,
            'suma_por_atendida' => $this->suma_por_atendida,
            'por_realizado' => $this->por_realizado,
            'habitantes_1' => $this->habitantes_1,
            'habitantes_2' => $this->habitantes_2,
            'habitantes_3' => $this->habitantes_3,
            'habitantes_4' => $this->habitantes_4,
            'habitantes_5' => $this->habitantes_5,
            'habitantes_6' => $this->habitantes_6,
            'habitantes_7' => $this->habitantes_7,
            'habitantes_8' => $this->habitantes_8,
            'habitantes_9' => $this->habitantes_9,
            'habitantes_10' => $this->habitantes_10,
            'habitantes_11' => $this->habitantes_11,
            'id_usuario' => $this->id_usuario,
        ]);

        $query->andFilterWhere(['like', 'comentarios', $this->comentarios]);

        return $dataProvider;
    }
}
