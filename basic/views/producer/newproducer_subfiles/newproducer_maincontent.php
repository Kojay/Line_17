<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\ActiveForm;
use kartik\dialog\Dialog;

$this->title = 'Artikel erstellen';

echo Html::tag('h1',Html::encode($this->title));

    if(Yii::$app->session->hasFlash('producerDataUpdated')){
        echo Html::beginTag('div');
        echo Alert::widget([
            'options' => ['class' => 'alert-info'],
            'body' => Yii::$app->session->getFlash('producerDataUpdated'),
        ]);
        echo Html::endTag('div');
    }
echo Html::beginTag('div',['style' => 'margin-top:20px']);

$form = ActiveForm::begin
([
    'id' => 'createArticle-formActive',
    'action' => 'article/articleedit',
    'options' => ['class' => 'articleupdate-style'],
    'fieldConfig' =>
        [
            'template' => '{label}{input}{error}',
            'labelOptions' => ['class' => 'col-md-2'],
            'inputOptions' => ['class' => 'col-md-4'],
            'errorOptions' => ['class' => 'col-md-4'],
        ],
]);

echo $form->field($model, 'articleproducerName',[ 'options' => ['id' => 'textinputNewProducer','class' => 'col-md-12 fieldStyle']])
    ->textInput(['value' => $model['articleproducerName']])->label('Neuer Hersteller: ');

echo $form->field($model, 'articleproducerDescription', [ 'options' => ['class' => 'col-md-12 fieldStyle']])
    ->textArea(['value' => $model['articleproducerDescription']])->label(translateField('articleproducerDescription'));

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
    $result = $stringArray[$paramString];
    return $result;
}
echo Html::Button('Artikel erstellen', ['class' => 'btn btn-success','id' => 'btn-create']);
// widget with default options
echo Dialog::widget();
echo Html::endTag('div');
$script = <<< JS
$( document ).ready(function() {
    $(function(){
        $("#btn-create").click(function(e){
            krajeeDialog.confirm("Sind sie sicher, dass sie den Artikel erstellen wollen?", 
            function (result) {
                if (result) {
                    e.preventDefault();
                    $.ajax({
                        url: urlAjax,
                        type:'post',
                        headers: { '_rqstAjaxFnc': 'create' },
                        data:$('#createArticle-formActive').serialize(),
                        success:function(){
                        //execute changes if needed ...         
                        }
                    });
                }
            });
        });
    });
    $('#someSwitchOptionDefaultProducer').change(function() {   
        if($('#someSwitchOptionDefaultProducer').prop('checked')){
           $('#textinputNewProducer').show();  
           $('#dropdownProducers').hide();
        }
        else{
           $('#textinputNewProducer').hide();
           $('#dropdownProducers').show();
        }               
    });  
    $('#someSwitchOptionDefaultArticletype').change(function() {   
        if($('#someSwitchOptionDefaultArticletype').prop('checked')){
           $('#textinputNewArticletype').show();  
           $('#dropdownArticletype').hide();
        }
        else{
           $('#textinputNewArticletype').hide();
           $('#dropdownArticletype).show();
        }               
    });  
});
JS;
//$url = Url::toRoute('article/neuerartikel');
$this->registerJs("var urlAjax = ".json_encode(url::current()).";");
$this->registerJs($script);

ActiveForm::end();
?>