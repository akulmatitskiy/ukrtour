<?php

use yii\db\Migration;

/**
 * Handles the creation of table `menu_items`.
 */
class m161123_130212_create_menu_items_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('menu_items', [
            'id' => $this->primaryKey(),
            'menu_id' => $this->integer(),
            'status' => $this->integer(1),
            'sort_order' => $this->integer(),
        ]);
        
        $this->createIndex('idx_menu_items', 'menu_items', [
            'menu_id',
            'status'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex('idx_menu_items', 'menu_items');
        $this->dropTable('menu_items');
    }
}
