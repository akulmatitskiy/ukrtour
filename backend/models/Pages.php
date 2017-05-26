<?php

namespace backend\models;

use common\models\Languages;
use common\models\PagesDescriptions;

/**
 * This is the model class for table "pages".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $status
 *
 * @property PagesDescriptions[] $pagesDescriptions
 */
class Pages extends \common\models\Pages {

    /**
     * Save page descrioptions to db
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
                $model = PagesDescriptions::findOne([
                        'page_id' => $this->id,
                        'lang_id' => $lang['id'],
                ]);

                if(empty($model)) {
                    // new entry
                    $model = new PagesDescriptions();
                }

                // Descr properties
                $model->page_id          = $this->id;
                $model->lang_id          = $lang['id'];
                $model->title            = $this->title[$code];
                $model->h1               = $this->h1[$code];
                $model->text             = $this->text[$code];
                $model->meta_description = $this->meta_description[$code];

                // Slug
                if(!empty($this->slug[$code])) {
                    $model->detachBehavior('slug');
                    $model->slug = $this->slug[$code];
                }

                if(!$model->save()) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Load page description to the model
     * @return boolean
     */
    public function pageDescr()
    {
        $langs = Languages::getLangs();
        foreach($langs as $code => $lang) {
            // Get hotel description
            $descr = $this->getDescr($code)->one();

            // Assign properties
            if(!empty($descr)) {
                $this->title[$code]            = $descr->title;
                $this->h1[$code]               = $descr->h1;
                $this->text[$code]             = $descr->text;
                $this->meta_description[$code] = $descr->meta_description;
                $this->slug[$code]             = $descr->slug;
            }
        }
        return true;
    }
    
    /**
     * Url in hint
     * @param type $lang
     * @param type $slug
     * @return string
     */
    public static function genUrl($lang, $slug) {
        $prefix = Languages::urlPrefix($lang);
        $url = $prefix . 'pages/' . $slug;
        return $url;
    }

}
