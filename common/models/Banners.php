<?php

namespace common\models;

use Yii;
use common\models\Languages;
use common\models\BannersDescriptions;
use common\models\Images;

/**
 * This is the model class for table "banners".
 *
 * @property integer $id
 * @property integer $type
 * @property string $image
 * @property integer $status
 * @property integer $sort_order
 *
 * @property BannersDescriptions[] $bannersDescriptions
 */
class Banners extends \yii\db\ActiveRecord {

    /**
     * Banners types
     */
    const BANNERS_TYPE_OFFER = 1;

    /**
     *  Banners statuses
     */
    const BANNERS_STATUS_INVISIBLE = 0;
    const BANNERS_STATUS_VISIBLE   = 1;

    /**
     * Banners categories
     */
    const BANNERS_CATEGORY_CONFERENCE = 4;
    
    /**
     * Banners cache
     */
    const BANNERS_CACHE_EXPIRATION = 3600;

    /**
     * Banner title
     * @var string $title
     */
    public $title;

    /**
     * Banner price info
     * @var string $price
     */
    public $price;

    /**
     * Banner url
     * @var string $url
     */
    public $url;

    /**
     * Banner description
     * @var string $text
     */
    public $text;

    /**
     * Types labels
     * @var array $typesLabels
     */
    public static function typesLabels()
    {
        return [
            self::BANNERS_TYPE_OFFER => Yii::t('app', 'Акція'),
        ];
    }

    /**
     * Banners statuses labels
     * @var array $statusesLabels
     */
    private static $statusesLabels = [
        self::BANNERS_STATUS_INVISIBLE => 'Скрыт',
        self::BANNERS_STATUS_VISIBLE => 'Опубликован',
    ];

    /**
     * Banners statuses labels
     * @return array $statusesLabels
     */
    public static function statusesLabels()
    {
        return self::$statusesLabels;
    }

    /**
     * Banners categories labels
     * @var array $statusesLabels
     */
    private static $categoriesLabels = [
        self::BANNERS_CATEGORY_CONFERENCE => 'Конференц сервис',
    ];

    /**
     * Banners statuses labels
     * @return array $statusesLabels
     */
    public static function categoriesLabels()
    {
        return self::$categoriesLabels;
    }

    /**
     * Banner status label
     * @return mixed $label
     */
    public function getTypeLabel()
    {
        $labels = $this->typesLabels();
        if(array_key_exists($this->type, $labels)) {
            return $labels[$this->type];
        }
        return null;
    }

    /**
     * Banner status label
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
     * Banner category label
     * @return mixed $label
     */
    public function getCategoryLabel()
    {
        $labels = $this->categoriesLabels();
        if(array_key_exists($this->category, $labels)) {
            return $labels[$this->category];
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'banners';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'status', 'sort_order', 'category'], 'integer'],
            [['title', 'url', 'price', 'text'], 'required'],
            [['title', 'url', 'price', 'text'], 'each', 'rule' => ['string', 'max' => 255]],
            [['image'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Тип',
            'image' => 'Изображение',
            'status' => 'Статус',
            'sort_order' => 'Сортировка',
            'title' => 'Заголовок',
            'url' => 'Url',
            'price' => 'Цена (предложение)',
            'text' => 'Описание',
            'category' => 'Отображать в категориях',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDescr($code = null)
    {
        $langId = Languages::getLangId($code);

        return $this->hasOne(BannersDescriptions::className(), ['banner_id' => 'id'])
                ->where('{{banners_descriptions}}.lang_id = :lang_id', [':lang_id' => $langId]);
    }

    /**
     * Banners for carousel
     * @return array $banners the carousel items
     */
    public static function getBanners($categ = null)
    {
        $banners = [];
        if($categ != self::BANNERS_CATEGORY_CONFERENCE) {
            $categ = null;
        }
        // Get banners items
        $items = self::find()
        ->where([
                'status' => self::BANNERS_STATUS_VISIBLE,
                'category' => $categ,
        ])
        ->orderBy('sort_order')
        ->all();

        foreach($items as $item) {
            // Image
            if(!empty($item->image)) {
                $image = $item->image;
            } else {
                $image = Images::PLACEHOLDER;
            }
            $imageUrl = Images::resize($image, 'banners', 'banners/' . $item->id , 'banners/' . $item->id);

            $banners[] = [
                'title' => $item->descr->title,
                'price' => $item->descr->price,
                'description' => $item->descr->text,
                'link' => $item->descr->url,
                'img' => $imageUrl,
                'type' => $item->getTypeLabel(),
            ];
        }

        return $banners;
    }

}
