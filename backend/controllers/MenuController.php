<?php

namespace backend\controllers;

use Yii;
use backend\models\MenuItems;
use backend\models\search\MenuSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Languages;
use yii\filters\AccessControl;
use yii\filters\AccessRule;

/**
 * MenuController implements the CRUD actions for MenuItems model.
 */
class MenuController extends Controller
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
     * Lists all MenuItems models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new MenuItems model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MenuItems();

        if ($model->load(Yii::$app->request->post())) {
            // Save description
            if(!$model->save()) {
                throw new BadRequestHttpException('Ошибка сохранения акции');
            }
            
            // Save description
            if(!$model->saveDescr()) {
                throw new BadRequestHttpException('Ошибка сохранения описания акции');
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
     * Updates an existing MenuItems model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            // Save description
            if(!$model->save()) {
                throw new BadRequestHttpException('Ошибка сохранения акции');
            }
            
            // Save description
            if(!$model->saveDescr()) {
                throw new BadRequestHttpException('Ошибка сохранения описания акции');
            }
            
            return $this->redirect(['index']);
        } else {
             // Get langs
            $langs = Languages::getLangs();
            
            // Get offer description
            $model->menuItemDescr();
            
            return $this->render('update', [
                'model' => $model,
                'langs' => $langs,
            ]);
        }
    }

    /**
     * Deletes an existing MenuItems model.
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
     * Finds the MenuItems model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MenuItems the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MenuItems::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
