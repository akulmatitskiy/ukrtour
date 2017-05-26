<?php

namespace common\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use himiklab\yii2\search\behaviors\SearchBehavior;
use common\models\Hostels;

/**
 * This is the model class for table "hostels_descriptions".
 *
 * @property integer $id
 * @property integer $hostel_id
 * @property integer $lang_id
 * @property string $title
 * @property string $annotation
 * @property string $meta_description
 * @property string $description
 * @property string $slug
 *
 * @property Hostels $hostel
 */
class HostelsDescriptions extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hostels_descriptions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hostel_id', 'lang_id'], 'integer'],
            [['description'], 'string'],
            [['title', 'annotation', 'meta_description', 'slug'], 'string', 'max' => 255],
            [['hostel_id'], 'exist', 'skipOnError' => true, 'targetClass' => Hostels::className(), 'targetAttribute' => ['hostel_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hostel_id' => 'Tour ID',
            'lang_id' => 'Lang ID',
            'title' => 'Title',
            'annotation' => 'Annotation',
            'meta_description' => 'Meta Description',
            'description' => 'Description',
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
                        'description',
                        'slug',
                        'lang_id'
                    ]);
                    $model->leftJoin('hostels', '{{hostels}}.id = {{hostels_descriptions}}.hostel_id');
                    $model->andWhere(['{{hostels}}.status' => Hostels::TOURS_STATUS_VISIBLE]);
                },
                    'searchFields' => function ($model) {
                    /** @var self $model */
                    return [
                        ['name' => 'title', 'value' => $model->title],
                        ['name' => 'description', 'value' => \strip_tags($model->description)],
                        ['name' => 'url', 'value' => $model->slug, 'type' => SearchBehavior::FIELD_KEYWORD],
                        ['name' => 'model', 'value' => 'offers', 'type' => SearchBehavior::FIELD_UNINDEXED],
                        ['name' => 'langId', 'value' => $model->lang_id, 'type' => SearchBehavior::FIELD_UNINDEXED],
                    ];
                }
                ],
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getHostel()
        {
            return $this->hasOne(Hostels::className(), ['id' => 'hostel_id']);
        }

    }
    