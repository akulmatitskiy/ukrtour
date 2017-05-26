<?php

namespace backend\controllers;

use Yii;
use backend\models\Features;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use common\models\Languages;
use yii\filters\AccessControl;
use yii\filters\AccessRule;

/**
 * FeaturesController implements the CRUD actions for Features model.
 */
class FeaturesController extends Controller
{
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
     * Lists all Features models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Features::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Features model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Features();

        if ($model->load(Yii::$app->request->post())) {
            // Save Model
            if(!$model->save()) {
                throw new BadRequestHttpException('Ошибка сохранения характеристики');
            }
           
            // Save description
            if(!$model->saveDescr()) {
                throw new BadRequestHttpException('Ошибка сохранения описания характеристики');
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
     * Updates an existing Features model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            // Save Model
            if(!$model->save()) {
                throw new BadRequestHttpException('Ошибка сохранения характеристики');
            }
           
            // Save description
            if(!$model->saveDescr()) {
                throw new BadRequestHttpException('Ошибка сохранения описания характеристики');
            }
            
            return $this->redirect(['index']);
        } else {
            // Get langs
            $langs = Languages::getLangs();
            
            // Get category description
            $model->featuresDescr();
            
            return $this->render('update', [
                'model' => $model,
                'langs' => $langs,
            ]);
        }
    }

    /**
     * Deletes an existing Features model.
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
     * Finds the Features model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Features the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Features::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
