<?php

use yii\db\Migration;

/**
 * Handles the creation of table `conf_rooms_descriptions`.
 */
class m161124_084114_create_conf_rooms_descriptions_table extends Migration {

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('conf_rooms_descriptions', [
            'id' => $this->primaryKey(),
            'conf_room_id' => $this->integer(),
            'lang_id' => $this->integer(1),
            'name' => $this->string(255),
            'title' => $this->string(255),
            'meta_description' => $this->string(255),
            'description' => $this->text(),
            'slug' => $this->string(255),
        ]);

        $this->createIndex('idx_conf_rooms_descriptions', 'conf_rooms_descriptions', [
            'conf_room_id',
            'lang_id'
        ]);

        $this->addForeignKey(
            'fk_conf_rooms', 'conf_rooms_descriptions', 'conf_room_id', 'conf_rooms', 'id', 'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_conf_rooms', 'conf_rooms_descriptions');
        $this->dropIndex('idx_conf_rooms_descriptions', 'conf_rooms_descriptions');
        $this->dropTable('conf_rooms_descriptions');
    }

}
