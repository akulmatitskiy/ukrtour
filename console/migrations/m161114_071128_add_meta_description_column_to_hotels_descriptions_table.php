<?php

use yii\db\Migration;

/**
 * Handles adding meta_description to table `hotels_descriptions`.
 */
class m161114_071128_add_meta_description_column_to_hotels_descriptions_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('hotels_descriptions', 'meta_description', $this->string(255));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('hotels_descriptions', 'meta_description');
    }
}
