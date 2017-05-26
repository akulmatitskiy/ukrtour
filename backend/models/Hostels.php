<?php

namespace backend\models;

use common\models\HostelsDescriptions;
use common\models\Languages;
use common\models\ServioCities;

/**
 * This is the model class for table "hostels".
 *
 * @property integer $id
 * @property integer $status
 * @property string $image
 * @property string $phone
 *
 * @property HostelsDescriptions[] $hostelsDescriptions
 */
class Hostels extends \common\models\Hostels {

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
                $model = HostelsDescriptions::findOne([
                        'hostel_id' => $this->id,
                        'lang_id' => $lang['id'],
                ]);

                if(empty($model)) {
                    // new entry
                    $model            = new HostelsDescriptions();
                    $model->hostel_id = $this->id;
                    $model->lang_id   = $lang['id'];
                }

                // Descr properties
                $model->title            = $this->title[$code];
                $model->annotation       = $this->annotation[$code];
                $model->description      = $this->description[$code];
                $model->meta_description = $this->meta_description[$code];
                $model->address          = $this->address[$code];

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
     * Load hostel description to the model
     * @return boolean
     */
    public function hostelDescr()
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
                $this->address[$code]          = $descr->address;
            }
        }
        return true;
    }
    
    public static function citiesTitles()
    {
        $cities = [];
        
        // Get all city + translates
        $citiesModel = ServioCities::find()->all();
        
        // Cities array
        foreach($citiesModel as $city) {
            $cities[$city->id] = $city->descr->name;
        }
        
        return $cities;
        
    }

}
