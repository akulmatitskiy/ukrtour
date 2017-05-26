<?php

namespace common\models;

use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "categories_desctiptions".
 *
 * @property integer $id
 * @property integer $catetory_id
 * @property integer $lang_id
 * @property string $title
 * @property string $annotation
 * @property string $h1
 * @property string $text
 * @property string $meta_title
 * @property string $meta_desctiption
 * @property string $slug
 */
class CategoriesDescriptions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categories_descriptions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'lang_id'], 'integer'],
            [['text'], 'string'],
            [['title', 'annotation', 'h1', 'meta_title', 'meta_description', 'slug'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Catetory ID',
            'lang_id' => 'Lang ID',
            'title' => 'Заголовок',
            'annotation' => 'Аннотация',
            'h1' => 'Заголовок H1',
            'text' => 'Текст',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Desctiption',
            'slug' => 'Псевдоним',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'slugAttribute' => 'slug',
                'ensureUnique' => true,
            ],
        ];
    }
}
