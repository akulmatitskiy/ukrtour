<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pages".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $status
 *
 * @property PagesDescriptions[] $pagesDescriptions
 */
class Pages extends \yii\db\ActiveRecord {

    /**
     *  Pages statuses
     */
    const PAGES_STATUS_INVISIBLE = 0;
    const PAGES_STATUS_VISIBLE   = 1;

    /**
     * Pages types
     */
    const PAGES_TYPE_HOME     = 1;
    const PAGES_TYPE_CONTACTS = 2;
    
    /**
     * Pages cache expiration
     * 24*60*60
     */
    const PAGES_EXPIRATION = 0;

    /**
     * Page title
     * @var string $title
     */
    public $title;

    /**
     * Page text
     * @var string $description
     */
    public $text;

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
     * Pages status labels
     * @var array 
     */
    private static $statusesLabels = [
        self::PAGES_STATUS_INVISIBLE => 'Скрыт',
        self::PAGES_STATUS_VISIBLE => 'Опубликован',
    ];

    /**
     * Pages types labels
     * @var array 
     */
    private static $typesLabels = [
        self::PAGES_TYPE_HOME => 'Главная',
        self::PAGES_TYPE_CONTACTS => 'Контакты',
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
    public function getStatusLabel()
    {
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
        return 'pages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'status'], 'integer'],
            ['title', 'required'],
            [['title', 'meta_description', 'h1', 'slug'], 'each', 'rule' => ['string', 'max' => 255]],
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
            'type' => 'Тип',
            'status' => 'Статус',
            'title' => 'Заголовок title',
            'description' => 'Описание',
            'address' => 'Адрес отеля',
            'meta_description' => 'Мета-описание',
            'h1' => 'Заголовок H1',
            'slug' => 'Псевдоним',
            'text' => 'Текст',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDescr($code = null)
    {
        $langId = Languages::getLangId($code);

        return $this->hasOne(PagesDescriptions::className(), ['page_id' => 'id'])
                ->where('{{pages_descriptions}}.lang_id = :lang_id', [':lang_id' => $langId]);
    }

}
