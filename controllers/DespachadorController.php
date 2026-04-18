<?php

namespace app\controllers;

use app\models\Despachador;
use app\models\DespachadorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DespachadorController implements the CRUD actions for Despachador model.
 */
class DespachadorController extends Controller
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
     * Lists all Despachador models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new DespachadorSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Despachador model.
     * @param int $id_despachador Id Despachador
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_despachador)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_despachador),
        ]);
    }

    /**
     * Creates a new Despachador model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Despachador();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_despachador' => $model->id_despachador]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Despachador model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_despachador Id Despachador
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_despachador)
    {
        $model = $this->findModel($id_despachador);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_despachador' => $model->id_despachador]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Despachador model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_despachador Id Despachador
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_despachador)
    {
        $this->findModel($id_despachador)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Despachador model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_despachador Id Despachador
     * @return Despachador the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_despachador)
    {
        if (($model = Despachador::findOne(['id_despachador' => $id_despachador])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
