<?php

use yii\db\Migration;

/**
 * Handles the creation of table `gallery`.
 */
class m161117_090803_create_gallery_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('gallery', [
            'id' => $this->primaryKey(),
            'type' => $this->integer(1),
            'parent_id' => $this->integer(),
            'status' => $this->integer(1),
            'sort_order' => $this->integer(2),
            'slug' => $this->string(255),
        ]);
        
        $this->createIndex('idx_gallery', 'gallery', [
            'type',
            'parent_id',
            'status'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex('idx_gallery', 'gallery');
        $this->dropTable('gallery');
    }
}
