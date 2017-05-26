<?php

use yii\db\Migration;

/**
 * Handles adding category to table `banners`.
 */
class m161202_144613_add_category_column_to_banners_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('banners', 'category', $this->integer());
        
        $this->createIndex('idx_banners_category', 'banners', [
            'status',
            'category',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex('idx_banners_category', 'banners');
        $this->dropColumn('banners', 'category');
    }
}
