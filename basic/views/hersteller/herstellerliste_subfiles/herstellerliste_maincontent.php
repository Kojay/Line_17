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
                'dataProvider' => (new QueryRqst())->getProducerListe(),
                'responsive'=> true,
                'hover'=> true,
                'export' => false,
                'rowOptions' => function ($model, $index, $widget, $grid) {
                    return ['id' => $model['articleproducerID'], 'onclick' => 'location.href="'.Url::to(['hersteller/hersteller']).'&_rqstarticleProducerID="+(this.id);','style' => 'cursor: pointer'];
                },
                'columns' => [
                    ['class' => '\kartik\grid\SerialColumn'],
                    [

                        'label' => 'Herstellername',
                        'attribute' => 'articleproducerName',
                    ],
                    [

                        'label' => 'Hersteller Beschreibung',
                        'attribute' => 'articleproducerDescription',

                    ],],
        ]);
echo Html::endTag('div');

?>