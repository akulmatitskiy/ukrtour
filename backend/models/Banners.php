<?php

namespace backend\models;

use Yii;
use common\models\Languages;
use common\models\BannersDescriptions;

/**
 * This is the model class for table "banners".
 *
 * @property integer $id
 * @property integer $type
 * @property string $image
 * @property integer $status
 * @property integer $sort_order
 *
 * @property BannersDescriptions[] $bannersDescriptions
 */
class Banners extends \common\models\Banners {

    /**
     * Save Banner image
     * @return boolean
     */
    public function saveImage()
    {
        $imageInfo = pathinfo($this->image);
        $directory = 'images/banners/' . $this->id;
        $filePath  = $directory . '/' . $imageInfo['basename'];

        // Create directory
        @mkdir($directory, 0777, true);



        // Skip already uploaded images
        Yii::trace($filePath);
        Yii::trace($this->image);
        
        if($filePath != trim($this->image, '/')) {
            // Copy file to images/banners
            if(!copy(Yii::getAlias('@backend/web' . $this->image), $filePath)) {
                return false;
            } 
        }
        $this->image = $imageInfo['basename'];
        return true;
    }

    /**
     * Save Banner descrioptions to db
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
                $model = BannersDescriptions::findOne([
                        'banner_id' => $this->id,
                        'lang_id' => $lang['id'],
                ]);

                if(empty($model)) {
                    // new entry
                    $model = new BannersDescriptions();
                }

                // Descr properties
                $model->banner_id = $this->id;
                $model->lang_id   = $lang['id'];
                $model->title     = $this->title[$code];
                $model->text      = $this->text[$code];
                $model->url       = $this->url[$code];
                $model->price     = $this->price[$code];

                if(!$model->save()) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Load Banner description to the model
     * @return boolean
     */
    public function bannerDescr()
    {
        $langs = Languages::getLangs();
        foreach($langs as $code => $lang) {
            // Get hotel description
            $descr = $this->getDescr($code)->one();

            // Assign properties
            if(!empty($descr)) {
                $this->title[$code] = $descr->title;
                $this->text[$code]  = $descr->text;
                $this->url[$code]   = $descr->url;
                $this->price[$code] = $descr->price;
            }
        }
        return true;
    }

}
