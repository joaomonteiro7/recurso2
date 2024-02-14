<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\fatura $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Faturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="fatura-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Pay', ['pay', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
            'user_id',
            'price',
            'state',
        ],
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $linhaFaturaProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'produto_id',
            'quantity',
            [
                'class' => 'yii\grid\ActionColumn',
                'controller' => 'linhafatura', 
                'template' => '{view} {update} {delete}',
            ],
        ],
    ]); ?>

</div>