<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Artikal */

$this->title = 'Update Artikal: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Artikli', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="artikal-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'kategorija'=>$kategorija,
        'postojeceKategorije'=>$postojeceKategorije
    ]) ?>
</div>

