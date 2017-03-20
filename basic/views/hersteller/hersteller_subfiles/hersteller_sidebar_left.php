<?php
use yii\helpers\Url;
use yii\helpers\Html;

echo Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Zurück', ['artikel/artikelliste','_rqstIDfhnwNumber' => yii::$app->request->get('_rqstIDfhnwNumber')],['class' => 'btn btn-primary pull-left']);
?>
<div class="panel panel-info" style="margin-top: 50px">
    <div class="panel-heading">
        <h3 class="panel-title"><span class="glyphicon glyphicon-transfer"></span>&nbsp&nbspAktionen</h3>
    </div>
    <div class="panel-body">
        <!--<div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Hersteller</h3>
            </div>
            <div class="">
                <a href="<?php echo Url::toRoute('artikel/artikelbearbeiten').'&_rqstIDfhnwNumber='.yii::$app->request->get('_rqstIDfhnwNumber');?>" style="color: #3C578C" class="list-group-item">
                    <span class="glyphicon glyphicon-edit"></span>
                    Artikel bearbeiten
                </a>
            </div>
            <div class="">
                <a href="<?= Url::toRoute('artikel/etikette')?>" style="color: #3C578C" class="list-group-item">
                    <span class="glyphicon glyphicon-print"></span>
                    Etikette drucken
                </a>
            </div>
            <div class="">
                <a href="<?= Url::toRoute('artikel/ausleihen')?>" style="color: #3C578C" class="list-group-item">
                    <span class="glyphicon glyphicon-briefcase"></span>
                    Artikel ausleihen
                </a>
            </div>
        </div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Seite</h3>
            </div>
            <div class="">
                <a href="<?= Url::toRoute('site/drucken')?>" style="color: #3C578C" class="list-group-item">
                    <span class="glyphicon glyphicon-print"></span>
                    Drucken
                </a>
            </div>
        </div>-->
    </div>
</div>
<div class="panel panel-info" style="margin-top: 10px">
    <div class="panel-heading">
        <h3 class="panel-title"><span class="glyphicon glyphicon-random"></span>Navigationsbaum</h3>
    </div>
    <div class="panel-body">
        <div id="breadcrumbs">
            <a style="margin-left:0px" href="<?= Url::toRoute('hersteller/herstellerliste')?>"> Herstellerliste</a>
        </div>
        <div id="breadcrumbs">
            <a style="margin-left:20px"  href="<?= Url::toRoute('artikel/artikel')?>"><span class="glyphicon glyphicon-arrow-right"></span> Hersteller Details</a>
        </div>
    </div>
</div>