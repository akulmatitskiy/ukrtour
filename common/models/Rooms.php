<?php

namespace common\models;

use Yii;
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
class Rooms extends \yii\db\ActiveRecord
{
    /**
     *  Rooms statuses
     */
    const ROOMS_STATUS_INVISIBLE = 0;
    const ROOMS_STATUS_VISIBLE   = 1;
    
    /**
     * Room features
     * @var array
     */
    public $roomFeatures;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'servio_rooms';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hotelId', 'servioId', 'beds', 'extBeds', 'visible'], 'integer'],
            [['name', 'photo'], 'string', 'max' => 128],
            [['roomFeatures'], 'each', 'rule' => ['integer']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hotelId' => 'Отель',
            'servioId' => 'Servio ID',
            'name' => 'Название',
            'beds' => 'Beds',
            'extBeds' => 'Ext Beds',
            'visible' => 'Visible',
            'photo' => 'Photo',
            'roomFeatures' => 'Характеристики',
        ];
    }
    
    /**
     * The hotels features relation
     * @return mixed
     */
    public function getFeatures()
    {
        return $this->hasMany(RoomsFeatures::className(), ['room_id' => 'id']);
    }
}
