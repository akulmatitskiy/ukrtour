<?php

use yii\db\Migration;

/**
 * Handles the creation of table `menu_items_descriptions`.
 */
class m161123_130607_create_menu_items_descriptions_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('menu_items_descriptions', [
            'id' => $this->primaryKey(),
            'item_id' => $this->integer(),
            'lang_id' => $this->integer(1),
            'url' => $this->string(255),
            'name' => $this->string(255),
            'title' => $this->string(255),
        ]);
        
        $this->createIndex('idx_menu_items_descr', 'menu_items_descriptions', [
            'item_id',
            'lang_id'
        ], true);
        
        $this->addForeignKey(
            'fk_menu_items',
            'menu_items_descriptions',
            'item_id',
            'menu_items',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_menu_items', 'menu_items_descriptions');
        $this->dropIndex('idx_menu_items_descr', 'menu_items_descriptions');
        $this->dropTable('menu_items_descriptions');
    }
}
