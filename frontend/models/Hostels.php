<?php

namespace frontend\models;

use Yii;
use yii\helpers\StringHelper;
use common\models\Images;
use yii\helpers\Url;

/**
 * This is the model class for table "hostels".
 *
 * @property integer $id
 * @property integer $status
 * @property string $image
 * @property string $phone
 *
 * @property HostelsDescriptions[] $hostelsDescriptions
 */
class Hostels extends \common\models\Hostels {

    public static function getHostels($limit = false)
    {
        // Get hostels model
        $query = self::find()
            ->where([
            'status' => self::HOSTELS_STATUS_VISIBLE,
        ]);

        // Limit
        if($limit) {
            $query->limit($limit);
        }

        $model = $query->all();

        if(!empty($model)) {
            // hostels array
            $hostels = [];
            foreach($model as $item) {
                // Title
                $title = '';
                if(isset($item->descr->title)) {
                    $title = StringHelper::truncate($item->descr->title, 70);
                }

                // Image
                if(!empty($item->image)) {
                    $image = $item->image;
                } else {
                    $image = Images::PLACEHOLDER;
                }
                $imageUrl = Images::resize($image, 'offer-bg', 'hostel', 'hostel');

                // annotation
                $annotation = '';
                if(isset($item->descr->annotation)) {
                    $annotation = $item->descr->annotation;
                }

                // Url
                if(!empty($item->descr->slug)) {
                    $url = Url::to(['hostels/view', 'slug' => $item->descr->slug]);
                } else {
                    $url = '#';
                }

                // Push to array
                $hostels[] = [
                    'id' => $item->id,
                    'title' => $title,
                    'image' => $imageUrl,
                    'annotation' => $annotation,
                    'url' => $url,
                ];
            }

            return $hostels;
        } else {
            return false;
        }
    }

    /**
     * Default image url
     * @return boolean
     */
    public function defaultImage()
    {
        // Image
        if(!empty($this->image)) {
            $image = $this->image;
        } else {
            $image = Images::PLACEHOLDER;
        }
        $imageUrl    = Images::resize($image, 'offer-big', 'hostel', 'hostel-big');
        $this->image = $imageUrl;
        return true;
    }

    /**
     * The hostels markers for map
     * @return array $model
     */
    public static function getHostelsGeo()
    {
        // Get hotels
        $model = self::find()
            ->select(['id', 'latitude', 'longitude'])
            ->where(['status' => self::HOSTELS_STATUS_VISIBLE])
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
                'type' => ConfRooms::CONF_ROOMS_TYPE_HOSTEL,
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
                    $image, 'conference-rooms', 'conference-rooms/' . $room->id, 'conference-rooms/' . $room->id
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

}
