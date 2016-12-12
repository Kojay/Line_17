<?php
\yii\widgets\Pjax::begin();
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\ActiveForm;


$this->title = 'Artikel Details';

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
                ['label' => 'Zurück', 'url' => ['artikel/artikelliste','_rqstIDfhnwNumber' => yii::$app->session->get('_rqstIDfhnwNumber')]],
                ['label' => 'Artikel Bearbeiten', 'url' => ['artikel/artikelbearbeiten','_rqstIDfhnwNumber' => yii::$app->session->get('_rqstIDfhnwNumber')]],
                ['label' => 'Etikette Drucken', 'url' => ['site/etikette']],
                ['label' => 'Ausleihen', 'url' => ['site/index']],
            ],
            'options' => ['class' =>'nav nav-tabs'],
        ]);

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
    ActiveForm::end(); 
    \yii\widgets\Pjax::end();
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
