<div>
    <ul>
        <li>Broj porudzbine: <?= $poslednjaPorudzbina[0]['id']?></li>

        <li>Artikli: <ul><?php foreach ($poslednjaPorudzbina as $one):?>
                <li><?= $one['naslov']?></li>
                <?php endforeach?>
            </ul>
        </li>
    </ul>
</div>
    <a href='/artikal/otkazi-porudzbinu?action=otkazi-porudzbinu' class="btn btn-danger">Otkazi porudzbinu</a>
