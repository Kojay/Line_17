<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use app\models\QueryRqst;

$this->title = 'Benutzer';
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h1',Html::encode($this->title));

echo Html::a('Neuer Benutzer', ['/benutzer/neuerbenutzer'], ['class'=>'btn btn-primary']);

echo Html::beginTag('div',['style' => 'margin-top:20px']);

echo GridView::widget([
                'dataProvider' => (new QueryRqst())->getDataBenutzer(),   
                'responsive'=> true,
                'hover'=> true,        
                'export' => false,
                //'rowOptions' => ['class' => GridView::TYPE_DANGER],
                'rowOptions' => function ($model, $index, $widget, $grid) {     
                     return ['id' => $model['userID'], 'onclick' => 'location.href="'.Url::to(['benutzer/benutzer']).'&_rqstIDUserID="+(this.id);','style' => 'cursor: pointer'];
                },
                'columns' => [
                    ['class' => '\kartik\grid\SerialColumn'],
                    [
                       
                        'label' => 'Vorname',
                        'attribute' => 'personFirstname',
             
                    ],
                    [
                        
                        'label' => 'Nachname',
                        'attribute' => 'personLastname',
                    ],
                    [
                        
                        'label' => 'E-Mail adresse',
                        'attribute' => 'personMail',

                    ],
                    [
                        'label' => 'Berechtigungstyp',
                        'attribute' => 'isUserAdmin',
                        'format' => 'raw',
                        'value' => function ($data) {
                            if($data['isUserAdmin'] == 1)
                            {
                               return 'Administrator'; 
                            }
                            else
                            {
                                return 'Benutzer'; 
                            }
                        }
                    ],
                ]                    
          ]);
                

