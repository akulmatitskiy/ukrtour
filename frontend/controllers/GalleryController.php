<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Gallery;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class GalleryController extends \yii\web\Controller {

    /**
     * body id attribute 
     * @var string body id
     */
    public $bodyId;

    public function actionView($type, $id)
    {
        $this->bodyId = 'page-gallery';
        $gallery      = Gallery::galleryPage($type, $id);
        $images = Gallery::galleryPageImages($type, $id);
        if($gallery) {
            return $this->render('view', [
                    'gallery' => $gallery,
                    'images' => $images
            ]);
        } else {
            throw new NotFoundHttpException('Page not found');
        }
    }

}
