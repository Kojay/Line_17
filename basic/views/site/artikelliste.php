<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* @var $this yii\web\View */

use yii\helpers\Html;
use app\models\QueryForm;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\web\UrlManager ;
use yii\widgets\Pjax;
use yii\data\SqlDataProvider;
use yii\helpers\Url;


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
            <li><a href="#fragment-1"><span>One</span></a></li>
            <li><a href="#fragment-2"><span>Two</span></a></li>
            <li><a href="#fragment-3"><span>Three</span></a></li>
        </ul>
        <div id="fragment-1">
            Artikel
            <?php
            $dataObj = new QueryForm(); 
            $dataProvider = $dataObj->getData();
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
                        'header' => 'Typ',
                        'attribute' => 'articleTypeName',
                    ],
                    [
                        'header' => 'Hersteller',
                        'attribute' => 'articleproducerName',
                    ],
                    [
                        'header' => 'Artikelname',
                        'attribute' => 'articleName',
                    ],
                    [
                        'header' => 'FHNW Nummer',
                        'attribute' => 'fhnwNumber',
                    ],
                    [
                        'header' => 'Ausgeliehen bis',
                        'attribute' => 'lvLoanReturnDate',
                    ],                    
                    'name', 
                    'population',                  
                ] 
            ]);        
            Pjax::end();
            
            ?>
            <!-- Gridview widget which can be filled with data -->
            
        </div>
        <div id="fragment-2">
            Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
            Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
        </div>
        <div id="fragment-3">
            Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
            Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
            Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
        </div>
    </div>

    <script>$( "#tabs" ).tabs();</script>
    

    <code><?= __FILE__ ?></code>
    
</div>

