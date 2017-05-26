<?php

use yii\db\Migration;

/**
 * Handles adding city_id to table `hostels`.
 */
class m170118_073509_add_city_id_column_to_hostels_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('hostels', 'city_id', $this->integer());
        $this->createIndex('idx_hostels_city_id', 'hostels', 'city_id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex('idx_hostels_city_id', 'hostels');
        $this->dropColumn('hostels', 'city_id');
    }
}
