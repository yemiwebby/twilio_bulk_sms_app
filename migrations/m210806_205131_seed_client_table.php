<?php

use yii\db\Migration;

/**
 * Class m210806_205131_seed_client_table
 */
class m210806_205131_seed_client_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp() {

        $this->insertFakeMembers();
    }

    private function insertFakeMembers() {

        $faker = Faker\Factory::create();

        for ($i = 0; $i < 1000; $i++) {
            $this->insert(
                'client',
                [
                    'name'        => $faker->name(),
                    'phoneNumber' => $faker->e164PhoneNumber()
                ]
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210806_205131_seed_client_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210806_205131_seed_client_table cannot be reverted.\n";

        return false;
    }
    */
}
