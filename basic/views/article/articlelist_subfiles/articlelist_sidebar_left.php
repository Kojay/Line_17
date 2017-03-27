<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="panel panel-info" style="margin-top: 50px">
    <div class="panel-heading">
        <h3 class="panel-title"><span class="glyphicon glyphicon-transfer"></span>&nbsp&nbspAktionen</h3>
    </div>
    <div class="panel-body">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Artikel</h3>
            </div>
            <div class="">
                <a href="<?= Url::toRoute('article/newarticle')?>" style="color: #3C578C" class="list-group-item">
                    <span class="glyphicon glyphicon-plus"></span>
                    Artikel erfassen
                </a>
            </div>
        </div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Artikelhersteller</h3>
            </div>
            <div class="">
                <a href="<?= Url::toRoute('producer/producerlist')?>" style="color: #3C578C" class="list-group-item">
                    <span class="glyphicon glyphicon-list"></span>
                    Hersteller anzeigen
                </a>
            </div>
        </div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Artikeltypen</h3>
            </div>
            <div class="">
                <a href="<?= Url::toRoute('articleproducer/articleproducerList')?>" style="color: #3C578C" class="list-group-item">
                    <span class="glyphicon glyphicon-list"></span>
                    Typenliste anzeigen
                </a>
            </div>
        </div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Seite</h3>
            </div>
            <div class="">
                <a href="<?= Url::toRoute('site/print')?>" style="color: #3C578C" class="list-group-item">
                    <span class="glyphicon glyphicon-print"></span>
                    Drucken
                </a>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-info" style="margin-top: 10px">
    <div class="panel-heading">
        <h3 class="panel-title"><span class="glyphicon glyphicon-random"></span>&nbsp&nbspNavigationsbaum</h3>
    </div>
    <div class="panel-body" style="text-align: center">
        <div id="breadcrumbs">
            <a style="margin-left:0px" href="<?= Url::toRoute('article/articlelist')?>"> Artikelliste</a>
        </div>
        <div id="breadcrumbs">
            <a style="margin-left:0px" href="<?= Url::toRoute('producer/producerlist')?>"> Herstellerliste</a>
        </div>
        <div id="breadcrumbs">
            <a style="margin-left:0px" href="<?= Url::toRoute('article/articlelist')?>"> Typenliste</a>
        </div>
    </div>
</div>