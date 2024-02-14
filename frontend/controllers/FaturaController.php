<?php

namespace frontend\controllers;

use common\models\User;
use yii\web\Controller;
use common\models\fatura;
use yii\filters\VerbFilter;
use common\models\LinhaFatura;
use yii\data\ActiveDataProvider;
use frontend\models\FaturaSearch;
use yii\web\NotFoundHttpException;

/**
 * FaturaController implements the CRUD actions for fatura model.
 */
class FaturaController extends Controller
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
     * Lists all fatura models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new FaturaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single fatura model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $LinhaFaturaProvider = new ActiveDataProvider([
            'query' => LinhaFatura::find()->where(['fatura_id' => $model->id]),
        ]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'linhaFaturaProvider' => $LinhaFaturaProvider,
        ]);
    }

    public function actionPay($id)
    {
        $fatura = Fatura::findOne(['id' => $id]);
        $user = User::findOne(['id' => $fatura->user_id]);
        // Check order status
        if($fatura->state == 'payment'){
            // Redirect to payment page
            return $this->render('pay', [
                'fatura' => $fatura,
                'user' => $user
            ]);
        }
    }

    
    public function actionPayfatura($id)
    {
        $fatura = Fatura::findOne(['id' => $id]);
        // Check fatura status
        if($fatura){
            $fatura->state = "paid";
            $fatura->save();
            // Redirect to payment page
            return $this->redirect(['fatura/index']);
        }
    }

    /**
     * Deletes an existing fatura model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the fatura model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return fatura the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = fatura::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
