<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\linhafatura $model */

$this->title = 'Update Linhafatura: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Linhafaturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="linhafatura-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
