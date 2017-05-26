<?php

use yii\db\Migration;

/**
 * Handles the creation of table `pages_descriptions`.
 */
class m161120_145806_create_pages_descriptions_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('pages_descriptions', [
            'id' => $this->primaryKey(),
            'page_id' => $this->integer(),
            'lang_id' => $this->integer(1),
            'title' => $this->string(255),
            'h1' => $this->string(255),
            'meta_description' => $this->string(255),
            'text' => $this->text(),
            'slug' => $this->string(255),
        ]);
        
        $this->createIndex('idx_pages_descr', 'pages_descriptions', [
            'page_id',
            'lang_id'
        ]);
        
        $this->addForeignKey(
            'fk_pages_descr_page_id', 
            'pages_descriptions', 
            'page_id',
            'pages',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_pages_descr_page_id', 'pages_descriptions');
        $this->dropIndex('idx_pages_descr', 'pages_descriptions');
        $this->dropTable('pages_descriptions');
    }
}
