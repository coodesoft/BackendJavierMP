<?php

use yii\db\Migration;

/**
 * Handles the creation of table `organizations`.
 */
class m180320_204215_create_organizations_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('organizations', [
            'id' => $this->primaryKey(),
            'Code' => $this->char(10),
            'Name' => $this->char(40),
            'Type' => $this->char(1),
            'Enrollment_code' => $this->char(5),
            'Created' => $this->datetime(),
            'Updated' => $this->datetime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('organizations');
    }
}
