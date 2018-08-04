<?php
use frontend\assets\AppAsset;
AppAsset::register($this);
?>

<div class="row">
    <div class="col-md-6">
        <div class="dugmici">
            <button id="tabelaId" class="btn btn-info">Stampaj</button>
            <button id="download" class="btn btn-primary">Snimi</button><br/><br/>
        </div>
        <div id="tabelarka">
            <table class="table-striped" width="500" border="1"  cellspacing="0">
                <tr align="center">
                    <td colspan="3"><b>Narudzbenica br: <?=$noviId?></b></h3></td>
                </tr>
                <tr align="center">
                    <td>Sifra</td>
                    <td colspan="1">Naziv</td>
                    <td>Cena (din.)</td>
                </tr>
                    <?php
                    if(isset($artikal)):
                    foreach ($artikal as $key=>$value): ?>
                <tr align="center">
                    <td><?=$value['id']?></td>
                    <td><?=$value['naslov']?></td>
                    <td><?=$value['cena']?></td>
                </tr>
                    <?php
                    endforeach;
                    endif
                    ?>
                <tr align="center">
                    <td colspan="2"><b>Ukupna vrednost porudzbine:</b></td>
                    <td colspan="1"><b><?=$ukupno?></b></td>
                </tr>
                <tr>
                    <td colspan="3" align="center"><h4><b>Podaci o kupcu</b></h4></td>
                </tr>
                <tr>
                    <td colspan="1">Ime</td>
                    <td colspan="2"><?=$korisnik['ime']?></td>
                </tr>
                <tr>
                    <td colspan="1">E-mail</td>
                    <td colspan="2"><?=$korisnik['email']?></td>
                </tr>
                <tr>
                    <td colspan="1">Ulica i broj</td>
                    <td colspan="2"><?=$korisnik['ulica'].' '.$korisnik['ulicni_broj']?></td>
                </tr>
                <tr>
                    <td colspan="1">Postanski broj i grad</td>
                    <td colspan="2"><?=$korisnik['postanski_broj']." ".$korisnik['grad']?></td>
                </tr>
                <tr>
                    <td colspan="1">Zemlja</td>
                    <td colspan="2"><?=$korisnik['zemlja']?></td>
                </tr>
            </table>
        </div>
        <?php if (Yii::$app->user->isGuest):?>
        <h3>Da biste potvrdili porudzbinu, morate biti ulogovani!<br/>
        Registrujte sa vec unetim podacima!
        <button id="registracija" class="btn btn-info">Registruj se!</button>
        </h3>
        <?php else:?>
        <br/>
        <a href="/artikal/potvrdi-porudzbinu" class="btn btn-success btn-lg">Potvrdi porudzbinu</a>
        <?php endif?>
    </div>
    <div id="signup" class="col-md-6">
    </div>
</div>
<iframe id="zaStampu"></iframe>

