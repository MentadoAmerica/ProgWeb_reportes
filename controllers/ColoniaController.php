<?php

namespace app\controllers;

use app\models\Colonia;
use app\models\ColoniaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ColoniaController implements the CRUD actions for Colonia model.
 */
class ColoniaController extends Controller
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
     * Lists all Colonia models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ColoniaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Colonia model.
     * @param int $id_colonia Id Colonia
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_colonia)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_colonia),
        ]);
    }

    /**
     * Creates a new Colonia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Colonia();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_colonia' => $model->id_colonia]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Colonia model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_colonia Id Colonia
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_colonia)
    {
        $model = $this->findModel($id_colonia);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_colonia' => $model->id_colonia]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Colonia model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_colonia Id Colonia
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_colonia)
    {
        $this->findModel($id_colonia)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Colonia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_colonia Id Colonia
     * @return Colonia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_colonia)
    {
        if (($model = Colonia::findOne(['id_colonia' => $id_colonia])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
