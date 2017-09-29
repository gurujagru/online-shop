<?php
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'GURUJAGRU',
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems =[
            //['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Contact', 'url' => ['/site/contact']],

        ];
    $leftMenuItems = [
            ['label' => 'Home', 'url' => '/site'],
            ['label' => 'Artikli', 'url' => '/artikal'],
            ['label' => 'Kategorije',
            'items'=>[
                ['label' => 'Kozmetika','url'=>'/artikal/kozmetika'],
                ['label' => 'Higijena','url'=>'/artikal/higijena'],
                ['label'=> 'Kucna hemija','url'=>'/artikal/kucna-hemija']
            ]
        ]
    ];
    $session = Yii::$app->session;
    $session->open();
        if (empty($_SESSION['shopping_cart'])){
        } else {
        $index = max(array_keys($_SESSION['shopping_cart']));
        $menuItems[] = ['label' => 'Korpa', 'url' => '/artikal/korpa?action=porudzbina&id='.$_SESSION['shopping_cart'][$index]['id']];
        }
    if (isset($session['poslednjaPorudzbina'])) {
        $menuItems[] = ['label' => 'Otkazi porudzbinu', 'url' =>'/artikal/otkazi-porudzbinu','class'=>'otkazi-porudzbinu'];
        }
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => $leftMenuItems,
    ]);

    NavBar::end();
    ?>
    <div class="container">

        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>

    </div>
</div>
<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; GURUJAGRU <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>


