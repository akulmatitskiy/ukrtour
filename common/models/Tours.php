<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tours".
 *
 * @property integer $id
 * @property integer $status
 * @property string $image
 * @property string $phone
 *
 * @property ToursDescriptions[] $toursDescriptions
 */
class Tours extends \yii\db\ActiveRecord {

    /**
     *  Tour statuses
     */
    const TOURS_STATUS_INVISIBLE = 0;
    const TOURS_STATUS_VISIBLE   = 1;

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
     * Tour status labels
     * @var array 
     */
    private static $statusesLabels = [
        self::TOURS_STATUS_INVISIBLE => 'Скрыт',
        self::TOURS_STATUS_VISIBLE => 'Опубликован',
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
        return 'tours';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['status'], 'integer'],
            [['image', 'phone'], 'string', 'max' => 255],
            [['title', 'meta_description', 'slug'], 'each', 'rule' => ['string', 'max' => 255]],
            [['annotation'], 'each', 'rule' => ['string', 'max' => 130]],
            [['description',], 'each', 'rule' => ['string']],
            ['images', 'string'],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDescr($code = null)
    {
        $langId = Languages::getLangId($code);

        return $this->hasOne(ToursDescriptions::className(), ['tour_id' => 'id'])
                ->where('{{tours_descriptions}}.lang_id = :lang_id', [':lang_id' => $langId]);
    }

}
