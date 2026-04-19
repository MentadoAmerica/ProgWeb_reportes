<?php

namespace app\controllers;

use app\models\Chofer;
use app\models\ChoferSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Yii;

/**
 * ChoferController implements the CRUD actions for Chofer model.
 */
class ChoferController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function () {
                            $user = Yii::$app->user->identity;
                            return $user instanceof \app\models\Usuarios && $user->isAdmin();
                        }
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'actions' => ['index', 'view'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => ['delete' => ['POST']],
            ],
        ]);
    }

    /**
     * Lists all Chofer models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ChoferSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Chofer model.
     * @param int $id_chofer Id Chofer
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_chofer)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_chofer),
        ]);
    }

    /**
     * Creates a new Chofer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Chofer();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_chofer' => $model->id_chofer]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Chofer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_chofer Id Chofer
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_chofer)
    {
        $model = $this->findModel($id_chofer);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_chofer' => $model->id_chofer]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Chofer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_chofer Id Chofer
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_chofer)
    {
        $this->findModel($id_chofer)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Chofer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_chofer Id Chofer
     * @return Chofer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_chofer)
    {
        if (($model = Chofer::findOne(['id_chofer' => $id_chofer])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
