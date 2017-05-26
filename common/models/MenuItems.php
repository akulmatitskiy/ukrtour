<?php

namespace common\models;

use common\models\MenuItemsDescriptions;


/**
 * This is the model class for table "menu_items".
 *
 * @property integer $id
 * @property integer $menu_id
 * @property integer $status
 * @property integer $sort_order
 *
 * @property MenuItemsDescriptions[] $menuItemsDescriptions
 */
class MenuItems extends \yii\db\ActiveRecord {

    /**
     * main menu id
     */
    const MENU_TYPE_MAIN   = 1;
    //const MENU_TYPE_FOOTER = 2;
    
    /**
     *  Item statuses
     */
    const MENU_STATUS_INVISIBLE = 0;
    const MENU_STATUS_VISIBLE   = 1;

    /**
     * Item title
     * @var string $title
     */
    public $title;

    /**
     * Item name
     * @var string $name
     */
    public $name;

    /**
     * Item url
     * @var string $url
     */
    public $url;

    /**
     * Menu types labels
     * @var array 
     */
    private static $typesLabels = [
        self::MENU_TYPE_MAIN => 'Главное',
        //self::MENU_TYPE_FOOTER => 'В подвале',
    ];

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
    public function getTypeLabel()
    {
        $labels = $this->typesLabels();
        if(array_key_exists($this->menu_id, $labels)) {
            return $labels[$this->menu_id];
        }
        return null;
    }
    
     /**
     * Offer status labels
     * @var array 
     */
    private static $statusesLabels = [
        self::MENU_STATUS_INVISIBLE => 'Скрыт',
        self::MENU_STATUS_VISIBLE => 'Опубликован',
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
        return 'menu_items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_id', 'status', 'sort_order'], 'integer'],
            [['title', 'name', 'url', 'menu_id'], 'required'],
            [['title', 'name', 'url'], 'each', 'rule' => ['string', 'max' => 255]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'menu_id' => 'Меню',
            'status' => 'Статус',
            'sort_order' => 'Сортировка',
            'title' => 'Атрибут title',
            'name' => 'Название',
            'url' => 'Ссылка',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDescr($code = null)
    {
        $langId = Languages::getLangId($code);

        return $this->hasOne(MenuItemsDescriptions::className(), ['item_id' => 'id'])
                ->where('{{menu_items_descriptions}}.lang_id = :lang_id', [':lang_id' => $langId]);
    }

}
