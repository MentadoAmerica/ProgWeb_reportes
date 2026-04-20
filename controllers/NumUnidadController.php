<?php

namespace app\controllers;

use app\models\NumUnidad;
use app\models\NumUnidadSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Yii;

/**
 * NumUnidadController implements the CRUD actions for NumUnidad model.
 */
class NumUnidadController extends Controller
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
     * Lists all NumUnidad models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new NumUnidadSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        return $this->safeRender('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single NumUnidad model.
     * @param int $id_unidad Id Unidad
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_unidad)
    {
        return $this->safeRender('view', [
            'model' => $this->findModel($id_unidad),
        ]);
    }

    /**
     * Creates a new NumUnidad model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new NumUnidad();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Unidad creada exitosamente!');
                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->safeRender('create', [
            'model' => $model,
        ]);
    }

    /**
     * Helper to render views from either `num-unidad` or `num_unidad` folder.
     */
    protected function safeRender($view, $params = [])
    {
        $viewPathDash = $this->getViewPath() . DIRECTORY_SEPARATOR . $view . '.php';
        // try default (controller id derived) first
        if (is_file($viewPathDash)) {
            return $this->render($view, $params);
        }
        // fallback to underscore directory
        $altPath = Yii::getAlias('@app') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'num_unidad' . DIRECTORY_SEPARATOR . $view . '.php';
        if (is_file($altPath)) {
            return $this->getView()->renderFile($altPath, $params, $this);
        }
        // default: let framework throw the original exception
        return $this->render($view, $params);
    }

    /**
     * Updates an existing NumUnidad model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_unidad Id Unidad
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_unidad)
    {
        $model = $this->findModel($id_unidad);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Unidad actualizada exitosamente!');
            return $this->redirect(['index']);
        }

        return $this->safeRender('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing NumUnidad model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_unidad Id Unidad
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_unidad)
    {
        $this->findModel($id_unidad)->delete();
        Yii::$app->session->setFlash('success', 'Unidad eliminada exitosamente!');

        return $this->redirect(['index']);
    }

    /**
     * Finds the NumUnidad model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_unidad Id Unidad
     * @return NumUnidad the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_unidad)
    {
        if (($model = NumUnidad::findOne(['id_unidad' => $id_unidad])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
