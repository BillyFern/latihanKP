<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

class Registrasi extends ActiveRecord
{
    public static function tableName()
    {
        return 'registrasi';
    }

    public function rules()
    {
        return [
            [['nama_pasien', 'tanggal_lahir', 'nik'], 'required'],
            [['tanggal_lahir'], 'date', 'format' => 'php:Y-m-d'],
            [['nik'], 'integer'],
            [['nama_pasien'], 'string', 'max' => 255],
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
            // auto-fill created_at_time / updated_at_time
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'create_time_at',
                'updatedAtAttribute' => 'update_time_at',
                'value' => function () {
                    return date('Y-m-d H:i:s');
                },
            ],
            // auto-fill created_by / updated_by (if you have user auth)
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'create_by',
                'updatedByAttribute' => 'update_by',
                'defaultValue' => function () {
                    // if no user system yet, fallback to no_registrasi
                    return $this->no_registrasi ?? 1;
                },
            ],
        ];
    }
}

?>