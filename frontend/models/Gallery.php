<?php

namespace frontend\models;

use Yii;
use common\models\Images;
use yii\validators\NumberValidator;
use common\models\GalleryImages;
use frontend\models\Tours;
use frontend\models\Hostels;

/**
 * This is the model class for table "gallery".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $parent_id
 * @property integer $status
 * @property integer $sort_order
 * @property string $slug
 */
class Gallery extends GalleryImages {

    /**
     * Hotels carousel
     * @return array $carousel the carousel items
     */
    public static function getCarousel($type, $id)
    {
        $carousel  = [];
        $countImg  = 0;
        $validator = new NumberValidator();

        // Validate id
        if(!$validator->validate($id, $error)) {
            Yii::warning($error);
            return false;
        }

        // Validate type
        if(!array_key_exists($type, GalleryImages::galleryTypes())) {
            Yii::warning('Неправильный тип');
            return false;
        }

        // Get type id
        $typeId = GalleryImages::galleryType($type);



        // Alt
        $alt = '';

        // Hotel
        if($typeId == Gallery::GALLERY_TYPE_HOTEL) {

            $hotel = Gallery::getHotel($id);

            if(!empty($hotel) && !empty($hotel->servioName->name)) {
                $alt = $hotel->servioName->name;
            }

            $path = '';
        }

        // Tour
        if($typeId == Gallery::GALLERY_TYPE_TOUR) {
            $tour = Tours::findOne($id);
            if(!empty($tour) && !empty($tour->descr->title)) {
                $alt = $tour->descr->title;
            }
            $path = $type . '/';
        }

        // Hostel
        if($typeId == Gallery::GALLERY_TYPE_HOSTEL) {
            $tour = Hostels::findOne($id);
            if(!empty($tour) && !empty($tour->descr->title)) {
                $alt = $tour->descr->title;
            }
            $path = $type . '/';
        }

        // Gallery model
        $gallery = GalleryImages::findAll([
                'type' => $typeId,
                'gallery_id' => $id
        ]);

        if(!empty($gallery)) {
            foreach($gallery as $image) {
                $sourcePath = 'gallery/' . $path . $id;
                $thumbPath  = 'gallery/' . $path . $id . '/thumb';
                if($countImg++ < GalleryImages::GALLERY_THUMB_LIMIT) {
                    // Images
                    $thumb      = Images::resize($image->image, 'gallery-thumb', $sourcePath, $thumbPath);
                    $fullImage  = Images::resize($image->image, 'gallery', $sourcePath, $sourcePath);
                    $carousel[] = [
                        'url' => $fullImage,
                        'thumbUrl' => $thumb,
                        'alt' => $alt,
                    ];
                }
            }
        }

        return $carousel;
    }

    /**
     * Hotels carousel
     * @return array $carousel the carousel items
     */
    public static function hotelImages($id)
    {
        $images    = [];
        $validator = new NumberValidator();
        $countImg  = 0;

        // Validate id
        if(!$validator->validate($id, $error)) {
            Yii::warning($error);
            return false;
        }

        $hotel = Gallery::getHotel($item->parent_id);

        if(!empty($hotel)) {
            // Hotel name
            if(!empty($hotel->servioName->name)) {
                $hotelName = $hotel->servioName->name;
            } else {
                $hotelName = '';
            }
        }

        // Gallery model
        $gallery = GalleryImages::findAll(['gallery_id' => $id]);

        //var_dump($gallery);
        if(!empty($gallery)) {
            foreach($gallery as $image) {
                $sourcePath = 'gallery/' . $id;
                $thumbPath  = 'gallery/' . $item->id . '/thumb';
                if($countImg++ < GalleryImages::GALLERY_THUMB_LIMIT) {
                    // Images
                    $thumb      = Images::resize($image->image, 'gallery-thumb', $sourcePath, $thumbPath);
                    $fullImage  = Images::resize($image->image, 'gallery', $sourcePath, $sourcePath);
                    $carousel[] = [
                        'url' => $fullImage,
                        'thumbUrl' => $thumb,
                        'alt' => $hotelName,
                    ];
                }
            }
        }

        return $carousel;
    }

    public static function galleryPage($type, $id)
    {
        $validator = new NumberValidator();

        // Validate id
        if(!$validator->validate($id, $error)) {
            Yii::warning($error);
            return false;
        }

        // Get type id
        $typeId = GalleryImages::galleryType($type);

        // Gallery model
        $model = GalleryImages::findOne([
                'type' => $typeId,
                'gallery_id' => $id
        ]);

        // Title
        $title = '';
        $type  = 'hotel';

        // Hotel
        if($typeId == Gallery::GALLERY_TYPE_HOTEL) {
            // Hotel translates
            $hotel = self::getHotel($id);
            $title = $hotel->servioCity->name . ' ' . $hotel->servioName->name;
        }

        // Tour
        if($typeId == Gallery::GALLERY_TYPE_TOUR) {
            $tour = Tours::findOne($id);
            if(!empty($tour) && !empty($tour->descr->title)) {
                $title = $tour->descr->title;
            }
            $type = 'tour';
        }

        // Hostel
        if($typeId == Gallery::GALLERY_TYPE_HOSTEL) {
            $hostel = Hostels::findOne($id);
            if(!empty($hostel) && !empty($hostel->descr->title)) {
                $title = $hostel->descr->title;
            }
            $type = 'hostel';
        }

        // Gallery items
        if(!empty($model)) {
            $gallery = [
                'id' => $id,
                'title' => $title,
                'type' => $type,
            ];
            return $gallery;
        } else {
            return false;
        }
    }

    public static function galleryPageImages($type, $id)
    {
        $typeId = GalleryImages::galleryType($type);

        $images = [];
        // Images model
        $model  = GalleryImages::find()
            ->where('gallery_id = :id AND type = :type', [
                ':id' => $id,
                ':type' => $typeId
            ])
            ->all();

        if(!empty($model)) {

            if($typeId == Gallery::GALLERY_TYPE_HOTEL) {
                $type = '';
            }

            // Paths
            $sourcePath = 'gallery/' . $type . '/' . $id;
            $thumbPath  = 'gallery/' . $type . '/' . $id . '/medium';

            // Images

            foreach($model as $image) {
                // Images urls
                $thumb     = Images::resize($image->image, 'gallery-medium', $sourcePath, $thumbPath);
                $fullImage = Images::resize($image->image, 'gallery', $sourcePath, $sourcePath);

                $images[] = [
                    'url' => $fullImage,
                    'thumbUrl' => $thumb
                ];
            }
        }
        return $images;
    }

    /**
     * Gallery images relation
     * @return mixed
     */
    protected static function getHotel($id)
    {
        // Hotel model
        $hotel = Hotels::find()
            ->joinWith(['servioName', 'descr'])
            ->where([
                '{{servio_hotels}}.id' => $id,
                'visible' => Hotels::HOTEL_STATUS_VISIBLE
            ])
            ->one();
        return $hotel;
    }

}
