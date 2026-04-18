<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "detalle_diario".
 *
 * @property int $id_folio
 * @property string $fecha_orden
 * @property string $fecha_captura
 * @property int $turno
 * @property int $id_tipo_unidad
 * @property int $id_unidad
 * @property int $id_ruta
 * @property int $id_chofer
 * @property float $cantidad_kg
 * @property float $porcentaje_efectividad
 * @property string|null $comentarios
 * @property int $num_puches
 * @property float $km_salir
 * @property float $km_entrar
 * @property float $total_km
 * @property float $diesel_iniciar
 * @property float $diesel_terminar
 * @property float $diesel_cargado
 * @property int $id_despachador
 * @property int|null $colonia_1
 * @property int|null $colonia_2
 * @property int|null $colonia_3
 * @property int|null $colonia_4
 * @property int|null $colonia_5
 * @property int|null $colonia_6
 * @property int|null $colonia_7
 * @property int|null $colonia_8
 * @property int|null $colonia_9
 * @property int|null $colonia_10
 * @property int|null $colonia_11
 * @property float|null $por_colonia_1
 * @property float|null $por_colonia_2
 * @property float|null $por_colonia_3
 * @property float|null $por_colonia_4
 * @property float|null $por_colonia_5
 * @property float|null $por_colonia_6
 * @property float|null $por_colonia_7
 * @property float|null $por_colonia_8
 * @property float|null $por_colonia_9
 * @property float|null $por_colonia_10
 * @property float|null $por_colonia_11
 * @property int $anio
 * @property int $mes
 * @property int $dia
 * @property int $cant_colonias
 * @property float $suma_por_atendida
 * @property float $por_realizado
 * @property int|null $habitantes_1
 * @property int|null $habitantes_2
 * @property int|null $habitantes_3
 * @property int|null $habitantes_4
 * @property int|null $habitantes_5
 * @property int|null $habitantes_6
 * @property int|null $habitantes_7
 * @property int|null $habitantes_8
 * @property int|null $habitantes_9
 * @property int|null $habitantes_10
 * @property int|null $habitantes_11
 * @property int|null $id_usuario
 *
 * @property Chofer $chofer
 * @property Despachador $despachador
 * @property ReporteDetalles[] $reporteDetalles
 * @property Ruta $ruta
 * @property TipoUnidad $tipoUnidad
 * @property NumUnidad $unidad
 * @property Usuarios $usuario
 */
class DetalleDiario extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'detalle_diario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
       return [
        // Campos requeridos con mensajes personalizados
        [['fecha_orden'], 'required', 'message' => 'La fecha de orden es obligatoria.'],
        [['turno'], 'required', 'message' => 'El turno es obligatorio (1-4).'],
        [['id_tipo_unidad'], 'required', 'message' => 'Debe seleccionar un tipo de unidad.'],
        [['id_unidad'], 'required', 'message' => 'Debe seleccionar un número de unidad.'],
        [['id_ruta'], 'required', 'message' => 'Debe seleccionar una ruta.'],
        [['id_chofer'], 'required', 'message' => 'Debe seleccionar un chofer.'],
        [['id_despachador'], 'required', 'message' => 'Debe seleccionar un despachador.'],
        [['cantidad_kg'], 'required', 'message' => 'La cantidad en kg es obligatoria.'],
        [['km_salir'], 'required', 'message' => 'Los kilómetros de salida son obligatorios.'],
        [['km_entrar'], 'required', 'message' => 'Los kilómetros de entrada son obligatorios.'],
        [['diesel_iniciar'], 'required', 'message' => 'El diésel al iniciar es obligatorio.'],
        [['diesel_terminar'], 'required', 'message' => 'El diésel al terminar es obligatorio.'],
        [['diesel_cargado'], 'required', 'message' => 'El diésel cargado es obligatorio.'],

        // Validación de turno (rango)
        [['turno'], 'in', 'range' => [1,2,3,4], 'message' => 'El turno debe ser 1, 2, 3 o 4.'],

        // Comparación de km
        [['km_entrar'], 'compare', 'compareAttribute' => 'km_salir', 'operator' => '>', 'type' => 'number', 'message' => 'Los kilómetros de entrada deben ser mayores a los de salida.'],
           [['comentarios', 'colonia_1', 'colonia_2', 'colonia_3', 'colonia_4', 'colonia_5', 'colonia_6', 'colonia_7', 'colonia_8', 'colonia_9', 'colonia_10', 'colonia_11', 'por_colonia_1', 'por_colonia_2', 'por_colonia_3', 'por_colonia_4', 'por_colonia_5', 'por_colonia_6', 'por_colonia_7', 'por_colonia_8', 'por_colonia_9', 'por_colonia_10', 'por_colonia_11', 'habitantes_1', 'habitantes_2', 'habitantes_3', 'habitantes_4', 'habitantes_5', 'habitantes_6', 'habitantes_7', 'habitantes_8', 'habitantes_9', 'habitantes_10', 'habitantes_11', 'id_usuario'], 'default', 'value' => null],
        [['num_puches'], 'default', 'value' => 0],
        // total_km, anio, mes, dia NO deben ser required
        [['id_folio', 'fecha_orden', 'fecha_captura', 'turno', 'id_tipo_unidad', 'id_unidad', 'id_ruta', 'id_chofer', 'cantidad_kg', 'porcentaje_efectividad', 'km_salir', 'km_entrar', 'diesel_iniciar', 'diesel_terminar', 'diesel_cargado', 'id_despachador', 'cant_colonias', 'suma_por_atendida', 'por_realizado'], 'required'],
        [['id_folio', 'turno', 'id_tipo_unidad', 'id_unidad', 'id_ruta', 'id_chofer', 'num_puches', 'id_despachador', 'colonia_1', 'colonia_2', 'colonia_3', 'colonia_4', 'colonia_5', 'colonia_6', 'colonia_7', 'colonia_8', 'colonia_9', 'colonia_10', 'colonia_11', 'cant_colonias', 'habitantes_1', 'habitantes_2', 'habitantes_3', 'habitantes_4', 'habitantes_5', 'habitantes_6', 'habitantes_7', 'habitantes_8', 'habitantes_9', 'habitantes_10', 'habitantes_11', 'id_usuario'], 'integer'],
        [['fecha_orden', 'fecha_captura'], 'safe'],
        [['cantidad_kg', 'porcentaje_efectividad', 'km_salir', 'km_entrar', 'diesel_iniciar', 'diesel_terminar', 'diesel_cargado', 'por_colonia_1', 'por_colonia_2', 'por_colonia_3', 'por_colonia_4', 'por_colonia_5', 'por_colonia_6', 'por_colonia_7', 'por_colonia_8', 'por_colonia_9', 'por_colonia_10', 'por_colonia_11', 'suma_por_atendida', 'por_realizado'], 'number'],
        [['comentarios'], 'string', 'max' => 500],
        [['turno'], 'in', 'range' => [1,2,3,4]],  // Validación de turno
        [['id_folio'], 'unique'],
            [['id_tipo_unidad'], 'exist', 'skipOnError' => true, 'targetClass' => TipoUnidad::class, 'targetAttribute' => ['id_tipo_unidad' => 'id_tipo_unidad']],
            [['id_unidad'], 'exist', 'skipOnError' => true, 'targetClass' => NumUnidad::class, 'targetAttribute' => ['id_unidad' => 'id_unidad']],
            [['id_ruta'], 'exist', 'skipOnError' => true, 'targetClass' => Ruta::class, 'targetAttribute' => ['id_ruta' => 'id_ruta']],
            [['id_chofer'], 'exist', 'skipOnError' => true, 'targetClass' => Chofer::class, 'targetAttribute' => ['id_chofer' => 'id_chofer']],
            [['id_despachador'], 'exist', 'skipOnError' => true, 'targetClass' => Despachador::class, 'targetAttribute' => ['id_despachador' => 'id_despachador']],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['id_usuario' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
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
        'colonia_1' => 'Colonia 1',
        // ... puedes poner etiquetas para las demás, pero no se mostrarán en el formulario
        'cant_colonias' => 'Cantidad de Colonias',
        'suma_por_atendida' => 'Suma de Porcentajes',
        'por_realizado' => 'Porcentaje Realizado',
        'id_usuario' => 'Usuario',
    ];
}

    /**
     * Gets query for [[Chofer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChofer()
    {
        return $this->hasOne(Chofer::class, ['id_chofer' => 'id_chofer']);
    }

    /**
     * Gets query for [[Despachador]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDespachador()
    {
        return $this->hasOne(Despachador::class, ['id_despachador' => 'id_despachador']);
    }

    /**
     * Gets query for [[ReporteDetalles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReporteDetalles()
    {
        return $this->hasMany(ReporteDetalles::class, ['id_folio' => 'id_folio']);
    }

    /**
     * Gets query for [[Ruta]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRuta()
    {
        return $this->hasOne(Ruta::class, ['id_ruta' => 'id_ruta']);
    }

    /**
     * Gets query for [[TipoUnidad]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTipoUnidad()
    {
        return $this->hasOne(TipoUnidad::class, ['id_tipo_unidad' => 'id_tipo_unidad']);
    }

    /**
     * Gets query for [[Unidad]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUnidad()
    {
        return $this->hasOne(NumUnidad::class, ['id_unidad' => 'id_unidad']);
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'id_usuario']);
    }

}
