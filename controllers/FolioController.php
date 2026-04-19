<?php

namespace app\controllers;

use app\models\Folio;
use app\models\FolioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Yii;

/**
 * FolioController implements the CRUD actions for Folio model.
 */
class FolioController extends Controller
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
     * Lists all Folio models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new FolioSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Folio model.
     * @param int $id_folio Id Folio
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_folio)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_folio),
        ]);
    }

    /**
     * Creates a new Folio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Folio();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_folio' => $model->id_folio]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Folio model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_folio Id Folio
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_folio)
    {
        $model = $this->findModel($id_folio);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_folio' => $model->id_folio]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Folio model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_folio Id Folio
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_folio)
    {
        $this->findModel($id_folio)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Folio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_folio Id Folio
     * @return Folio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_folio)
    {
        if (($model = Folio::findOne(['id_folio' => $id_folio])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
