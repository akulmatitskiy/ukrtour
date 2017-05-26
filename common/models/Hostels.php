<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hostels".
 *
 * @property integer $id
 * @property integer $status
 * @property string $image
 * @property string $phone
 *
 * @property HostelsDescriptions[] $hostelsDescriptions
 */
class Hostels extends \yii\db\ActiveRecord {

    /**
     *  Tour statuses
     */
    const HOSTELS_STATUS_INVISIBLE = 0;
    const HOSTELS_STATUS_VISIBLE   = 1;

    /**
     * Tour title
     * @var string $title
     */
    public $title;

    /**
     * Tour text
     * @var string $description
     */
    public $description;

    /**
     * Tour annotation
     * @var string $h1
     */
    public $annotation;

    /**
     * Meta description tag
     * @var string $meta_description
     */
    public $meta_description;

    /**
     * Alias
     * @var string $slug
     */
    public $slug;
    
    /**
     * Gallery images
     * @var string $images
     */
    public $images;
    
    /**
     * Address
     * @var string $address
     */
    public $address;

    /**
     * Tour status labels
     * @var array 
     */
    private static $statusesLabels = [
        self::HOSTELS_STATUS_INVISIBLE => 'Скрыт',
        self::HOSTELS_STATUS_VISIBLE => 'Опубликован',
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
     * Tour status label
     * @return mixed $label
     */
    public function getStatusLabel()
    {
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
        return 'hostels';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'region', 'city_id'], 'required'],
            [['status', 'region', 'city_id'], 'integer'],
            [['image', 'phone'], 'string', 'max' => 255],
            [['title', 'meta_description', 'slug', 'address'], 'each', 'rule' => ['string', 'max' => 255]],
            [['annotation'], 'each', 'rule' => ['string', 'max' => 130]],
            [['description',], 'each', 'rule' => ['string']],
            [['images', 'latitude', 'longitude'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Статус',
            'image' => 'Фоновое изображение',
            'phone' => 'Телефон',
            'title' => 'Заголовок',
            'annotation' => 'Аннотация',
            'meta_description' => 'Meta Description',
            'description' => 'Описание',
            'slug' => 'Псевдоним',
            'address' => 'Адрес',
            'region' => 'Область',
            'city_id' => 'Город',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDescr($code = null)
    {
        $langId = Languages::getLangId($code);

        return $this->hasOne(HostelsDescriptions::className(), ['hostel_id' => 'id'])
                ->where('{{hostels_descriptions}}.lang_id = :lang_id', [':lang_id' => $langId]);
    }

}
