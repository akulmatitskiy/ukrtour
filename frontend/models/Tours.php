<?php

namespace frontend\models;

use yii\helpers\StringHelper;
use common\models\Images;
use yii\helpers\Url;

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

    public static function getTours($limit = false)
    {
        // Get offers model
        $query = self::find()
            ->where([
            'status' => self::TOURS_STATUS_VISIBLE,
        ]);

        // Limit
        if($limit) {
            $query->limit($limit);
        }

        $model = $query->all();

        if(!empty($model)) {
            // Offers array
            $tours = [];
            foreach($model as $item) {
                // Title
                $title = '';
                if(isset($item->descr->title)) {
                    $title = StringHelper::truncate($item->descr->title, 70);
                }

                // Image
                if(!empty($item->image)) {
                    $image = $item->image;
                } else {
                    $image = Images::PLACEHOLDER;
                }
                $imageUrl = Images::resize($image, 'offer-bg', 'tour', 'tour');

                // annotation
                $annotation = '';
                if(isset($item->descr->annotation)) {
                    $annotation = $item->descr->annotation;
                }

                // Url
                if(!empty($item->descr->slug)) {
                    $url = Url::to(['tours/view', 'slug' => $item->descr->slug]);
                } else {
                    $url = '#';
                }

                // Push to array
                $tours[] = [
                    'title' => $title,
                    'image' => $imageUrl,
                    'annotation' => $annotation,
                    'url' => $url,
                ];
            }

            return $tours;
        } else {
            return false;
        }
    }

    /**
     * Default image url
     * @return boolean
     */
    public function defaultImage()
    {
        // Image
        if(!empty($this->image)) {
            $image = $this->image;
        } else {
            $image = Images::PLACEHOLDER;
        }
        $imageUrl = Images::resize($image, 'offer-big', 'tour', 'tour-big');
        $this->image = $imageUrl;
        return true;
    }

}
