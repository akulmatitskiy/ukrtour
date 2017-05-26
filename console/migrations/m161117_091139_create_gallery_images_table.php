<?php

use yii\db\Migration;

/**
 * Handles the creation of table `gallery_images`.
 */
class m161117_091139_create_gallery_images_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('gallery_images', [
            'id' => $this->primaryKey(),
            'gallery_id' => $this->integer(),
            'image' => $this->string(255),
            'main' => $this->integer(1),
        ]);
        
        $this->createIndex('idx_gallery_images', 'gallery_images', 'gallery_id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex('idx_gallery_images', 'gallery_images');
        $this->dropTable('gallery_images');
    }
}
