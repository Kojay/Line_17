<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* @var $this yii\web\View */

use yii\helpers\Html;
use app\models\QueryForm;
use yii\web\UrlManager;
use yii\widgets\Pjax;
use yii\data\SqlDataProvider;
use yii\helpers\Url;
use kartik\grid\GridView;

$this->title = 'Artikel';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-artikelliste">
    <h1 font size="20"><?= Html::encode($this->title) ?></h1>
    <?= Html::a('Neuer Artikel', ['/site/neuerartikel'], ['class'=>'btn btn-primary']) ?>
      
    <?php
     /*   $this->registerJsFile(Yii::$app->request->baseUrl.'/js/ArticleList.js', ['depends' => [\yii\web\JqueryAsset::className()]]);*/
    
    // Following code is here to generate Tabs and in there a list.
    ?>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.12.4.js"></script>
    <script src="//code.jquery.com/ui/1.12.0/jquery-ui.js"></script>

    <div id="tabs">
        
        <ul>
            <li><a href="#fragment-1"><span>Alles</span></a></li>
            <li><a href="#fragment-2"><span>Artikel</span></a></li>
            <li><a href="#fragment-3"><span>Benutzer</span></a></li>
        </ul>
        <script>$( "#tabs" ).tabs();</script>
        <div value="jk" id="fragment-1">
            <?php

            
            
            Pjax::begin();               

            
            $dataObj = new QueryForm();
            $dataProvider = $dataObj->getData();
            //echo VarDumper::dumpAsString($dataProvider->models[0]['fhnwNumber'])               
            echo GridView::widget([
                'dataProvider' => $dataProvider,   
                'responsive'=> true,
                'hover'=> true,
                'export' => false,
                
               
                'rowOptions' => function ($model, $index, $widget, $grid) {
                     return ['id' => $model['fhnwNumber'], 'onclick' => 'location.href="'.Url::to(['site/artikel']).'&id="+(this.id);'];
                },
                'columns' => [
                    ['class' => '\kartik\grid\SerialColumn'],

                    // Simple columns defined by the data contained in $dataProvider.
                    // Data from the model's column will be used.
                    // More complex one.

                    [
                        'attribute' => 'articleTypeName',
                        'label' => 'ArtikelTyp',
                    ],
                    [
                        
                        'label' => 'Hersteller',
                        'attribute' => 'articleproducerName',
                    ],
                    [
                       
                        'label' => 'Artikelname',
                        'attribute' => 'articleName',
             
                    ],
                    [
                        
                        'label' => 'FHNW Nummer',
                        'attribute' => 'fhnwNumber',
                    ],
                    [
                        
                        'label' => 'Ausgeliehen bis',
                        'attribute' => 'lvLoanReturnDate',

                    ],],                                                   
                        
          ]);   
                Pjax::end();
                //$this->registerJsFile('');
            ?>       

        </div>
        <div id="fragment-2">
            Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
            Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
        </div>
    </div>
    

</div>

