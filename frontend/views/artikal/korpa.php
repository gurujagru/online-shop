<?php
    use yii\helpers\Html;
    use frontend\assets\AppAsset;

AppAsset::register($this);
?>
<div>
    <h1>Korpa <a href="#stavi" type="button" id="dodaj" class="btn btn-primary">Dodaj artikle</a></h1>
    <table class="table table-responsive">
    <th>Naziv</th>
    <th>Cena (din.)</th>
<?php
    $total = 0;
    foreach ($_SESSION['shopping_cart'] as $keys => $values):?>
        <tr>
            <td><?= Html::img(Yii::getAlias('@slikaUrl').'/'.$values['slika'],['width'=>60,'class'=>'mojaKlasa'])?></td>
            <td><?= Html::a($values['naslov'],'/artikal/view?id='.$values['id'])?></td>
            <td><?= $values['cena']?></td>
            <td><a href="/artikal/korpa?action=ukloni&id=<?php echo $values['id']?>"  name="Ukloni" class="btn btn-danger">Ukloni</a></td>
        </tr>
        <?php $total = $total + $values['cena'];
            $_SESSION['ukupno'] = $total;
        ?>
    <?php endforeach ?>
    <tr>
        <td align="right" colspan="2"><b>Ukupno</b></td>
        <td><b><?=$total?></b></td>
        <td><a href="#stavi" type="button" id="poruci" class="btn btn-success">Poruci</a><td>
    </tr>
    </table>
    </div>
<div id="stavi"></div>
<div id="myModal" class="modalMoj">
    <span class="zatvori">&times;</span>
    <img class="modalMoj-content" id="img01">
    <div id="caption"></div>
</div>

