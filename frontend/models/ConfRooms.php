<?php

namespace frontend\models;

use Yii;
use common\models\Images;
use yii\helpers\Url;
use frontend\models\Hotels;
use common\models\ServioCities;

/**
 * This is the model class for table "conf_rooms".
 *
 * @property integer $id
 * @property integer $hotel_id
 * @property integer $quantity
 * @property double $price_1
 * @property double $price_3
 * @property double $price_24
 * @property string $image
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ConfRoomsDescriptions[] $confRoomsDescriptions
 */
class ConfRooms extends \common\models\ConfRooms {

    /**
     * Conference roons on category page
     * @param type $limit
     * @param type $offset
     * @return array $rooms conference rooms
     */
    public static function getConfRooms($offset = 0, $limit = false)
    {
        $rooms = [];
        // Find avalable conference rooms
        $query = self::find()
            ->where(['status' => self::CONF_ROOMS_STATUS_ACTIVE])
            ->offset($offset);

        // Limit
        if($limit) {
            $query->limit($limit);
        }

        $items = $query->all();

        if(!empty($items)) {
            // Form the rooms array
            foreach($items as $item) {
                // Image
                if(!empty($item->image)) {
                    $image = $item->image;
                } else {
                    $image = Images::PLACEHOLDER;
                }
                $imageUrl = Images::resize(
                        $image, 'conference-rooms', 'conference-rooms/' . $item->id, 'conference-rooms/' . $item->id
                );

                // Url
                if(!empty($item->descr->slug)) {
                    $slug = $item->descr->slug;
                    $url  = Url::to(['conf-rooms/view', 'slug' => $slug]);
                } else {
                    $url = '';
                }

                // Desr from parent
                $name   = '';
                $rating = 0;
                $city   = '';
                if($item->type == self::CONF_ROOMS_TYPE_HOTEL) {
                    // Hotel model

                    $hotel = Hotels::findOne($item->parent_id);
                    if(!empty($hotel)) {
                        $name   = isset($hotel->servioName->name) ? $hotel->servioName->name : '';
                        $city   = isset($hotel->servioCity->name) ? $hotel->servioCity->name : '';
                        $rating = $hotel->rating;
                    }
                }
                if($item->type == self::CONF_ROOMS_TYPE_HOSTEL) {
                    // Hostel model
                    $hostel = Hostels::findOne($item->parent_id);
                    if(!empty($hostel->descr->title)) {
                        $name = $hostel->descr->title;
                    }
                    

                    // Сity
                    if(!empty($hostel->city_id)) {
                        $cityModel = ServioCities::findOne($hostel->city_id);
                        if(!empty($cityModel) && !empty($cityModel->descr->name)) {
                            $city = $cityModel->descr->name;
                        }
                    }
                    
                }

                // roominess
                $descr = '';
                if(!empty($item->people_min)) {
                    $descr .= Yii::t('app', 'від')
                        . '&nbsp;' . $item->people_min . '&nbsp;';
                }
                if(!empty($item->people_max)) {
                    $descr .= Yii::t('app', 'до')
                        . '&nbsp;' . $item->people_max;
                }
                if(!empty($descr)) {
                    $descr .= '&nbsp;' . Yii::t('app', 'персон');
                }

                $rooms[] = [
                    'image' => $imageUrl,
                    'url' => $url,
                    'name' => $name,
                    'rating' => $rating,
                    'city' => $city,
                    'descr' => $descr,
                ];
            }
        }

        return $rooms;
    }

    public static function getConfRoomBySlug($slug)
    {
        $room = self::find()
            ->joinWith('descr')
            ->where('slug = :slug', [':slug' => $slug])
            ->andWhere(['status' => self::CONF_ROOMS_STATUS_ACTIVE])
            ->one();

        // Image
        if(!empty($room->image)) {
            $imageUrl    = Images::resize(
                    $room->image, 'conference-rooms-big', 'conference-rooms/' . $room->id, 'conference-rooms/' . $room->id . '/big'
            );
            $room->image = $imageUrl;
        }
        return $room;
    }

    public static function countCities()
    {
        // Count city (all active rooms)
        $citiesHotel = self::find()
            ->select('{{servio_hotels}}.cityId as city')
            ->leftJoin(
                'servio_hotels', '{{servio_hotels}}.id = {{conf_rooms}}.parent_id'
            )
            ->where([
                '{{conf_rooms}}.status' => self::CONF_ROOMS_STATUS_ACTIVE,
                '{{conf_rooms}}.type' => self::CONF_ROOMS_TYPE_HOTEL
                ])
            ->groupBy('city')
            ->all();
        
        $citiesHostel = self::find()
            ->select('{{hostels}}.city_id as city')
            ->leftJoin(
                'hostels', '{{hostels}}.id = {{conf_rooms}}.parent_id'
            )
            ->where([
                '{{conf_rooms}}.status' => self::CONF_ROOMS_STATUS_ACTIVE,
                '{{conf_rooms}}.type' => self::CONF_ROOMS_TYPE_HOSTEL
                ])
            ->groupBy('city')
            ->all();
        
        $result = array_merge($citiesHotel, $citiesHostel);
        $quantity = count($result);

        return $quantity;
    }

    /**
     * Room name with hotel name & city
     * @param type $id the room ID
     * @return string the room name
     */
    public static function confRoomName($id)
    {
        $roomModel = self::find()
            ->where('id = :id', [':id' => $id])
            ->one();

        if(!empty($roomModel)) {
            // Hotel info
            $hotel = Hotels::findOne($roomModel->hotel_id);
            if(!empty($hotel)) {
                $name = $hotel->servioName->name;
                $city = $hotel->servioCity->name;
            }

            $room = $hotel->servioName->name . ', '
                . $hotel->servioCity->name . ': '
                . $roomModel->descr->name;
            return $room;
        } else {
            return '';
        }
    }

}
