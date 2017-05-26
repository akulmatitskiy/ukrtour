<?php

use yii\db\Migration;

/**
 * Handles adding type to table `categories`.
 */
class m161117_081314_add_type_column_to_categories_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('categories', 'type', $this->integer(1));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('categories', 'type');
    }
}
