<?php

namespace backend\controllers;

use Yii;
use backend\models\ConfRooms;
use common\models\Languages;
use backend\models\search\ConfRoomsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\filters\AccessRule;
use yii\web\Response;

/**
 * ConfRoomsController implements the CRUD actions for ConfRooms model.
 */
class ConfRoomsController extends Controller {

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
                        'actions' => ['create', 'update', 'delete', 'parents'],
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
     * Lists all ConfRooms models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new ConfRoomsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new ConfRooms model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ConfRooms();

        if($model->load(Yii::$app->request->post())) {
            // Save Model
            if(!$model->save()) {
                throw new BadRequestHttpException('Ошибка сохранения конференц зала');
            }

            // Save image
            if(!empty($model->image)) {
                if(!$model->saveImage()) {
                    throw new BadRequestHttpException('Ошибка сохранения изображения');
                }
            }

            // Save description
            if(!$model->saveDescr()) {
                throw new BadRequestHttpException('Ошибка сохранения описания конференц зала');
            }

            // Save features
            if(!$model->saveFeatures()) {
                throw new BadRequestHttpException('Ошибка сохранения характеристик');
            }

            return $this->redirect(['index']);
        } else {
            // Get langs
            $langs = Languages::getLangs();

            // Available features 
            $features = $model->featuresList();

            return $this->render('create', [
                    'model' => $model,
                    'langs' => $langs,
                    'features' => $features,
            ]);
        }
    }

    /**
     * Updates an existing ConfRooms model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if($model->load(Yii::$app->request->post())) {
            // Save Model
            if(!$model->save()) {
                throw new BadRequestHttpException('Ошибка сохранения категории');
            }

            // Save image
            if(!empty($model->image)) {
                if(!$model->saveImage()) {
                    throw new BadRequestHttpException('Ошибка сохранения изображения');
                }
            } else {
                // Save to db current image
                $model->image = $model->oldImage;
                $model->save();
            }

            // Save description
            if(!$model->saveDescr()) {
                throw new BadRequestHttpException('Ошибка сохранения описания категории');
            }

            // Save features
            if(!$model->saveFeatures()) {
                throw new BadRequestHttpException('Ошибка сохранения характеристик');
            }

            return $this->redirect(['index']);
        } else {
            // Get langs
            $langs = Languages::getLangs();

            // Get category description
            $model->confRoomDescr();

            // Available features 
            $features = $model->featuresList();

            return $this->render('update', [
                    'model' => $model,
                    'langs' => $langs,
                    'features' => $features,
            ]);
        }
    }

    /**
     * Deletes an existing ConfRooms model.
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
     * Finds the ConfRooms model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ConfRooms the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if(($model = ConfRooms::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Comf room parents
     * @return array $parents
     */
    public function actionParents()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $params = Yii::$app->request->post('depdrop_all_params');
        $parents = [];

        // Get parents by type
        if(!empty($params['type'])) {
            $parents = ConfRooms::getParents($params['type']);
            $active = ConfRooms::getActiveParent($params['type'], $params['roomId']);
        }

        return ["output" => $parents, "selected" => (string)$active];
    }

}
