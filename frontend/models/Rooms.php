<?php

namespace frontend\models;

use common\models\RoomsFeatures;

/**
 * This is the model class for table "servio_rooms".
 *
 * @property integer $id
 * @property integer $hotelId
 * @property integer $servioId
 * @property string $name
 * @property integer $beds
 * @property integer $extBeds
 * @property integer $visible
 * @property string $photo
 */
class Rooms extends \common\models\Rooms {

    /**
     * Rooms features
     * @param integer $hotelId The hotel ID
     * @return mixed features
     */
    public static function getRoomsFeatures($hotelId)
    {
        $features = [];
        // Get rooms
        $rooms    = self::find()
            ->where('hotelId = :id', [':id' => $hotelId])
            ->andWhere(['visible' => self::ROOMS_STATUS_VISIBLE])
            ->all();
        if(!empty($rooms)) {
            // Get features
            foreach($rooms as $room) {
                if(!empty($room->features)) {
                    // Get icoms
                    foreach($room->features as $feature) {
                        $features[$feature->room_id][] = $feature->feature->icon;
                    }
                }
            }
            return $features;
        } else {
            return null;
        }
    }

}
