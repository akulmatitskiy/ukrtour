<?php

namespace backend\models;

use common\models\Languages;
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
class MenuItems extends \common\models\MenuItems {

    /**
     * Save offer descrioptions to db
     * @return boolean
     */
    public function saveDescr()
    {
        $langs = Languages::getLangs();

        // save
        foreach($langs as $code => $lang) {
            // Skip empty description

            if(!empty($this->title[$code])) {

                // find descr
                $model = MenuItemsDescriptions::findOne([
                        'item_id' => $this->id,
                        'lang_id' => $lang['id'],
                ]);

                if(empty($model)) {
                    // new entry
                    $model = new MenuItemsDescriptions();
                }

                // Descr properties
                $model->item_id = $this->id;
                $model->lang_id = $lang['id'];
                $model->title   = $this->title[$code];
                $model->name    = $this->name[$code];
                $model->url     = $this->url[$code];

                if(!$model->save()) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Load offer description to the model
     * @return boolean
     */
    public function menuItemDescr()
    {
        $langs = Languages::getLangs();
        foreach($langs as $code => $lang) {
            // Get hotel description
            $descr = $this->getDescr($code)->one();

            // Assign properties
            if(!empty($descr)) {
                $this->title[$code]            = $descr->title;
                $this->name[$code]       = $descr->name;
                $this->url[$code]             = $descr->url;
            }
        }
        return true;
    }

}
