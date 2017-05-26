<?php

use yii\db\Migration;

/**
 * Handles the creation of table `categories_descriptions`.
 */
class m161116_144044_create_categories_descriptions_table extends Migration {

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('categories_descriptions', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer(),
            'lang_id' => $this->integer(2),
            'title' => $this->string(255),
            'annotation' => $this->string(255),
            'h1' => $this->string(255),
            'text' => $this->text(),
            'meta_title' => $this->string(255),
            'meta_description' => $this->string(255),
            'slug' => $this->string(255),
        ]);

        $this->createIndex('idx_categ_descr', 'categories_descriptions', [
            'category_id',
            'lang_id'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex('idx_categ_descr', 'categories_descriptions');
        $this->dropTable('categories_descriptions');
    }

}
