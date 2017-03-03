<?php
use yii\helpers\Html;
use app\models\QueryRqst;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\tabs\TabsX;

$this->title = 'Artikel';
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h1',Html::encode($this->title));

echo Html::beginTag('div',['style' => 'margin-top:20px']);

        echo GridView::widget([
                'dataProvider' => (new QueryRqst())->getData(),
                'responsive'=> true,
                'hover'=> true,
                'export' => false,
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
        ]);

echo Html::endTag('div');

?>