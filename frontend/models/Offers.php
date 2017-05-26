<?php

namespace frontend\models;

use yii\helpers\StringHelper;
use common\models\Images;
use yii\helpers\Url;

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

    // 60*60
    const OFFERS_LIST_EXPIRATION = 3600;

    /**
     * Offers
     * @param integer $type the offer type
     * @param integer $limit
     * @return boolean
     */
    public static function getOffers($limit = false)
    {
        // Get offers model
        $query = self::find()
            ->where([
            'status' => self::OFFERS_STATUS_VISIBLE,
        ]);

        // Limit
        if($limit) {
            $query->limit($limit);
        }

        $model = $query->all();

        if(!empty($model)) {
            // Offers array
            $offers = [];
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
                $imageUrl = Images::resize($image, 'offer-bg', 'offers', 'offers');

                // annotation
                $annotation = '';
                if(isset($item->descr->annotation)) {
                    $annotation = $item->descr->annotation;
                }

                // Url
                if(!empty($item->descr->slug)) {
                    $url = Url::to(['offers/view', 'slug' => $item->descr->slug]);
                } else {
                    $url = '#';
                }

                // Push to array
                $offers[] = [
                    'title' => $title,
                    'image' => $imageUrl,
                    'annotation' => $annotation,
                    'url' => $url,
                ];
            }

            return $offers;
        } else {
            return false;
        }
    }

    /**
     * Default image Url
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
        $imageUrl = Images::resize($image, 'offer-bg', 'offers', 'offers');
        $this->image = $imageUrl;
        return true;
    }

}
