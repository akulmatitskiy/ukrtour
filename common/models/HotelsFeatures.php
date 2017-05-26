<?php

namespace common\models;

use common\models\Languages;
use common\models\FeaturesDescriptions;

/**
 * This is the model class for table "hotels_features".
 *
 * @property integer $id
 * @property integer $hotel_id
 * @property integer $feature_id
 */
class HotelsFeatures extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hotels_features';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hotel_id', 'feature_id'], 'integer'],
            [['hotel_id', 'feature_id'], 'unique', 'targetAttribute' => ['hotel_id', 'feature_id'], 'message' => 'The combination of Hotel ID and Feature ID has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hotel_id' => 'Hotel ID',
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
