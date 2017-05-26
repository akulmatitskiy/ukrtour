<?php

use yii\db\Migration;

/**
 * Handles the creation of table `hostels`.
 */
class m161219_091930_create_hostels_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('hostels', [
            'id' => $this->primaryKey(),
            'status' => $this->integer(1),
            'image' => $this->string(),
            'phone' => $this->string(),
        ]);
        
        $this->createIndex('idx_hostels', 'hostels', ['status']);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex('idx_hostels', 'hostels');
        $this->dropTable('hostels');
    }
}
