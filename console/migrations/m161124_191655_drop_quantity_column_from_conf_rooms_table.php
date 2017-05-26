<?php

use yii\db\Migration;

/**
 * Handles dropping quantity from table `conf_rooms`.
 */
class m161124_191655_drop_quantity_column_from_conf_rooms_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropColumn('conf_rooms', 'quantity');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->addColumn('conf_rooms', 'quantity', $this->integer());
    }
}
