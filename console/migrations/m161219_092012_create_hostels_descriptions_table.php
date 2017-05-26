<?php

use yii\db\Migration;

/**
 * Handles the creation of table `hostels_descriptions`.
 */
class m161219_092012_create_hostels_descriptions_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('hostels_descriptions', [
            'id' => $this->primaryKey(),
            'hostel_id' => $this->integer(),
            'lang_id' => $this->integer(1),
            'title' => $this->string(),
            'annotation' => $this->string(),
            'meta_description' => $this->string(),
            'description' => $this->text(),
            'address' => $this->string(),
            'slug' => $this->string(),
        ]);
        
        $this->createIndex('idx_hostels_descriptions', 'hostels_descriptions', [
            'hostel_id',
            'lang_id'
        ]);
        
        $this->addForeignKey('fk_hostels', 'hostels_descriptions', 'hostel_id', 'hostels', 'id', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey($name, 'fk_hostels', 'hostels_descriptions');
        $this->dropIndex('idx_hostels_descriptions', 'hostels_descriptions');
        $this->dropTable('hostels_descriptions');
    }
}
