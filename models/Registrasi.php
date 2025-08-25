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
    public function beforeSave($insert)
    {
        if ($insert) {
            // Get today’s date in ddmmyy
            $date = date('dmy');

            // Find last no_registrasi starting with today’s date
            $last = self::find()
                ->where(['like', "CAST(no_registrasi AS TEXT)", $date . '%', false])
                ->orderBy(['no_registrasi' => SORT_DESC])
                ->one();

            if ($last) {
                // Get the last 3 digits and increment
                $lastNumber = (int)substr($last->no_registrasi, -3);
                $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            } else {
                // If no record today, start from 001
                $newNumber = '001';
            }

            // Set the new no_registrasi
            $this->no_registrasi = $date . $newNumber;
            $this->no_rekam_medis = $date . $newNumber;
        }

        return parent::beforeSave($insert);
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
