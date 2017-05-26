<?php

use yii\db\Migration;

/**
 * Handles adding parents to table `conf_rooms`.
 */
class m170116_090830_add_parents_column_to_conf_rooms_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('conf_rooms', 'type', $this->integer(1)->defaultValue(1));
        $this->renameColumn('conf_rooms', 'hotel_id', 'parent');
        $this->createIndex('idx_conf_rooms_parent', 'conf_rooms', [
            'type',
            'parent',
            'status'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex('idx_conf_rooms_parent', 'conf_rooms');
        $this->dropColumn('conf_rooms', 'type');
        $this->renameColumn('conf_rooms', 'parent', 'hotel_id');
    }
}
