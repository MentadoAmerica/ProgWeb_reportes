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
    public $globalSearch;  // Búsqueda global

    public function rules()
    {
        return [
            [['id_folio', 'turno', 'id_tipo_unidad', 'id_unidad', 'id_ruta', 'id_chofer', 'id_despachador', 'cant_colonias', 'id_usuario'], 'integer'],
            [['fecha_orden', 'fecha_captura', 'comentarios', 'nombre_colonia', 'fecha_desde', 'fecha_hasta', 'globalSearch'], 'safe'],
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
    
    // Joins necesarios
    $query->joinWith(['reporteDetalles.colonia']);
    $query->joinWith(['unidad']);
    $query->joinWith(['ruta']);
    $query->joinWith(['chofer']);
    $query->joinWith(['despachador']);

    // 👇 EVITA DUPLICADOS: agrupa por el ID del reporte
    $query->groupBy('detalle_diario.id_folio');

    $dataProvider = new ActiveDataProvider([
        'query' => $query,
        'sort' => [
            'defaultOrder' => ['id_folio' => SORT_ASC],
            'attributes' => [
                'id_folio',
                'fecha_orden',
                'fecha_captura',
                'turno',
                'id_tipo_unidad',
                'id_unidad',
                'id_ruta',
                'cantidad_kg',
                'total_km',
            ]
        ],
        'pagination' => [
            'pageSize' => 5, //  reportes por página 
        ],
    ]);

    $this->load($params);

    if (!$this->validate()) {
        return $dataProvider;
    }

    // Filtros exactos
    $query->andFilterWhere([
        'detalle_diario.id_folio' => $this->id_folio,
        'detalle_diario.turno' => $this->turno,
        'detalle_diario.id_tipo_unidad' => $this->id_tipo_unidad,
        'detalle_diario.id_unidad' => $this->id_unidad,
        'detalle_diario.id_ruta' => $this->id_ruta,
        'detalle_diario.id_chofer' => $this->id_chofer,
        'detalle_diario.id_usuario' => $this->id_usuario,
        'detalle_diario.id_despachador' => $this->id_despachador,
        'detalle_diario.cantidad_kg' => $this->cantidad_kg,
    ]);

    $query->andFilterWhere(['like', 'detalle_diario.comentarios', $this->comentarios]);

    // Fechas
    if (!empty($this->fecha_desde)) {
        $query->andFilterWhere(['>=', 'detalle_diario.fecha_orden', $this->fecha_desde]);
    }
    if (!empty($this->fecha_hasta)) {
        $query->andFilterWhere(['<=', 'detalle_diario.fecha_orden', $this->fecha_hasta]);
    }

    // Colonia
    if (!empty($this->nombre_colonia)) {
        $query->andFilterWhere(['like', 'colonia.nombre_colonia', $this->nombre_colonia]);
    }

    // Búsqueda global
    if (!empty($this->globalSearch)) {
        $query->andFilterWhere([
            'or',
            ['like', 'detalle_diario.id_folio', $this->globalSearch],
            ['like', 'num_unidad.numero_unidad', $this->globalSearch],
            ['like', 'ruta.nombre_ruta', $this->globalSearch],
            ['like', 'chofer.nombre_chofer', $this->globalSearch],
            ['like', 'despachador.nombre_despachador', $this->globalSearch],
            ['like', 'detalle_diario.comentarios', $this->globalSearch],
        ]);
    }

    return $dataProvider;
}
}