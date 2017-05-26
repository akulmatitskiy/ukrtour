<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "features_descriptions".
 *
 * @property integer $id
 * @property integer $feature_id
 * @property integer $lang_id
 * @property string $title
 *
 * @property Features $feature
 */
class FeaturesDescriptions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'features_descriptions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['feature_id', 'lang_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['feature_id', 'lang_id'], 'unique', 'targetAttribute' => ['feature_id', 'lang_id'], 'message' => 'The combination of Feature ID and Lang ID has already been taken.'],
            [['feature_id'], 'exist', 'skipOnError' => true, 'targetClass' => Features::className(), 'targetAttribute' => ['feature_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'feature_id' => 'Feature ID',
            'lang_id' => 'Lang ID',
            'title' => 'Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeature()
    {
        return $this->hasOne(Features::className(), ['id' => 'feature_id']);
    }
}
