<?php

namespace app\controllers;

use app\models\RutaColonia;
use app\models\RutaColoniaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RutaColoniaController implements the CRUD actions for RutaColonia model.
 */
class RutaColoniaController extends Controller
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
     * Lists all RutaColonia models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new RutaColoniaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RutaColonia model.
     * @param int $id_ruta_colonia Id Ruta Colonia
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_ruta_colonia)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_ruta_colonia),
        ]);
    }

    /**
     * Creates a new RutaColonia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new RutaColonia();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_ruta_colonia' => $model->id_ruta_colonia]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing RutaColonia model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_ruta_colonia Id Ruta Colonia
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_ruta_colonia)
    {
        $model = $this->findModel($id_ruta_colonia);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_ruta_colonia' => $model->id_ruta_colonia]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing RutaColonia model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_ruta_colonia Id Ruta Colonia
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_ruta_colonia)
    {
        $this->findModel($id_ruta_colonia)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the RutaColonia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_ruta_colonia Id Ruta Colonia
     * @return RutaColonia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_ruta_colonia)
    {
        if (($model = RutaColonia::findOne(['id_ruta_colonia' => $id_ruta_colonia])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
