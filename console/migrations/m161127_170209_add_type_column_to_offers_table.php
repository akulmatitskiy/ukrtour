<?php

use yii\db\Migration;

/**
 * Handles adding type to table `offers`.
 */
class m161127_170209_add_type_column_to_offers_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('offers', 'type', $this->integer(1));
        $this->createIndex('idx_offers_type', 'offers', [
           'type',
            'status'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex('idx_offers_type', 'offers');
        $this->dropColumn('offers', 'type');
    }
}
