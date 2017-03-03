<?php
    use yii\helpers\Url;
    use yii\helpers\Html;
    use yii\widgets\Menu;
    use yii\widgets\Breadcrumbs;
    use yii\bootstrap\ActiveForm;
    use app\models\QueryRqst;
    use kartik\tabs\TabsX;
    use kartik\grid\GridView;


/**
 * Created by PhpStorm.
 * User: kwlski
 * Date: 18.12.2016
 * Time: 16:28
 */

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

//echo yii\helpers\VarDumper::dump($model);
//echo yii\helpers\VarDumper::dump($models);
echo $form->errorSummary($model);

echo $form->field($model, 'articleName')->textInput(['readonly'=>true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('articleName'));
echo $form->field($model, 'articleTypeName')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('articleTypeName'));
echo $form->field($model, 'articleproducerName')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('articleproducerName'));
echo $form->field($model, 'serialNumber')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('serialNumber'));
echo $form->field($model, 'dateBought')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('dateBought'));
echo $form->field($model, 'dateWarranty')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('dateWarranty'));
echo $form->field($model, 'articlePrice')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('articlePrice'));
echo $form->field($model, 'fhnwNumber')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('fhnwNumber'));
echo $form->field($model, 'articleDescription')->textArea(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('articleDescription'));


echo '<h3><b>Ausleihhistorie</b></h3>';
echo GridView::widget([
        'dataProvider' => (new QueryRqst())->getArtikelHistory($model['fhnwNumber']),
        'responsive'=> true,
        'hover'=> true,
        'export' => false,
        //'rowOptions' => function ($model, $index, $widget, $grid) {
        //     return ['id' => $model['fhnwNumber'], 'onclick' => 'location.href="'.Url::to(['artikel/artikel']).'&_rqstIDfhnwNumber="+(this.id);','style' => 'cursor: pointer'];
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
        'articleDescription' => 'Beschreibung: '
    ];
    return $stringArray[$paramString];
}
ActiveForm::end();
echo Html::endTag('div');

$script = <<< JS
$( document ).ready(function() { 
   $("#btn-updateArticle").click(function(e){
    krajeeDialog.confirm("Sind sie sicher, dass sie den Artikel bearbeiten wollen?", 
        function (result) {
            $("#fnc").value = 'update';
            if (result) {                     
                e.preventDefault();
                $.ajax({
                    url: urlAjax,
                    type:'post',
                    headers: { 'REQUESTfnc': 'update' },
                    data:$('#articleUpdate-form').serialize(),
                    success:function(){
                    }
                });
            }
        });
    });
    $("#btn-deleteArticle").click(function(e){
    krajeeDialog.confirm("Sind sie sicher, dass sie den Artikel löschen wollen?", 
        function (result) {
            if (result) {
                e.preventDefault();
                $.ajax({
                    url: urlAjax,
                    type:'post',
                    headers: { '_rqstAjaxFnc': 'delete' },
                    data:$('#articleUpdate-form').serialize(),
                    success:function(){
                    }
                });
            }
        });
    });
});
JS;
$this->registerJs("var urlAjax = ".json_encode(url::current()).";");
$this->registerJs($script);
?>