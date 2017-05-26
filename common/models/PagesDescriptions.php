<?php

namespace common\models;

use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "pages_descriptions".
 *
 * @property integer $id
 * @property integer $page_id
 * @property integer $lang_id
 * @property string $title
 * @property string $h1
 * @property string $meta_description
 * @property string $text
 * @property string $slug
 *
 * @property Pages $page
 */
class PagesDescriptions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pages_descriptions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_id', 'lang_id'], 'integer'],
            [['text'], 'string'],
            [['title', 'h1', 'meta_description', 'slug'], 'string', 'max' => 255],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pages::className(), 'targetAttribute' => ['page_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'page_id' => 'Page ID',
            'lang_id' => 'Lang ID',
            'title' => 'Title',
            'h1' => 'H1',
            'meta_description' => 'Meta Description',
            'text' => 'Text',
            'slug' => 'Slug',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Pages::className(), ['id' => 'page_id']);
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
