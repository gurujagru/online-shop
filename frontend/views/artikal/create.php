<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Artikal */

$this->title = 'Create Artikal';
$this->params['breadcrumbs'][] = ['label' => 'Artikli', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="artikal-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'kategorija'=>$kategorija
    ]) ?>

</div>
