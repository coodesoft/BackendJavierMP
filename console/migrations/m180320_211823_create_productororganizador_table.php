<?php

use yii\db\Migration;

/**
 * Handles the creation of table `productororganizador`.
 * Has foreign keys to the tables:
 *
 * - `users`
 * - `users`
 */
class m180320_211823_create_productororganizador_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('productororganizador', [
            'id' => $this->primaryKey(),
            'ProductoId' => $this->integer()->notNull(),
            'OrganizadorId' => $this->integer()->notNull(),
            'FechaInicioVigencia' => $this->datetime(),
            'FechaFinVigencia' => $this->datetime(),
            'MaxComisionProductor' => $this->decimal(6,3),
            'ComisionOrganizador' => $this->decimal(6,3),
            'MaxSumaAseguradoMuerte' => $this->decimal(16,2),
        ]);

        // creates index for column `ProductoId`
        $this->createIndex(
            'idx-productororganizador-ProductoId',
            'productororganizador',
            'ProductoId'
        );

        // add foreign key for table `users`
        $this->addForeignKey(
            'fk-productororganizador-ProductoId',
            'productororganizador',
            'ProductoId',
            'users',
            'id',
            'CASCADE'
        );

        // creates index for column `OrganizadorId`
        $this->createIndex(
            'idx-productororganizador-OrganizadorId',
            'productororganizador',
            'OrganizadorId'
        );

        // add foreign key for table `users`
        $this->addForeignKey(
            'fk-productororganizador-OrganizadorId',
            'productororganizador',
            'OrganizadorId',
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
        // drops foreign key for table `users`
        $this->dropForeignKey(
            'fk-productororganizador-ProductoId',
            'productororganizador'
        );

        // drops index for column `ProductoId`
        $this->dropIndex(
            'idx-productororganizador-ProductoId',
            'productororganizador'
        );

        // drops foreign key for table `users`
        $this->dropForeignKey(
            'fk-productororganizador-OrganizadorId',
            'productororganizador'
        );

        // drops index for column `OrganizadorId`
        $this->dropIndex(
            'idx-productororganizador-OrganizadorId',
            'productororganizador'
        );

        $this->dropTable('productororganizador');
    }
}
