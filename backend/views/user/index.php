<?php

use common\models\user;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\userSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'username',
            'email',
            [
                'label' => 'Name',
                'value' => function ($model) {
                    return $model->userInfo ? $model->userInfo->name : null; // Substitua attributeName pelo nome do atributo que deseja exibir
                },
            ],
            [
                'label' => 'Address',
                'value' => function ($model) {
                    return $model->userInfo ? $model->userInfo->address : null; // Substitua attributeName pelo nome do atributo que deseja exibir
                },
            ],
            [
                'label' => 'Nif',
                'value' => function ($model) {
                    return $model->userInfo ? $model->userInfo->nif : null; // Substitua attributeName pelo nome do atributo que deseja exibir
                },
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, user $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
