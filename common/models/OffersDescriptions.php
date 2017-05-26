<?php

namespace common\models;

use yii\behaviors\SluggableBehavior;
use himiklab\yii2\search\behaviors\SearchBehavior;
use common\models\Offers;

/**
 * This is the model class for table "offers_descriptions".
 *
 * @property integer $id
 * @property integer $offer_id
 * @property integer $lang_id
 * @property string $title
 * @property string $annotation
 * @property string $meta_description
 * @property string $text
 * @property string $slug
 */
class OffersDescriptions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'offers_descriptions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['offer_id', 'lang_id'], 'integer'],
            [['text'], 'string'],
            [['title', 'meta_description', 'slug'], 'string', 'max' => 255],
            [['annotation'], 'string', 'max' => 130],
            [['offer_id', 'lang_id'], 'unique', 'targetAttribute' => ['offer_id', 'lang_id'], 'message' => 'The combination of Offer ID and Lang ID has already been taken.'],
            [['lang_id', 'slug'], 'unique', 'targetAttribute' => ['lang_id', 'slug'], 'message' => 'The combination of Lang ID and Slug has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'offer_id' => 'Offer ID',
            'lang_id' => 'Lang ID',
            'title' => 'Title',
            'annotation' => 'Annotation',
            'meta_description' => 'Meta Description',
            'text' => 'Text',
            'slug' => 'Slug',
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
            'search' => [
                'class' => SearchBehavior::className(),
                'searchScope' => function ($model) {
                    /** @var \yii\db\ActiveQuery $model */
                    $model->select([
                        'title',
                        'text',
                        'slug',
                        'lang_id'
                    ]);
                    $model->leftJoin('offers', '{{offers}}.id = {{offers_descriptions}}.offer_id');
                    $model->andWhere(['{{offers}}.status' => Offers::OFFERS_STATUS_VISIBLE]);
                    //$model->andWhere(['indexed' => true]);
                },
                    'searchFields' => function ($model) {
                    /** @var self $model */
                    return [
                        ['name' => 'title', 'value' => $model->title],
                        ['name' => 'description', 'value' => \strip_tags($model->text)],
                        ['name' => 'url', 'value' => $model->slug, 'type' => SearchBehavior::FIELD_KEYWORD],
                        ['name' => 'model', 'value' => 'offers', 'type' => SearchBehavior::FIELD_UNINDEXED],
                        ['name' => 'langId', 'value' => $model->lang_id, 'type' => SearchBehavior::FIELD_UNINDEXED],
                    ];
                }
                ],
        ];
    }
}
