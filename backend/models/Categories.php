<?php

namespace backend\models;

use Yii;
use common\models\Languages;
use common\models\CategoriesDescriptions;

/**
 * This is the model class for table "categories".
 *
 * @property integer $id
 * @property string $icon
 * @property string $image
 * @property integer $status
 * @property integer $sort_order
 */
class Categories extends \common\models\Categories {

    /**
     * Save category descriptions to db
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
                $model = CategoriesDescriptions::findOne([
                        'category_id' => $this->id,
                        'lang_id' => $lang['id'],
                ]);

                if(empty($model)) {
                    // new entry
                    $model = new CategoriesDescriptions();
                }

                // Descr properties
                $model->category_id      = $this->id;
                $model->lang_id          = $lang['id'];
                $model->title            = $this->title[$code];
                $model->h1               = $this->h1[$code];
                $model->annotation       = $this->annotation[$code];
                $model->text             = $this->text[$code];
                $model->meta_title       = $this->meta_title[$code];
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
     * Load category description to the model
     * @return boolean
     */
    public function categDescr()
    {
        $langs = Languages::getLangs();
        foreach($langs as $code => $lang) {
            // Get hotel description
            $descr = $this->getDescr($code)->one();

            // Assign properties
            if(!empty($descr)) {
                $this->title[$code]            = $descr->title;
                $this->h1[$code]               = $descr->h1;
                $this->annotation[$code]       = $descr->annotation;
                $this->text[$code]             = $descr->text;
                $this->meta_title[$code]       = $descr->meta_title;
                $this->meta_description[$code] = $descr->meta_description;
                $this->slug[$code]             = $descr->slug;
            }
        }
        return true;
    }

    /**
     * Save image
     * @param type $image
     * @return boolean
     */
    public function saveImage($image)
    {
        $imageInfo = pathinfo($image);
        $filePath = 'images/' . $imageInfo['basename'];
        
        // Copy file to images/categories
        if(!copy(Yii::getAlias('@backend/web' . $image), $filePath)) {
            return false;
        }
        $this->image = $imageInfo['basename'];
        return true;
    }


}
