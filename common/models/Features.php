<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "features".
 *
 * @property integer $id
 * @property string $icon
 * @property integer $status
 * @property integer $sort_order
 *
 * @property FeaturesDescriptions[] $featuresDescriptions
 */
class Features extends \yii\db\ActiveRecord
{
    /**
     * Features display statuses
     */
    const FEATURES_STATUS_INACTIVE = 0;
    const FEATURES_STATUS_ACTIVE = 1;
    
    /**
     * Features types
     */
    const FEATURES_TYPE_HOTEL = 1;
    const FEATURES_TYPE_ROOM = 2;
    const FEATURES_TYPE_CONF_ROOM = 3;
    
    
    /**
     * Feature title
     * @var string $title_hotel
     */
    public $title;
    
    /**
     * Statuses labels
     * @var type 
     */
    private static $statusesLabels = [
        self::FEATURES_STATUS_INACTIVE => 'Скрыт',
        self::FEATURES_STATUS_ACTIVE => 'Опубликован',
    ];
    
    /**
     * Types labels
     * @var type 
     */
    private static $typesLabels = [
        self::FEATURES_TYPE_HOTEL => 'Отель',
        self::FEATURES_TYPE_ROOM => 'Номер',
        self::FEATURES_TYPE_CONF_ROOM => 'Конференц-зал',
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
     * Statuses labels
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
    public function getTypeLabel() {
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
        return 'features';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'sort_order', 'type'], 'integer'],
            [['icon', 'title', 'type'], 'required'],
            [['icon'], 'string', 'max' => 255],
            [['title'], 'each', 'rule' => ['string', 'max' => 255]],
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
            'status' => 'Статус',
            'sort_order' => 'Сортировка',
            'title' => 'Заголовок',
            'type' => 'Тип',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDescr($code = null)
    {
        $langId = Languages::getLangId($code);

        return $this->hasOne(FeaturesDescriptions::className(), ['feature_id' => 'id'])
                ->where('{{features_descriptions}}.lang_id = :lang_id', [':lang_id' => $langId]);
    }
}
