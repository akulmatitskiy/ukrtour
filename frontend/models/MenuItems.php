<?php

namespace frontend\models;

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

    public static function getMainMenu()
    {
        $menu  = [];
        $items = MenuItems::findAll([
                'menu_id' => self::MENU_TYPE_MAIN,
                'status' => self::MENU_STATUS_VISIBLE,
        ]);

        if($items != null) {

            foreach($items as $item) {
                $menu[] = [
                    'name' => $item->descr->name,
                    'url' => $item->descr->url,
                    'title' => $item->descr->title
                ];
            }
        }

        return $menu;
    }

}
