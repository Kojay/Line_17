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
                'dataProvider' => (new QueryRqst())->getArtikelListe(),
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
                        'label' => 'Artikeltyp',
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