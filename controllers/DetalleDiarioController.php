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
                $folio->save();
                $model->id_folio = $folio->id_folio;

                // 2. Asignar valores automáticos
                $model->fecha_captura = date('Y-m-d H:i:s');
                $model->id_usuario = 1; // Cambiar después por Yii::$app->user->id

                // 3. Guardar el modelo principal (sin colonias aún) - usamos save(false) para omitir validaciones
                if (!$model->save(false)) {
                    throw new \Exception('No se pudo guardar el registro principal');
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
                    $reporte->save();

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
                $model->save(false);

                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Reporte guardado con folio ' . $model->id_folio);
                return $this->redirect(['view', 'id_folio' => $model->id_folio]);

            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'Error al guardar: ' . $e->getMessage());
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

    protected function findModel($id_folio)
    {
        if (($model = DetalleDiario::findOne(['id_folio' => $id_folio])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}