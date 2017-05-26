<?php

use yii\db\Migration;

/**
 * Handles adding slug to table `hotels_descriptions`.
 */
class m161114_071749_add_slug_column_to_hotels_descriptions_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('hotels_descriptions', 'slug', $this->string(255));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('hotels_descriptions', 'slug');
    }
}
