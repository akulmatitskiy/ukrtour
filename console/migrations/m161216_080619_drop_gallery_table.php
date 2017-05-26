<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `gallery`.
 */
class m161216_080619_drop_gallery_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropIndex('idx_gallery', 'gallery');
        $this->dropTable('gallery');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->createTable('gallery', [
            'id' => $this->primaryKey(),
            'type' => $this->integer(1),
            'parent_id' => $this->integer(),
            'status' => $this->integer(1),
            'sort_order' => $this->integer(2),
            'slug' => $this->string(255),
        ]);
    }
}
