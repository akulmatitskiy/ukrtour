<?php

use yii\db\Migration;

/**
 * Handles the creation of table `hotels_descriptions`.
 */
class m161113_164314_create_hotels_descriptions_table extends Migration {

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('hotels_descriptions', [
            'id' => $this->primaryKey(),
            'hotel_id' => $this->integer(),
            'lang_id' => $this->integer(),
            'title' => $this->string(255),
            'address' => $this->string(255),
            'description' => $this->text(),
            'map' => $this->text(),
        ]);

        $this->createIndex(
            'idx_hotels_descriptions', 'hotels_descriptions', ['hotel_id', 'lang_id'], true
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex('idx_hotels_descriptions', 'hotels_descriptions');

        $this->dropTable('hotels_descriptions');
    }

}
