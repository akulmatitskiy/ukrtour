<?php

use yii\db\Migration;

/**
 * Handles the creation of table `features`.
 */
class m161125_110010_create_features_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('features', [
            'id' => $this->primaryKey(),
            'icon' => $this->string(255),
            'type' => $this->integer(1),
            'status' => $this->integer(1),
            'sort_order' => $this->integer(),
        ]);
        
        $this->createIndex('idx_features', 'features', [
            'status',
            'type'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex('idx_features', 'features');
        $this->dropTable('features');
    }
}
