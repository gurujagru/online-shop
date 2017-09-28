<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\ArtikalSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="artikal-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'naslov') ?>

    <?= $form->field($model, 'slika') ?>

    <?= $form->field($model, 'opis') ?>

    <?= $form->field($model, 'cena') ?>

    <?php // echo $form->field($model, 'proizvodjac') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
