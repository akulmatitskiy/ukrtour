<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\Features;
use common\models\RoomsFeatures;
use common\models\ServioTranslates;

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
                'type' => Features::FEATURES_TYPE_ROOM
            ])
            ->asArray()
            ->all();

        $features = ArrayHelper::map($model, 'id', 'title');
        return $features;
    }

    /**
     * Save room features
     * @return boolean
     */
    public function saveFeatures()
    {
        // Clean features
        if(RoomsFeatures::deleteAll(['room_id' => $this->id]) !== null) {
            if(!empty($this->roomFeatures)) {
                // Add features
                foreach($this->roomFeatures as $feature) {
                    $model             = new roomsFeatures();
                    $model->room_id    = $this->id;
                    $model->feature_id = $feature;
                    if(!$model->save()) {
                        Yii::error_log('Error save room feature');
                        return false;
                    }
                }
            }
            return true;
        } else {
            Yii::error_log('Error claes room features');
            return false;
        }
    }

    /**
     * Conference room features
     * @return array features
     */
    public function roomFeatures()
    {
        // Get features
        $features = RoomsFeatures::find()
            ->where(['room_id' => $this->id])
            ->asArray()
            ->all();

        return ArrayHelper::map($features, 'feature_id', 'feature_id');
    }

    /**
     * Conference room features
     * @return array features
     */
    public function roomFeaturesIcons()
    {
        // Get features
        $features = RoomsFeatures::find()
            ->where(['room_id' => $this->id])
            ->all();
        if(!empty($features)) {
            $icons = '';
            foreach($features as $feature) {
                $icons .= '<i class="material-icons">'
                    . $feature->feature->icon . '</i>';
            }
            return $icons;
        } else {
            return null;
        }
    }

    /**
     * Get hotel name from servio module
     * @return mixed $name the hotel name
     */
    public static function hotelName($id)
    {
        // model
        $model = ServioTranslates::findOne([
                'parentId' => $id,
                'parentType' => 'hotels',
                'isoLang' => 'ru',
        ]);

        if(!empty($model)) {
            $name = $model->name;
        } else {
            $name = null;
        }

        // City
        $city  = '';
        $hotel = Hotels::findOne($id);
        if(!empty($hotel)) {
            $city = self::hotelCity($hotel->cityId);
            $city .= ': ';
        }

        return $city . $name;
    }

    /**
     * City
     * @param type $cityId
     * @return string
     */
    protected static function hotelCity($cityId)
    {
        // model
        $model = ServioTranslates::findOne([
                'parentId' => $cityId,
                'parentType' => 'cities',
                'isoLang' => 'ru',
        ]);

        if(!empty($model)) {
            $name = $model->name;
        } else {
            $name = '';
        }

        return $name;
    }

    /**
     * List hotels
     * @return array $hotels
     */
    public function getHotels()
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

}
