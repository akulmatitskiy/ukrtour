<?php

use yii\db\Migration;

/**
 * Handles the creation of table `pages`.
 */
class m161120_145547_create_pages_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('pages', [
            'id' => $this->primaryKey(),
            'type' => $this->integer(1),
            'status' => $this->integer(1),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('pages');
    }
}
