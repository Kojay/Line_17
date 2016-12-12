<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* @var $this yii\web\View */

use yii\helpers\Html;
use app\models\QueryRqst;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\tabs\TabsX;

$this->title = 'Artikel';
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h1',Html::encode($this->title));

echo Html::a('Neuer Artikel', ['/artikel/neuerartikel'], ['class'=>'btn btn-primary']);

echo Html::beginTag('div',['style' => 'margin-top:20px']);

$items = [
    [
        'label'=>'<i class="glyphicon glyphicon-search"></i> Global',
        'content'=> 
                GridView::widget([
                'dataProvider' => (new QueryRqst())->getData(),
                'responsive'=> true,
                'hover'=> true,        
                'export' => false,
                //'rowOptions' => ['class' => GridView::TYPE_DANGER],
                'rowOptions' => function ($model, $index, $widget, $grid) {
                    return ['id' => $model['fhnwNumber'], 'onclick' => 'location.href="'.Url::to(['artikel/artikel']).'&_rqstIDfhnwNumber="+(this.id);','style' => 'cursor: pointer'];
                },
                'columns' => [
                    ['class' => '\kartik\grid\SerialColumn'],
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
                        
          ]),
        'active'=>true
    ],
    [
        'label'=>'<i class="glyphicon glyphicon-user"></i> Benutzer',
        'content'=>
        GridView::widget([
                'dataProvider' => (new QueryRqst())->getData(),   
                'responsive'=> true,
                'hover'=> true,        
                'export' => false,
                'rowOptions' => ['class' => GridView::TYPE_DANGER, 'id' => 'lauch'],
                'rowOptions' => function ($model, $index, $widget, $grid) {
                     return ['_rqstIDfhnwNumber' => $model['fhnwNumber'], 'onclick' => 'location.href="'.Url::to(['benutzer/benutzer']).'&_rqstIDfhnwNumber="+(this._rqstIDfhnwNumber);','style' => 'cursor: pointer'];
                },
                'columns' => [
                    ['class' => '\kartik\grid\SerialColumn'],
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
                        
          ])
    ],
    [
        'label'=>'<i class="glyphicon glyphicon-tags"></i> Artikel',
        'content'=>
        GridView::widget([
                'dataProvider' => (new QueryRqst())->getData(),   
                'responsive'=> true,
                'hover'=> true,        
                'export' => false,
                'rowOptions' => function ($model, $index, $widget, $grid) {
                     return ['_rqstIDfhnwNumber' => $model['fhnwNumber'], 'onclick' => 'location.href="'.Url::to(['artikel/artikel']).'&_rqstIDfhnwNumber="+(this._rqstIDfhnwNumber);','style' => 'cursor: pointer'];
                },
                'columns' => [
                    ['class' => '\kartik\grid\SerialColumn'],
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
                        'value' => function($model,$key){
                            if($model === NULL){
                                return 'nicht ausgeliehen';
                            }                           
                        }

                    ],
                ],                                                                     
        ])
    ],
];            
            
echo TabsX::widget([
    'items'=>$items,
    'position'=>TabsX::POS_ABOVE,
    'bordered'=>true,
    'encodeLabels'=>false
]);

echo Html::endTag('div');
