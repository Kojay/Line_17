<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\QueryRqst;
use kartik\grid\GridView;
use kartik\dialog\Dialog;
/**
 * Article view
 * @author Alexander Weinbeck
 * @var $this yii\web\View
 */
//init Krajee
Dialog::widget();
$this->registerJs("var urlAjax = ".json_encode(url::current()).";");
$this->registerJsFile('@web/js/article.js');


$this->title = 'Artikel Details';

echo Html::tag('h1',Html::encode($this->title));

$form = ActiveForm::begin
([
    'id' => 'article-form',
    'layout' => 'horizontal',
    'fieldConfig' =>
        [
            'template' => "{label}{input}{error}",
            'labelOptions' => ['class' => 'col-md-2'],
            'inputOptions' => ['class' => 'col-md-4'],
        ],
]);

echo Html::beginTag('div',['style' => 'margin-top:20px']);

echo $form->errorSummary($model);

echo $form->field($model, 'articleName')->textInput(['readonly'=>true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('articleName'));
echo $form->field($model, 'articleTypeName')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('articleTypeName'));
echo $form->field($model, 'articleproducerName')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('articleproducerName'));
echo $form->field($model, 'serialNumber')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('serialNumber'));
echo $form->field($model, 'dateBought')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('dateBought'));
echo $form->field($model, 'dateWarranty')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('dateWarranty'));
echo $form->field($model, 'articlePrice')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('articlePrice'));
echo $form->field($model, 'fhnwNumber')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('fhnwNumber'));
echo $form->field($model, 'isArchive')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('isArchive'));
echo $form->field($model, 'articleStatus')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('articleStatus'));
echo $form->field($model, 'statusComment')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('statusComment'));
echo $form->field($model, 'articleDescription')->textArea(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('articleDescription'));

echo '<h5><b>Status ändern:</b></h5>';
echo Html::Button('Artikel in Reperatur', ['class' => 'btn btn-warning col-md-4 btn-md btn-group','id' => 'btn-repairArticle','style' => 'margin-right:20px; margin-top:20px;']);
echo Html::Button('Artikel ins Archiv verschieben', ['class' => 'btn btn-danger col-md-4 btn-md btn-group','id' => 'btn-archiveArticle','style' => 'margin-right:20px; margin-top:20px;']);
echo '<br>';
echo '<br>';
echo '<br>';

echo '<h3><b>Ausleihhistorie</b></h3>';

echo GridView::widget([
        'dataProvider' => (new QueryRqst())->getArticleHistory($model['fhnwNumber']),
        'responsive'=> true,
        'hover'=> true,
        'export' => false,
        //'rowOptions' => function ($model, $index, $widget, $grid) {
        //     return ['id' => $model['fhnwNumber'], 'onclick' => 'location.href="'.Url::to(['article/article']).'&_rqstIDfhnwNumber="+(this.id);','style' => 'cursor: pointer'];
        //},
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

                'label' => 'Ausleihdatum',
                'attribute' => 'lvLoanLendingDate',
                'format' =>  ['date', 'php:d.m.Y'],

            ],           
            [

                'label' => 'Rückgabedatum',
                'attribute' => 'lvLoanReturnDate',
                'format' =>  ['date', 'php:d.m.Y'],

            ],],
]);

function translateField($paramString){
    $stringArray = [
        'articleName' => 'Artikelname: ',
        'articleTypeName' => 'Typ: ',
        'articleproducerName' => 'Hersteller: ',
        'serialNumber' => 'Seriennummer: ',
        'dateBought' => 'Kaufdatum: ',
        'dateWarranty' => 'Garantiedatum: ',
        'articlePrice' => 'Artikelpreis: ',
        'fhnwNumber' => 'Institut: ',
        'isArchive' => 'Archiviert: ',
        'articleStatus' => 'Status: ',
        'statusComment' => 'Statuskommentar: ',
        'articleDescription' => 'Beschreibung: '
    ];
    return $stringArray[$paramString];
}
ActiveForm::end();
echo Html::endTag('div');
?>