<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;


class DataForm extends ActiveRecord
{
    public $dataFields = []; // virtual attribute to hold JSON data

    public static function tableName()
    {
        return 'data_form';
    }

    public function rules()
    {
        return [
            [['id_registrasi'], 'required'],
            [['id_form', 'id_form_data', 'id_registrasi', 'create_by', 'update_by'], 'integer'],
            [['is_delete'], 'boolean'],
            [['data'], 'safe'], // store JSON
            [['dataFields'], 'safe'], // allow array input
        ];
    }

    public function afterFind()
    {
        parent::afterFind();
        // Decode JSON back into array
        $this->dataFields = json_decode($this->data, true);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Encode dataFields into JSON before saving
            if (!empty($this->dataFields)) {
                $this->data = json_encode($this->dataFields, JSON_UNESCAPED_UNICODE);
            } else {
                $this->data = json_encode(new \stdClass()); // store empty object instead of null
            }
             // Make sure id_form always matches id_form_data
            $this->id_form = $this->id_form_data;

            // Ensure is_delete is false by default when inserting
            if ($insert && $this->is_delete === null) {
                $this->is_delete = false;
            }
            return true;
        }
        return false;
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