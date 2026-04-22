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
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'exportar', 'pdf', 'get-unidades', 'get-colonias'],
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
                // --- Generar nuevo folio basado en el máximo id_folio de la tabla folio ---
                $maxFolio = Folio::find()->max('id_folio') ?? 0;
                $nuevoFolio = $maxFolio + 1;

                $folio = new Folio();
                $folio->id_folio = $nuevoFolio;
                if (!$folio->save()) {
                    throw new \Exception('No se pudo guardar el folio: ' . json_encode($folio->getErrors()));
                }
                $model->id_folio = $folio->id_folio;
                // --- Fin generación de folio ---

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
        $transaction = Yii::$app->db->beginTransaction();
        try {
            // Eliminar el folio de la tabla folio
            Folio::deleteAll(['id_folio' => $id_folio]);
            // Eliminar el reporte
            $this->findModel($id_folio)->delete();
            $transaction->commit();
            Yii::$app->session->setFlash('success', 'Reporte y folio eliminados correctamente.');
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'Error al eliminar: ' . $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    /**
     * Exporta los reportes a Excel, respetando los filtros de búsqueda.
     * Utiliza Query directo para evitar problemas con columnas generadas.
     */
    public function actionExportar()
    {
        if (ob_get_level()) ob_end_clean();
        ob_start();

        $params = Yii::$app->request->queryParams;
        $searchModel = new DetalleDiarioSearch();
        $searchModel->load($params);

        $query = (new \yii\db\Query())
            ->from('detalle_diario')
            ->select('*');

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
            $query->innerJoin('reporte_detalles', 'detalle_diario.id_folio = reporte_detalles.id_folio')
                  ->innerJoin('colonia', 'reporte_detalles.id_colonia = colonia.id_colonia')
                  ->andWhere(['like', 'colonia.nombre_colonia', $searchModel->nombre_colonia])
                  ->groupBy('detalle_diario.id_folio');
        }

        $rows = $query->all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Reporte Completo');

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
            $tipo = \app\models\TipoUnidad::findOne($dataRow['id_tipo_unidad']);
            $unidad = \app\models\NumUnidad::findOne($dataRow['id_unidad']);
            $ruta = \app\models\Ruta::findOne($dataRow['id_ruta']);
            $chofer = \app\models\Chofer::findOne($dataRow['id_chofer']);
            $despachador = \app\models\Despachador::findOne($dataRow['id_despachador']);
            $usuario = \app\models\Usuarios::findOne($dataRow['id_usuario']);

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

            $col = 'A';
            foreach ($data as $value) {
                $sheet->setCellValue($col . $row, $value);
                $col++;
            }
            $row++;
        }

        foreach (range('A', $col) as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="reporte_completo_' . date('Ymd_His') . '.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        Yii::$app->end();
    }

    /**
     * Exporta a PDF (con mPDF)
     */
    public function actionPdf($type = 'filtered', $id_folio = null)
    {
        $searchModel = new DetalleDiarioSearch();
        
        if ($type === 'single' && $id_folio !== null) {
            $model = DetalleDiario::findOne($id_folio);
            if (!$model) {
                throw new NotFoundHttpException('El reporte no existe.');
            }
            $reportes = [$this->formatoReporteCompleto($model)];
            $titulo = "Reporte Individual - Folio {$model->id_folio}";
        } elseif ($type === 'all') {
            $query = DetalleDiario::find()
                ->joinWith(['tipoUnidad', 'unidad', 'ruta', 'chofer', 'despachador', 'usuario'])
                ->orderBy(['fecha_orden' => SORT_DESC]);
            $modelos = $query->all();
            $reportes = [];
            foreach ($modelos as $model) {
                $reportes[] = $this->formatoReporteCompleto($model);
            }
            $titulo = "Reporte Completo - Todos los registros";
        } else {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->pagination = false;
            $modelos = $dataProvider->getModels();
            $reportes = [];
            foreach ($modelos as $model) {
                $reportes[] = $this->formatoReporteCompleto($model);
            }
            $titulo = "Reporte Filtrado";
        }

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 20,
            'margin_bottom' => 15,
        ]);

        $html = $this->renderPartial('_pdf', [
            'reportes' => $reportes,
            'filtros' => ($type === 'filtered') ? Yii::$app->request->queryParams : [],
            'fechaGeneracion' => date('d/m/Y H:i:s'),
            'titulo' => $titulo,
        ]);

        $mpdf->WriteHTML($html);
        $mpdf->Output("reporte_camiones_" . date('Ymd_His') . ".pdf", 'D');
        exit;
    }

    /**
     * Formatea un modelo para el PDF
     */
    private function formatoReporteCompleto($model)
    {
        return [
            'id_folio' => $model->id_folio,
            'fecha_orden' => $model->fecha_orden,
            'fecha_captura' => $model->fecha_captura,
            'turno' => $model->turno,
            'tipo_unidad' => $model->tipoUnidad ? $model->tipoUnidad->nombre_tipo : '',
            'numero_unidad' => $model->unidad ? $model->unidad->numero_unidad : '',
            'nombre_ruta' => $model->ruta ? $model->ruta->nombre_ruta : '',
            'nombre_chofer' => $model->chofer ? $model->chofer->nombre_chofer : '',
            'nombre_despachador' => $model->despachador ? $model->despachador->nombre_despachador : '',
            'usuario_nombre' => $model->usuario ? $model->usuario->nombre : 'Sistema',
            'cantidad_kg' => $model->cantidad_kg,
            'porcentaje_efectividad' => $model->porcentaje_efectividad,
            'comentarios' => $model->comentarios,
            'num_puches' => $model->num_puches,
            'km_salir' => $model->km_salir,
            'km_entrar' => $model->km_entrar,
            'total_km' => $model->total_km,
            'diesel_iniciar' => $model->diesel_iniciar,
            'diesel_terminar' => $model->diesel_terminar,
            'diesel_cargado' => $model->diesel_cargado,
            'cant_colonias' => $model->cant_colonias,
            'colonia_1' => $model->colonia_1, 'por_colonia_1' => $model->por_colonia_1,
            'colonia_2' => $model->colonia_2, 'por_colonia_2' => $model->por_colonia_2,
            'colonia_3' => $model->colonia_3, 'por_colonia_3' => $model->por_colonia_3,
            'colonia_4' => $model->colonia_4, 'por_colonia_4' => $model->por_colonia_4,
            'colonia_5' => $model->colonia_5, 'por_colonia_5' => $model->por_colonia_5,
            'colonia_6' => $model->colonia_6, 'por_colonia_6' => $model->por_colonia_6,
            'colonia_7' => $model->colonia_7, 'por_colonia_7' => $model->por_colonia_7,
            'colonia_8' => $model->colonia_8, 'por_colonia_8' => $model->por_colonia_8,
            'colonia_9' => $model->colonia_9, 'por_colonia_9' => $model->por_colonia_9,
            'colonia_10' => $model->colonia_10, 'por_colonia_10' => $model->por_colonia_10,
            'colonia_11' => $model->colonia_11, 'por_colonia_11' => $model->por_colonia_11,
        ];
    }

    protected function findModel($id_folio)
    {
        if (($model = DetalleDiario::findOne(['id_folio' => $id_folio])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}