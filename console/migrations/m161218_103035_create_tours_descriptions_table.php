<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tours_descriptions`.
 */
class m161218_103035_create_tours_descriptions_table extends Migration {

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('tours_descriptions', [
            'id' => $this->primaryKey(),
            'tour_id' => $this->integer(),
            'lang_id' => $this->integer(1),
            'title' => $this->string(),
            'annotation' => $this->string(),
            'meta_description' => $this->string(),
            'description' => $this->text(),
            'slug' => $this->string(),
        ]);

        $this->createIndex('idx_tours_descriptions', 'tours_descriptions', [
            'tour_id',
            'lang_id'
        ]);
        
        $this->addForeignKey('fk_tours', 'tours_descriptions', 'tour_id', 'tours', 'id', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey($name, 'fk_tours', 'tours_descriptions');
        $this->dropIndex('idx_tours_descriptions', 'tours_descriptions');
        $this->dropTable('tours_descriptions');
    }

}
