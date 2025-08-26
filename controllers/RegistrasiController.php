<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use app\models\Registrasi;
use app\models\DataForm;
use yii\helpers\Html;

class RegistrasiController extends Controller
{
    public function actionIndex()
    {
        // KUNCI PERBAIKAN ADA DI SINI:
        // 1. `joinWith('pasien')`: Melakukan JOIN ke tabel 'pasien'.
        // 2. `with('pasien')`: Mengambil data relasi secara efisien (eager loading).
        $query = Registrasi::find()->joinWith('pasien')->with('pasien');

        $q = Yii::$app->request->get('q');
        // if (!empty($q)) {
        //     $query->andFilterWhere(['ilike', 'nama_pasien', $q])
        //         ->orFilterWhere(['like', "CAST(nik AS TEXT)", $q])
        //         ->orFilterWhere(['like', "CAST(no_registrasi AS TEXT)", $q]);
        // }
    
        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        // 3. `orderBy('pasien.nama ASC')`: Mengurutkan berdasarkan kolom 'nama' dari tabel 'pasien'.
        // Ini menyelesaikan error "Unknown Property nama_pasien".
        $registrasi = $query->orderBy('pasien.nama ASC')
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

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Registrasi Berhasil Ditambahkan!');
            } else {
                // Jika gagal, tampilkan pesan error yang lebih detail
                $errors = Html::errorSummary($model, ['header' => '<strong>Mohon perbaiki kesalahan berikut:</strong>']);
                Yii::$app->session->setFlash('error', $errors);
            }
        }

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = \app\models\Registrasi::findOne($id)) !== null) {
            return $model;
        }

        throw new \yii\web\NotFoundHttpException('The requested registrasi does not exist.');
    }

    
    public function actionUpdate($id)
    {
        try {
            $model = $this->findModel($id);

            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        } catch (\Throwable $e) {
            // For debugging: output the error directly
            Yii::error($e->getMessage() . "\n" . $e->getTraceAsString());
            return "<pre style='color:red;'>".$e->getMessage()."\n".$e->getTraceAsString()."</pre>";
        }
    }
}

