<?php

namespace app\controllers;

use app\models\Pasien;
use app\models\PasienSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * PasienController implements the CRUD actions for Pasien model.
 */
class PasienController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Pasien models and provides a model for the create form modal.
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PasienSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        // Menyiapkan model kosong untuk form 'create' di dalam modal
        $model = new Pasien();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model, // Mengirim model ini ke view index
        ]);
    }

    /**
     * Creates a new Pasien model from the modal form.
     * Redirects to the 'index' page with a success or error flash message.
     * @return \yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Pasien();

        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($model->save()) {
                // Jika berhasil, kirim notifikasi sukses
                Yii::$app->session->setFlash('success', 'Data pasien berhasil ditambahkan!');
            } else {
                // Jika gagal, kumpulkan semua error dan kirim notifikasi gagal
                $errors = \yii\helpers\Html::errorSummary($model, ['header' => '<strong>Mohon perbaiki kesalahan berikut:</strong>']);
                Yii::$app->session->setFlash('error', $errors);
            }
        }

        // Selalu kembali ke halaman index setelah mencoba menyimpan
        return $this->redirect(['index']);
    }

    /**
     * Displays a single Pasien model.
     * @param int $id_pasien ID Pasien
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_pasien)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_pasien),
        ]);
    }

    /**
     * Updates an existing Pasien model from a modal form.
     * On success or failure, it redirects back to the index page.
     * @param int $id_pasien ID Pasien
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_pasien)
    {
        $model = $this->findModel($id_pasien);

        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Data pasien berhasil diubah!');
            } else {
                // Jika gagal, kirim error via flash message, sama seperti actionCreate
                $errors = \yii\helpers\Html::errorSummary($model, ['header' => '<strong>Mohon perbaiki kesalahan berikut:</strong>']);
                Yii::$app->session->setFlash('error', $errors);
            }
            // Selalu redirect kembali ke halaman index
            return $this->redirect(['index']);
        }

        // Baris ini tidak akan dieksekusi jika form modal di-submit,
        // hanya jika URL /update diakses langsung via GET request.
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Pasien model.
     * @param int $id_pasien ID Pasien
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete()
{
    $id_pasien = Yii::$app->request->post('id_pasien');

    if ($id_pasien !== null) {
        $this->findModel($id_pasien)->delete();
        Yii::$app->session->setFlash('success', 'Data pasien telah dihapus.');
    } else {
        Yii::$app->session->setFlash('error', 'ID pasien tidak ditemukan.');
    }

    return $this->redirect(['index']);
}
    /**
     * Finds the Pasien model based on its primary key value.
     * @param int $id_pasien ID Pasien
     * @return Pasien the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_pasien)
    {
        if (($model = Pasien::findOne(['id_pasien' => $id_pasien])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Action for Select2 AJAX search.
     * @param string|null $q
     * @return array
     */
    public function actionPasienList($q = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => [['id' => '', 'text' => '']]];
        if (!is_null($q)) {
            $query = new \yii\db\Query();
            $query->select('no_rekam_medis AS id, CONCAT(no_rekam_medis, \' - \', nama) AS text')
                ->from('pasien')
                ->where(['ilike', 'nama', $q])
                ->orWhere(['like', new \yii\db\Expression('CAST(no_rekam_medis AS TEXT)'), $q . '%']);
            
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        return $out;
    }
}
