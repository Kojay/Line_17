<?php
use yii\helpers\Html;
use app\models\QueryRqst;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\tabs\TabsX;

$this->title = 'Ausleihliste';
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h1',Html::encode($this->title));

echo Html::beginTag('div',['style' => 'margin-top:20px']);

echo GridView::widget([
    'dataProvider' => (new QueryRqst())->getDataAllfaelligeAusleihungen(),
    'responsive' => true,
    'pjax' => true,
    'hover' => true,
    'export' => false,
    'rowOptions' => function ($model, $index, $widget, $grid) {
        return ['id' => $model['fhnwNumber'], 'onclick' => 'location.href="'.Url::to(['ausleihe/ausleihe']).'&_rqstIDfhnwNumber="+(this.id);','style' => 'cursor: pointer'];
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
]);
echo Html::endTag('div');
?>