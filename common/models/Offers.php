<?php

namespace common\models;

use common\models\OffersDescriptions;

/**
 * This is the model class for table "offers".
 *
 * @property integer $id
 * @property integer $banner
 * @property integer $status
 * @property string $image
 * @property double $price
 */
class Offers extends \yii\db\ActiveRecord {

    /**
     *  Offer statuses
     */
    const OFFERS_STATUS_INVISIBLE = 0;
    const OFFERS_STATUS_VISIBLE   = 1;

    /**
     *  Offer types
     */
    const OFFERS_TYPE_SPECIAL = 1;

    /**
     * Offer title
     * @var string $title
     */
    public $title;

    /**
     * Offer text
     * @var string $description
     */
    public $text;

    /**
     * Offer annotation
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
     * Offer status labels
     * @var array 
     */
    private static $statusesLabels = [
        self::OFFERS_STATUS_INVISIBLE => 'Скрыт',
        self::OFFERS_STATUS_VISIBLE => 'Опубликован',
    ];
    
    /**
     * Offer type labels
     * @var array 
     */
    private static $typesLabels = [
        self::OFFERS_TYPE_SPECIAL => 'Акция',
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
     * Offer status label
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
     * Offer type label
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
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'offers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'type'], 'integer'],
            [['title', 'type'], 'required'],
            [['image'], 'string', 'max' => 255],
            [['title', 'meta_description', 'slug'], 'each', 'rule' => ['string', 'max' => 255]],
            [['annotation'], 'each', 'rule' => ['string', 'max' => 130]],
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
            'status' => 'Статус',
            'image' => 'Изображение',
            'title' => 'Заголовок',
            'annotation' => 'Аннотация',
            'meta_description' => 'Мета-описание',
            'slug' => 'Псевдоним',
            'text' => 'Описание',
            'type' => 'Тип',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDescr($code = null)
    {
        $langId = Languages::getLangId($code);

        return $this->hasOne(OffersDescriptions::className(), ['offer_id' => 'id'])
                ->where('{{offers_descriptions}}.lang_id = :lang_id', [':lang_id' => $langId]);
    }

}
