<?php

namespace app\controllers;

use app\models\ReporteDetalles;
use app\models\ReporteDetallesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReporteDetallesController implements the CRUD actions for ReporteDetalles model.
 */
class ReporteDetallesController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all ReporteDetalles models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ReporteDetallesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ReporteDetalles model.
     * @param int $id_reporte Id Reporte
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_reporte)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_reporte),
        ]);
    }

    /**
     * Creates a new ReporteDetalles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ReporteDetalles();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_reporte' => $model->id_reporte]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ReporteDetalles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_reporte Id Reporte
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_reporte)
    {
        $model = $this->findModel($id_reporte);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_reporte' => $model->id_reporte]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ReporteDetalles model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_reporte Id Reporte
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_reporte)
    {
        $this->findModel($id_reporte)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ReporteDetalles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_reporte Id Reporte
     * @return ReporteDetalles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_reporte)
    {
        if (($model = ReporteDetalles::findOne(['id_reporte' => $id_reporte])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
