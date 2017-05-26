<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "banners_descriptions".
 *
 * @property integer $id
 * @property integer $banner_id
 * @property integer $lang_id
 * @property string $title
 * @property string $url
 * @property string $price
 * @property string $text
 *
 * @property Banners $banner
 */
class BannersDescriptions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'banners_descriptions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['banner_id', 'lang_id'], 'integer'],
            [['title', 'url', 'price', 'text'], 'required'],
            [['title', 'url', 'price', 'text'], 'string', 'max' => 255],
            [['banner_id'], 'exist', 'skipOnError' => true, 'targetClass' => Banners::className(), 'targetAttribute' => ['banner_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'banner_id' => 'Banner ID',
            'lang_id' => 'Lang ID',
            'title' => 'Title',
            'url' => 'Url',
            'price' => 'Price',
            'text' => 'Text',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBanner()
    {
        return $this->hasOne(Banners::className(), ['id' => 'banner_id']);
    }
}
