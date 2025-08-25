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