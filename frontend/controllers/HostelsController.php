<?php

namespace frontend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use frontend\models\Hostels;
use common\models\Categories;
use frontend\models\Gallery;

class HostelsController extends \yii\web\Controller
{
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
        $hostel = self::findModelBySlug($slug);
        if($hostel == null) {
            throw new NotFoundHttpException('Page not found');
        }
        
        // Image
        $hostel->defaultImage();
        
        // Category
        $category = Categories::findOne(['type' => Categories::CATEGORY_TYPE_HOSTEL]);
        
        // Banners
        $banners = Gallery::getCarousel('hostel', $hostel->id);
        
        // Conference rooms
        $confRooms = $hostel->getConfRooms();

        return $this->render('view', [
                'hostel' => $hostel,
                'category' => $category,
                'banners' => $banners,
                'confRooms' => $confRooms
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
        $model = Hostels::find()
            ->joinWith('descr')
            ->where('slug = :slug', [':slug' => $slug])
            ->andWhere(['status' => Hostels::HOSTELS_STATUS_VISIBLE])
            ->one();
        if(!empty($model)) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'Сторінку не знайдено'));
        }
    }

}
