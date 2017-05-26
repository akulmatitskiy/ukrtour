<?php

use yii\db\Migration;

/**
 * Handles the creation of table `categories`.
 */
class m161116_143646_create_categories_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('categories', [
            'id' => $this->primaryKey(),
            'icon' => $this->string(255),
            'image' => $this->string(255),
            'status' => $this->integer(1),
            'sort_order' => $this->integer(2),
        ]);
        
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('categories');
    }
}
