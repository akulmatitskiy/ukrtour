<?php

namespace common\models;

use Yii;
use yii\base\model;
use yii\imagine\Image;
use Imagine\Gd;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;
use Imagine\Image\ImageInterface;

/**
 * This is the model class for images.
 *
 */
class Images extends Model {

    /**
     * Image sizes
     */
    //const SIZE_THUMB         = 'thumb';
    //const SIZE_SMALL         = 'small';
    // const SIZE_MEDIUM        = 'medium';
//    const SIZE_FULL          = 'full';
//    const SIZE_POST_SMALL    = 'smallpost';
//    const SIZE_COMPARE_SMALL = 'compare-small';
    const HOTEL_BG_BIG         = 'hotel-bg-big';
    const CATEGORIES           = 'categories';
    const GALLERY              = 'gallery';
    const GALLERY_THUMB        = 'gallery-thumb';
    const GALLERY_MEDIUM       = 'gallery-medium';
    const OFFER_BG             = 'offer-bg';
    const OFFER_BIG             = 'offer-big';
    const BANNERS              = 'banners';
    const CONFERENCE_ROOMS     = 'conference-rooms';
    const CONFERENCE_ROOMS_BIG = 'conference-rooms-big';
    const PLACEHOLDER          = 'no-image.jpg';

    /**
     *  Sizes
     * @var array ['width', 'height'] 
     */
    private static $sizes = [
        self::HOTEL_BG_BIG => [
            'width' => 1065,
            'height' => 755
        ],
        self::CATEGORIES => [
            'width' => 455,
            'height' => 500
        ],
        self::GALLERY => [
            'width' => 1920,
            'height' => 1440
        ],
        self::GALLERY_THUMB => [
            'width' => 82,
            'height' => 62
        ],
        self::GALLERY_MEDIUM => [
            'width' => 300,
            'height' => 255
        ],
        self::OFFER_BG => [
            'width' => 540,
            'height' => 310
        ],
        self::OFFER_BIG => [
            'width' => 1000,
            'height' => 750
        ],
        self::BANNERS => [
            'width' => 1920,
            'height' => 854
        ],
        self::CONFERENCE_ROOMS => [
            'width' => 552,
            'height' => 300
        ],
        self::CONFERENCE_ROOMS_BIG => [
            'width' => 1000,
            'height' => 750
        ],
    ];

    public static function getSize($size)
    {
        return array_key_exists($size, static::$sizes) ? static::$sizes[$size] : null;
    }

    /**
     * Resize image
     * @param type $imageName the file name
     * @param type $sizeAlias the size alias
     * @param string $sourcePath the source path
     * @param string $targetPath the target path
     * @return string the image url
     */
    public static function resize($imageName, $sizeAlias, $sourcePath = '', $targetPath = '')
    {
        // Default path
        $backendPath = Yii::getAlias('@backend' . '/web/images/');
        // Custom path
        if(!empty($sourcePath)) {
            $backendPath = Yii::getAlias('@backend' . '/web/images/' . $sourcePath . '/');
        }
        if(empty($targetPath)) {
            $targetPath = $sizeAlias;
        }

        $path  = '/images/' . $targetPath;
        $sizes = self::getSize($sizeAlias);

        // set placeholder for product w/o image
        if(empty($imageName || !is_file($backendPath . $imageName))) {
            $imageName = self::PLACEHOLDER;
        }
        
        $sourceImage = $backendPath . $imageName;
        $newImage    = Yii::getAlias('@webroot' . $path . '/' . $imageName);
        $imageUrl    = $path . '/' . $imageName;

        // check folder exist
        if(!file_exists(Yii::getAlias('@webroot' . $path))) {
            @mkdir(Yii::getAlias('@webroot' . $path), 0777, true);
        }

        // check file exist
        if(!is_file($sourceImage)) {
            $sourceImage = Yii::getAlias('@backend' . '/web/images/') . self::PLACEHOLDER;
        }

//        var_dump($newImage);
//        var_dump(!is_file($newImage));
//        var_dump(filectime($newImage));
//        var_dump(filectime($sourceImage));
//        var_dump((filectime($newImage) < filectime($sourceImage)));
//        exit;

        if(!is_file($newImage) || (filectime($newImage) < filectime($sourceImage))) {

            // generate a thumbnail image
            Image::thumbnail($sourceImage, $sizes['width'], $sizes['height'])
                ->save(Yii::getAlias($newImage), ['quality' => 80]);
        }

        return $imageUrl;
    }

    /**
     * Return banner params
     * @return array
     */
    public static function bannerResize($imageName, $height)
    {
        $sourceImage  = Yii::getAlias('@backend') . '/web/uploads/banners/' . $imageName;
        $bannerFolder = Yii::getAlias('@webroot/images/banners');
        $newImage     = $bannerFolder . '/' . $imageName;

        // check folder exist
        if(!file_exists($bannerFolder)) {
            mkdir($bannerFolder, 0777);
        }

        // Check file exist
        if(!is_file($newImage) || (filectime($newImage) < filectime($sourceImage))) {
            // Open image
            $image = Image::getImagine()
                ->open($sourceImage);

            if(!empty($width)) {
                $box = new Box($width, $height);
            } else {
                // Resize image for category banners
                $size = $image->getSize();
                $box  = new Box($size->getWidth(), $size->getHeight());
                $box  = $box->heighten($height);
            }

            // Gen image
            $image->thumbnail($box, ImageInterface::THUMBNAIL_INSET)
                ->save($newImage, ['quality' => 90]);
            $width = $image->getSize()->getWidth();
        } elseif(empty($width)) {
            $image = Image::getImagine()
                ->open($newImage);
            $size  = $image->getSize();
            $width = $image->getSize()->getWidth();
        }
        $banner = [
            'image' => '/images/banners/' . $imageName,
            'width' => $width,
            'height' => $height,
        ];

        return $banner;
    }

    /**
     * Save image
     * @param type $image
     * @return boolean
     */
    public static function saveImage($image, $path)
    {
        $imageInfo = pathinfo($image);
        $filePath  = 'images/' . $path . '/';
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

        return $imageInfo['basename'];
    }

}
