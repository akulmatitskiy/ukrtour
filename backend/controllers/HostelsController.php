<?php

namespace backend\controllers;

use Yii;
use backend\models\Hostels;
use backend\models\search\HostelsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use common\models\Languages;
use common\models\GalleryImages;
use common\models\Images;

/**
 * HostelsController implements the CRUD actions for Hostels model.
 */
class HostelsController extends Controller
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
     * Lists all Hostels models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HostelsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Hostels model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Hostels();

        if ($model->load(Yii::$app->request->post())) {
            // Save image
            if(!empty($model->image)) {
                $image = Images::saveImage($model->image, 'hostel');
                if($image != false) {
                    $model->image = $image;
                } else {
                    Yii::warning('Ошибка сохранения изображения');
                }
            }
            
            // Save description
            if(!$model->save()) {
                Yii::warning($model->errors);
                throw new BadRequestHttpException('Ошибка сохранения турбазы');
            }
            
            // Save image
            if(!empty($model->images)) {
                if(!GalleryImages::saveImages($model->images, $model->id, GalleryImages::GALLERY_TYPE_HOSTEL, 'hostel')) {
                    Yii::warning('Ошибка сохранения галереи');
                }
            }

            // Save description
            if(!$model->saveDescr()) {
                throw new BadRequestHttpException('Ошибка сохранения описания турбазы');
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
     * Updates an existing Hostels model.
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
                $image = Images::saveImage($model->image, 'hostel');
                if($image != false) {
                    $model->image = $image;
                } else {
                    Yii::warning('Ошибка сохранения изображения');
                }
            }
            
            // Save description
            if(!$model->save()) {
                throw new BadRequestHttpException('Ошибка сохранения турбазы');
            }
            
            // Save image
            if(!empty($model->images)) {
                if(!GalleryImages::saveImages($model->images, $model->id, GalleryImages::GALLERY_TYPE_HOSTEL, 'hostel')) {
                    Yii::warning('Ошибка сохранения галереи');
                }
            }

            // Save description
            if(!$model->saveDescr()) {
                throw new BadRequestHttpException('Ошибка сохранения описания турбазы');
            }

            return $this->redirect(['index']);
        } else {
            // Get langs
            $langs = Languages::getLangs();
            
            // Get offer description
            $model->hostelDescr();
            
            // Images
            $images = GalleryImages::getImages($model->id, GalleryImages::GALLERY_TYPE_HOSTEL);
            
            return $this->render('update', [
                'model' => $model,
                'langs' => $langs,
                'images' => $images,
            ]);
        }
    }

    /**
     * Deletes an existing Hostels model.
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
     * Finds the Hostels model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Hostels the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Hostels::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
