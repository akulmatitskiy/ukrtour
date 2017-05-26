<?php

use yii\db\Migration;

/**
 * Handles dropping banner from table `offers`.
 */
class m161121_065404_drop_banner_column_from_offers_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropColumn('offers', 'banner');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->addColumn('offers', 'banner', $this->integer());
    }
}
