<?php

use yii\db\Migration;

/**
 * Handles adding latitude_longitude to table `hostels`.
 */
class m161227_202947_add_latitude_longitude_column_to_hostels_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('hostels', 'latitude', $this->decimal(9,6));
        $this->addColumn('hostels', 'longitude', $this->decimal(9,6));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('hostels', 'latitude');
        $this->dropColumn('hostels', 'longitude');
    }
}
