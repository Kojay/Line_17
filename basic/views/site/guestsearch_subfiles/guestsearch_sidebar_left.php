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
                <h3 class="panel-title">Seite</h3>
            </div>
            <div class="">
                <a href="<?= Url::toRoute('site/drucken')?>" style="color: #3C578C" class="list-group-item">
                    <span class="glyphicon glyphicon-print"></span>
                    Drucken
                </a>
            </div>
            <div class="">
                <a href="<?= Url::toRoute('site/export')?>" style="color: #3C578C" class="list-group-item">
                    <span class="glyphicon glyphicon-export"></span>
                    Exportieren
                </a>
            </div>
        </div>
    </div>
</div>