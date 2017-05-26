<?php

namespace backend\models;

use common\models\ToursDescriptions;
use common\models\Languages;

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
class Tours extends \common\models\Tours {

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
                $model = ToursDescriptions::findOne([
                        'tour_id' => $this->id,
                        'lang_id' => $lang['id'],
                ]);

                if(empty($model)) {
                    // new entry
                    $model = new ToursDescriptions();
                }

                // Descr properties
                $model->tour_id          = $this->id;
                $model->lang_id          = $lang['id'];
                $model->title            = $this->title[$code];
                $model->annotation       = $this->annotation[$code];
                $model->description      = $this->description[$code];
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
     * Load offer description to the model
     * @return boolean
     */
    public function tourDescr()
    {
        $langs = Languages::getLangs();
        foreach($langs as $code => $lang) {
            // Get hotel description
            $descr = $this->getDescr($code)->one();

            // Assign properties
            if(!empty($descr)) {
                $this->title[$code]            = $descr->title;
                $this->annotation[$code]       = $descr->annotation;
                $this->description[$code]      = $descr->description;
                $this->meta_description[$code] = $descr->meta_description;
                $this->slug[$code]             = $descr->slug;
            }
        }
        return true;
    }

}
