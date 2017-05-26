<?php

namespace common\models;

use yii\behaviors\SluggableBehavior;
use himiklab\yii2\search\behaviors\SearchBehavior;
use common\models\ConfRooms;

/**
 * This is the model class for table "conf_rooms_descriptions".
 *
 * @property integer $id
 * @property integer $conf_room_id
 * @property integer $lang_id
 * @property string $name
 * @property string $title
 * @property string $meta_description
 * @property string $description
 *
 * @property ConfRooms $confRoom
 */
class ConfRoomsDescriptions extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'conf_rooms_descriptions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['conf_room_id', 'lang_id'], 'integer'],
            [['description'], 'string'],
            [['name', 'title', 'meta_description', 'slug'], 'string', 'max' => 255],
            [['conf_room_id'], 'exist', 'skipOnError' => true, 'targetClass' => ConfRooms::className(), 'targetAttribute' => ['conf_room_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'conf_room_id' => 'Conf Room ID',
            'lang_id' => 'Lang ID',
            'name' => 'Name',
            'title' => 'Title',
            'meta_description' => 'Meta Description',
            'description' => 'Description',
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
                'attribute' => 'name',
                //'slugAttribute' => 'slug',
                'ensureUnique' => true,
                'immutable' => true,
            ],
            'search' => [
                'class' => SearchBehavior::className(),
                'searchScope' => function ($model) {
                    /** @var \yii\db\ActiveQuery $model */
                    $model->select([
                        'name',
                        'description',
                        'slug',
                        'lang_id'
                    ]);
                    $model->leftJoin('conf_rooms', '{{conf_rooms}}.id = {{conf_rooms_descriptions}}.conf_room_id');
                    $model->andWhere(['{{conf_rooms}}.status' => ConfRooms::CONF_ROOMS_STATUS_ACTIVE]);
                    //$model->andWhere(['indexed' => true]);
                },
                    'searchFields' => function ($model) {
                    /** @var self $model */
                    return [
                        ['name' => 'title', 'value' => $model->name],
                        ['name' => 'description', 'value' => \strip_tags($model->description)],
                        ['name' => 'url', 'value' => $model->slug, 'type' => SearchBehavior::FIELD_KEYWORD],
                        ['name' => 'model', 'value' => 'conf-rooms', 'type' => SearchBehavior::FIELD_UNINDEXED],
                        ['name' => 'langId', 'value' => $model->lang_id, 'type' => SearchBehavior::FIELD_UNINDEXED],
                    ];
                }
                ],
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getConfRoom()
        {
            return $this->hasOne(ConfRooms::className(), ['id' => 'conf_room_id']);
        }

    }
    