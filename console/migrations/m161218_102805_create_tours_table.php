<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tours`.
 */
class m161218_102805_create_tours_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('tours', [
            'id' => $this->primaryKey(),
            'status' => $this->integer(1),
            'image' => $this->string(),
            'phone' => $this->string(),
        ]);
        
        $this->createIndex('idx_tours', 'tours', ['status']);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex('idx_tours', 'tours');
        $this->dropTable('tours');
    }
}
