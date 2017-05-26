<?php

namespace common\models;

use Yii;
use common\models\HotelsDescriptions;
use common\models\Languages;
use common\models\HotelsFeatures;

/**
 * This is the model class for table "servio_hotels".
 *
 * @property integer $id
 * @property integer $cityId
 * @property string $alias
 * @property integer $serverId
 * @property integer $servioId
 * @property integer $tourTax
 * @property string $manager_emails
 * @property string $latitude
 * @property string $longitude
 * @property integer $visible
 * @property integer $rating
 */
class Hotels extends \yii\db\ActiveRecord {

    /**
     *  Hotels statuses
     */
    const HOTEL_STATUS_INVISIBLE = 0;
    const HOTEL_STATUS_VISIBLE   = 1;
    
    /**
     * Hotel title
     * @var string $title
     */
    public $title;

    /**
     * Hotel description
     * @var string $description
     */
    public $description;

    /**
     * Hotel address
     * @var string $address
     */
    public $address;

    /**
     * H1 tag
     * @var string $h1
     */
    public $h1;

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
     * Hotel image
     * @var string $image the hotel background image
     */
    public $image;

    /**
     * Hotels features
     * @var array
     */
    public $hotelFeatures;
    
    /**
     * Hotels map link
     * @var array
     */
    public $map;
    
    /**
     * Gallery images
     * @var array $images
     */
    public $images;
    

    /**
     * Statuses labels
     * @var type 
     */
    private static $statusesLabels = [
        self::HOTEL_STATUS_INVISIBLE => 'Скрыт',
        self::HOTEL_STATUS_VISIBLE => 'Опубликован',
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
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'servio_hotels';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cityId', 'visible', 'rating', 'region', 'sort_order'], 'integer'],
            ['title', 'required'],
            [['phone', 'image'], 'string', 'max' => 50],
            [['rating'], 'integer', 'min' => 0, 'max' => 5],
            [['title', 'address', 'meta_description', 'h1', 'slug'], 'each', 'rule' => ['string', 'max' => 255]],
            [['description', 'map'], 'each', 'rule' => ['string']],
            [['hotelFeatures'], 'each', 'rule' => ['integer']],
            [['dist_aero', 'dist_railway', 'dist_avto', 'images'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cityId' => 'City ID',
            'alias' => 'Alias',
            'serverId' => 'Server ID',
            'servioId' => 'Servio ID',
            'tourTax' => 'Tour Tax',
            'manager_emails' => 'Manager Emails',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'visible' => 'Статус',
            'rating' => 'Рейтинг',
            'title' => 'Заголовок title',
            'description' => 'Описание',
            'address' => 'Адрес отеля',
            'meta_description' => 'Мета-описание',
            'h1' => 'Заголовок H1',
            'slug' => 'Псевдоним',
            'phone' => 'Телефон',
            'image' => 'Фоновое изображение',
            'images' => 'Галерея',
            'region' => 'Область',
            'hotelFeatures' => 'Характеристики',
            'map' => 'Ссылка на карту',
            'dist_aero' => Yii::t('app', 'від аэропорту'),
            'dist_railway' => Yii::t('app', 'від з/д вокзалу'),
            'dist_avto' => Yii::t('app', 'від авто-вокзалу'),
            'sort_order' => 'Сортировка',
        ];
    }

    /**
     * The hotel description relation
     * @param type $code
     * @return type
     */
    public function getDescr($code = null)
    {
        $langId = Languages::getLangId($code);

        return $this->hasOne(HotelsDescriptions::className(), ['hotel_id' => 'id'])
                ->where('{{hotels_descriptions}}.lang_id = :lang_id', [':lang_id' => $langId]);
    }

    /**
     * The hotels features relation
     * @return mixed
     */
    public function getFeatures()
    {
        return $this->hasMany(HotelsFeatures::className(), ['hotel_id' => 'id']);
    }

}
