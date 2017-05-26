<?php

namespace frontend\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\StringHelper;
use common\models\ServioTranslates;
use common\models\HotelsImages;
use common\models\Languages;
use common\models\Images;
use frontend\models\ConfRooms;

/**
 * This is the model class for table "servio_hotels".
 *
 * @property integer $id
 * @property integer $cityId
 * @property string $alias
 * @property integer $serverId
 * @property integer $servioId
 * @property integer $tourTax
 * @property string $manager_emails
 * @property string $latitude
 * @property string $longitude
 * @property integer $visible
 * @property integer $rating
 * @property string $phone
 */
class Hotels extends \common\models\Hotels {
    
    /**
     * Cache
     * 60*60 = 3600
     */
    const HOTELS_CACHE_EXPIRATION = 3600;

    /**
     * Servio hotel name relation
     * @param type $code the lang code
     * @return mixed hotel name
     */
    public function getServioName($code = null)
    {

        $langIso = Languages::getIsoCode($code);

        return $this->hasOne(ServioTranslates::className(), ['parentId' => 'id'])
                ->where([
                    'isoLang' => $langIso,
                    'parentType' => 'hotels',
        ]);
    }

    /**
     * Servio city name relation
     * @param type $code the lang code
     * @return mixed city name
     */
    public function getServioCity($code = null)
    {

        $langIso = Languages::getIsoCode($code);

        return $this->hasOne(ServioTranslates::className(), ['parentId' => 'cityId'])
                ->where([
                    'isoLang' => $langIso,
                    'parentType' => 'cities',
        ]);
    }

    /**
     * Hotel main image relation
     * @return mixed
     */
    public function getMainImage()
    {
        return $this->hasOne(HotelsImages::className(), ['hotel_id' => 'id'])
                ->where(['main' => 1]);
    }

    /**
     * Return hotels
     * @param int $limit
     * @param int $offset
     */
    public static function getHotels($limit, $offset = 0)
    {
        $query = self::find()
            ->select([
                '{{servio_hotels}}.id',
                '{{servio_hotels}}.cityId',
                '{{servio_hotels}}.rating',
            ])
            ->joinWith('servioName', 'mainImage')
            ->where(['visible' => self::HOTEL_STATUS_VISIBLE])
            ->offset($offset)
            ->orderBy('sort_order');

        // Limit
        if($limit) {
            $query->limit($limit);
        }

        $model = $query->all();

        // Hotels
        $hotels = [];
        foreach($model as $item) {
            // Hotel name
            $name = $item->servioName;
            if(!empty($name)) {
                $name = $name->name;
            }

            // Hotel city
            $city = $item->servioCity;
            if(!empty($city)) {
                $city = $city->name;
            }

            // Image
            if(!empty($item->mainImage)) {
                $image = $item->mainImage->image;
            } else {
                $image = HotelsImages::NO_IMAGE;
            }
            $imageUrl = Images::resize($image, 'hotel-bg-big', 'hotels');

            // Description
            $descr = $item->descr;
            if(!empty($descr->description)) {
                $description = strip_tags($descr->description);
                $text        = StringHelper::truncateWords($description, 35);
            } else {
                $text = '';
            }
            // Hotel slug

            if(!empty($descr->slug)) {
                $slug = $descr->slug;
                $url  = Url::to(['hotels/view', 'slug' => $slug]);
            } else {
                $url = '';
            }

            // Hotel
            $hotels[] = [
                'id' => 'hotel-' . $item->id,
                'name' => $name,
                'rating' => $item->rating,
                'city' => $city,
                'url' => $url,
                'image' => $imageUrl,
                'text' => $text,
                'type' => 'hotel'
            ];
        }

        return $hotels;
    }

    /**
     * Hotel
     * @param type $slug
     * @return type
     */
    public static function getHotelBySlug($slug)
    {
        $hotel = Hotels::find()
            ->joinWith(['descr', 'features'])
            ->where('slug = :slug', [':slug' => $slug])
            ->one();
        return $hotel;
    }

    /**
     * The hotels markers for map
     * @return array $model
     */
    public static function getHotelsGeo()
    {
        // Get hotels
        $model = Hotels::find()
            ->select(['id', 'latitude', 'longitude'])
            ->where(['visible' => self::HOTEL_STATUS_VISIBLE])
            ->asArray()
            ->all();

        return $model;
    }

    /**
     * Available hotel conference rooms
     * @return array $rooms the hotel conference rooms
     */
    public function getConfRooms()
    {
        $rooms      = [];
        $roomsModel = ConfRooms::find()
            ->where([
                'status' => ConfRooms::CONF_ROOMS_STATUS_ACTIVE,
                'type' => ConfRooms::CONF_ROOMS_TYPE_HOTEL,
                'parent_id' => $this->id,
            ])
            ->all();

        // Rooms array
        foreach($roomsModel as $room) {
            // Prices
            $prices = [];
            
            // 24 hour (day)
            if(!empty($room->price_24)) {
                $prices[] = [
                    'price' => $room->price_24,
                    'term' => Yii::t('app', 'за день'),
                ];
            }
            
            // 3 hour
            if(!empty($room->price_3)) {
                $prices[] = [
                    'price' => $room->price_3,
                    'term' => Yii::t('app', 'за 3 години'),
                ];
            }

            // 1 hour
            if(!empty($room->price_1)) {
                $prices[] = [
                    'price' => $room->price_1,
                    'term' => Yii::t('app', 'за 1 годину'),
                ];
            }

            // Image
            if(!empty($room->image)) {
                $image = $room->image;
            } else {
                $image = Images::PLACEHOLDER;
            }
            $imageUrl = Images::resize(
                    $image,
                'conference-rooms',
                'conference-rooms/' . $room->id,
                'conference-rooms/' . $room->id
            );

            // Features
            $features = [];
            foreach($room->features as $feature) {
                $features[] = [
                    'icon' => $feature->feature->icon,
                    'title' => $feature->descr->title,
                ];
            }

            $rooms[] = [
                'id' => $room->id,
                'image' => $imageUrl,
                'name' => $room->descr->name,
                'prices' => $prices,
                'features' => $features,
            ];
        }
        return $rooms;
    }
    
    /** 
     * Hotels rooms params
     * @param type $hotelId
     * @param type $roomsCount
     * @param type $search
     * @return type
     */
    public static function roomsParams($hotelId, $roomsCount, $search) {
        if(!empty($roomsCount) && !empty($search)) {
            $params = http_build_query([
                'roomsCount' => $roomsCount,
                'search' => $search,
            ]);
        } else {
            // Default params
            $params = http_build_query([
                'roomsCount' => 1,
                'search' => [
                    'hotelId' => $hotelId,
                    'arrival' => Yii::$app->formatter->asDate('now +1 day', 'dd.MM.yyyy') . ' 14:00',
                    'departure' => Yii::$app->formatter->asDate('now +2 day', 'dd.MM.yyyy') . ' 12:00',
                    'companyCode' => '',
                    'loyaltyCard' => '',
                    'isTouristTax' => false,
                    'rooms' => [
                        0 => [
                            'adults' => 1,
                            'children' => 0,
                            'isExtraBedUsed' => 0,
                            'childrenAges' => [0],
                        ]
                    ]
                ],
            ]);

        }
        return $params;
    }
    
}
