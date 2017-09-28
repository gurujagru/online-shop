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
    <a href="/artikal/ponisti-porudzbinu">Ponisti porudzbinu</a>