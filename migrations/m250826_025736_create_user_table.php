<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m250826_025736_create_user_table extends Migration
{
    public function safeUp()
    {
        // Buat tabel user
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(100)->notNull(),
            'email' => $this->string()->notNull()->unique(),
            'password' => $this->string()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // Buat function untuk auto-update updated_at
        $this->execute("
            CREATE OR REPLACE FUNCTION update_updated_at_column()
            RETURNS TRIGGER AS $$
            BEGIN
                NEW.updated_at = NOW();
                RETURN NEW;
            END;
            $$ language 'plpgsql';
        ");

        // Buat trigger untuk tabel user
        $this->execute("
            CREATE TRIGGER update_user_updated_at
            BEFORE UPDATE ON {{%user}}
            FOR EACH ROW
            EXECUTE FUNCTION update_updated_at_column();
        ");
    }

    public function safeDown()
    {
        if ($this->db->schema->getTableSchema('{{%user}}', true) !== null) {
            $this->dropTable('{{%user}}');
        }
    }
}
