<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;

class Pasien extends ActiveRecord
{
    public static function tableName()
    {
        return 'pasien';
    }

    public function rules()
    {
        return [
            // Aturan dasar
            [['nama', 'tanggal_lahir', 'nik'], 'required'],
            [['create_by', 'update_by'], 'integer'],
            // no_rekam_medis kita biarkan sebagai safe, karena tidak di-input dari form
            [['no_rekam_medis'], 'safe'],
            [['tanggal_lahir', 'create_time_at', 'update_time_at'], 'safe'],
            [['nama'], 'string', 'max' => 255],

            // --- INI ADALAH PERBAIKAN FINAL ---

            // 1. Validasi 'no_rekam_medis' unik HANYA SAAT MEMBUAT RECORD BARU.
            //    Ini memastikan aturan ini 100% tidak akan berjalan saat update.
            [
                'no_rekam_medis',
                'unique',
                'when' => function ($model) {
                    return $model->isNewRecord;
                },
                'message' => 'No. Rekam Medis ini sudah ada (kesalahan sistem).'
            ],

            // 2. Validasi 'nik' unik HANYA JIKA NILAINYA BENAR-BENAR BERBEDA.
            //    Kita bandingkan nilainya secara manual untuk menghindari masalah tipe data.
            [
                'nik',
                'unique',
                'when' => function ($model) {
                    // Jangan jalankan validasi jika ini record baru (sudah dicover 'required')
                    if ($model->isNewRecord) {
                        return true;
                    }
                    // Jalankan validasi HANYA JIKA nilai lama TIDAK SAMA DENGAN nilai baru
                    // Tanda '==' akan membandingkan nilai tanpa peduli tipe data (string vs integer)
                    return $model->getOldAttribute('nik') != $model->nik;
                },
                'message' => 'NIK ini sudah terdaftar.'
            ],

            // Aturan format NIK
            [['nik'], 'filter', 'filter' => 'strval'],
            [['nik'], 'string', 'length' => 16, 'message' => 'NIK harus 16 digit.'],
            [['nik'], 'match', 'pattern' => '/^[0-9]+$/', 'message' => 'NIK hanya boleh berisi angka.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id_pasien' => 'ID Pasien',
            'no_rekam_medis' => 'No Rekam Medis',
            'nama' => 'Nama Pasien',
            'tanggal_lahir' => 'Tanggal Lahir',
            'nik' => 'NIK',
            'create_by' => 'Dibuat Oleh',
            'create_time_at' => 'Dibuat Pada',
            'update_by' => 'Diubah Oleh',
            'update_time_at' => 'Diubah Pada',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'create_time_at',
                'updatedAtAttribute' => 'update_time_at',
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'create_by',
                'updatedByAttribute' => 'update_by',
                // Sebaiknya nilai default di-handle oleh controller atau biarkan null
                // 'defaultValue' => 1, 
            ],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Jika ini adalah record BARU ($insert = true)
            if ($insert) {
                // Generate nomor rekam medis hanya saat pembuatan data baru
                $this->no_rekam_medis = $this->generateNoRekamMedis();
            }
            // Tidak perlu ada logika apa pun untuk 'update' di sini
            // karena no_rekam_medis dan NIK sudah di-handle oleh rules().
            return true;
        }
        return false;
    }


    private function generateNoRekamMedis()
    {
        $year = date('Y');
        // Menggunakan string untuk menghindari masalah integer overflow pada sistem 32-bit
        $startOfYear = $year . '00000000';
        $endOfYear   = $year . '99999999';

        $maxRm = self::find()
            ->where(['between', 'no_rekam_medis', $startOfYear, $endOfYear])
            ->max('no_rekam_medis');

        // Jika belum ada rekam medis di tahun ini, mulai dari 1. Jika sudah ada, tambahkan 1.
        return $maxRm ? ($maxRm + 1) : (int)($year . '00000001');
    }

    public function getTanggalLahirFormatted()
    {
        if (empty($this->tanggal_lahir)) {
            return '-';
        }
        return Yii::$app->formatter->asDate($this->tanggal_lahir, 'php:d/m/Y');
    }
}
