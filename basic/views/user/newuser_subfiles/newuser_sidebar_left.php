<?php
use yii\helpers\Url;
use yii\helpers\Html;

echo Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Zurück', ['user/usermanagement','_rqstIDUserID' => yii::$app->request->get('_rqstIDUserID')],['class' => 'btn btn-primary pull-left']);
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
    <div class="panel-body">
        <div id="breadcrumbs">
            <a style="margin-left:0px" href="<?= Url::toRoute('user/usermanagement')?>"> Benutzerliste</a>
        </div>
        <div id="breadcrumbs">
            <a style="margin-left:20px"  href="<?= Url::toRoute('user/newuser')?>"><span class="glyphicon glyphicon-arrow-right"></span> Benutzer erstellen</a>
        </div>
    </div>
</div>