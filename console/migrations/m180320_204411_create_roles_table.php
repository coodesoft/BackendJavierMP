<?php

use yii\db\Migration;

/**
 * Handles the creation of table `roles`.
 */
class m180320_204411_create_roles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('roles', [
            'id' => $this->primaryKey(),
            'Code' => $this->char(10),
            'Name' => $this->char(20),
            'Description' => $this->char(200),
            'Created' => $this->datetime(),
            'Updated' => $this->datetime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('roles');
    }
}
