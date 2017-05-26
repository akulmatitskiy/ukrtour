<?php

namespace backend\controllers;

use Yii;
use backend\models\Tours;
use backend\models\search\ToursSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use common\models\Languages;
use common\models\GalleryImages;
use common\models\Images;

/**
 * ToursController implements the CRUD actions for Tours model.
 */
class ToursController extends Controller
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
        ];
    }

    /**
     * Lists all Tours models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ToursSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Tours model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tours();

        if ($model->load(Yii::$app->request->post())) {
            // Save image
            if(!empty($model->image)) {
                $image = Images::saveImage($model->image, 'tour');
                if($image != false) {
                    $model->image = $image;
                } else {
                    Yii::warning('Ошибка сохранения изображения');
                }
            }
            
            // Save description
            if(!$model->save()) {
                Yii::warning($model->errors);
                throw new BadRequestHttpException('Ошибка сохранения тура');
            }
            
            // Save image
            if(!empty($model->images)) {
                if(!GalleryImages::saveImages($model->images, $model->id, GalleryImages::GALLERY_TYPE_TOUR, 'tour')) {
                    Yii::warning('Ошибка сохранения галереи');
                }
            }

            // Save description
            if(!$model->saveDescr()) {
                throw new BadRequestHttpException('Ошибка сохранения описания тура');
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
     * Updates an existing Tours model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            
            // Save image
            if(!empty($model->image)) {
                $image = Images::saveImage($model->image, 'tour');
                if($image != false) {
                    $model->image = $image;
                } else {
                    Yii::warning('Ошибка сохранения изображения');
                }
            }
            
            // Save description
            if(!$model->save()) {
                throw new BadRequestHttpException('Ошибка сохранения тура');
            }
            
            // Save image
            if(!empty($model->images)) {
                if(!GalleryImages::saveImages($model->images, $model->id, GalleryImages::GALLERY_TYPE_TOUR, 'tour')) {
                    Yii::warning('Ошибка сохранения галереи');
                }
            }

            // Save description
            if(!$model->saveDescr()) {
                throw new BadRequestHttpException('Ошибка сохранения описания тура');
            }

            return $this->redirect(['index']);
        } else {
            // Get langs
            $langs = Languages::getLangs();
            
            // Get offer description
            $model->tourDescr();
            
            // Images
            $images = GalleryImages::getImages($model->id, GalleryImages::GALLERY_TYPE_TOUR);
            
            return $this->render('update', [
                'model' => $model,
                'langs' => $langs,
                'images' => $images,
            ]);
        }
    }

    /**
     * Deletes an existing Tours model.
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
     * Finds the Tours model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tours the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tours::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
