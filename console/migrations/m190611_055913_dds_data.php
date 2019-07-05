<?php

use yii\db\Migration;

/**
 * Class m190611_055913_dds_data
 */
class m190611_055913_dds_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('dds_data', [
            'id' => $this->primaryKey(),

            'data_json' => $this->text(),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('dds_data');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190611_055913_dds_data cannot be reverted.\n";

        return false;
    }
    */
}
