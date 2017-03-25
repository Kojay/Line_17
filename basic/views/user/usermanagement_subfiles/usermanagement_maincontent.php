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
use kartik\sidenav\SideNav;

$this->title = 'Benutzerübersicht';
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h1',Html::encode($this->title));

echo Html::beginTag('div',['style' => 'margin-top:20px']);

echo GridView::widget([
    'dataProvider' => (new QueryRqst())->getDataUsers(),
    'responsive'=> true,
    'hover'=> true,
    'export' => false,
    //'rowOptions' => ['class' => GridView::TYPE_DANGER],
    'rowOptions' => function ($model, $index, $widget, $grid) {
        return ['id' => $model['userID'], 'onclick' => 'location.href="'.Url::to(['user/user']).'&_rqstIDUserID="+(this.id);','style' => 'cursor: pointer'];
    },
    'columns' => [
        ['class' => '\kartik\grid\SerialColumn'],
        [
            'label' => 'Benutzer ID',
            'attribute' => 'userID',
        ],
        [
            'label' => 'E-Mail Adresse',
            'attribute' => 'mail',
        ],
        [
            'label' => 'Berechtigungstyp',
            'attribute' => 'isUserAdmin',
            'format' => 'raw',
            'value' => function ($data) {
                if($data['isUserAdmin'] == 1 && $data['userID'] > 9900) return 'Supervisor';
                elseif ($data['isUserAdmin'] == 1) return 'Administrator';
                else return 'Benutzer';
            }
        ],
    ]
]);
echo Html::endTag('div');
?>