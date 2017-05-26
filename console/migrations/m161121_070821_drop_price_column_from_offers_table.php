<?php

use yii\db\Migration;

/**
 * Handles dropping price from table `offers`.
 */
class m161121_070821_drop_price_column_from_offers_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropColumn('offers', 'price');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->addColumn('offers', 'price', $this->float(2));
    }
}
