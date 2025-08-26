<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\User;

class SeedController extends Controller
{
    public function actionAddUser()
    {
        $user = new User();
        $user->username = "Karin";
        $user->email = "petugas@gmail.com";
        $user->password = "petugas123"; 

        if ($user->save()) {
            echo "User berhasil ditambahkan.\n";
        } else {
            print_r($user->errors);
        }
    }
}
