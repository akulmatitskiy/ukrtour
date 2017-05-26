<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Hotels;
use common\models\Categories;
use frontend\models\Offers;
use yii\web\NotFoundHttpException;
use frontend\models\ConfRooms;
use frontend\models\Tours;
use frontend\models\Hostels;
use common\models\Banners;

class CategoriesController extends \yii\web\Controller {

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\PageCache',
                //'only' => ['index'],
                'duration' => Categories::CATEGORIES_EXPIRATION,
                'variations' => [
                    Yii::$app->language,
                    Yii::$app->request->get('slug')
                ],
            ],
        ];
    }

    /**
     * Categories
     * @param string $slug
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($slug)
    {
        $category = Categories::getCategoryBySlug($slug);


        if(!empty($category)) {
            // Banners
            if($category->type == Categories::CATEGORY_TYPE_CONF_ROOMS) {
                $bannerCateg = 4;
            } else {
                $bannerCateg = null;
            }
            $banners = Banners::getBanners($bannerCateg);

            // Hotels
            if($category->type == Categories::CATEGORY_TYPE_HOTELS) {

                $hotels = Hotels::getHotels(8, 0);
                if(!empty($hotels)) {
                    return $this->render('hotels', [
                            'category' => $category,
                            'hotels' => $hotels,
                            'banners' => $banners,
                    ]);
                }
            } elseif($category->type == Categories::CATEGORY_TYPE_CONF_ROOMS) {

                // Get offers
                $rooms = ConfRooms::getConfRooms(0, 7);

                // Count cities
                $citiesQuantity = ConfRooms::countCities();
                if(!empty($rooms)) {
                    return $this->render('conf-rooms', [
                            'category' => $category,
                            'rooms' => $rooms,
                            'citiesQuantity' => $citiesQuantity,
                            'banners' => $banners,
                    ]);
                }
            } elseif($category->type == Categories::CATEGORY_TYPE_TOURS) {

                // Get tours
                $tours = Tours::getTours();
                if(!empty($tours)) {
                    // Use offers view
                    return $this->render('offers', [
                            'category' => $category,
                            'offers' => $tours,
                            'banners' => $banners,
                    ]);
                }
            } elseif($category->type == Categories::CATEGORY_TYPE_HOSTEL) {
                // Get hostels
                $hostels = Hostels::getHostels();
                if(!empty($hostels)) {
                    // Use offers view
                    return $this->render('offers', [
                            'category' => $category,
                            'offers' => $hostels,
                            'banners' => $banners,
                    ]);
                }
            } else {
                // Get offers
                $offers = Offers::getOffers();
                return $this->render('offers', [
                        'category' => $category,
                        'offers' => $offers,
                        'banners' => $banners,
                ]);
            }
            throw new NotFoundHttpException(Yii::t('app', 'Сторінку не знайдено'));
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'Сторінку не знайдено'));
        }
    }

}
