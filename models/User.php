<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return '{{%user}}';
    }

    // === IdentityInterface ===
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null; // tidak dipakai
    }

    // cari user by username
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    // cari user by email
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return null; // bisa tambahkan kolom auth_key kalau perlu
    }

    public function validateAuthKey($authKey)
    {
        return true; // kalau pakai auth_key, validasi di sini
    }

    // validasi password
    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password);
    }

    // sebelum simpan, hash password
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (!empty($this->password) && $this->isAttributeChanged('password')) {
                $this->password = \Yii::$app->security->generatePasswordHash($this->password);
            }
            return true;
        }
        return false;
    }
}
