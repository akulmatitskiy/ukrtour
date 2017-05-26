<?php

namespace backend\controllers;

use Yii;
use backend\models\Hotels;
use backend\models\search\HotelsSearch;
use common\models\Languages;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\filters\AccessRule;
use common\models\GalleryImages;

/**
 * HotelsController implements the CRUD actions for Hotels model.
 */
class HotelsController extends Controller {

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
     * Lists all Hotels models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new HotelsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Hotels model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
                'model' => $this->findModel($id),
        ]);
    }

    /**
     * Updates an existing Hotels model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if($model->load(Yii::$app->request->post())) {
            // Save description
            if(!$model->saveDescr()) {
                throw new BadRequestHttpException('Ошибка сохранения описания отеля');
            }

            // Save images
            if(!empty($model->image)) {
                if(!$model->saveImage($model->image, 1)) {
                    Yii::warning('Ошибка сохранения изображения');
                }
            }
            if(!empty($model->images)) {
                if(!$model->saveImages()) {
                    Yii::warning('Ошибка сохранения галереи');
                }
            }

            // Save hotel
            if(!$model->save()) {
                Yii::warning($model->errors);
                throw new BadRequestHttpException('Ошибка сохранения отеля');
            }
            
            // Save features
            if(!$model->saveFeatures()) {
                throw new BadRequestHttpException('Ошибка сохранения характеристик');
            }
            

            return $this->redirect(['index']);
        } else {
            // Get langs
            $langs = Languages::getLangs();

            // Get hotel description
            $model->hotelDescr();
            
            // Get hotel features
            //$model->hotelFeatures();
            
            // Available features 
            $features = $model->featuresList();
            
            // Images
            $images = GalleryImages::getImages($model->id, GalleryImages::GALLERY_TYPE_HOTEL);

            return $this->render('update', [
                    'model' => $model,
                    'langs' => $langs,
                    'features' => $features,
                    'images' => $images,
            ]);
        }
    }

    /**
     * Deletes an existing Hotels model.
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
     * Finds the Hotels model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Hotels the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = Hotels::find()
            ->where(['{{servio_hotels}}.id' => $id])
            ->one();
        
        if($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
