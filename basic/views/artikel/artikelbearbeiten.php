<?php
\yii\widgets\Pjax::begin();
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use kartik\dialog\Dialog;

$this->title = 'Artikel bearbeiten';

echo Breadcrumbs::widget([
    'links' => [
        [
            'label' => 'Artikelliste',
            'url' => ['artikel/artikelliste','id' => yii::$app->request->get('_rqstIDfhnwNumber')],
            'template' => "<li>{link}</li>\n", // template for this link only
        ],      
        $this->title
    ],
]);

echo Html::tag('h1',Html::encode($this->title));

echo Menu::widget([
    'items' =>
    [
        ['label' => 'Zurück', 'url' => ['artikel/artikel','_rqstIDfhnwNumber' => yii::$app->request->get('_rqstIDfhnwNumber')]],
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
echo Html::endTag('div');

echo Html::beginTag('div');
    $form = ActiveForm::begin
    ([
        'id' => 'articleupdate-form',
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

    echo Html::beginTag('div',['style' => 'margin-top:20px']);

    echo $form->field($model, 'articleName')->textInput(['value' => $model->articleName])->label(translateField('articleName'));
    echo $form->field($model, 'articleTypeName')->textInput(['value' => $model['articleTypeName']])->label(translateField('articleTypeName'));
    echo $form->field($model, 'articleproducerName')->textInput(['value' => $model['articleproducerName']])->label(translateField('articleproducerName'));
    echo $form->field($model, 'serialNumber')->textInput(['value' => $model['serialNumber']])->label(translateField('serialNumber'));
    echo $form->field($model, 'dateBought')->textInput(['value' => $model['dateBought']])->label(translateField('dateBought'));
    echo $form->field($model, 'dateWarranty')->textInput(['value' => $model['dateWarranty']])->label(translateField('dateWarranty'));
    echo $form->field($model, 'articlePrice')->textInput(['value' => $model['articlePrice']])->label(translateField('articlePrice'));
    echo $form->field($model, 'fhnwNumber')->textInput(['value' => $model['fhnwNumber']])->label(translateField('fhnwNumber'));
    echo $form->field($model, 'articleDescription')->textArea(['value' => $model['articleDescription']])->label(translateField('articleDescription'));
    echo $form->field($model, 'param')->hiddenInput(['id' => 'fnc','value' => 'fnctn'])->label(false);

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
    echo Html::Button('Artikel bearbeiten', ['class' => 'btn btn-success','id' => 'btn-updateArticle','style' => 'margin-right:20px']);
    echo Html::Button('Artikel löschen', ['class' => 'btn btn-danger','id' => 'btn-deleteArticle']);
    // widget with default options
    echo Dialog::widget();

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
                    headers: { '_rqstAjaxFnc': 'update' },
                    data:$('#articleupdate-form').serialize(),
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
                    data:$('#articleupdate-form').serialize(),
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
\yii\widgets\Pjax::end();
