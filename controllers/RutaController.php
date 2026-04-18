<?php

namespace app\controllers;

use app\models\Ruta;
use app\models\RutaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RutaController implements the CRUD actions for Ruta model.
 */
class RutaController extends Controller
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
     * Lists all Ruta models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new RutaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Ruta model.
     * @param int $id_ruta Id Ruta
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_ruta)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_ruta),
        ]);
    }

    /**
     * Creates a new Ruta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Ruta();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_ruta' => $model->id_ruta]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Ruta model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_ruta Id Ruta
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_ruta)
    {
        $model = $this->findModel($id_ruta);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_ruta' => $model->id_ruta]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Ruta model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_ruta Id Ruta
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_ruta)
    {
        $this->findModel($id_ruta)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Ruta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_ruta Id Ruta
     * @return Ruta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_ruta)
    {
        if (($model = Ruta::findOne(['id_ruta' => $id_ruta])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
