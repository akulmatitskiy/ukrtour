<?php

namespace frontend\controllers;

use Yii;
use yii\web\Response;
use frontend\models\Hotels;
use frontend\models\Rooms;
use frontend\models\Gallery;
use yii\web\NotFoundHttpException;

class HotelsController extends \yii\web\Controller {

    public $bodyId;

    /**
     * Hotel page action
     */
    public function actionView($slug)
    {
        $this->bodyId = 'page-hotel';
        $request      = Yii::$app->request;
        $search       = $request->post('search');
        $roomsCount   = $request->post('roomsCount');

        $hotel = Hotels::getHotelBySlug($slug);
        if($hotel === null) {
            throw new NotFoundHttpException('Page not found');
        }

        // isTouristTax
        if(isset($search['isTouristTax']) && $search['isTouristTax']) {
            $isTouristTax = true;
        } else {
            $isTouristTax = false;
        }

        // Conference rooms
        $rooms = $hotel->getConfRooms();

        return $this->render('view', [
                'hotel' => $hotel,
                'rooms' => $rooms,
                'banners' => Gallery::getCarousel('hotel', $hotel->id),
                'params' => Hotels::roomsParams($hotel->id, $roomsCount, $search),
                'isTouristTax' => $isTouristTax,
        ]);
    }

    /**
     * Search Hotel (booking) action
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionHotelsSearch()
    {
        $this->bodyId = 'page-hotel';
        $request      = Yii::$app->request;
        $search       = $request->post('search');
        $roomsCount   = $request->post('roomsCount');

        if($search) {
            $hotel = Hotels::find()
                ->where('id = :id', [':id' => $search['hotelId']])
                ->one();

            $banners = Gallery::getCarousel('hotel', $hotel->id);

            // isTouristTax
            if(isset($search['isTouristTax']) && $search['isTouristTax']) {
                $isTouristTax = true;
            } else {
                $isTouristTax = false;
            }

            return $this->render('view', [
                    'hotel' => $hotel,
                    'params' => Hotels::roomsParams($hotel->id, $roomsCount, $search),
                    'banners' => $banners,
                    'isTouristTax' => $isTouristTax,
            ]);
        } else {
            throw new NotFoundHttpException('Page not found');
        }
    }

    public function actionRoomsFeatures($hotel)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Features
        $features = Rooms::getRoomsFeatures($hotel);
        return [$features];
    }

    public function actionRooms($id)
    {
        $this->bodyId = 'page-hotel';

        $hotel = Hotels::findOne($id);
        if($hotel === null) {
            throw new NotFoundHttpException('Page not found');
        }



        return $this->render('rooms', [
                'hotel' => $hotel,
                'params' => Hotels::roomsParams($hotel->id, null, null),
        ]);
    }

    /**
     * Hotels for hotels category page
     * @return string
     */
    public function actionList()
    {
        $cache = Yii::$app->cache;
        $lang  = Yii::$app->language;

        // Get hotels
        $hotels = $cache->get('hotelsList' . $lang);
        if($hotels === false) {
            $hotels = Hotels::getHotels(false);

            // Caching results 
            $cache->set('hotelsList' . $lang, $hotels, Hotels::HOTELS_CACHE_EXPIRATION);
        }

        return $this->renderPartial('list', ['hotels' => $hotels]);
    }

}
