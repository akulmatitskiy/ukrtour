<?php

use yii\db\Migration;

/**
 * Handles the creation of table `lang_iso_codes`.
 */
class m161229_132208_create_lang_iso_codes_table extends Migration {

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('lang_iso_codes', [
            'id' => $this->primaryKey(),
            'lang_id' => $this->integer(1),
            'iso_code' => $this->string(2),
        ]);

        $this->createIndex('idx_lang_iso_codes', 'lang_iso_codes', 'lang_id');

        $this->batchInsert('lang_iso_codes', [
            'lang_id',
            'iso_code'
            ], [
                [1,'uk'],
                [2,'ru'],
                [3,'en'],
            ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex('idx_lang_iso_codes', 'lang_iso_codes');
        $this->dropTable('lang_iso_codes');
    }

}
