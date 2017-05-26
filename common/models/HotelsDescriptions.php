<?php

namespace common\models;

use yii\behaviors\SluggableBehavior;
use himiklab\yii2\search\behaviors\SearchBehavior;

/**
 * This is the model class for table "hotels_descriptions".
 *
 * @property integer $id
 * @property integer $hotel_id
 * @property integer $lang_id
 * @property string $title
 * @property string $address
 * @property string $descriotion
 * @property string $map
 */
class HotelsDescriptions extends \yii\db\ActiveRecord {

    /**
     * City name
     * @var type string
     */
    public $city;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hotels_descriptions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hotel_id', 'lang_id'], 'integer'],
            //[['title', 'h1'], 'required'],
            [['description', 'map'], 'string'],
            [['title', 'address', 'h1', 'slug'], 'string', 'max' => 255],
            [['hotel_id', 'lang_id'], 'unique', 'targetAttribute' => ['hotel_id', 'lang_id'], 'message' => 'The combination of Hotel ID and Lang ID has already been taken.'],
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
            'lang_id' => 'Lang ID',
            'title' => 'Title',
            'address' => 'Address',
            'description' => 'description',
            'map' => 'Map',
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
                        'address',
                        'description',
                        'slug',
                        '{{hotels_descriptions}}.lang_id',
                        '{{servio_translates}}.name as city'
                    ]);
                    $model->leftJoin('servio_hotels', '{{servio_hotels}}.id = {{hotels_descriptions}}.hotel_id');
                    $model->leftJoin('lang_iso_codes', '{{hotels_descriptions}}.lang_id = {{lang_iso_codes}}.lang_id');
                    $model->leftJoin('servio_translates', '{{servio_hotels}}.cityId = {{servio_translates}}.parentId
                        AND {{servio_translates}}.isoLang = {{lang_iso_codes}}.iso_code'
                        );
                    $model->andWhere(['{{servio_hotels}}.visible' => Hotels::HOTEL_STATUS_VISIBLE]);
                    $model->andWhere(['{{servio_translates}}.parentType' => 'cities']);
                    //$model->andWhere(['indexed' => true]);
                },
                    'searchFields' => function ($model) {
                    /** @var self $model */
                    return [
                        ['name' => 'title', 'value' => $model->title],
                        ['name' => 'address', 'value' => $model->address],
                        ['name' => 'description', 'value' => \strip_tags($model->description)],
                        ['name' => 'city', 'value' => $model->city],
                        ['name' => 'url', 'value' => $model->slug, 'type' => SearchBehavior::FIELD_KEYWORD],
                        ['name' => 'model', 'value' => 'hotels', 'type' => SearchBehavior::FIELD_UNINDEXED],
                        ['name' => 'langId', 'value' => $model->lang_id, 'type' => SearchBehavior::FIELD_UNINDEXED],
                    ];
                }
                ],
            ];
        }

    }
    