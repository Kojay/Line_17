<?php

/* @var $this \yii\web\View */
/* @var $content string */


use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use kartik\sidenav\SideNav;
use yii\helpers\url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

    <script src="//code.jquery.com/jquery-1.12.4.js"></script>
    <script src="//code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="path/to/css/checkbox-x.min.css" media="all" rel="stylesheet" type="text/css" />
    <script src="path/to/js/checkbox-x.min.js" type="text/javascript"></script>

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head()?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="container-fluid">
    <nav role="navigation" class="navbar navbar-default navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header navbar-right pull-right">
          <ul class="nav pull-left">
            <li class="navbar-text pull-left">Benutzername</li>
            <li class="dropdown pull-right">
              <a href="#" data-toggle="dropdown" style="color:#777; margin-top: 5px;" class="dropdown-toggle">
                <span class="glyphicon glyphicon-user"></span>
                <b class="caret"></b>
              </a>
              <ul class="dropdown-menu">
                <li>
                  <a href="/users/id" title="Profile">Profile</a>
                </li>
                <li>
                  <a href="/logout" title="Logout">Logout </a>
                </li>
              </ul>
            </li>
          </ul>
          <button type="button" data-toggle="collapse" data-target=".navbar-collapse" class="navbar-toggle">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="visible-xs-block clearfix"></div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-left">
            <li><?php echo Html::img('@web/images/Logo_FHNW.svg_edited.png') ?></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="<?= Url::toRoute('site/contact')?>">Kontakt</a></li>
            <li><a href="<?= Url::toRoute('site/index')?>">Index</a></li>
            <li><a href="<?= Url::toRoute('benutzer/benutzerverwaltung')?>">Benutzer</a></li>
            <li><a href="<?= Url::toRoute('artikel/artikelliste')?>">Artikel</a></li>
            <li><a href="<?= Url::toRoute('site/statistik')?>">Statistik</a></li>
          </ul>
        </div>
      </div>
    </nav>
<!--
        /***********Suche als Eingabe möglich
        "

         <form class='navbar-form navbar-right' role='search'>
                <div class='form-group has-feedback'>
                    <input id='searchbox' type='text' placeholder='Suche' class='form-control'>
                    <span id='searchicon' class='fa fa-search form-control-feedback'></span>
                </div>
        </form>";

    */
      echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [

                ['label' => 'Home', 'url' => ['/site/index']],
                ['label' => 'Artikel', 'url' => ['/artikel/artikelliste']],
                ['label' => 'Benutzerverwaltung', 'url' => ['/benutzer/benutzerverwaltung']],
                ['label' => 'Statistik', 'url' => ['/site/statistik']],
                ['label' => 'Contact', 'url' => ['/site/contact']],
                ['label' => 'Suche', 'url' => ['/site/suche']],
                Yii::$app->user->isGuest ? (
                    ['label' => 'Login', 'url' => ['/site/login']]
                ) : (
                    '<li>'
                    . Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                        'Logout (' . Yii::$app->user->identity->username . ')',
                        ['class' => 'btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>'
                )
            ],
        ]);
        NavBar::end();
    ?>
-->
</div>
<div class="wrap container-fluid">
            <div class="col-md-2">
                <?php
                echo SideNav::widget([
                    'type' => SideNav::TYPE_DEFAULT,
                    'heading' => 'Navigation',
                    'items' => [
                        [
                            'url' => '#',
                            'label' => 'Home',
                            'icon' => 'home'
                        ],
                        ['label' => 'Home', 'url' => ['/site/index']],
                        ['label' => 'Artikel', 'url' => ['/artikel/artikelliste']],
                        ['label' => 'Benutzerverwaltung', 'url' => ['/benutzer/benutzerverwaltung']],
                        ['label' => 'Statistik', 'url' => ['/site/statistik']],
                        ['label' => 'Contact', 'url' => ['/site/contact']],
                        ['label' => 'Suche', 'url' => ['/site/suche']],
                        [
                            'label' => 'Help',
                            'icon' => 'question-sign',
                            'items' => [
                                ['label' => 'Home', 'url' => ['/site/index']],
                                ['label' => 'Artikel', 'url' => ['/artikel/artikelliste']],
                                ['label' => 'Benutzerverwaltung', 'url' => ['/benutzer/benutzerverwaltung']],
                                ['label' => 'Statistik', 'url' => ['/site/statistik']],
                                ['label' => 'Contact', 'url' => ['/site/contact']],
                                ['label' => 'Suche', 'url' => ['/site/suche']],
                            ],
                        ],
                    ],
                ]);
                ?>
            </div>
            <div class="col-md-8">
                <?= $content ?>
            </div>
            <!-- OPTIONAL
            <div class="col-md-2 bodyright">
                <?php
                echo Html::a('Neuer Artikel', ['/artikel/neuerartikel'], ['class'=>'btn btn-primary']);
                ?>
            </div>
            -->
</div>
<footer class="footer">
    <div class="container-fluid">
        <p class="pull-left">&copy;Team Lagerverwaltung <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
$script = <<< JS
$( document ).ready(function() { 
    /* Set the width of the side navigation to 250px */
    function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    }

    /* Set the width of the side navigation to 0 */
    function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    }
});
JS;
$this->registerJs("var urlAjax = ".json_encode(url::current()).";");
$this->registerJs($script);

$this->registerCss("

");


?>