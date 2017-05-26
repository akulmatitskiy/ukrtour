<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "rooms_features".
 *
 * @property integer $id
 * @property integer $room_id
 * @property integer $feature_id
 */
class RoomsFeatures extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rooms_features';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['room_id', 'feature_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'room_id' => 'Room ID',
            'feature_id' => 'Feature ID',
        ];
    }
    
    /**
     * The feature relation
     * @param type $code
     * @return type
     */
    public function getFeature()
    {
        return $this->hasOne(Features::className(), ['id' => 'feature_id']);
    }
}
