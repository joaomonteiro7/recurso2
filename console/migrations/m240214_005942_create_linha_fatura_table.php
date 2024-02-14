<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%linha_fatura}}`.
 */
class m240214_005942_create_linha_fatura_table extends Migration
{
    public function safeUp()
    {
        // Check if the table exists before trying to create it
        if (!$this->db->getTableSchema('{{%linha_fatura}}')) {
            $this->createTable('{{%linha_fatura}}', [
                'id' => $this->primaryKey(),
                'produto_id' => $this->integer(),
                'fatura_id' => $this->integer(),
                'quantity' => $this->decimal(4, 2)
            ], 'ENGINE=InnoDB');

            $this->createIndex(
                '{{%idx-linha_fatura-produto_id}}',
                '{{%linha_fatura}}',
                'produto_id'
            );

            $this->addForeignKey(
                '{{%fk-linha_fatura-produto_id}}',
                '{{%linha_fatura}}',
                'produto_id',
                '{{%produto}}',
                'id',
                'CASCADE'
            );


             $this->createIndex(
                '{{%idx-linha_fatura-fatura_id}}',
                '{{%linha_fatura}}',
                'fatura_id'
            );

            $this->addForeignKey(
                '{{%fk-linha_fatura-fatura_id}}',
                '{{%linha_fatura}}',
                'fatura_id',
                '{{%fatura}}',
                'id',
                'CASCADE'
            ); 
        } else {
            echo "Table 'linha_fatura' already exists. Migration skipped.\n";
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Check if the table exists before trying to drop it
        if ($this->db->getTableSchema('{{%linha_fatura}}')) {
            $this->dropForeignKey(
                '{{%fk-linha_fatura-produto_id}}',
                '{{%linha_fatura}}'
            );

            $this->dropIndex(
                '{{%idx-linha_fatura-produto_id}}',
                '{{%linha_fatura}}'
            );

            $this->dropForeignKey(
                '{{%fk-linha_fatura-fatura_id}}',
                '{{%linha_fatura}}'
            );

            $this->dropIndex(
                '{{%idx-linha_fatura-fatura_id}}',
                '{{%linha_fatura}}'
            ); 

            $this->dropTable('{{%linha_fatura}}');
        } else {
            echo "Table 'linha_fatura' does not exist. Migration skipped.\n";
        }
    }
}
