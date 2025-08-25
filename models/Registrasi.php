<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;

class Registrasi extends ActiveRecord
{
    public static function tableName()
    {
        return 'registrasi';
    }

    public function rules()
    {
        return [
            [['no_rekam_medis'], 'required'],
            [['no_registrasi'], 'required', 'on' => 'update'],
            [['no_registrasi', 'no_rekam_medis', 'create_by', 'update_by'], 'integer'],
            [['create_time_at', 'update_time_at'], 'safe'],
            [['no_registrasi'], 'unique'],
            [['no_rekam_medis'], 'exist', 'targetClass' => Pasien::class, 'targetAttribute' => 'no_rekam_medis'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id_registrasi' => 'ID Registrasi',
            'no_registrasi' => 'No Registrasi',
            'no_rekam_medis' => 'No Rekam Medis',
            'create_by' => 'Dibuat Oleh',
            'create_time_at' => 'Dibuat Pada',
            'update_by' => 'Diubah Oleh',
            'update_time_at' => 'Diubah Pada',
        ];
    }

    // In your Model (e.g. Registrasi.php)

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
                'defaultValue' => 1,
            ],
        ];
    }

    public function getPasien()
    {
        return $this->hasOne(Pasien::class, ['no_rekam_medis' => 'no_rekam_medis']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert && empty($this->no_registrasi)) {
                $this->no_registrasi = $this->generateNoRegistrasi();
            }
            return true;
        }
        return false;
    }

    /**
     * KUNCI PERBAIKAN: Logika baru untuk generate No Registrasi.
     * @return int
     */
    private function generateNoRegistrasi()
    {
        $datePrefix = date('Ymd');
        
        // Menentukan rentang nomor untuk hari ini (misal: 202508250000 s/d 202508259999)
        $startOfDay = (int) ($datePrefix . '0000');
        $endOfDay = (int) ($datePrefix . '9999');

        // Mencari nomor registrasi TERTINGGI di hari ini
        $maxReg = self::find()
            ->where(['between', 'no_registrasi', $startOfDay, $endOfDay])
            ->max('no_registrasi');

        if ($maxReg) {
            // Jika sudah ada nomor, tambahkan 1
            $newReg = $maxReg + 1;
        } else {
            // Jika belum ada, buat nomor pertama untuk hari ini
            $newReg = (int) ($datePrefix . '0001');
        }
        
        return $newReg;
    }
}
