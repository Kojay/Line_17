<?php
/**
 * Article edit view
 * @author Alexander Weinbeck
 * @var $this yii\web\View
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use kartik\dialog\Dialog;

//init Krajee
Dialog::widget();
//use kartik\dialog\DialogAsset;
//DialogAsset::register($this);

$this->title = 'Artikel bearbeiten';

echo Html::tag('h1',Html::encode($this->title));

if(Yii::$app->session->hasFlash('articleDataUpdated')){
    echo Html::beginTag('div');
    echo Alert::widget([
        'options' => ['class' => 'alert-info'],
        'body' => Yii::$app->session->getFlash('articleDataUpdated'),
    ]);
}

$form = ActiveForm::begin
([
    'id' => 'articleupdate-form',
    'action' => 'article/articleedit',
    'options' => ['class' => 'articleupdate-style'],
    'fieldConfig' =>
        [
            'template' => '{label}{input}{error}',
            'labelOptions' => ['class' => 'articleupdate-style col-md-2'],
            'inputOptions' => ['class' => 'articleupdate-style col-md-4'],
            'errorOptions' => ['class' => 'articleupdate-style col-md-6'],
        ],
]);


echo $form->field($model, 'articleName',['options' => ['class' => 'col-md-12 fieldStyle']])
    ->textInput(['value' => $model->articleName])->label(translateField('articleName'));

echo $form
    ->field($model, 'articleTypeName',['options' => ['class' => 'col-md-12 fieldStyle']])
    ->textInput(['value' => $model['articleTypeName']])->label(translateField('articleTypeName'));

echo $form->field($model, 'articleTypeName',['options' => ['class' => 'col-md-12 fieldStyle','style' => 'Display: none;']])
    ->textInput(['value' => $model['lv_articletype_articleTypeID']])->label(translateField('lv_articletype_articleTypeID'));

echo $form->field($model, 'articleproducerName',['options' => ['id' => 'dropdownProducers','class' => 'col-md-12 fieldStyle','template' => '{input}{label}{error}{hint}',]])
    ->dropDownList($modelProducers,['style' => 'height: 26px;'])->label(translateField('articleproducerName'));

echo $form->field($model, 'articleproducerName',['options' => ['id' => 'textinputNewProducer','class' => 'col-md-12 fieldStyle','style' => 'Display: none;']])
    ->textInput(['placeholder' => 'Hersteller angeben...'])->label('Neuer Hersteller: ');

echo $form->field($model, 'serialNumber',['options' => ['class' => 'col-md-12 fieldStyle']])
    ->textInput(['value' => $model['serialNumber']], ['class' => 'col-md-6'])->label(translateField('serialNumber'));

echo $form->field($model, 'dateBought',['options' => ['class' => 'col-md-12 fieldStyle']])
    ->textInput(['value' => $model['dateBought']])->label(translateField('dateBought'));

echo $form->field($model, 'dateWarranty',['options' => ['class' => 'col-md-12 fieldStyle']])
    ->textInput(['value' => $model['dateWarranty']])->label(translateField('dateWarranty'));

echo $form->field($model, 'articlePrice',['options' => ['class' => 'col-md-12 fieldStyle']])
    ->textInput(['value' => $model['articlePrice']])->label(translateField('articlePrice'));

echo $form->field($model, 'fhnwNumber',['options' => ['class' => 'col-md-12 fieldStyle']])
    ->textInput(['value' => $model['fhnwNumber']])->label(translateField('fhnwNumber'));

echo $form->field($model, 'articleDescription',['options' => ['class' => 'col-md-12 fieldStyle']])
    ->textArea(['value' => $model['articleDescription']])->label(translateField('articleDescription'));


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
        'articleDescription' => 'Beschreibung: ',
        'lv_producer_producerID' => 'HerstellerID: ',
        'lv_articletype_articleTypeID' => 'ArtikeltypID: '
    ];
    return $stringArray[$paramString];
}
echo Html::Button('Artikel übernehmen', ['class' => 'btn btn-success col-md-4 btn-md btn-group','id' => 'btn-updateArticle','style' => 'margin-right:20px; margin-top:20px;']);
echo Html::Button('Artikel löschen', ['class' => 'btn btn-danger col-md-4 btn-md btn-group','id' => 'btn-deleteArticle','style' => 'margin-right:20px; margin-top:20px;']);

ActiveForm::end();
echo Html::endTag('div');

$this->registerJs("var urlAjax = ".json_encode(url::current()).";");
$this->registerJs(<<<JS
/**
 * Javascript for page "artikelbearbeiten.php"
 * @Author Alexander Weinbeck
 */
$(document).ready(function() {
    /**
     * Function to handle onclick event of edit "Artikel"
     * @Author Alexander Weinbeck
     */
    $("#btn-updateArticle").click(function(e){
        krajeeDialog.confirm("Sind sie sicher, dass sie den Artikel bearbeiten wollen?",
        function (result) {
            $("#fnc").value = 'update';
            if (result) {                     
                e.preventDefault();
                $.ajax({
                    url: urlAjax,
                    type:'post',
                    headers: { '_rqstAjaxFnc': 'update' },
                    data:$('#articleupdate-form').serialize(),
                    success:function(){
                    }
                });
            }
        });
    });
    /**
     * Function to handle onclick event to delete "Artikel"
     * @Author Alexander Weinbeck
     */
    $("#btn-deleteArticle").click(function(e){
        krajeeDialog.confirm("Sind sie sicher, dass sie den Artikel l�schen wollen?",
        function (result) {
            if (result) {
                e.preventDefault();
                $.ajax({
                    url: urlAjax,
                    type:'post',
                    headers: { '_rqstAjaxFnc': 'delete' },
                    data:$('#articleupdate-form').serialize(),
                    success:function(){
                    }
                });
            }
        });
    });
    /**
     * Function to handle check event of "Artikelproducers"
     * @Author Alexander Weinbeck
     */
    $("#textinputNewProducer").hide();
    $("#dropdownProducers").show();
    $(":checkbox").change(function() {
        if($(":checkbox").prop('checked')){
           $("#textinputNewProducer").show();
           $("#dropdownProducers").hide();
        }
        else{
           $("#textinputNewProducer").hide();
           $("#dropdownProducers").show();
        }               
    });
});

JS
);
?>