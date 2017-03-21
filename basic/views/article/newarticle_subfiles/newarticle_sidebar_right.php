<?php
/**
 * Created by PhpStorm.
 * User: kwlski
 * Date: 18.12.2016
 * Time: 16:28
 */
use yii\helpers\Url;
use kartik\checkbox\CheckboxX;
?>
<div class="panel panel-info" style="margin-top: 50px">
    <div class="panel-heading">
        <h3 class="panel-title"><span class="glyphicon glyphicon-cog"></span>&nbsp&nbspKonfiguration</h3>
    </div>
    <div class="panel-body">
        <ul class="list-group">
            <li class="list-group-item">
                Neuer Hersteller?
                <div class="material-switch pull-right">
                    <input id="someSwitchOptionDefaultProducer" name="someSwitchOptionProducer001" type="checkbox"/>
                    <label for="someSwitchOptionDefaultProducer" class="label-primary"></label>
                </div>
            </li>
        </ul>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Hersteller</h3>
            </div>
            <div class="">
                <a href="<?= Url::toRoute('article/producer')?>" style="color: #3C578C" class="list-group-item">
                    <span class="glyphicon glyphicon-gift"></span>
                    Hersteller verwalten
                </a>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <ul class="list-group">
            <li class="list-group-item">
                Neuer Artikeltyp?
                <div class="material-switch pull-right">
                    <input id="someSwitchOptionDefaultArticleType" name="someSwitchOptionArticleType001" type="checkbox"/>
                    <label for="someSwitchOptionDefaultArticleType" class="label-primary"></label>
                </div>
            </li>
        </ul>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Artikeltyp</h3>
            </div>
            <div class="">
                <a href="<?= Url::toRoute('article/articletype')?>" style="color: #3C578C" class="list-group-item">
                    <span class="glyphicon glyphicon-gift"></span>
                    Artikeltyp verwalten
                </a>
            </div>
        </div>
    </div>
</div>