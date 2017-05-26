<?php

use yii\db\Migration;

/**
 * Handles the creation of table `hotels_features`.
 */
class m161126_082405_create_hotels_features_table extends Migration {

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('hotels_features', [
            'id' => $this->primaryKey(),
            'hotel_id' => $this->integer(),
            'feature_id' => $this->integer(),
        ]);

        $this->createIndex(
            'idx_hotels_features', 'hotels_features', [
            'hotel_id',
            'feature_id'
            ], true
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex('idx_hotels_features', 'hotels_features');
        $this->dropTable('hotels_features');
    }

}
