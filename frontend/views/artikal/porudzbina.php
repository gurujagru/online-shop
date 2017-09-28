<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<h2>Isporuka</h2>
<div id="isporuka">
<?php
$form = ActiveForm::begin([
    'id' => 'formaBato',
    'method'=>'post',
]);?>
<?=$form->field($modelUser,'username')->textInput(['readonly' => !$modelUser->isNewRecord]);?>
<?=$form->field($modelUser,'email')->textInput(['readonly' => !$modelUser->isNewRecord]);?>
<?=$form->field($modelAdresa,'ulica')->textInput();?>
<?=$form->field($modelAdresa,'ulicni_broj')->textInput();?>
<?=$form->field($modelAdresa,'postanski_broj')->textInput();?>
<?=$form->field($modelAdresa,'grad')->textInput();?>
<?=$form->field($modelAdresa,'zemlja')->textInput();?>
<?=Html::submitButton('Sacuvaj',['class'=>'btn btn-success'])?>
<?php ActiveForm::end()?>
</div>



