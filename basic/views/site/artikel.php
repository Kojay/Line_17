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
        
        <?= VarDumper::dumpAsString($model['articleNumber']) ?>
            
        <?= Html::submitButton('Artikel speichern', ['class' => 'btn btn-primary','col-sm-2', 'name' => 'save-button']) ?>
    
    </div>       
        <div class='form-group">
           
        </div>
    <?php ActiveForm::end(); ?>
</div>
