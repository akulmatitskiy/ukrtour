<?php

use yii\db\Migration;

/**
 * Handles adding people_max to table `conf_rooms`.
 */
class m161124_191553_add_people_max_column_to_conf_rooms_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('conf_rooms', 'people_max', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('conf_rooms', 'people_max');
    }
}
