<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\linhafatura $model */

$this->title = 'Create Linhafatura';
$this->params['breadcrumbs'][] = ['label' => 'Linhafaturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="linhafatura-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
