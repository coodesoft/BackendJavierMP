<?php

use yii\db\Migration;

/**
 * Handles the creation of table `usersinrole`.
 * Has foreign keys to the tables:
 *
 * - `roles`
 * - `users`
 */
class m180320_212131_create_usersinrole_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('usersinrole', [
            'id' => $this->primaryKey(),
            'RoleId' => $this->integer()->notNull(),
            'UserId' => $this->integer()->notNull(),
        ]);

        // creates index for column `RoleId`
        $this->createIndex(
            'idx-usersinrole-RoleId',
            'usersinrole',
            'RoleId'
        );

        // add foreign key for table `roles`
        $this->addForeignKey(
            'fk-usersinrole-RoleId',
            'usersinrole',
            'RoleId',
            'roles',
            'id',
            'CASCADE'
        );

        // creates index for column `UserId`
        $this->createIndex(
            'idx-usersinrole-UserId',
            'usersinrole',
            'UserId'
        );

        // add foreign key for table `users`
        $this->addForeignKey(
            'fk-usersinrole-UserId',
            'usersinrole',
            'UserId',
            'users',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `roles`
        $this->dropForeignKey(
            'fk-usersinrole-RoleId',
            'usersinrole'
        );

        // drops index for column `RoleId`
        $this->dropIndex(
            'idx-usersinrole-RoleId',
            'usersinrole'
        );

        // drops foreign key for table `users`
        $this->dropForeignKey(
            'fk-usersinrole-UserId',
            'usersinrole'
        );

        // drops index for column `UserId`
        $this->dropIndex(
            'idx-usersinrole-UserId',
            'usersinrole'
        );

        $this->dropTable('usersinrole');
    }
}
