<?php

use yii\helpers\Html;
use yii\grid\GridView;
use frontend\assets\AppAsset;

AppAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ArtikalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Artikli';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="artikal-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>
    <div>
        <?php if(Yii::$app->user->can('create-artikal')){
        echo Html::a('Napravi novi artikal', ['create'], ['class' => 'btn btn-success']);
        } ?>
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn'
            ],
            [
              'attribute'=>'slika',
                'value' => function ($data) {
                    return $img = Html::img(Yii::getAlias('@slikaUrl').'/' . $data['slika'],
                        ['width'=>60,'class'=>'mojaKlasa','alt'=>$data['naslov']]);
                },
                'format'=>'raw',
                'label'=>''
            ],
            [
                'attribute'=>'naslov',
                'label'=>'Naziv',
                'value'=>function($data) {
                   return Html::a($data['naslov'],'/artikal/view?id='.$data['id']);
                        },
                'format'=>'raw'
            ],
            [
                'attribute'=>'cena',
                'label'=>'Cena (min-max)'
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
<div id="myModal" class="modalMoj">
    <span class="zatvori">&times;</span><img class="modalMoj-content" id="img01">
    <div id="caption"></div>
</div>


