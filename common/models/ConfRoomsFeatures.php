<?php

namespace common\models;

use common\models\Languages;
use common\models\FeaturesDescriptions;

/**
 * This is the model class for table "conf_rooms_features".
 *
 * @property integer $id
 * @property integer $conf_room_id
 * @property integer $feature_id
 */
class ConfRoomsFeatures extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'conf_rooms_features';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['conf_room_id', 'feature_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'conf_room_id' => 'Conf Room ID',
            'feature_id' => 'Feature ID',
        ];
    }
    
    /**
     * The feature description relation
     * @param type $code
     * @return type
     */
    public function getDescr($code = null)
    {
        $langId = Languages::getLangId($code);

        return $this->hasOne(FeaturesDescriptions::className(), ['feature_id' => 'feature_id'])
                ->where('{{features_descriptions}}.lang_id = :lang_id', [':lang_id' => $langId]);
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
