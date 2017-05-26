<?php

use yii\db\Migration;

/**
 * Handles the creation of table `conf_rooms_features`.
 */
class m161126_160834_create_conf_rooms_features_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('conf_rooms_features', [
            'id' => $this->primaryKey(),
            'conf_room_id' => $this->integer(),
            'feature_id' => $this->integer(),
        ]);
        
        $this->createIndex('idx_conf_rooms_features', 'conf_rooms_features', [
            'conf_room_id',
            'feature_id'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex('idx_conf_rooms_features', 'conf_rooms_features');
        $this->dropTable('conf_rooms_features');
    }
}
