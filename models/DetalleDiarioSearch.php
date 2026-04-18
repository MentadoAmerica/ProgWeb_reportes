<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DetalleDiario;

class DetalleDiarioSearch extends DetalleDiario
{
    public $nombre_colonia;
    public $fecha_desde;
    public $fecha_hasta;

    public function rules()
    {
        return [
            [['id_folio', 'turno', 'id_tipo_unidad', 'id_unidad', 'id_ruta', 'id_chofer', 'id_despachador', 'cant_colonias'], 'integer'],
            [['fecha_orden', 'fecha_captura', 'comentarios', 'nombre_colonia', 'fecha_desde', 'fecha_hasta'], 'safe'],
            [['cantidad_kg', 'porcentaje_efectividad', 'km_salir', 'km_entrar', 'suma_por_atendida', 'por_realizado'], 'number'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = DetalleDiario::find();
        $query->joinWith(['reporteDetalles.colonia']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id_folio' => SORT_DESC],
                'attributes' => [
                    'id_folio',
                    'fecha_orden',
                    'fecha_captura',
                    'turno',
                    'id_tipo_unidad',
                    'id_unidad',
                    'id_ruta',
                    'cantidad_kg',
                    'total_km', // total_km es una columna de la tabla, pero no se filtra
                ]
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'detalle_diario.id_folio' => $this->id_folio,
            'detalle_diario.turno' => $this->turno,
            'detalle_diario.id_tipo_unidad' => $this->id_tipo_unidad,
            'detalle_diario.id_unidad' => $this->id_unidad,
            'detalle_diario.id_ruta' => $this->id_ruta,
            'detalle_diario.id_chofer' => $this->id_chofer,
            'detalle_diario.id_despachador' => $this->id_despachador,
            'detalle_diario.cantidad_kg' => $this->cantidad_kg,
        ]);

        $query->andFilterWhere(['like', 'detalle_diario.comentarios', $this->comentarios]);

        if (!empty($this->fecha_desde)) {
            $query->andFilterWhere(['>=', 'detalle_diario.fecha_orden', $this->fecha_desde]);
        }
        if (!empty($this->fecha_hasta)) {
            $query->andFilterWhere(['<=', 'detalle_diario.fecha_orden', $this->fecha_hasta]);
        }

        if (!empty($this->nombre_colonia)) {
            $query->andFilterWhere(['like', 'colonia.nombre_colonia', $this->nombre_colonia]);
        }

        return $dataProvider;
    }
}