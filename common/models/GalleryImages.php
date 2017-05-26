<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gallery_images".
 *
 * @property integer $id
 * @property integer $gallery_id
 * @property string $image
 */
class GalleryImages extends \yii\db\ActiveRecord {
    
    /**
     * Limit display thumbs in carousel
     */
    const GALLERY_THUMB_LIMIT = 10;
    
    /**
     * Gallery types
     */
    const GALLERY_TYPE_HOTEL = 1;
    const GALLERY_TYPE_HOSTEL = 2;
    const GALLERY_TYPE_TOUR = 3;
    
    /**
     * Gallery types
     * @var type 
     */
    private static $types = [
        'hotel' => self::GALLERY_TYPE_HOTEL,
        'hostel' => self::GALLERY_TYPE_HOSTEL,
        'tour' => self::GALLERY_TYPE_TOUR,
    ];
    
    public static function galleryTypes() {
        return self::$types;
    }
    
    /**
     * Type
     * @param type $type 
     * @return integer the type ID
     */
    public static function galleryType($type) {
        if(array_key_exists($type, static::$types)) {
            return static::$types[$type];
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gallery_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gallery_id', 'type'], 'integer'],
            [['image'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gallery_id' => 'Gallery ID',
            'image' => 'Image',
        ];
    }

    /**
     * Delete gallery image
     * @param type $id the image ID
     * @param type $gallery the gallery ID
     * @return boolean
     */
    public static function deleteImage($id, $gallery)
    {
        // Gallery image model
        $model    = GalleryImages::findOne([
                'id' => $id,
                'gallery_id' => $gallery,
        ]);
        // Delete file path
        $filename = Yii::getAlias('@backend/web/images/' . $gallery . '/')
            . $model->image;

        // Delete model
        if($model->delete() !== null) {
            // Delete file
            @unlink($filename);
        } else {
            return false;
        }

        return true;
    }

    /**
     * Gallery images for preview
     * @return array $images
     */
    public static function getImages($id, $type) {
        // Get model
        $images = self::find()
            ->where([
                'gallery_id' => $id,
                'type' => $type,
                ])
            ->asArray()
            ->all();

        return $images;
    }
    
   /**
    * Save gallery images
    * @param string $images
    * @param integer $id
    * @param integer $type
    * @param string $path
    * @return boolean
    */
    public static function saveImages($images, $id, $type, $path)
    {
        $images = explode(', ', $images);
        foreach($images as $image) {
            $imageInfo = pathinfo($image);
            $directory = 'images/gallery/' . $path . '/' . $id;
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
                    'gallery_id' => $id,
                    'type' => $type
            ]);

            if($modelImage == null) {
                // Save image name to gallery_images
                $modelImage             = new GalleryImages();
                $modelImage->gallery_id = $id;
                $modelImage->image      = $imageInfo['basename'];
                $modelImage->type      = $type;
                
                if(!$modelImage->save()) {
                    return false;
                }
            }
            
        }
        return true;
    }
    
    

}
