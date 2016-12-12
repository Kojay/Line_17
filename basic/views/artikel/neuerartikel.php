<?php
\yii\widgets\Pjax::begin();
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\ActiveForm;
use kartik\dialog\Dialog;

$this->title = 'Artikel erstellen';

echo Breadcrumbs::widget([
    'links' => [
        [
            'label' => 'Artikelliste',
            'url' => ['artikel/artikelliste'],
            'template' => "<li>{link}</li>\n", // template for this link only
        ],      
        $this->title
    ],
]);

echo Html::tag('h1',Html::encode($this->title));

echo Menu::widget([
            'items' => 
            [
                ['label' => 'Zurück', 'url' => ['artikel/artikel',['_rqstIDfhnwNumber' => ['fhnwNumber' => yii::$app->session->get('_rqstIDfhnwNumber')]]]],
                ['label' => 'Artikel Bearbeiten', 'url' => false],
                ['label' => 'Etikette Drucken', 'url' => ['site/etikette']],
                ['label' => 'Ausleihen', 'url' => ['site/ausleihe']],    
            ],
            'options' => ['class' =>'nav nav-tabs'],
        ]);

echo Html::beginTag('div');
    if(Yii::$app->session->hasFlash('articleDataUpdated')){
        echo Html::beginTag('div');    
            echo Alert::widget([
                'options' => ['class' => 'alert-info'],
                'body' => Yii::$app->session->getFlash('articleDataUpdated'),
            ]);
        echo Html::endTag('div');
    }
echo Html::beginTag('div',['style' => 'margin-top:20px']);

    $form = ActiveForm::begin
    ([
        'id' => 'createArticle-formActive',
        'action' => 'artikel/artikelbearbeiten',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => 
        [
            'template' => '{label}{input}{error}',
            'labelOptions' => ['class' => 'col-md-2'],
            'inputOptions' => ['class' => 'col-md-4'],
            'errorOptions' => ['class' => 'col-md-4'],
        ],
    ]);
    //echo var_dump($model->errors);
    echo $form->field($model, 'articleName')->textInput(['value' => $model['articleName']])->label(translateField('articleName'));  
    echo $form->field($model, 'articleTypeName')->textInput(['value' => $model['articleTypeName']])->label(translateField('articleTypeName'));  
    echo $form->field($model, 'articleproducerName')->textInput(['value' => $model['articleproducerName']])->label(translateField('articleproducerName'));  
    echo $form->field($model, 'serialNumber')->textInput(['value' => $model['serialNumber']])->label(translateField('serialNumber'));  
    echo $form->field($model, 'dateBought')->textInput(['value' => $model['dateBought']])->label(translateField('dateBought'));
    echo $form->field($model, 'dateWarranty')->textInput(['value' => $model['dateWarranty']])->label(translateField('dateWarranty'));
    echo $form->field($model, 'articlePrice')->textInput(['value' => $model['articlePrice']])->label(translateField('articlePrice'));
    echo $form->field($model, 'fhnwNumber')->textInput(['value' => $model['fhnwNumber']])->label(translateField('fhnwNumber'));
    echo $form->field($model, 'articleDescription')->textArea(['value' => $model['articleDescription']])->label(translateField('articleDescription'));  
    //echo $form->field($model, 'fhnwNumberID')->hiddenInput(['value' => $model['fhnwNumber']])->label(false);
    
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
    echo Html::Button('Artikel erstellen', ['class' => 'btn btn-success','id' => 'btn-create']);    
    // widget with default options
    echo Dialog::widget();
    ActiveForm::end();  

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
});
JS;
//$url = Url::toRoute('artikel/neuerartikel');
$this->registerJs("var urlAjax = ".json_encode(url::current()).";");
$this->registerJs($script);
\yii\widgets\Pjax::end();