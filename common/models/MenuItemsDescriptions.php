<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "menu_items_descriptions".
 *
 * @property integer $id
 * @property integer $item_id
 * @property integer $lang_id
 * @property string $url
 * @property string $name
 * @property string $title
 *
 * @property MenuItems $item
 */
class MenuItemsDescriptions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu_items_descriptions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'lang_id'], 'integer'],
            [['url', 'name', 'title'], 'string', 'max' => 255],
            [['item_id', 'lang_id'], 'unique', 'targetAttribute' => ['item_id', 'lang_id'], 'message' => 'The combination of Item ID and Lang ID has already been taken.'],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => MenuItems::className(), 'targetAttribute' => ['item_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_id' => 'Item ID',
            'lang_id' => 'Lang ID',
            'url' => 'Url',
            'name' => 'Name',
            'title' => 'Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(MenuItems::className(), ['id' => 'item_id']);
    }
}
