<?php

use yii\db\Migration;

/**
 * Handles adding h1 to table `hotels_descriptions`.
 */
class m161114_071215_add_h1_column_to_hotels_descriptions_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('hotels_descriptions', 'h1', $this->string(255));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('hotels_descriptions', 'h1');
    }
}
