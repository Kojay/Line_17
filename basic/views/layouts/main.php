<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\buttongroup;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use kartik\sidenav\SideNav;
use yii\helpers\url;

AppAsset::register($this);
$this->registerCssFile('@web/css/site.css');
$this->beginPage();

?>
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
            <li class="navbar-text pull-left">
                <?php
                if(!Yii::$app->user->isGuest){
                    echo Yii::$app->user->identity->username;
                }
                else{
                    echo 'Gast';
                }
                ?>
            </li>
            <li class="dropdown pull-right">
              <a href="#" data-toggle="dropdown" style="color:#777; margin-top: 5px;" class="dropdown-toggle">
                <span class="glyphicon glyphicon-user"></span>
                <b class="caret"></b>
              </a>
              <ul class="dropdown-menu">
                  <?php
                  if (!Yii::$app->user->isGuest) {
                      ?>
                      <li>
                          <a href="<?= Url::to(['site/logout'])?>" data-method="post" title="Logout">Logout</a>
                      </li>
                      <li>
                          <a href="<?= Url::toRoute('site/profile')?>"  title="Profile">Profil</a>
                      </li>
                      <?php
                  }
                  if (Yii::$app->user->isGuest) {
                      ?>
                      <li>
                          <a href="<?= Url::toRoute('site/login')?>"  title="Login">Login</a>
                      </li>
                      <?php
                  }
                  ?>
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
            <li class="logo"><?php echo Html::img('@web/images/Logo_FHNW.svg_edited.png',['class' => 'logo']) ?></li>
          </ul>
        <?php
        if (!Yii::$app->user->isGuest) {
            ?>
          <ul class="nav navbar-nav navbar-right">
              <ul class="nav pull-left">
                  <li class="dropdown pull-right">
                      <a href="<?= Url::toRoute('site/index')?>" style="color:#777; margin-top: 5px;" class="dropdown-toggle">
                          Home
                          <span class="glyphicon glyphicon-home"></span>
                      </a>
                  </li>
              </ul>
              <ul class="nav pull-left">
                  <li class="dropdown pull-right">
                      <a href="<?= Url::toRoute('site/email')?>" style="color:#777; margin-top: 5px;" class="dropdown-toggle">
                          Kontakt
                          <span class="glyphicon glyphicon-envelope"></span>
                      </a>
                  </li>
              </ul>
              <ul class="nav pull-left">
                  <li class="dropdown pull-right">
                      <a href="<?= Url::toRoute('site/suche')?>" style="color:#777; margin-top: 5px;" class="dropdown-toggle">
                          Suchfunktion
                          <span class="glyphicon glyphicon-search"></span>
                      </a>
                  </li>
              </ul>
              <ul class="nav pull-left">
                  <li class="dropdown pull-right">
                      <a href="<?= Url::toRoute('site/statistik')?>" style="color:#777; margin-top: 5px;" class="dropdown-toggle">
                          Statistik
                          <span class="glyphicon glyphicon-stats"></span>
                      </a>
                  </li>
              </ul>
              <ul class="nav pull-left">
                  <li class="dropdown pull-right">
                      <a href="<?= Url::toRoute('artikel/artikelliste')?>" style="color:#777; margin-top: 5px;" class="dropdown-toggle">
                          Artikel
                          <span class="glyphicon glyphicon-tags"></span>
                      </a>
                  </li>
              </ul>
              <ul class="nav pull-left">
                  <li class="dropdown pull-right">
                      <a href="<?= Url::toRoute('benutzer/benutzerverwaltung')?>" style="color:#777; margin-top: 5px;" class="dropdown-toggle">
                          Benutzer
                          <span class="glyphicon glyphicon-user"></span>
                      </a>
                  </li>
              </ul>
              <?php
              }
              ?>
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
    <?= $content ?>
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
<?php
$this->endPage();
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