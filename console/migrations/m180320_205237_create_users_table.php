<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users`.
 */
class m180320_205237_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'FirstName' => $this->char(50),
            'LastName' => $this->char(50),
            'Email' => $this->char(60),
            'Password' => $this->char(100),
            'Organization_code' => $this->char(10),
            'Created' => $this->datetime(),
            'Updated' => $this->datetime(),
            'Created_by' => $this->integer(),
            'disabled_on' => $this->datetime(),
            'pw_expiration_date' => $this->datetime(),
            'token' => $this->char(200),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('users');
    }
}
