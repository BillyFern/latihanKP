<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use app\models\Registrasi;
use app\models\DataForm;

class RegistrasiController extends Controller
{
    public function actionIndex()
    {
        $query = Registrasi::find();

        $q = Yii::$app->request->get('q');
        if (!empty($q)) {
            $query->andFilterWhere(['ilike', 'nama_pasien', $q])
                ->orFilterWhere(['like', "CAST(nik AS TEXT)", $q])
                ->orFilterWhere(['like', "CAST(no_registrasi AS TEXT)", $q]);
        }
    
        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $registrasi = $query->orderBy('nama_pasien')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $model = new Registrasi();
        $dataform = new DataForm();
        $existingDataIds = DataForm::find()
            ->select('id_registrasi')
            ->where(['is_delete' => false])
            ->column();

        return $this->render('index', [
            'registrasi' => $registrasi,
            'pagination' => $pagination,
            'model' => $model,
            'dataform' => $dataform,
            'existingDataIds' => $existingDataIds
        ]);
    }

    public function actionCreate()
    {
        $model = new Registrasi();

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Registrasi Berhasil Ditambahkan!');
            return $this->redirect(['index']);
        }
        return $this->render('_form', [
            'model' => $model,
        ]);
    }
}


?>