<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\assets\AppAsset;

AppAsset::register($this);

/* @var $this yii\web\View */
/* @var $model frontend\models\Artikal */

$this->title = ucfirst($model->naslov);
$this->params['breadcrumbs'][] = ['label' => 'Artikli', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="artikal-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?php if(Yii::$app->user->can('update-artikal')):?>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php if(Yii::$app->user->can('delete-artikal')):?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?php endif?>
        <?php endif?>
    </p>
    <div align="center">
        <?php $model->save()?>
        <?= Html::a('',['korpa','id'=>$model->id],['class'=>'glyphicon glyphicon-shopping-cart','width'=>100])?>
        Stavi u korpu
    </div>
    <div id="artikalView">
    <?= DetailView::widget(
        [
            'model' => $model,
            'attributes' => [
                [
                    'attribute'=>'naslov',
                    'label'=>'Naziv'
                ],
                'opis:text',
                'cena',
                'proizvodjac',
                [
                    'attribute'=>'slika',
                    'value'=>Html::img(Yii::getAlias('@slikaUrl').'/'.$model->slika, ['width'=>200,'id'=>'myImg','alt'=>$model->naslov]),
                    'format'=>'raw'
                ],
            ]
        ]) ?>
    <table class="table table-bordered">
        <thead><b>Postojece kategorije</b></thead>
        <tr>
        <?php foreach($kategorije as $kategorija):?>
        <td bgcolor="white"><?= ucfirst($kategorija['naziv']);?></td>
        </tr>
        <?php endforeach ?>
    </table>
    </div>
</div>
<div id="myModal" class="modalMoj">
    <span class="zatvori">&times;</span>
    <img class="modalMoj-content" id="img01">
    <div id="caption"></div>
</div>


