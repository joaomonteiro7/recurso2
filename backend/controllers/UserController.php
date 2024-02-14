<?php

namespace backend\controllers;

use common\models\user;
use yii\web\Controller;
use yii\filters\VerbFilter;
use backend\models\UserForm;
use backend\models\userSearch;
use yii\web\NotFoundHttpException;
use Yii;

/**
 * UserController implements the CRUD actions for user model.
 */
class UserController extends Controller
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
     * Lists all user models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new userSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single user model.
     * @param int $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new user model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new UserForm();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && ($user = $model->save())) {
                return $this->redirect(['user/view', 'id' => $user->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing user model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $user = $this->findModel($id);
    $model = new UserForm();

    // Carrega os dados do usuário no UserForm
    $model->username = $user->username;
    $model->email = $user->email;

    // Verifica se o relacionamento userInfo está definido e não é nulo antes de acessá-lo
    if ($user->userInfo !== null) {
        $model->name = $user->userInfo->name;
        $model->address = $user->userInfo->address;
        $model->nif = $user->userInfo->nif;
    } else {
        // Se não houver userInfo associado, inicialize os atributos com valores padrão ou vazios
        $model->name = '';
        $model->address = '';
        $model->nif = '';
    }

    if ($model->load(Yii::$app->request->post())) {
        if ($model->update($user->id)) {
            // Após a atualização bem-sucedida, redirecione para a página de visualização do usuário
            return $this->redirect(['view', 'id' => $user->id]);
        } else {
            Yii::$app->session->setFlash('error', 'Erro ao atualizar o usuário.');
        }
    }

    return $this->render('update', [
        'model' => $model,
        'user' => $user,
    ]);
    }

    /**
     * Deletes an existing user model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the user model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return user the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = user::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
