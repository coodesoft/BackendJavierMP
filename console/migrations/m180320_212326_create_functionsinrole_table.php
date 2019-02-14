<?php

use yii\db\Migration;

/**
 * Handles the creation of table `functionsinrole`.
 * Has foreign keys to the tables:
 *
 * - `roles`
 * - `functions`
 */
class m180320_212326_create_functionsinrole_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('functionsinrole', [
            'id' => $this->primaryKey(),
            'Roleid' => $this->integer()->notNull(),
            'FunctionId' => $this->integer()->notNull(),
        ]);

        // creates index for column `Roleid`
        $this->createIndex(
            'idx-functionsinrole-Roleid',
            'functionsinrole',
            'Roleid'
        );

        // add foreign key for table `roles`
        $this->addForeignKey(
            'fk-functionsinrole-Roleid',
            'functionsinrole',
            'Roleid',
            'roles',
            'id',
            'CASCADE'
        );

        // creates index for column `FunctionId`
        $this->createIndex(
            'idx-functionsinrole-FunctionId',
            'functionsinrole',
            'FunctionId'
        );

        // add foreign key for table `functions`
        $this->addForeignKey(
            'fk-functionsinrole-FunctionId',
            'functionsinrole',
            'FunctionId',
            'functions',
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
            'fk-functionsinrole-Roleid',
            'functionsinrole'
        );

        // drops index for column `Roleid`
        $this->dropIndex(
            'idx-functionsinrole-Roleid',
            'functionsinrole'
        );

        // drops foreign key for table `functions`
        $this->dropForeignKey(
            'fk-functionsinrole-FunctionId',
            'functionsinrole'
        );

        // drops index for column `FunctionId`
        $this->dropIndex(
            'idx-functionsinrole-FunctionId',
            'functionsinrole'
        );

        $this->dropTable('functionsinrole');
    }
}
