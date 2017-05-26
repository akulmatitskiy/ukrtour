<?php

use yii\db\Migration;

/**
 * Handles the creation of table `conf_rooms`.
 */
class m161124_083915_create_conf_rooms_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('conf_rooms', [
            'id' => $this->primaryKey(),
            'hotel_id' => $this->integer(),
            'quantity' => $this->integer(),
            'price_1' => $this->float(2),
            'price_3' => $this->float(2),
            'price_24' => $this->float(2),
            'image' => $this->string(255),
            'status' => $this->integer(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        
        $this->createIndex('idx_conf_rooms', 'conf_rooms', [
            'hotel_id',
            'status'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex('idx_conf_rooms', 'conf_rooms');
        $this->dropTable('conf_rooms');
    }
}
