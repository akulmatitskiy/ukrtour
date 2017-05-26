<?php

namespace backend\models;

use Yii;
use common\models\Languages;
use common\models\HotelsDescriptions;
use common\models\HotelsImages;
use common\models\ServioTranslates;
use backend\models\Features;
use yii\helpers\ArrayHelper;
use common\models\HotelsFeatures;
use common\models\GalleryImages;

/**
 * This is the model class for table "servio_hotels".
 *
 * @property integer $id
 * @property integer $cityId
 * @property string $alias
 * @property integer $serverId
 * @property integer $servioId
 * @property integer $tourTax
 * @property string $manager_emails
 * @property string $latitude
 * @property string $longitude
 * @property integer $visible
 * @property integer $rating
 */
class Hotels extends \common\models\Hotels {

    /**
     * Save hotel descrioptions to db
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
                $model = HotelsDescriptions::findOne([
                        'hotel_id' => $this->id,
                        'lang_id' => $lang['id'],
                ]);

                if(empty($model)) {
                    // new entry
                    $model = new HotelsDescriptions();
                }

                // Descr properties
                $model->hotel_id         = $this->id;
                $model->lang_id          = $lang['id'];
                $model->title            = $this->title[$code];
                $model->h1               = $this->h1[$code];
                $model->description      = $this->description[$code];
                $model->meta_description = $this->meta_description[$code];
                $model->address          = $this->address[$code];
                $model->map              = $this->map[$code];

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
     * Load hotel description to the model
     * @return boolean
     */
    public function hotelDescr()
    {
        $langs = Languages::getLangs();
        foreach($langs as $code => $lang) {
            // Get hotel description
            $descr = $this->getDescr($code)->one();

            // Assign properties
            if(!empty($descr)) {
                $this->title[$code]            = $descr->title;
                $this->h1[$code]               = $descr->h1;
                $this->description[$code]      = $descr->description;
                $this->meta_description[$code] = $descr->meta_description;
                $this->address[$code]          = $descr->address;
                $this->slug[$code]             = $descr->slug;
                $this->map[$code]              = $descr->map;
            }
        }
        return true;
    }

    /**
     * Get hotel name from servio module
     * @return mixed $name the hotel name
     */
    public function hotelName()
    {
        // model
        $model = ServioTranslates::findOne([
                'parentId' => $this->id,
                'parentType' => 'hotels',
                'isoLang' => 'ru',
        ]);

        if(!empty($model)) {
            $name = $model->name;
        } else {
            $name = null;
        }

        return $name;
    }

    public function hotelCity()
    {
        // model
        $model = ServioTranslates::findOne([
                'parentId' => $this->cityId,
                'parentType' => 'cities',
                'isoLang' => 'ru',
        ]);

        if(!empty($model)) {
            $name = $model->name;
        } else {
            $name = null;
        }

        return $name;
    }

    /**
     * Save image
     * @param type $image
     * @param type $main
     * @return boolean
     */
    public function saveImage($image, $main = 0)
    {
        $imageInfo = pathinfo($image);
        $suffix    = '';
        $i         = 1;
        do {
            // Search image in DB
            $fileName = $imageInfo['filename']
                . $suffix . '.' . $imageInfo['extension'];
            $search   = HotelsImages::find()
                ->where(['image' => $fileName])
                ->exists();
            $suffix   = '-' . $i++;
        } while($search);

        $filePath = 'images/hotels/' . $fileName;
        // Copy file to images/hotels
        if(copy(Yii::getAlias('@backend/web' . $image), $filePath)) {
            // search exist image
            $model = HotelsImages::findOne([
                    'hotel_id' => $this->id,
                    'main' => $main,
            ]);

            if(empty($model)) {
                // New image
                $model = new HotelsImages();
            }

            // load properties
            $model->hotel_id = $this->id;
            $model->image    = $fileName;
            $model->main     = $main;
            if($model->save()) {
                return $model->id;
            }
        }
        return false;
    }

    /**
     * Features available for hotel
     * @return array $features The hotel features 
     */
    public function featuresList()
    {
        $model = Features::find()
            ->select('{{features}}.id as id, {{features_descriptions}}.title as title')
            ->joinWith('descr')
            ->where([
                'status' => Features::FEATURES_STATUS_ACTIVE,
                'type' => Features::FEATURES_TYPE_HOTEL
            ])
            ->asArray()
            ->all();

        $features = ArrayHelper::map($model, 'id', 'title');
        return $features;
    }

    /**
     * Save hotels features
     * @return boolean
     */
    public function saveFeatures()
    {
        // Clean features
        if(HotelsFeatures::deleteAll(['hotel_id' => $this->id]) !== null) {
            if(!empty($this->hotelFeatures)) {
                // Add features
                foreach($this->hotelFeatures as $feature) {
                    $model             = new HotelsFeatures();
                    $model->hotel_id   = $this->id;
                    $model->feature_id = $feature;
                    if(!$model->save()) {
                        Yii::error('Error save hotels feature');
                        return false;
                    }
                }
            }
            return true;
        } else {
            Yii::error('Error clean hotels features');
            return false;
        }
    }

    public function hotelFeatures()
    {
        //$features = [];
        // Get faetures
        $features = HotelsFeatures::find()
            ->where(['hotel_id' => $this->id])
            ->asArray()
            ->all();

        return ArrayHelper::map($features, 'feature_id', 'feature_id');
    }
    
    /**
     * Save gallery images
     * @return boolean
     */
    public function saveImages()
    {
        $images = explode(', ', $this->images);
        foreach($images as $image) {
            $imageInfo = pathinfo($image);
            $directory = 'images/gallery/' . $this->id;
            $filePath  = $directory  . '/' . $imageInfo['basename'];
            
            // Create directory
            @mkdir($directory, 0777, true);

            // Copy file to images/gallery
            if(!copy(Yii::getAlias('@backend/web' . $image), $filePath)) {
                return false;
            }

            // Search image in DB
            $modelImage = GalleryImages::findOne([
                    'image' => $imageInfo['basename'],
                    'gallery_id' => $this->id
            ]);

            if($modelImage == null) {
                // Save image name to gallery_images
                $modelImage             = new GalleryImages();
                $modelImage->gallery_id = $this->id;
                $modelImage->image      = $imageInfo['basename'];
                $modelImage->type      = GalleryImages::GALLERY_TYPE_HOTEL;
                
                if(!$modelImage->save()) {
                    return false;
                }
            }
            
        }
        return true;
    }

}
