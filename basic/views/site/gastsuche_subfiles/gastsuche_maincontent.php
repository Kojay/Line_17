<?php
use yii\helpers\Html;
use app\models\QueryRqst;
use kartik\grid\GridView;
use yii\helpers\Url;
use kartik\tabs\TabsX;

$this->title = 'Gastsuche';
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h1',Html::encode($this->title));

echo Html::beginTag('div',['style' => 'margin-top:20px']);

echo Html::tag('p','Suchbegriff eingeben:');

$items = [
    [
        'label'=>'<i class="glyphicon glyphicon-search"></i> Global',
        'pjax'=>true,
        'content'=>
            GridView::widget([
                'dataProvider' => (new QueryRqst())->getDataArtikelliste(),
                'responsive'=> true,
                'hover'=> true,
                'export' => false,
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
                    ],
                ],

            ]),
        'active'=>true
    ],
    [
        'label'=>'<i class="glyphicon glyphicon-user"></i> Benutzer',
        'content'=>
            GridView::widget([
                'dataProvider' => (new QueryRqst())->getDataBenutzer(),
                'responsive'=> true,
                'pjax'=>true,
                'hover'=> true,
                'export' => false,
                'rowOptions' => function ($model, $index, $widget, $grid) {
                    return ['_rqstIDUserID' => $model['userID'], 'onclick' => 'location.href="'.Url::to(['benutzer/benutzer']).'&_rqstIDUserID="+(this._rqstIDUserID);','style' => 'cursor: pointer'];
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
                ],
            ])
    ],
    [
        'label'=>'<i class="glyphicon glyphicon-tags"></i> Artikel',
        'content'=>
            GridView::widget([
                'dataProvider' => (new QueryRqst())->getDataArtikelliste(),
                'responsive'=> true,
                'pjax'=>true,
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
                            if($model['lvLoanReturnDate'] === NULL){
                                return 'nicht ausgeliehen';
                            }
                        }
                    ],
                ],
            ])
    ],
    [
        'label'=>'<i class="glyphicon glyphicon-inbox"></i> Ausleihungen',
        'content'=>
            GridView::widget([
                'dataProvider' => (new QueryRqst())->getDataAllfaelligeAusleihungen(),
                'responsive'=> true,
                'pjax'=>true,
                'hover'=> true,
                'export' => false,
                'rowOptions' => function ($model, $index, $widget, $grid) {
                    return ['fhnwNumber' => $model['fhnwNumber'], 'onclick' => 'location.href="'.Url::to(['artikel/artikel']).'&_rqstIDfhnwNumber="+(this.fhnwNumber);','style' => 'cursor: pointer'];
                },
                'columns' => [
                    ['class' => '\kartik\grid\SerialColumn'],
                    [
                        'label' => 'Ausleihender',
                        'attribute' => 'personFirstname',
                        'visible' => true,
                    ],
                    [
                        'label' => 'Rückgabedatum',
                        'attribute' => 'lvLoanReturnDate',
                    ],
                    [
                        'label' => 'Artikel',
                        'attribute' => 'articleName',
                    ],
                    [
                        'label' => 'Standort',
                        'attribute' => 'loanLocation',
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
?>