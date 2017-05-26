<?php

namespace backend\controllers;

use common\models\GalleryImages;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\filters\AccessRule;

/**
 * GalleryController implements the CRUD actions for Gallery model.
 */
class GalleryController extends Controller {

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
                        'actions' => ['delete-image'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    
    /**
     * Delete gallery image
     * @param type $id
     * @param type $route
     * @param type $gallery
     * @return type
     * @throws NotFoundHttpException
     */
    public function actionDeleteImage($id, $route, $gallery)
    {
        if(GalleryImages::deleteImage($id, $gallery) != false) {
            
            return $this->redirect([$route, 'id' => $gallery]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
