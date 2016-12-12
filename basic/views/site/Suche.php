<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* @var $this yii\web\View */

use yii\helpers\Html;
use app\models\QueryRqst;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\web\UrlManager ;
use yii\widgets\Pjax;
use yii\data\SqlDataProvider;
use yii\helpers\Url;


$this->title = 'Suche';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-suche">
    <h1 font size="20"><?= Html::encode($this->title) ?></h1>
    
	<style> 
	input[type=text] {
		width: 500px;
		border: 2px solid #ccc;
		border-radius: 4px;
		font-size: 16px;
		padding: 12px 20px 12px 12px;
	}
	</style>
	<form>
     <input type="text" name="search" placeholder="Suche">
	</form>
	
	
      
    <?php
     /*   $this->registerJsFile(Yii::$app->request->baseUrl.'/js/ArticleList.js', ['depends' => [\yii\web\JqueryAsset::className()]]);*/
    
    // Following code is here to generate Tabs and in there a list.
    ?>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.12.4.js"></script>
    <script src="//code.jquery.com/ui/1.12.0/jquery-ui.js"></script>

    <div id="tabs">
        <ul>
            <li><a href="#fragment-1"><span>Artikel</span></a></li>
            <li><a href="#fragment-2"><span>Ausleihe</span></a></li>
            <li><a href="#fragment-3"><span>Benutzer</span></a></li>
        </ul>
        <div id="fragment-1">
            Artikel
            <?php
            Pjax::begin();               
            ?>
            
            <?= GridView::widget([
                
            'dataProvider' => (new QueryRqst())->getData(),
                
            'columns' => 
                [
                    [
                        'class' => ActionColumn::className(),
                        'template'=>'{view}',
                        'buttons' => 
                        [
                            'view' => function ($url, $model) 
                            {
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, 
                            [
                            'title' => Yii::t('app', 'Artikel Bearbeiten'),
                            ]);
                            }
                        ],
                                'urlCreator' => function ($action, $model, $key, $index)
                                {
                                    if ($action === 'view') 
                                    {
                                        return Url::to(['artikel']);
                                    }
                                }
                        
                    ],
                    [
			'label' => 'Typ',
                        'attribute' => 'articleTypeName',
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
                    ],                    
                                    
                ] 
            ]);        
            Pjax::end();
            
            ?>
            <!-- Gridview widget which can be filled with data -->
            
        </div>
        <div id="fragment-2">
               Artikel
            <?php
            $dataProvider = (new QueryRqst())->getData();
            Pjax::begin();               
            ?>
            
            <?= GridView::widget([
                
            'dataProvider' => $dataProvider,
                
            'columns' => 
                [
                    [
                        'class' => ActionColumn::className(),
                        'template'=>'{view}',
                        'buttons' => 
                        [
                            'view' => function ($url, $model) 
                            {
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, 
                            [
                            'title' => Yii::t('app', 'Artikel Bearbeiten'),
                            ]);
                            }
                        ],
                                'urlCreator' => function ($action, $model, $key, $index)
                                {
                                    if ($action === 'view') 
                                    {
                                        return Url::to(['artikel']);
                                    }
                                }
                        
                    ],
                    [
                        'label' => 'Ausleihender',
                        'attribute' => 'articleTypeName',
                    ],
                    [
                        'label' => 'Dozent',
                        'attribute' => 'articleproducerName',
                    ],
                    [
                        'label' => 'Ausleihdatum',
                        'attribute' => 'articleName',
                    ],
                    [
                        'label' => 'Rückgabedatum',
                        'attribute' => 'fhnwNumber',
                    ],
                    [
                        'label' => 'Positionen',
                        'attribute' => 'lvLoanReturnDate',
                    ],                    
                                 
                ] 
            ]);        
            Pjax::end();
            
            ?>
            <!-- Gridview widget which can be filled with data -->
              </div>
        <div id="fragment-3">
   Artikel
            <?php
            Pjax::begin();               
            ?>
            
            <?= GridView::widget([
                
            'dataProvider' => (new QueryRqst())->getData(),
                
            'columns' => 
                [
                    [
                        'class' => ActionColumn::className(),
                        'template'=>'{view}',
                        'buttons' => 
                        [
                            'view' => function ($url, $model) 
                            {
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, 
                            [
                            'title' => Yii::t('app', 'Artikel Bearbeiten'),
                            ]);
                            }
                        ],
                                'urlCreator' => function ($action, $model, $key, $index)
                                {
                                    if ($action === 'view') 
                                    {
                                        return Url::to(['artikel']);
                                    }
                                }
                        
                    ],
                    [
                        'header' => 'Vorname',
                        'attribute' => 'articleTypeName',
                    ],
                    [
                        'header' => 'Nachname',
                        'attribute' => 'articleproducerName',
                    ],
                    [
                        'header' => 'E-Mail',
                        'attribute' => 'articleName',
                    ],
                    [
                        'header' => 'Rechte',
                        'attribute' => 'fhnwNumber',
                    ],
                           
                                    
                ] 
            ]);        
            Pjax::end();
            
            ?>
            <!-- Gridview widget which can be filled with data -->
            </div>
    </div>

    <script>$( "#tabs" ).tabs();</script>
    

    <code><?= __FILE__ ?></code>
    
</div>

