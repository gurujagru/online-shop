<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\models\Kategorija;
use frontend\assets\AppAsset;

AppAsset::register($this);

/* @var $this yii\web\View */
/* @var $model frontend\models\Artikal */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="artikal-form">

<?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>
<?= $form->field($model, 'naslov')->textInput() ?>
<?= $form->field($model,'upload_slika')->fileInput(['id'=>'promeniSliku']);?>
<?= isset($model->slika)?Html::label('Slika', ['class'=>'control-label']):null?><br/>
<?= isset($model->slika)?Html::img(Yii::getAlias('@slikaUrl').'/'.$model->slika,['width'=>200,'id'=>'myImg']):'<img id="myImg" src="" width="200">';?><?= $form->field($model, 'opis')->textarea(['rows' => 6]) ?><?= $form->field($model, 'cena')->textInput() ?><?= $form->field($model, 'proizvodjac')->textInput(['maxlength' => true]) ?>
<?php if (isset($postojeceKategorije)):?>
    <div>
    <table class="table table-borderless">
        <thead><b>Postojece kategorije</b></thead>
        <tr>
            <?php foreach($postojeceKategorije as $postojecaKategorija):?>
                <td id="beloPolje"><?= ucfirst($postojecaKategorija['naziv']);?></td>
                <?php if (Yii::$app->user->can('obrisi-kategoriju')):?>
                    <td align="right" width="1px">
                        <?= Html::a('Obrisi kategoriju',
                        [
                        'artikal/obrisi', 'id'=>$model->id,
                        'idPostojeceKategorije' => $postojecaKategorija['id']
                        ],
                        [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Da li zelite da obrisete kategoriju?',
                            'method' => 'post',
                        ]
                        ])?>
                    </td>
                <?php endif ?>
        </tr>
            <?php endforeach ?>
    </table>
<?php endif ?>
    </div>
<?= $form->field($kategorija, 'naziv')->dropDownList(
    ArrayHelper::map(Kategorija::find()->all(),'id','naziv'),
    ['prompt'=>isset($postojecaKategorija)?'':$kategorija->naziv,]
);?>
<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end();?>
</div>
<div id="myModal" class="modalMoj">
    <span class="zatvori">&times;</span>
    <img class="modalMoj-content" id="img01">
    <div id="caption"></div>
</div>

