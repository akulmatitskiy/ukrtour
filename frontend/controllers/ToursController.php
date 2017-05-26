<?php

namespace frontend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use frontend\models\Tours;
use common\models\Categories;
use frontend\models\Gallery;

class ToursController extends \yii\web\Controller {

    /**
     * Body id attribute
     * @var string body ID 
     */
    public $bodyId;

    public function actionView($slug)
    {
        // Set body ID
        $this->bodyId = 'page-hotel';

        // Get offer model
        $tour = self::findModelBySlug($slug);
        if($tour == null) {
            throw new NotFoundHttpException('Page not found');
        }

        // Image
        $tour->defaultImage();

        // Category
        $category = Categories::findOne(['type' => Categories::CATEGORY_TYPE_TOURS]);
        
        // Banners
        $banners = Gallery::getCarousel('tour', $tour->id);

        return $this->render('view', [
                'tour' => $tour,
                'category' => $category,
                'banners' => $banners
        ]);
    }

    /**
     * Find model by slug
     * @param string $slug
     * @return mixes
     * @throws NotFoundHttpException
     */
    protected static function findModelBySlug($slug)
    {
        $model = Tours::find()
            ->joinWith('descr')
            ->where('slug = :slug', [':slug' => $slug])
            ->andWhere(['status' => Tours::TOURS_STATUS_VISIBLE])
            ->one();
        if(!empty($model)) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'Сторінку не знайдено'));
        }
    }

}
