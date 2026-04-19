<?php

namespace app\controllers;

use Yii;
use app\models\DetalleDiario;
use app\models\DetalleDiarioSearch;
use app\models\Folio;
use app\models\ReporteDetalles;
use app\models\RutaColonia;
use app\models\Colonia;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DetalleDiarioController extends Controller
{
    public function behaviors()
    {
        return [
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
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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

            // Populate model hidden fields from posted detalle_colonias so validation preserves data
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
            $model->por_realizado = ($model->cant_colonias > 0) ? ($sumaPorcentajesPreview / ($model->cant_colonias * 100)) * 100 : 0;
            $model->porcentaje_efectividad = $model->por_realizado;
            $transaction = Yii::$app->db->beginTransaction();
            try {
                // 1. Generar nuevo folio desde tabla FOLIO
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

                // 2. Asignar valores automáticos
                $model->fecha_captura = date('Y-m-d H:i:s');
                // asignar el usuario actual si está autenticado, si no, usar 1 como fallback
                $model->id_usuario = Yii::$app->user && !Yii::$app->user->isGuest ? (int)Yii::$app->user->id : 1;

                // 3. Guardar el modelo principal (validando campos)
                if (!$model->save()) {
                    $errors = $model->getErrors();
                    Yii::error('Error guardando DetalleDiario: ' . json_encode($errors));
                    throw new \Exception('Validación fallida al guardar el reporte: ' . json_encode($errors));
                }

                // 4. Procesar colonias y porcentajes
                $sumaPorcentajes = 0;
                $indice = 1;
                foreach ($detalleColonias as $det) {
                    // Guardar en REPORTE_DETALLES
                    $reporte = new ReporteDetalles();
                    $reporte->id_folio = $model->id_folio;
                    $reporte->id_colonia = $det['id_colonia'];
                    $reporte->porcentaje_colonia = $det['porcentaje'];
                    if (!$reporte->save()) {
                        Yii::error('Error guardando ReporteDetalles: ' . json_encode($reporte->getErrors()));
                        throw new \Exception('No se pudo guardar detalle de colonia: ' . json_encode($reporte->getErrors()));
                    }

                    // Llenar columnas desnormalizadas (hasta 11)
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

                // Guardar nuevamente con las columnas de colonias actualizadas
                if (!$model->save()) {
                    $errors = $model->getErrors();
                    Yii::error('Error guardando DetalleDiario (segundo guardado): ' . json_encode($errors));
                    throw new \Exception('Error al actualizar reporte con colonias: ' . json_encode($errors));
                }

                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Reporte guardado con folio ' . $model->id_folio);
                return $this->redirect(['view', 'id_folio' => $model->id_folio]);

            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'Error al guardar: ' . $e->getMessage());
                // fallthrough: render form below with $detalleColonias preserved
            }
        }

        // Cargar listas para dropdowns
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

    // Acciones AJAX (getUnidades, getColonias, etc.) igual que antes...
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

    public function actionExportar()
    {
        $searchModel = new DetalleDiarioSearch();
        $searchModel->load(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Encabezados
        $headers = ['Folio','Fecha Orden','Fecha Captura','Turno','Tipo','Unidad','Ruta','Chofer','Cantidad (kg)','Total KM'];
        $col = 'A';
        foreach ($headers as $h) {
            $sheet->setCellValue($col . '1', $h);
            $col++;
        }

        $row = 2;
        foreach ($dataProvider->query->all() as $model) {
            $sheet->setCellValue('A' . $row, $model->id_folio);
            $sheet->setCellValue('B' . $row, $model->fecha_orden);
            $sheet->setCellValue('C' . $row, $model->fecha_captura);
            $sheet->setCellValue('D' . $row, $model->turno);
            $sheet->setCellValue('E' . $row, $model->tipoUnidad ? $model->tipoUnidad->nombre_tipo : '');
            $sheet->setCellValue('F' . $row, $model->unidad ? $model->unidad->numero_unidad : '');
            $sheet->setCellValue('G' . $row, $model->ruta ? $model->ruta->nombre_ruta : '');
            $sheet->setCellValue('H' . $row, $model->chofer ? $model->chofer->nombre_chofer : '');
            $sheet->setCellValue('I' . $row, $model->cantidad_kg);
            $sheet->setCellValue('J' . $row, $model->total_km);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'detalle_diario_export_' . date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
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