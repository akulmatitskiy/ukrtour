<?php

use yii\db\Migration;

/**
 * Handles the creation of table `hotels_images`.
 */
class m161114_150155_create_hotels_images_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('hotels_images', [
            'id' => $this->primaryKey(),
            'hotel_id' => $this->integer(),
            'image' => $this->string(255),
            'main' => $this->integer(1),
        ]);
        
        $this->createIndex('idx_hohels_images', 'hotels_images', ['hotel_id', 'main']);
        
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex('idx_hohels_images', 'hotels_images');
        
        $this->dropTable('hotels_images');
    }
}
