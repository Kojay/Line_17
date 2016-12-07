<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\ActiveForm;
use kartik\dialog\Dialog;

$this->title = 'Artikel bearbeiten';

echo Breadcrumbs::widget([
    'links' => [
        [
            'label' => 'Artikelliste',
            'url' => ['site/artikelliste'],
            'template' => "<li>{link}</li>\n", // template for this link only
        ],      
        $this->title
    ],
]);

echo Html::tag('h1',Html::encode($this->title));
echo Menu::widget([
            'items' => 
            [
                ['label' => 'Zurück', 'url' => ['site/artikel']],
                ['label' => 'Artikel Bearbeiten', 'url' => false],
                ['label' => 'Etikette Drucken', 'url' => ['site/etikette']],
                ['label' => 'Ausleihen', 'url' => ['site/ausleihe']],
                
            ],
            'options' => ['class' =>'nav nav-tabs'],
        ]);

echo Html::beginTag('div',['style' => 'margin-top:20px']);

    $form = ActiveForm::begin
    ([
        'id' => 'artikelspeichern-formActive',
        'action' => 'site/artikelbearbeiten',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => 
        [
            'template' => '{label}{input}',
            'labelOptions' => ['class' => 'col-md-2'],
            'inputOptions' => ['class' => 'col-md-4'],
        ],
    ]);
    echo $form->field($model, 'articleName')->textInput(['value' => $modeldata['articleName']])->label(translateField('articleName'));  
    echo $form->field($model, 'articleTypeName')->textInput(['value' => $modeldata['articleTypeName']])->label(translateField('articleTypeName'));  
    echo $form->field($model, 'articleproducerName')->textInput(['value' => $modeldata['articleproducerName']])->label(translateField('articleproducerName'));  
    echo $form->field($model, 'serialNumber')->textInput(['value' => $modeldata['serialNumber']])->label(translateField('serialNumber'));  
    echo $form->field($model, 'dateBought')->textInput(['value' => $modeldata['dateBought']])->label(translateField('dateBought'));
    echo $form->field($model, 'dateWarranty')->textInput(['value' => $modeldata['dateWarranty']])->label(translateField('dateWarranty'));
    echo $form->field($model, 'articlePrice')->textInput(['value' => $modeldata['articlePrice']])->label(translateField('articlePrice'));
    echo $form->field($model, 'fhnwNumber')->textInput(['value' => $modeldata['fhnwNumber']])->label(translateField('fhnwNumber'));
    echo $form->field($model, 'articleDescription')->textArea(['value' => $modeldata['articleDescription']])->label(translateField('articleDescription'));  
    echo $form->field($model, 'fhnwNumberID')->hiddenInput(['value' => $modeldata['fhnwNumber']])->label(false);
    
    function translateField($paramString){
        $stringArray = [
                             'articleName' => 'Artikelname: ',
                             'articleTypeName' => 'Typ: ', 
                             'articleproducerName' => 'Hersteller: ',
                             'serialNumber' => 'Seriennummer: ',
                             'dateBought' => 'Kaufdatum: ',
                             'dateWarranty' => 'Garantiedatum: ',
                             'articlePrice' => 'Artikelpreis: ',
                             'fhnwNumber' => 'FHNW Nummer: ',
                             'articleDescription' => 'Beschreibung: '
                        ];
        $result = $stringArray[$paramString];
        return $result;
    }

    echo Html::Button('Artikel bearbeiten', ['class' => 'btn btn-primary','id' => 'btn-confirm']);

    // widget with default options
    echo Dialog::widget();
    ActiveForm::end();  
echo Html::Tag('div','',['style' => 'margin-bottom:20px']);
    echo Html::Tag('textfield','Artikel erfolgreich gespeichert!',['id' => 'SuccessText','style' => 'display:none']);
echo Html::endTag('div', ['style' => 'margin-bottom:50px']);

$script = <<< JS
$( document ).ready(function() {
        var form=$("#artikelspeichern-formActive");
    $(function(){
       $("#btn-confirm").click(function(e){
        krajeeDialog.confirm("Sind sie sicher, dass sie den Artikel bearbeiten wollen?", function (result) {
            if (result) {
                        //$("#artikelspeichern-formActive").submit();
                        e.preventDefault();
                        $.ajax({
                                url: urlAjax,
                                type:'post',
                                data:$('#artikelspeichern-formActive').serialize(),
                        success:function(){
                                //execute changes if needed ...
        
                                    $('#SuccessText').delay(500).fadeIn("normal", function() {
                                    $(this).delay(2500).fadeOut("normal");
                                        });
                                    
                        }
    });

            }
        });
        });
    });
});
JS;
$url = Url::toRoute('site/artikelbearbeiten');
$this->registerJs("var urlAjax = ".json_encode($url).";");
$this->registerJs($script);
?>

    
    
    <!--
    $.ajax({
                            url: "?r=site/artikelspreichern",
                            
                                dataType: "json",
                                data: {articleDescription: $("#articleDescription").text();},
                                success: function(data) {
                                if(data.error) {
                                                alert(data.error);
                                        } else if(data.quote) {
                                                $("#quote-of-the-day").html(data.quote);
                                        } else {
                                                $("#quote-of-the-day").html("Response in invalid format!");
                                                alert("Response in invalid format!");
                                        }
                }
        })
    -->