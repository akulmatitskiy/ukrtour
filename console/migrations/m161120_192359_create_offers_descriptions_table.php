<?php

use yii\db\Migration;

/**
 * Handles the creation of table `offers_descriptions`.
 */
class m161120_192359_create_offers_descriptions_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('offers_descriptions', [
            'id' => $this->primaryKey(),
            'offer_id' => $this->integer(),
            'lang_id' => $this->integer(2),
            'title' => $this->string(255),
            'annotation' => $this->string(255),
            'meta_description' => $this->string(255),
            'text' => $this->text(),
            'slug' => $this->string(255),
        ]);
        
        $this->createIndex('idx_offers_descriptions', 'offers_descriptions', [
            'offer_id',
            'lang_id'
        ], true);
        
        $this->createIndex('idx_offers_descriptions_slug', 'offers_descriptions', [
            'lang_id',
            'slug'
        ], true);
        
        $this->addForeignKey(
            'fk_offers_descriptions_offer_id', 
            'offers_descriptions', 
            'offer_id',
            'offers',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_offers_descriptions_offer_id', 
            'offers_description');
        $this->dropIndex('idx_offers_descriptions', 'offers_descriptions');
        $this->dropIndex('idx_offers_descriptions_slug', 'offers_descriptions');
        $this->dropTable('offers_descriptions');
    }
}
