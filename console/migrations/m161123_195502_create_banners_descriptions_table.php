<?php

use yii\db\Migration;

/**
 * Handles the creation of table `banners_descriptions`.
 */
class m161123_195502_create_banners_descriptions_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('banners_descriptions', [
            'id' => $this->primaryKey(),
            'banner_id' => $this->integer(),
            'lang_id' => $this->integer(1),
            'title' => $this->string(255),
            'url' => $this->string(255),
            'price' => $this->string(255),
            'text' => $this->string(255),
        ]);
        
        $this->createIndex('idx_banners_descriptions', 'banners_descriptions', [
            'banner_id',
            'lang_id'
        ]);
        
        $this->addForeignKey(
            'fk_banners',
            'banners_descriptions',
            'banner_id',
            'banners',
            'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_banners', 'banners_descriptions');
        $this->dropIndex('idx_banners_descriptions', 'banners_descriptions');
        $this->dropTable('banners_descriptions');
    }
}
