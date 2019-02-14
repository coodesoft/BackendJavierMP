<?php

use yii\db\Migration;

/**
 * Handles the creation of table `functions`.
 */
class m180320_204614_create_functions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('functions', [
            'id' => $this->primaryKey(),
            'Resource' => $this->char(30),
            'Method' => $this->char(10),
            'Description' => $this->char(100),
            'Created' => $this->datetime(),
            'Updated' => $this->datetime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('functions');
    }
}
