<?php

namespace backend\controllers;

use Yii;
use backend\models\Banners;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Languages;
use yii\web\BadRequestHttpException;
use yii\filters\AccessControl;
use yii\filters\AccessRule;

/**
 * BannersController implements the CRUD actions for Banners model.
 */
class BannersController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['index',],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Banners models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = Banners::find()->joinWith('descr');

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => ['type', 'status', 'sort_order', 'title'],
            ],
        ]);

        return $this->render('index', [
                'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Banners model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Banners();

        if($model->load(Yii::$app->request->post())) {
            // Save image
            if(!empty($model->image)) {
                if(!$model->saveImage()) {
                    throw new BadRequestHttpException('Ошибка сохранения изображения');
                }
            }

            // Save model
            if(!$model->save()) {
                throw new BadRequestHttpException('Ошибка сохранения баннера');
            }

            // Save description
            if(!$model->saveDescr()) {
                throw new BadRequestHttpException('Ошибка сохранения описания баннера');
            }

            return $this->redirect(['index']);
        } else {
            // Get langs
            $langs = Languages::getLangs();

            return $this->render('create', [
                    'model' => $model,
                    'langs' => $langs,
            ]);
        }
    }

    /**
     * Updates an existing Banners model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if($model->load(Yii::$app->request->post())) {
            // Save image
            if(!empty($model->image)) {
                if(!$model->saveImage()) {
                    throw new BadRequestHttpException('Ошибка сохранения изображения');
                }
            }

            // Save model
            if(!$model->save()) {
                throw new BadRequestHttpException('Ошибка сохранения баннера');
            }

            // Save description
            if(!$model->saveDescr()) {
                throw new BadRequestHttpException('Ошибка сохранения описания баннера');
            }

            return $this->redirect(['index']);
        } else {
            // Get langs
            $langs = Languages::getLangs();

            // Get offer description
            $model->bannerDescr();

            return $this->render('update', [
                    'model' => $model,
                    'langs' => $langs,
            ]);
        }
    }

    /**
     * Deletes an existing Banners model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Banners model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Banners the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if(($model = Banners::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
