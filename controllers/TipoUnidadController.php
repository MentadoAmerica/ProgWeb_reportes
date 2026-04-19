<?php

namespace app\controllers;

use app\models\TipoUnidad;
use app\models\TipoUnidadSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Yii;

/**
 * TipoUnidadController implements the CRUD actions for TipoUnidad model.
 */
class TipoUnidadController extends Controller
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
     * Lists all TipoUnidad models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TipoUnidadSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TipoUnidad model.
     * @param int $id_tipo_unidad Id Tipo Unidad
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_tipo_unidad)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_tipo_unidad),
        ]);
    }

    /**
     * Creates a new TipoUnidad model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TipoUnidad();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_tipo_unidad' => $model->id_tipo_unidad]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TipoUnidad model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_tipo_unidad Id Tipo Unidad
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_tipo_unidad)
    {
        $model = $this->findModel($id_tipo_unidad);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_tipo_unidad' => $model->id_tipo_unidad]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TipoUnidad model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_tipo_unidad Id Tipo Unidad
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_tipo_unidad)
    {
        $this->findModel($id_tipo_unidad)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TipoUnidad model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_tipo_unidad Id Tipo Unidad
     * @return TipoUnidad the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_tipo_unidad)
    {
        if (($model = TipoUnidad::findOne(['id_tipo_unidad' => $id_tipo_unidad])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
