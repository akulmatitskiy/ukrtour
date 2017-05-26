<?php

namespace backend\models;

use common\models\FeaturesDescriptions;
use common\models\Languages;

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
class Features extends \common\models\Features {

    /**
     * Save features descriptions to db
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
                $model = FeaturesDescriptions::findOne([
                        'feature_id' => $this->id,
                        'lang_id' => $lang['id'],
                ]);

                if(empty($model)) {
                    // new entry
                    $model = new FeaturesDescriptions();
                }

                // Descr properties
                $model->feature_id = $this->id;
                $model->lang_id      = $lang['id'];
                $model->title        = $this->title[$code];

                if(!$model->save()) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Load features description to the model
     * @return boolean
     */
    public function featuresDescr()
    {
        $langs = Languages::getLangs();
        foreach($langs as $code => $lang) {
            // Get hotel description
            $descr = $this->getDescr($code)->one();

            // Assign properties
            if(!empty($descr)) {
                $this->title[$code] = $descr->title;
            }
        }
        return true;
    }

}
