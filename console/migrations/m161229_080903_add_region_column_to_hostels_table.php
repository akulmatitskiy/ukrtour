<?php

use yii\db\Migration;

/**
 * Handles adding region to table `hostels`.
 */
class m161229_080903_add_region_column_to_hostels_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('hostels', 'region', $this->integer());
        $this->createIndex('idx_hostels_region', 'hostels', [
            'status',
            'region'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex('idx_hostels_region', 'hostels');
        $this->dropColumn('hostels', 'region');
    }
}
