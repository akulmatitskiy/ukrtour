<?php

namespace frontend\controllers;

use Yii;
use yii\web\Response;
use frontend\models\ConfRooms;

class ConfRoomsController extends \yii\web\Controller {

    public $bodyId;

    /**
     * All roms
     * @return json
     */
    public function actionIndex()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Get rooms
        $rooms = ConfRooms::getConfRooms(7);

        return $rooms;
    }

    /**
     * Conference room page
     * @param type $slug
     * @return mixed
     */
    public function actionView($slug)
    {
        $this->bodyId = 'page-hotel';

        $room = ConfRooms::getConfRoomBySlug($slug);

        // Prices
        $prices = [];

        if(!empty($room)) {
            // 1 hour
            if(!empty($room->price_1)) {
                $prices[] = [
                    'price' => $room->price_1,
                    'term' => Yii::t('app', 'за 1 годину'),
                ];
            }

            // 3 hour
            if(!empty($room->price_3)) {
                $prices[] = [
                    'price' => $room->price_3,
                    'term' => Yii::t('app', 'за 3 години'),
                ];
            }

            // 24 hour (day)
            if(!empty($room->price_24)) {
                $prices[] = [
                    'price' => $room->price_24,
                    'term' => Yii::t('app', 'за день'),
                ];
            }

            // roominess
            $roominess = '';
            if(!empty($room->people_min)) {
                $roominess .= Yii::t('app', 'від')
                    . '&nbsp;' . $room->people_min . '&nbsp;';
            }
            if(!empty($room->people_max)) {
                $roominess .= Yii::t('app', 'до')
                    . '&nbsp;' . $room->people_max;
            }
            if(!empty($roominess)) {
                $roominess .= '&nbsp;' . Yii::t('app', 'персон');
            }
        }

        return $this->render('view', [
                'room' => $room,
                'prices' => $prices,
                'roominess' => $roominess,
        ]);
    }

    /**
     * Rooms for conference rooms category page
     * @return string
     */
    public function actionList()
    {
        $cache = Yii::$app->cache;
        $lang  = Yii::$app->language;

        // Get conf rooms
        $rooms = $cache->get('confRoomsList' . $lang);
        if($rooms === false) {
            $rooms = ConfRooms::getConfRooms();

            // Caching results 
            $cache->set('confRoomsList' . $lang, $rooms, Yii::$app->params['cacheExpiration']);
        }

        return $this->renderPartial('list', ['rooms' => $rooms]);
    }

}
