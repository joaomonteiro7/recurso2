<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\user $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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
        ],
    ]) ?>

</div>