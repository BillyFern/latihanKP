<?php

use yii\db\Migration;

/**
 * Handles the creation of tables `{{%registrasi}}` and `{{%data_form}}`.
 */
class m240825_100000_create_registrasi_and_data_form extends Migration
{
    public function safeUp()
    {
        // Table: registrasi
        $this->createTable('{{%registrasi}}', [
            'id_registrasi' => $this->primaryKey()->unsigned()->notNull(),
            'no_registrasi' => $this->bigInteger()->notNull()->unique(),
            'no_rekam_medis' => $this->bigInteger()->notNull()->unique(),
            'nama_pasien' => $this->string(255),
            'tanggal_lahir' => $this->date(),
            'nik' => $this->bigInteger(),
            'create_by' => $this->bigInteger(),
            'create_time_at' => $this->timestamp(),
            'update_by' => $this->bigInteger(),
            'update_time_at' => $this->timestamp(),
        ]);

        // Table: data_form
        $this->createTable('{{%data_form}}', [
            'id_form_data' => $this->primaryKey()->unsigned()->notNull(),
            'id_form' => $this->bigInteger(),
            'id_registrasi' => $this->bigInteger(),
            'data' => $this->json(),
            'is_delete' => $this->boolean()->defaultValue(false),
            'create_by' => $this->bigInteger(),
            'update_by' => $this->bigInteger(),
            'create_time_at' => $this->timestamp(),
            'update_time_at' => $this->timestamp(),
        ]);

        // Foreign key: data_form → registrasi
        $this->addForeignKey(
            'fk_data_form_registrasi',
            '{{%data_form}}',
            'id_registrasi',
            '{{%registrasi}}',
            'id_registrasi',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_data_form_registrasi', '{{%data_form}}');
        $this->dropTable('{{%data_form}}');
        $this->dropTable('{{%registrasi}}');
    }
}
