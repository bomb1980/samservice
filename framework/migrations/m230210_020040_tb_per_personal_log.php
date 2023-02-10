<?php

use Faker\Factory;
use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m230210_020040_tb_per_personal_log
 */
class m230210_020040_tb_per_personal_log extends Migration
{


    public function up()
    {
        // $this->dropTable('tb_per_personal_log');

        $this->createTable('tb_per_personal_log', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'name' => Schema::TYPE_STRING,
            'content' => Schema::TYPE_TEXT,
            'gogo' => Schema::TYPE_TEXT,
        ]);

        $columns = array(
            'id',
            'title',
            'content',
            'gogo',
        );
        $values = [];

        for ($i = 1; $i <= 10; $i++) {
            $facker = Factory::create();

            $values[] = [
                $i,
                $facker->sentence,
                $facker->sentence,
                $facker->sentence,
            ];
        }

        $this->batchInsert('tb_per_personal_log', $columns, $values);
    }

    public function down()
    {
        $this->dropTable('tb_per_personal_log');
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230210_020040_tb_per_personal_log cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230210_020040_tb_per_personal_log cannot be reverted.\n";

        return false;
    }
    */
}
