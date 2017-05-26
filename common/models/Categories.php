<?php

namespace common\models;

use common\models\CategoriesDescriptions;
use common\models\Images;
use yii\helpers\Url;

/**
 * This is the model class for table "categories".
 *
 * @property integer $id
 * @property string $icon
 * @property string $image
 * @property integer $status
 * @property integer $sort_order
 */
class Categories extends \yii\db\ActiveRecord {

    /**
     * Cache expiration
     * 24*60*60
     */
    const CATEGORIES_EXPIRATION = 0;
    
    /**
     * Categories display statuses
     */
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    
    /**
     * Types of categories
     */
    const CATEGORY_TYPE_DEFAULT = 0;
    const CATEGORY_TYPE_HOTELS = 1;
    const CATEGORY_TYPE_OFFERS = 2;
    const CATEGORY_TYPE_CONF_ROOMS = 3;
    const CATEGORY_TYPE_TOURS = 4;
    const CATEGORY_TYPE_HOSTEL = 5;
    
    /**
     * Statuses labels
     * @var type 
     */
    private static $statusesLabels = [
        self::STATUS_INACTIVE => 'Скрыта',
        self::STATUS_ACTIVE => 'Опубликована',
    ];
    
    /**
     * Types labels
     * @var type 
     */
    private static $typesLabels = [
        self::CATEGORY_TYPE_DEFAULT => 'По умолчанию (сетка)',
        self::CATEGORY_TYPE_HOTELS => 'Отели',
        self::CATEGORY_TYPE_OFFERS => 'Акции',
        self::CATEGORY_TYPE_CONF_ROOMS => 'Конференц -сервис',
        self::CATEGORY_TYPE_TOURS => 'Туры по Украине',
        self::CATEGORY_TYPE_HOSTEL => 'Турбазы',
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
     * Types labels
     * @return array
     */
    public static function typesLabels()
    {
        return self::$typesLabels;
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
     * Category status label
     * @return mixed $label
     */
    public function getTypeLabel() {
        $labels = $this->typesLabels();
        if(array_key_exists($this->type, $labels)) {
            return $labels[$this->type];
        }
        return null;
    }

    /**
     * The category title, display on home page
     * @var string $title
     */
    public $title;

    /**
     * The category annotation, display on home page
     * @var string $annotation
     */
    public $annotation;

    /**
     * The category h1, display on category page
     * @var string $h1 
     */
    public $h1;

    /**
     *  SEO text on category page
     * @var string $text
     */
    public $text;

    /**
     * <title> tag
     * @var string $meta_title
     */
    public $meta_title;

    /**
     *  Meta-description tag
     * @var string $meta_description
     */
    public $meta_description;

    /**
     * Category alias
     * @var string
     */
    public $slug;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'type'], 'integer'],
            [['title', 'type'], 'required'],
            ['sort_order', 'integer', 'min' => -99, 'max' => 99],
            [['icon', 'image'], 'string', 'max' => 255],
            [['title', 'annotation', 'h1', 'meta_title', 'meta_description', 'slug'], 'each', 'rule' => ['string', 'max' => 255]],
            [['text'], 'each', 'rule' => ['string']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icon' => 'Иконка',
            'image' => 'Изображение',
            'status' => 'Статус',
            'sort_order' => 'Сортировка',
            'title' => 'Заголовок',
            'annotation' => 'Аннотация',
            'h1' => 'Заголовок H1',
            'text' => 'Текст',
            'meta_title' => 'Meta Title',
            'meta_desctiption' => 'Meta Desctiption',
            'slug' => 'Псевдоним',
            'type' => 'Тип',
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

        return $this->hasOne(CategoriesDescriptions::className(), ['category_id' => 'id'])
                ->where('{{categories_descriptions}}.lang_id = :lang_id', [':lang_id' => $langId]);
    }
    
    /**
     * Categories for home page
     * @param integer $limit
     * @return array $categories the categories
     */
    public static function homeCategories($limit = 4) {
        // Get categories model
        $model = Categories::find()
            ->where([
                'status' => Categories::STATUS_ACTIVE
            ])
            ->limit($limit)
            ->orderBy('sort_order')
            ->all();
        
        // Categories array
        $categories = [];
        foreach($model as $item) {
            // Image
            if(!empty($item->image)) {
                $image = $item->image;
            } else {
                $image = Images::PLACEHOLDER;
            }
            $imageUrl = Images::resize($image, 'categories');
            
            $categories[] = [
                'image' => $imageUrl,
                'url' => Url::to(['categories/view', 'slug' => $item->descr->slug]),
                'icon' => $item->icon,
                'title' => $item->descr->title,
                'annotation' => $item->descr->annotation,
            ];
        }
        return $categories;
    }
    
     /**
     * Category model
     * @param type $slug
     * @return object $category
     */
    public static function getCategoryBySlug($slug)
    {
        $category = Categories::find()
            ->joinWith('descr')
            ->where('slug = :slug', [':slug' => $slug])
            ->andWhere(['status' => Categories::STATUS_ACTIVE])
            ->one();
        return $category;
    }
    
    /**
     * Offers type
     * @return integer The offer type
     */
    public function getOfferType() {
        $types = [
            self::CATEGORY_TYPE_OFFERS => Offers::OFFERS_TYPE_SPECIAL,
            self::CATEGORY_TYPE_TOURS => Offers::OFFERS_TYPE_TOUR,
            self::CATEGORY_TYPE_HOSTEL => Offers::OFFERS_TYPE_HOSTEL,
        ];
        if(array_key_exists($this->type, $types)) {
            return $types[$this->type];
        }
        return false;
    }

}
