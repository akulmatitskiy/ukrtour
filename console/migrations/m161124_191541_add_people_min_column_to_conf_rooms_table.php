<?php

use yii\db\Migration;

/**
 * Handles adding people_min to table `conf_rooms`.
 */
class m161124_191541_add_people_min_column_to_conf_rooms_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('conf_rooms', 'people_min', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('conf_rooms', 'people_min');
    }
}
