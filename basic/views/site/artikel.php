<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\widgets\Menu;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\ActiveForm;

$this->title = 'Artikel Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-statistic">
    <h1><?= Html::encode($this->title) ?></h1>
    <div>   
    <?php
        echo Menu::widget([
            'items' => 
            [
                ['label' => 'Zurück', 'url' => ['site/index']],
                ['label' => 'Artikel Bearbeiten', 'url' => ['site/index']],
                ['label' => 'Etikette Drucken', 'url' => ['site/about']],
                ['label' => 'Ausleihen', 'url' => ['site/index']],
            ],
            'options' => ['class' =>'nav nav-tabs'],
        ]);
    ?>
    </div>
    <div style="margin-top:20px">
    <?php $form = ActiveForm::begin
    ([
        'id' => 'article-form',
        'layout' => 'horizontal',
        'fieldConfig' => 
        [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>       
            <div class="form-group field-artikelform-articleName">
                <label class="col-sm-2" for="artikelform-articleName">
                    Artikelname:
                </label>
                <div class="col-lg-3">
                    <?= VarDumper::dumpAsString($model['articleName'])?>        
                </div>
                <div class="col-lg-8"><div class="help-block help-block-error "></div></div>
            </div>
            <div class="form-group field-artikelform-articleType">
                <label class="col-sm-2" for="artikelform-articleType">
                    Artikeltyp:
                </label>
                <div class="col-lg-3">
                    <?= VarDumper::dumpAsString($model['articleType'])?>        
                </div>
                <div class="col-lg-8"><div class="help-block help-block-error "></div></div>
            </div>
            <div class="form-group field-artikelform-articleManufacturer">
                <label class="col-sm-2" for="artikelform-articleManufacturer">
                    Hersteller:
                </label>
                <div class="col-lg-3">
                    <?= VarDumper::dumpAsString($model['articleManufacturer'])?>        
                </div>
                <div class="col-lg-8"><div class="help-block help-block-error "></div></div>
            </div>
            <div class="form-group field-artikelform-articleSerialnumber">
                <label class="col-sm-2" for="artikelform-articleSerialnumber">
                    Seriennummer:
                </label>
                <div class="col-lg-3">
                    <?= VarDumper::dumpAsString($model['articleSerialnumber'])?>        
                </div>
                <div class="col-lg-8"><div class="help-block help-block-error "></div></div>
            </div>
            <div class="form-group field-artikelform-articleInstitute">
                <label class="col-sm-2" for="artikelform-articleInstitute">
                    Institut:
                </label>
                <div class="col-lg-3">
                    <?= VarDumper::dumpAsString($model['articleInstitute'])?>        
                </div>
                <div class="col-lg-8"><div class="help-block help-block-error "></div></div>
            </div>
            <div class="form-group field-artikelform-articlePurchased">
                <label class="col-sm-2" for="artikelform-articlePurchased">
                    Kaufdatum:
                </label>
                <div class="col-lg-3">
                    <?= VarDumper::dumpAsString($model['articlePurchased'])?>        
                </div>
                <div class="col-lg-8"><div class="help-block help-block-error "></div></div>
            </div>
            <div class="form-group field-artikelform-articleGuarantee">
                <label class="col-sm-2" for="artikelform-articleGuarantee">
                    Garantiedatum:
                </label>
                <div class="col-lg-3">
                    <?= VarDumper::dumpAsString($model['articleGuarantee'])?>        
                </div>
                <div class="col-lg-8"><div class="help-block help-block-error "></div></div>
            </div>
            <div class="form-group field-artikelform-articlePrice">
                <label class="col-sm-2" for="artikelform-articlePrice">
                    Preis (CHF):
                </label>
                <div class="col-lg-3">
                    <?= VarDumper::dumpAsString($model['articlePrice'])?>        
                </div>
                <div class="col-lg-8"><div class="help-block help-block-error "></div></div>
            </div>
            <div class="form-group field-artikelform-articleFHNW">
                <label class="col-sm-2" for="artikelform-articleFHNW">
                    FHNW Nummer:
                </label>
                <div class="col-lg-3">
                    <?= VarDumper::dumpAsString($model['articleFHNW'])?>        
                </div>
                <div class="col-lg-8"><div class="help-block help-block-error "></div></div>
            </div>
            <div class="form-group field-artikelform-articleDescription">
                <label class="col-sm-2" for="artikelform-articleDescription">
                    Beschreibung:
                </label>
                <div class="col-lg-3">
                    <?= VarDumper::dumpAsString($model['articleDescription'])?>        
                </div>
                <div class="col-lg-8"><div class="help-block help-block-error "></div></div>
            </div>

   
        <?= Html::submitButton('Artikel speichern', ['class' => 'btn btn-primary','col-sm-2', 'name' => 'save-button']) ?>
    
    </div>       
        <div class='form-group">
           
        </div>
    <?php ActiveForm::end(); ?>
</div>
