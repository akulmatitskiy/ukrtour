<?php

use yii\db\Migration;

class m170116_123103_rename_parent_column_conf_rooms_table extends Migration
{
    public function up()
    {
        $this->renameColumn('conf_rooms', 'parent', 'parent_id');
    }

    public function down()
    {
        $this->renameColumn('conf_rooms', 'parent_id', 'parent');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
