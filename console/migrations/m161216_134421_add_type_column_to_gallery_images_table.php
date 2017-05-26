<?php

use yii\db\Migration;

/**
 * Handles adding type to table `gallery_images`.
 */
class m161216_134421_add_type_column_to_gallery_images_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('gallery_images', 'type', $this->integer(1));
        $this->dropColumn('gallery_images', 'main');
        $this->dropIndex('idx_gallery_images', 'gallery_images');
        $this->createIndex('idx_gallery_images', 'gallery_images', [
            'gallery_id',
            'type'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex('idx_gallery_images', 'gallery_images');
        $this->dropColumn('gallery_images', 'type');
    }
}
