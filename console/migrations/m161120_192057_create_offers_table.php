<?php

use yii\db\Migration;

/**
 * Handles the creation of table `offers`.
 */
class m161120_192057_create_offers_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('offers', [
            'id' => $this->primaryKey(),
            'banner' => $this->integer(1),
            'status' => $this->integer(1),
            'image' => $this->string(255),
            'price' => $this->float(2),
        ]);
        
        $this->createIndex('idx_offers', 'offers', ['banner', 'status']);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex('idx_offers', 'offers');
        $this->dropTable('offers');
    }
}
