<?php

namespace backend\models;

use Yii;
use common\models\OffersDescriptions;
use common\models\Languages;

/**
 * This is the model class for table "offers".
 *
 * @property integer $id
 * @property integer $banner
 * @property integer $status
 * @property string $image
 * @property double $price
 */
class Offers extends \common\models\Offers {

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
                $model = OffersDescriptions::findOne([
                        'offer_id' => $this->id,
                        'lang_id' => $lang['id'],
                ]);

                if(empty($model)) {
                    // new entry
                    $model = new OffersDescriptions();
                }

                // Descr properties
                $model->offer_id         = $this->id;
                $model->lang_id          = $lang['id'];
                $model->title            = $this->title[$code];
                $model->annotation       = $this->annotation[$code];
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
     * Load offer description to the model
     * @return boolean
     */
    public function offerDescr()
    {
        $langs = Languages::getLangs();
        foreach($langs as $code => $lang) {
            // Get hotel description
            $descr = $this->getDescr($code)->one();

            // Assign properties
            if(!empty($descr)) {
                $this->title[$code]            = $descr->title;
                $this->annotation[$code]       = $descr->annotation;
                $this->text[$code]             = $descr->text;
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
        $filePath  = 'images/offers/';
        $path      = $filePath . $imageInfo['basename'];

        // skip same image
        if(trim($imageInfo['dirname'], '/') != trim($filePath, '/')) {
            // Create directory
            @mkdir($filePath, 0777, true);

            // Copy file to images/offers
            if(!copy(Yii::getAlias('@backend/web' . $image), $path)) {
                return false;
            }
        }
        $this->image = $imageInfo['basename'];
        return true;
    }

}
