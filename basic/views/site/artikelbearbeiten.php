<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\widgets\Menu;
use yii\bootstrap\ActiveForm;
use app\models\QueryForm;

$this->title = 'Artikel bearbeiten';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-statistic">
    <h1><?= Html::encode($this->title) ?></h1>
    <div>   
    <?php
        echo Menu::widget([
            'items' => 
            [
                ['label' => 'Zurück', 'url' => ['site/artikel']],
                ['label' => 'Artikel Bearbeiten', 'url' => ['site/artikelbearbeiten']],
                ['label' => 'Etikette Drucken', 'url' => ['site/etikette']],
                ['label' => 'Ausleihen', 'url' => ['site/ausleihe']],
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
        
        <div class="form-group">
            <label for="usr">Name:</label>
            <input type="text" class="form-control" id="usr">
        </div>
        
        
        <div class="form-group field-artikelform-articleFHNW">
                <label class="col-sm-2" for="artikelform-articleFHNW">
                    FHNW Nummer:
                </label>
                <input class="col-lg-3">
                    <?= VarDumper::dumpAsString($model['fhnwNumber'])?>        
                </input>
                <div class="col-lg-8"><div class="help-block help-block-error "></div></div>
            </div>
        
        <?php
//            $dataObj = new QueryForm(); 
//            $dataProvider = $dataObj->getDataArtikelliste();
//            
//            foreach($dataProvider->models as $myModel)
//            {
//            
//            
//            //echo $myModel['articleName'];
//            } 
        ?>
        
       
    </div>       
        <div class="form-group">
           
        </div>
    <?php ActiveForm::end(); ?>
</div>
