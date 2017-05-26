<?php

use yii\db\Migration;

class m161230_082214_change_banners_fk extends Migration
{
    public function up()
    {
        $this->dropForeignKey('fk_banners', 'banners_descriptions');
        $this->addForeignKey(
            'fk_banners',
            'banners_descriptions',
            'banner_id',
            'banners',
            'id',
            'CASCADE');
    }

    public function down()
    {
        echo "m161230_082214_change_banners_fk cannot be reverted.\n";

        return false;
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
