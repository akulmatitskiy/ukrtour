<?php

use yii\db\Migration;

/**
 * Handles the creation of table `banners`.
 */
class m161123_195329_create_banners_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('banners', [
            'id' => $this->primaryKey(),
            'type' => $this->integer(1),
            'image' => $this->string(255),
            'status' => $this->integer(1),
            'sort_order' => $this->integer(),
        ]);
        
        $this->createIndex('idx_banners', 'banners', 'status');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex('idx_banners', 'banners');
        $this->dropTable('banners');
    }
}
