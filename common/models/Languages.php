<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Description of Languages
 *
 * @author igor
 */
class Languages extends Model {

    // Langs
    const LANG_UK = 'uk-UA';
    const LANG_RU = 'ru-RU';
    const LANG_EN = 'en-US';

    // Languages ids   
    private static $langs = [
        self::LANG_UK => [
            'id' => 1,
            'label' => 'Українська',
            'iso' => 'uk',
            'iso3' => 'ukr'
        ],
        self::LANG_RU => [
            'id' => 2,
            'label' => 'Русский',
            'iso' => 'ru',
            'iso3' => 'rus'
        ],
        self::LANG_EN => [
            'id' => 3,
            'label' => 'English',
            'iso' => 'en',
            'iso3' => 'eng'
        ],
    ];

    /**
     * Return all lang
     * @return array all langs
     */
    public static function getLangs()
    {
        return self::$langs;
    }

    /**
     * Returl lang
     * @param string $code the lang code 
     * @return array $lang
     */
    public static function getLang($code)
    {
        if(array_key_exists($code, self::$langs)) {
            $lang = self::$langs[$code];
        } else {
            $lang = null;
        }
        return $lang;
    }

    /**
     * Return current lang ID
     * @return int the lang ID
     */
    public static function getCurrentLangId()
    {
        // Get  id
        $lang = self::getLang(Yii::$app->language);
        return $lang['id'];
    }

    /**
     * 	Return lang code
     * @return string
     * @param int $langId
     */
    public static function langCode($langId)
    {
        foreach(static::$langs as $code => $params) {
            if($langId == $params['id']) {
                return $code;
            }
        }
        return Yii::$app->language;
    }

    /**
     * Return lang ID
     * @param mixed $code the language code
     * @return integer $lang the language ID
     */
    public static function getLangId($code)
    {
        // DEfault value
        if($code === null) {
            // Get current lang
            $code = Yii::$app->language;
        }

        // Get lang id
        $lang = self::getLang($code);

        return $lang['id'];
    }

    /**
     * Return lang ISO code (2 letters)
     * @param mixed $code the language code
     * @return integer $lang the language ID
     */
    public static function getIsoCode($code = null, $type = 'iso')
    {
        // DEfault value
        if($code === null) {
            // Get current lang
            $code = Yii::$app->language;
        }

        // Get lang id
        $lang = self::getLang($code);

        return $lang[$type];
    }

    /**
     * Lang code by iso code
     * @param type $iso
     * @return mixed lang code
     */
    public static function getLangByIso($iso = null)
    {
        // Default value
        if($iso === null) {
            // Get current lang
            return Yii::$app->language;
        }

        $langs = self::getLangs();
        // Search
        foreach($langs as $code => $lang) {
            if(in_array($iso, $lang)) {
                return $code;
            }
        }

        return false;
    }

    /**
     * Generate url prefix
     * @param type $lang
     * @return string $prefix
     */
    public static function urlPrefix($lang)
    {
        // Default prefix
        $prefix = '/';
        if($lang == self::LANG_UK) {
            return $prefix;
        }
        // Get lang code
        $code = self::getIsoCode($lang);
        
        $prefix .= $code . '/';
        
        return $prefix;
    }

}
