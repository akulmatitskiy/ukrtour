<?php

use yii\db\Migration;

/**
 * Handles the creation of table `features_descriptions`.
 */
class m161125_110126_create_features_descriptions_table extends Migration {

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('features_descriptions', [
            'id' => $this->primaryKey(),
            'feature_id' => $this->integer(),
            'lang_id' => $this->integer(1),
            'title' => $this->string(255),
        ]);

        $this->createIndex('idx_features_descriptions', 'features_descriptions', [
            'feature_id',
            'lang_id'
            ], true);
        
        $this->addForeignKey(
            'fk_features_descriptions',
            'features_descriptions',
            'feature_id',
            'features',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_features_descriptions', 'features_descriptions');
        $this->dropIndex('idx_features_descriptions', 'features_descriptions');
        $this->dropTable('features_descriptions');
    }

}
