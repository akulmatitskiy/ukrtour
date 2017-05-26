<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "conf_rooms".
 *
 * @property integer $id
 * @property integer $hotel_id
 * @property integer $quantity
 * @property double $price_1
 * @property double $price_3
 * @property double $price_24
 * @property string $image
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ConfRoomsDescriptions[] $confRoomsDescriptions
 */
class ConfRooms extends \yii\db\ActiveRecord
{
    
    /**
     * Conference rooms display statuses
     */
    const CONF_ROOMS_STATUS_INACTIVE = 0;
    const CONF_ROOMS_STATUS_ACTIVE = 1;
    
    /**
     * 
     */
    const CONF_ROOMS_TYPE_HOTEL = 1;  
    const CONF_ROOMS_TYPE_HOSTEL = 2;  
    
    /**
     * Conference room name
     * @var string $name 
     */
    public $name;
    
    /**
     * Conference room page title
     * @var string $title
     */
    public $title;
    
    /**
     * Conference room meta description
     * @var string $meta_description 
     */
    public $meta_description;
    
    /**
     * Conference room description
     * @var string $description 
     */
    public $description;
    
    /**
     * Conference room alias
     * @var string $description 
     */
    public $slug;
    
    /**
     * Current image
     * @var string current image name
     */
    public $oldImage;
    
    /**
     * Conference room features
     * @var array
     */
    public $confRoomFeatures;
    
    //public $parent_id;

    
    /**
     * Statuses labels
     * @var type 
     */
    private static $statusesLabels = [
        self::CONF_ROOMS_STATUS_INACTIVE => 'Скрыт',
        self::CONF_ROOMS_STATUS_ACTIVE => 'Опубликован',
    ];
    
    /**
     * Statuses labels
     * @return array
     */
    public static function statusesLabels()
    {
        return self::$statusesLabels;
    }
    
    /**
     * Category status label
     * @return mixed $label
     */
    public function getStatusLabel() {
        $labels = $this->statusesLabels();
        if(array_key_exists($this->status, $labels)) {
            return $labels[$this->status];
        }
        return null;
    }
    
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'conf_rooms';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'people_min', 'people_max', 'status', 'type'], 'integer'],
            [['parent_id', 'name'], 'required'],
            [['price_1', 'price_3', 'price_24'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['image', 'oldImage'], 'string', 'max' => 255],
            [['description'], 'each', 'rule' => ['string']],
            [['name', 'title', 'meta_description', 'slug'], 'each', 'rule' => ['string', 'max' => 255]],
            [['confRoomFeatures'], 'each', 'rule' => ['integer']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'people_min' => 'Вместимость от',
            'people_max' => 'Вместимость до',
            'price_1' => Yii::t('app', 'за 1 годину'),
            'price_3' => Yii::t('app', 'за 3 години'),
            'price_24' => Yii::t('app', 'за день'),
            'image' => 'Фоновое изображение',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата редактирования',
            'name' => 'Название',
            'title' => 'Заголовок title',
            'meta_description' => 'Meta-описание',
            'description' => 'Описание',
            'slug' => 'Псевдоним',
            'confRoomFeatures' => 'Характеристики',
            'type' => 'Тип родительского элемента',
            'parent_id' => 'Родительский элемент',
        ];
    }

    /**
     * The category description relation
     * @param type $code
     * @return type
     */
    public function getDescr($code = null)
    {
        $langId = Languages::getLangId($code);

        return $this->hasOne(ConfRoomsDescriptions::className(), ['conf_room_id' => 'id'])
                ->where('{{conf_rooms_descriptions}}.lang_id = :lang_id', [':lang_id' => $langId]);
    }
    
    /**
     * The hotels features relation
     * @return mixed
     */
    public function getFeatures()
    {
        return $this->hasMany(ConfRoomsFeatures::className(), ['conf_room_id' => 'id']);
    }
}
