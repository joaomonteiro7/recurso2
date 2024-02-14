<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Fatura;
use common\models\produto;
use yii\filters\VerbFilter;
use common\models\LinhaFatura;
use frontend\models\ProdutoSearch;
use yii\web\NotFoundHttpException;

/**
 * ProdutoController implements the CRUD actions for produto model.
 */
class ProdutoController extends Controller
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
     * Lists all produto models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProdutoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionBuy($id)
    {
        $faturaPayment = Fatura::findOne(['state' => 'payment']);
        $model = new LinhaFatura();
        $produto = Produto::findOne(['id' => $id]);

        if (!$faturaPayment) {

            $fatura = new Fatura();

            if ($this->request->isPost) {
                $fatura->user_id = Yii::$app->user->getId();
                $fatura->state = 'payment';
                $model->produto_id = $id;

                if ($model->load($this->request->post()) && $model->save()) {
                    $fatura->price += $produto->price * $model->quantity;
                    $fatura->save();
                    $model->fatura_id = $fatura->id;
                    $model->save();
                    return $this->redirect(['produto/index']);
                }
            }
        } else {
            if ($this->request->isPost) {
                $model->produto_id = $id;
                $model->fatura_id = $faturaPayment->id;
                if ($model->load($this->request->post()) && $model->save()) {
                    $faturaPayment->price += $produto->price * $model->quantity;
                    $faturaPayment->save();

                    return $this->redirect(['produto/index']);
                }
            }
        }
        return $this->render('@frontend/views/linhafatura/create', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the produto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return produto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = produto::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
