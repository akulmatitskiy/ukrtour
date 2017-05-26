<?php

use yii\db\Migration;

/**
 * Handles the creation of table `rooms_features`.
 */
class m161204_123905_create_rooms_features_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('rooms_features', [
            'id' => $this->primaryKey(),
            'room_id' => $this->integer(),
            'feature_id' => $this->integer(),
        ]);
        
        $this->createIndex('idx_rooms_features', 'rooms_features', [
            'room_id',
            'feature_id'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex('idx_rooms_features', 'rooms_features');
        $this->dropTable('rooms_features');
    }
}
