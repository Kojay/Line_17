<?php
/**
 * Created by PhpStorm.
 * User: kwlski
 * Date: 16.12.2016
 * Time: 22:14
 */
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
]);

