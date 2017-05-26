<?php

namespace backend\models;

use Yii;
use common\models\Languages;
use common\models\ConfRoomsDescriptions;
use backend\models\Hotels;
use backend\models\Hostels;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use common\models\ConfRoomsFeatures;
use yii\helpers\ArrayHelper;
use backend\models\Features;

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
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => [ 'created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => [ 'updated_at'],
                ],
            ],
        ];
    }

    /**
     * Save conference room descriptions to db
     * @return boolean
     */
    public function saveDescr()
    {
        $langs = Languages::getLangs();

        // save
        foreach($langs as $code => $lang) {
            // Skip empty description

            if(!empty($this->name[$code])) {

                // find descr
                $model = ConfRoomsDescriptions::findOne([
                        'conf_room_id' => $this->id,
                        'lang_id' => $lang['id'],
                ]);

                if(empty($model)) {
                    // new entry
                    $model = new ConfRoomsDescriptions();
                }

                // Descr properties
                $model->conf_room_id     = $this->id;
                $model->lang_id          = $lang['id'];
                $model->title            = $this->title[$code];
                $model->name             = $this->name[$code];
                $model->description      = $this->description[$code];
                $model->meta_description = $this->meta_description[$code];

                // Slug
                if(!empty($this->slug[$code])) {
                    $model->detachBehavior('slug');
                    $model->slug = $this->slug[$code];
                } else {
                    $model->slug = null;
                }

                if(!$model->save()) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Load category description to the model
     * @return boolean
     */
    public function confRoomDescr()
    {
        $langs = Languages::getLangs();
        foreach($langs as $code => $lang) {
            // Get hotel description
            $descr = $this->getDescr($code)->one();

            // Assign properties
            if(!empty($descr)) {
                $this->title[$code]            = $descr->title;
                $this->name[$code]             = $descr->name;
                $this->description[$code]      = $descr->description;
                $this->meta_description[$code] = $descr->meta_description;
                $this->slug[$code]             = $descr->slug;
            }
        }
        return true;
    }

    /**
     * Save Banner image
     * @return boolean
     */
    public function saveImage()
    {
        $imageInfo = pathinfo($this->image);
        $directory = 'images/conference-rooms/' . $this->id;
        $filePath  = $directory . '/' . $imageInfo['basename'];

        // Create directory
        @mkdir($directory, 0777, true);

        // Copy file to images/confrence-rooms
        if(!copy(Yii::getAlias('@backend/web' . $this->image), $filePath)) {
            return false;
        } else {
            $this->image = $imageInfo['basename'];
            $this->save();
            return true;
        }
    }

    public static function getTypes()
    {
        return [
            self::CONF_ROOMS_TYPE_HOTEL => 'Отель',
            self::CONF_ROOMS_TYPE_HOSTEL => 'Турбаза',
        ];
    }

    /**
     * List parents
     * @param int $type
     * @return array
     */
    public static function getParents($type)
    {
        if($type == self::CONF_ROOMS_TYPE_HOTEL) {
            $result = [];

            // Get items
            $parents = self::getHotels();

            // result array, in format id: <id>, name: <name>
            foreach($parents as $id => $name) {
                $result[] = [
                    'id' => $id,
                    'name' => $name,
                ];
            }
            return $result;
        } else {
            return self::getHostels();
        }
    }

    /**
     * List hotels
     * @return array $hotels
     */
    public static function getHotels()
    {
        $hotels = [];

        // Get hotels items
        $items = Hotels::findAll(['visible' => Hotels::HOTEL_STATUS_VISIBLE]);

        // Hotels array for drop down list
        foreach($items as $item) {
            $hotels[$item->id] = $item->hotelCity() . ': ' . $item->hotelName();
        }

        return $hotels;
    }

    /**
     * List hostels
     * @return array $hostels
     */
    public static function getHostels()
    {
        $hostels = [];

        // Get hotels items
        $items = Hostels::findAll(['status' => Hostels::HOSTELS_STATUS_VISIBLE]);

        // Hotels array for drop down list
        foreach($items as $item) {
            $title = null;
            if(!empty($item->descr->title)) {
                $title = $item->descr->title;
            }
            $hostels[] = [
                'id' => $item->id,
                'name' => $title,
            ];
        }

        return $hostels;
    }

    /**
     * Actiove parent ID
     * @param type $type
     * @param type $id
     * @return type
     */
    public static function getActiveParent($type, $id)
    {
        $confRoom = self::findOne([
            'id' => $id,
            'type' => $type
        ]);
        
        $active = null;
        if($confRoom !== null) {
            $active = $confRoom->parent_id;
        } 
        
        return $active;
    }

    /**
     * Room hotel
     * @return stirng $hotels
     */
    public function getHotel()
    {
        $hotels = [];

        // Get hotel
        $hotel = Hotels::findOne([
                'visible' => Hotels::HOTEL_STATUS_VISIBLE,
                'id' => $this->parent_id,
        ]);
        if(!empty($hotel)) {
            // Hotel city + name
            $hotel = $hotel->hotelCity() . ': ' . $hotel->hotelName();
            return $hotel;
        } else {
            return null;
        }
        return $hotels;
    }
    
    /**
     * Room hostel
     * @return stirng $hotels
     */
    public function getHostel()
    {

        // Get hotel
        $hostel = Hostels::findOne([
                'status' => Hostels::HOSTELS_STATUS_VISIBLE,
                'id' => $this->parent_id,
        ]);
        
        if(!empty($hostel->descr->title)) {
            // Hotel city + name
            $title = 'Турбаза: ' . $hostel->descr->title;
            return $title;
        } else {
            return null;
        }
    }

    /**
     * Features available for hotel
     * @return array $features The hotel features 
     */
    public function featuresList()
    {
        $model = Features::find()
            ->select('{{features}}.id as id, {{features_descriptions}}.title as title')
            ->joinWith('descr')
            ->where([
                'status' => Features::FEATURES_STATUS_ACTIVE,
                'type' => Features::FEATURES_TYPE_CONF_ROOM
            ])
            ->asArray()
            ->all();

        $features = ArrayHelper::map($model, 'id', 'title');
        return $features;
    }

    /**
     * Save hotels features
     * @return boolean
     */
    public function saveFeatures()
    {
        // Clean features
        if(ConfRoomsFeatures::deleteAll(['conf_room_id' => $this->id]) !== null) {
            if(!empty($this->confRoomFeatures)) {
                // Add features
                foreach($this->confRoomFeatures as $feature) {
                    $model               = new ConfRoomsFeatures();
                    $model->conf_room_id = $this->id;
                    $model->feature_id   = $feature;
                    if(!$model->save()) {
                        Yii::error_log('Error save conf room feature');
                        return false;
                    }
                }
            }
            return true;
        } else {
            Yii::error_log('Error claes conf room features');
            return false;
        }
    }

    /**
     * Conference room features
     * @return array features
     */
    public function confRoomFeatures()
    {
        // Get features
        $features = ConfRoomsFeatures::find()
            ->where(['conf_room_id' => $this->id])
            ->asArray()
            ->all();

        return ArrayHelper::map($features, 'feature_id', 'feature_id');
    }

}
