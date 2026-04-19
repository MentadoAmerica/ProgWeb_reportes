<?php

namespace app\controllers;

use Yii;
use app\models\DetalleDiario;
use app\models\DetalleDiarioSearch;
use app\models\Folio;
use app\models\ReporteDetalles;
use app\models\RutaColonia;
use app\models\Colonia;
use app\models\Usuarios;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DetalleDiarioController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'exportar', 'get-unidades', 'get-colonias'],
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    Yii::$app->session->setFlash('error', 'Debes iniciar sesión para acceder a esta sección.');
                    return $this->redirect(['site/login']);
                },
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new DetalleDiarioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;

        $usuarios = Usuarios::find()->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'usuarios' => $usuarios,
        ]);
    }

    public function actionView($id_folio)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_folio),
        ]);
    }

    public function actionCreate()
    {
        $model = new DetalleDiario();
        $detalleColonias = [];

        if ($model->load(Yii::$app->request->post())) {
            $detalleColonias = Yii::$app->request->post('detalle_colonias', []);

            $sumaPorcentajesPreview = 0;
            $indicePreview = 1;
            foreach ($detalleColonias as $det) {
                if ($indicePreview <= 11) {
                    $model->{"colonia_$indicePreview"} = $det['id_colonia'] ?? null;
                    $model->{"por_colonia_$indicePreview"} = $det['porcentaje'] ?? 0;
                    $model->{"habitantes_$indicePreview"} = $det['habitantes'] ?? 0;
                }
                $sumaPorcentajesPreview += floatval($det['porcentaje'] ?? 0);
                $indicePreview++;
            }
            $model->cant_colonias = count($detalleColonias);
            $model->suma_por_atendida = $sumaPorcentajesPreview;
            $model->por_realizado = ($model->cant_colonias > 0)
                ? ($sumaPorcentajesPreview / ($model->cant_colonias * 100)) * 100
                : 0;
            $model->porcentaje_efectividad = $model->por_realizado;

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $folio = Folio::find()->one();
                if (!$folio) {
                    $folio = new Folio();
                    $folio->id_folio = 1;
                } else {
                    $folio->id_folio += 1;
                }
                if (!$folio->save()) {
                    throw new \Exception('No se pudo actualizar folio: ' . json_encode($folio->getErrors()));
                }
                $model->id_folio = $folio->id_folio;

                $model->fecha_captura = date('Y-m-d H:i:s');
                $model->id_usuario = Yii::$app->user->id ?? 1;

                if (!$model->save()) {
                    throw new \Exception('Validación fallida: ' . json_encode($model->getErrors()));
                }

                $sumaPorcentajes = 0;
                $indice = 1;
                foreach ($detalleColonias as $det) {
                    $reporte = new ReporteDetalles();
                    $reporte->id_folio = $model->id_folio;
                    $reporte->id_colonia = $det['id_colonia'];
                    $reporte->porcentaje_colonia = $det['porcentaje'];
                    if (!$reporte->save()) {
                        throw new \Exception('Error guardando detalle de colonia: ' . json_encode($reporte->getErrors()));
                    }

                    if ($indice <= 11) {
                        $model->{"colonia_$indice"} = $det['id_colonia'];
                        $model->{"por_colonia_$indice"} = $det['porcentaje'];
                        $model->{"habitantes_$indice"} = $det['habitantes'];
                    }
                    $sumaPorcentajes += $det['porcentaje'];
                    $indice++;
                }

                $model->cant_colonias = count($detalleColonias);
                $model->suma_por_atendida = $sumaPorcentajes;
                $model->por_realizado = ($model->cant_colonias > 0)
                    ? ($sumaPorcentajes / ($model->cant_colonias * 100)) * 100
                    : 0;
                $model->porcentaje_efectividad = $model->por_realizado;

                if (!$model->save()) {
                    throw new \Exception('Error actualizando columnas de colonias: ' . json_encode($model->getErrors()));
                }

                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Reporte guardado con folio ' . $model->id_folio);
                return $this->redirect(['view', 'id_folio' => $model->id_folio]);

            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'Error al guardar: ' . $e->getMessage());
            }
        }

        $tiposUnidad = \app\models\TipoUnidad::find()->all();
        $rutas = \app\models\Ruta::find()->all();
        $choferes = \app\models\Chofer::find()->all();
        $despachadores = \app\models\Despachador::find()->all();

        return $this->render('create', [
            'model' => $model,
            'tiposUnidad' => $tiposUnidad,
            'rutas' => $rutas,
            'choferes' => $choferes,
            'despachadores' => $despachadores,
            'detalleColonias' => $detalleColonias,
        ]);
    }

    public function actionGetUnidades($id_tipo)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $unidades = \app\models\NumUnidad::find()
            ->where(['id_tipo_unidad' => $id_tipo])
            ->all();
        return $this->renderAjax('_unidades', ['unidades' => $unidades]);
    }

    public function actionGetColonias($id_ruta)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $colonias = RutaColonia::find()
            ->where(['id_ruta' => $id_ruta])
            ->orderBy(['orden_numeracion' => SORT_ASC])
            ->with('colonia')
            ->all();

        $resultado = [];
        foreach ($colonias as $rc) {
            $resultado[] = [
                'id_colonia' => $rc->colonia->id_colonia,
                'nombre' => $rc->colonia->nombre_colonia,
                'habitantes' => $rc->colonia->num_habitantes,
                'orden' => $rc->orden_numeracion,
            ];
        }
        return $resultado;
    }

    public function actionUpdate($id_folio)
    {
        return $this->redirect(['create']);
    }

    public function actionDelete($id_folio)
    {
        $this->findModel($id_folio)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Exporta los reportes a Excel, respetando los filtros de búsqueda.
     * Utiliza Query directo para evitar problemas con columnas generadas (anio, mes, dia, total_km).
     */
    public function actionExportar()
    {
        // Limpiar búfer de salida
        if (ob_get_level()) ob_end_clean();
        ob_start();

        // Obtener parámetros de búsqueda
        $params = Yii::$app->request->queryParams;
        $searchModel = new DetalleDiarioSearch();
        $searchModel->load($params);

        // Construir consulta base
        $query = (new \yii\db\Query())
            ->from('detalle_diario')
            ->select('*');

        // Aplicar filtros manualmente (para respetar la búsqueda)
        if (!empty($searchModel->id_folio)) {
            $query->andWhere(['id_folio' => $searchModel->id_folio]);
        }
        if (!empty($searchModel->fecha_desde)) {
            $query->andWhere(['>=', 'fecha_orden', $searchModel->fecha_desde]);
        }
        if (!empty($searchModel->fecha_hasta)) {
            $query->andWhere(['<=', 'fecha_orden', $searchModel->fecha_hasta]);
        }
        if (!empty($searchModel->id_ruta)) {
            $query->andWhere(['id_ruta' => $searchModel->id_ruta]);
        }
        if (!empty($searchModel->id_chofer)) {
            $query->andWhere(['id_chofer' => $searchModel->id_chofer]);
        }
        if (!empty($searchModel->id_tipo_unidad)) {
            $query->andWhere(['id_tipo_unidad' => $searchModel->id_tipo_unidad]);
        }
        if (!empty($searchModel->id_usuario)) {
            $query->andWhere(['id_usuario' => $searchModel->id_usuario]);
        }
        if (!empty($searchModel->nombre_colonia)) {
            // Búsqueda por colonia: requiere JOIN con reporte_detalles y colonia
            $query->innerJoin('reporte_detalles', 'detalle_diario.id_folio = reporte_detalles.id_folio')
                  ->innerJoin('colonia', 'reporte_detalles.id_colonia = colonia.id_colonia')
                  ->andWhere(['like', 'colonia.nombre_colonia', $searchModel->nombre_colonia])
                  ->groupBy('detalle_diario.id_folio'); // evita duplicados
        }

        // Ejecutar consulta
        $rows = $query->all();

        // Crear Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Reporte Completo');

        // Encabezados
        $headers = [
            'Folio', 'Fecha de Orden', 'Fecha de Captura', 'Turno',
            'Tipo de Unidad', 'Número de Unidad', 'Ruta', 'Chofer', 'Despachador',
            'Cantidad (kg)', '% Efectividad', 'Comentarios', 'Número de Puches',
            'Km Salida', 'Km Entrada', 'Total Km', 'Diésel Inicio', 'Diésel Final',
            'Diésel Cargado', 'Año', 'Mes', 'Día', 'Cant. Colonias', 'Suma %',
            '% Realizado', 'Usuario Captura'
        ];

        for ($i = 1; $i <= 11; $i++) {
            $headers[] = "Colonia $i";
            $headers[] = "% Colonia $i";
            $headers[] = "Habitantes $i";
        }

        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '1', $header);
            $col++;
        }

        $row = 2;
        foreach ($rows as $dataRow) {
            // Obtener datos relacionados
            $tipo = \app\models\TipoUnidad::findOne($dataRow['id_tipo_unidad']);
            $unidad = \app\models\NumUnidad::findOne($dataRow['id_unidad']);
            $ruta = \app\models\Ruta::findOne($dataRow['id_ruta']);
            $chofer = \app\models\Chofer::findOne($dataRow['id_chofer']);
            $despachador = \app\models\Despachador::findOne($dataRow['id_despachador']);
            $usuario = \app\models\Usuarios::findOne($dataRow['id_usuario']);

            // Datos fijos
            $data = [
                $dataRow['id_folio'],
                $dataRow['fecha_orden'],
                $dataRow['fecha_captura'],
                $dataRow['turno'],
                $tipo ? $tipo->nombre_tipo : '',
                $unidad ? $unidad->numero_unidad : '',
                $ruta ? $ruta->nombre_ruta : '',
                $chofer ? $chofer->nombre_chofer : '',
                $despachador ? $despachador->nombre_despachador : '',
                $dataRow['cantidad_kg'],
                $dataRow['porcentaje_efectividad'],
                $dataRow['comentarios'],
                $dataRow['num_puches'],
                $dataRow['km_salir'],
                $dataRow['km_entrar'],
                $dataRow['total_km'],
                $dataRow['diesel_iniciar'],
                $dataRow['diesel_terminar'],
                $dataRow['diesel_cargado'],
                $dataRow['anio'],
                $dataRow['mes'],
                $dataRow['dia'],
                $dataRow['cant_colonias'],
                $dataRow['suma_por_atendida'],
                $dataRow['por_realizado'],
                $usuario ? $usuario->nombre : 'Sistema',
            ];

            // Datos de colonias (hasta 11)
            for ($i = 1; $i <= 11; $i++) {
                $coloniaId = $dataRow["colonia_$i"] ?? null;
                $nombreColonia = '';
                $habitantes = '';
                if ($coloniaId) {
                    $colonia = Colonia::findOne($coloniaId);
                    if ($colonia) {
                        $nombreColonia = $colonia->nombre_colonia;
                        $habitantes = $colonia->num_habitantes;
                    }
                }
                $data[] = $nombreColonia;
                $data[] = $dataRow["por_colonia_$i"] ?? '';
                $data[] = $habitantes;
            }

            // Escribir fila
            $col = 'A';
            foreach ($data as $value) {
                $sheet->setCellValue($col . $row, $value);
                $col++;
            }
            $row++;
        }

        // Ajustar ancho de columnas
        foreach (range('A', $col) as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Cabeceras de descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="reporte_completo_' . date('Ymd_His') . '.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        Yii::$app->end();
    }

    protected function findModel($id_folio)
    {
        if (($model = DetalleDiario::findOne(['id_folio' => $id_folio])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}