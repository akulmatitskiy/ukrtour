<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hotels_images".
 *
 * @property integer $id
 * @property integer $hotel_id
 * @property string $image
 * @property integer $main
 */
class HotelsImages extends \yii\db\ActiveRecord
{
    const NO_IMAGE = 'no-image.jpg';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hotels_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hotel_id', 'main'], 'integer'],
            [['image'], 'string', 'max' => 255],
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
            'image' => 'Image',
            'main' => 'Main',
        ];
    }
}
