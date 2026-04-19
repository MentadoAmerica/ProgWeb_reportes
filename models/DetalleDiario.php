<?php

namespace app\models;

use Yii;

class DetalleDiario extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'detalle_diario';
    }

    public function rules()
    {
        return [
            [['fecha_orden', 'turno', 'id_tipo_unidad', 'id_unidad', 'id_ruta', 'id_chofer', 'cantidad_kg', 'km_salir', 'km_entrar', 'diesel_iniciar', 'diesel_terminar', 'diesel_cargado', 'id_despachador'], 'required', 'message' => 'Este campo es obligatorio.'],
            [['turno'], 'in', 'range' => [1,2,3,4], 'message' => 'El turno debe ser 1, 2, 3 o 4.'],
            [['km_entrar'], 'compare', 'compareAttribute' => 'km_salir', 'operator' => '>', 'type' => 'number', 'message' => 'Los kilómetros de entrada deben ser mayores a los de salida.'],
            [['id_folio', 'fecha_captura', 'total_km', 'anio', 'mes', 'dia', 'cant_colonias', 'suma_por_atendida', 'por_realizado', 'porcentaje_efectividad', 'id_usuario'], 'safe'],
            [['comentarios', 'colonia_1', 'colonia_2', 'colonia_3', 'colonia_4', 'colonia_5', 'colonia_6', 'colonia_7', 'colonia_8', 'colonia_9', 'colonia_10', 'colonia_11', 'por_colonia_1', 'por_colonia_2', 'por_colonia_3', 'por_colonia_4', 'por_colonia_5', 'por_colonia_6', 'por_colonia_7', 'por_colonia_8', 'por_colonia_9', 'por_colonia_10', 'por_colonia_11', 'habitantes_1', 'habitantes_2', 'habitantes_3', 'habitantes_4', 'habitantes_5', 'habitantes_6', 'habitantes_7', 'habitantes_8', 'habitantes_9', 'habitantes_10', 'habitantes_11'], 'default', 'value' => null],
            [['num_puches'], 'default', 'value' => 0],
            [['id_folio', 'turno', 'id_tipo_unidad', 'id_unidad', 'id_ruta', 'id_chofer', 'num_puches', 'id_despachador', 'colonia_1', 'colonia_2', 'colonia_3', 'colonia_4', 'colonia_5', 'colonia_6', 'colonia_7', 'colonia_8', 'colonia_9', 'colonia_10', 'colonia_11', 'cant_colonias', 'habitantes_1', 'habitantes_2', 'habitantes_3', 'habitantes_4', 'habitantes_5', 'habitantes_6', 'habitantes_7', 'habitantes_8', 'habitantes_9', 'habitantes_10', 'habitantes_11', 'id_usuario'], 'integer'],
            [['fecha_orden', 'fecha_captura'], 'safe'],
            [['cantidad_kg', 'porcentaje_efectividad', 'km_salir', 'km_entrar', 'total_km', 'diesel_iniciar', 'diesel_terminar', 'diesel_cargado', 'por_colonia_1', 'por_colonia_2', 'por_colonia_3', 'por_colonia_4', 'por_colonia_5', 'por_colonia_6', 'por_colonia_7', 'por_colonia_8', 'por_colonia_9', 'por_colonia_10', 'por_colonia_11', 'suma_por_atendida', 'por_realizado'], 'number'],
            [['comentarios'], 'string', 'max' => 500],
            [['id_folio'], 'unique'],
            [['id_tipo_unidad'], 'exist', 'skipOnError' => true, 'targetClass' => TipoUnidad::class, 'targetAttribute' => ['id_tipo_unidad' => 'id_tipo_unidad']],
            [['id_unidad'], 'exist', 'skipOnError' => true, 'targetClass' => NumUnidad::class, 'targetAttribute' => ['id_unidad' => 'id_unidad']],
            [['id_ruta'], 'exist', 'skipOnError' => true, 'targetClass' => Ruta::class, 'targetAttribute' => ['id_ruta' => 'id_ruta']],
            [['id_chofer'], 'exist', 'skipOnError' => true, 'targetClass' => Chofer::class, 'targetAttribute' => ['id_chofer' => 'id_chofer']],
            [['id_despachador'], 'exist', 'skipOnError' => true, 'targetClass' => Despachador::class, 'targetAttribute' => ['id_despachador' => 'id_despachador']],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['id_usuario' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id_folio' => 'Folio',
            'fecha_orden' => 'Fecha de Orden',
            'fecha_captura' => 'Fecha de Captura',
            'turno' => 'Turno (1-4)',
            'id_tipo_unidad' => 'Tipo de Unidad',
            'id_unidad' => 'Número de Unidad',
            'id_ruta' => 'Ruta',
            'id_chofer' => 'Chofer',
            'cantidad_kg' => 'Cantidad (kg)',
            'porcentaje_efectividad' => '% Efectividad',
            'comentarios' => 'Comentarios',
            'num_puches' => 'Número de Puches',
            'km_salir' => 'Kilómetros Salida',
            'km_entrar' => 'Kilómetros Entrada',
            'total_km' => 'Total Kilómetros',
            'diesel_iniciar' => 'Diésel Inicio',
            'diesel_terminar' => 'Diésel Final',
            'diesel_cargado' => 'Diésel Cargado',
            'id_despachador' => 'Despachador',
            'cant_colonias' => 'Cantidad de Colonias',
            'suma_por_atendida' => 'Suma de Porcentajes',
            'por_realizado' => 'Porcentaje Realizado',
            'id_usuario' => 'Usuario',
        ];
    }

    public function attributes()
    {
        $attributes = parent::attributes();
        // Exponer todas las columnas de la tabla, excepto campos calculados de búsqueda
        $exclude = ['anio', 'mes', 'dia'];
        return array_diff($attributes, $exclude);
    }

    public function getChofer()
    {
        return $this->hasOne(Chofer::class, ['id_chofer' => 'id_chofer']);
    }

    public function getDespachador()
    {
        return $this->hasOne(Despachador::class, ['id_despachador' => 'id_despachador']);
    }

    public function getReporteDetalles()
    {
        return $this->hasMany(ReporteDetalles::class, ['id_folio' => 'id_folio']);
    }

    public function getRuta()
    {
        return $this->hasOne(Ruta::class, ['id_ruta' => 'id_ruta']);
    }

    public function getTipoUnidad()
    {
        return $this->hasOne(TipoUnidad::class, ['id_tipo_unidad' => 'id_tipo_unidad']);
    }

    public function getUnidad()
    {
        return $this->hasOne(NumUnidad::class, ['id_unidad' => 'id_unidad']);
    }

    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'id_usuario']);
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        // calcular total_km si están disponibles
        if ($this->hasAttribute('km_salir') && $this->hasAttribute('km_entrar')) {
            $salir = $this->km_salir;
            $entrar = $this->km_entrar;
            if ($salir !== null && $entrar !== null) {
                $this->total_km = $entrar - $salir;
            }
        }
        return true;
    }
}