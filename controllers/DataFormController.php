<?php

namespace app\controllers;

use Yii;
use app\models\DataForm;
use app\models\Registrasi;
use PHPUnit\Metadata\Annotation\Parser\Registry;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class DataFormController extends Controller{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionCreate($id_registrasi=null)
    {
        $model = new DataForm();

        if ($id_registrasi != null){
            $model->id_registrasi = $id_registrasi;
        }

        if ($model->load(Yii::$app->request->post())) {
            // dataFields will be filled automatically from POST
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Form data saved successfully.');
                return $this->redirect(['registrasi/index']);
            }
        }

        return $this->render('create', [
            'dataform' => $model,
        ]);
    }

    protected function findModelByRegistrasi($id_registrasi)
    {
        if (($model = DataForm::findOne(['id_registrasi' => $id_registrasi, 'is_delete' => false])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionUpdate($id_registrasi)
    {
        $model = $this->findModelByRegistrasi($id_registrasi);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Data updated successfully');
            return $this->redirect(['registrasi/index']);
        }

        return $this->render('update', [
            'dataform' => $model,
        ]);
    }

    public function actionDelete($id_registrasi)
    {
        $model = $this->findModelByRegistrasi($id_registrasi);

        if ($model !== null) {
            $model->is_delete = true;
            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Data deleted successfully');
            } else {
                Yii::$app->session->setFlash('error', 'Failed to delete data');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Data not found');
        }

        return $this->redirect(['registrasi/index']);
    }

    public function actionView($id_registrasi)
    {
        $model_form = $this->findModelByRegistrasi($id_registrasi);
        $model_registrasi = new Registrasi();
        $model_registrasi = Registrasi::findOne(['id_registrasi' => $id_registrasi]);

        if ($model_form === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $this->render('view', [
            'model_form' => $model_form,
            'model_registrasi' => $model_registrasi
        ]);
    }
}
