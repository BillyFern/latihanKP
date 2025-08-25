<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "pasien".
 *
 * @property int $id_pasien
 * @property int $no_rekam_medis
 * @property string|null $nama
 * @property string|null $tanggal_lahir
 * @property string|null $nik
 * @property int|null $create_by
 * @property string|null $create_time_at
 * @property int|null $update_by
 * @property string|null $update_time_at
 */
class Pasien extends ActiveRecord
{
    public static function tableName()
    {
        return 'pasien';
    }

    public function rules()
    {
        return [
            [['nama', 'tanggal_lahir', 'nik'], 'required'],
            [['nik'], 'filter', 'filter' => 'strval'],
            [['no_rekam_medis'], 'required', 'on' => 'update'],
            [['no_rekam_medis', 'create_by', 'update_by'], 'integer'],
            [['tanggal_lahir', 'create_time_at', 'update_time_at'], 'safe'],
            [['nama'], 'string', 'max' => 255],
            [['no_rekam_medis', 'nik'], 'unique'],
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
                'defaultValue' => 1, 
            ],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert && empty($this->no_rekam_medis)) {
                $this->no_rekam_medis = $this->generateNoRekamMedis();
            }
            return true;
        }
        return false;
    }

    /**
     * KUNCI PERBAIKAN: Logika baru untuk generate No Rekam Medis.
     * Metode ini lebih andal dan efisien.
     * @return int
     */
    private function generateNoRekamMedis()
    {
        $year = date('Y');
        
        // Menentukan rentang nomor untuk tahun ini (misal: 202500000000 s/d 202599999999)
        $startOfYear = (int) ($year . '00000000');
        $endOfYear = (int) ($year . '99999999');

        // Mencari nomor rekam medis TERTINGGI di tahun ini
        $maxRm = self::find()
            ->where(['between', 'no_rekam_medis', $startOfYear, $endOfYear])
            ->max('no_rekam_medis');

        if ($maxRm) {
            // Jika sudah ada nomor, tambahkan 1
            $newRm = $maxRm + 1;
        } else {
            // Jika belum ada, buat nomor pertama untuk tahun ini
            $newRm = (int) ($year . '00000001');
        }
        
        return $newRm;
    }

    public function getTanggalLahirFormatted()
    {
        if (empty($this->tanggal_lahir)) {
            return '-';
        }
        return Yii::$app->formatter->asDate($this->tanggal_lahir, 'php:d/m/Y');
    }
}
