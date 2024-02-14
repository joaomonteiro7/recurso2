<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%fatura}}`.
 * - `{{%user}}`
 * - `{{%produto}}`
 */
class m240214_003945_create_fatura_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%fatura}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'price' => $this->decimal(4, 2)->notNull(),
            'state' => $this->getDb()->getSchema()->createColumnSchemaBuilder("ENUM('payment', 'paid', 'completed')")->notNull()
        ], 'ENGINE=InnoDB');

        $this->createIndex(
            '{{%idx-fatura-user_id}}',
            '{{%fatura}}',
            'user_id'
        );

        $this->addForeignKey(
            '{{%fk-fatura-user_id}}',
            '{{%fatura}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            '{{%fk-fatura-user_id}}',
            '{{%fatura}}'
        );

        $this->dropIndex(
            '{{%idx-fatura-user_id}}',
            '{{%fatura}}'
        );

        $this->dropTable('{{%fatura}}');
    }
}
