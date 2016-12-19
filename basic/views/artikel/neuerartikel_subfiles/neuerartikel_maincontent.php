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
    'options' => ['class' => 'articleupdate-style'],
    'fieldConfig' =>
        [
            'template' => '{label}{input}{error}',
            'labelOptions' => ['class' => 'col-md-2'],
            'inputOptions' => ['class' => 'col-md-4'],
            'errorOptions' => ['class' => 'col-md-4'],
        ],
]);

echo $form->field($model, 'articleName',        [ 'options' => ['class' => 'col-md-12 fieldStyle']])
    ->textInput(['value' => $model->articleName])->label(translateField('articleName'));

echo $form->field($model, 'articleTypeName',    [ 'options' => ['class' => 'col-md-12 fieldStyle']])
    ->textInput(['value' => $model['articleTypeName']])->label(translateField('articleTypeName'));

echo $form->field($model, 'articleproducerName',[ 'options' => ['id' => 'dropdownProducers','class' => 'col-md-12 fieldStyle','template' => '{input}{label}{error}{hint}',]])
    ->dropDownList($modelProducers,['style' => 'height: 26px;'])->label(translateField('articleproducerName'));

echo $form->field($model, 'articleproducerName',[ 'options' => ['id' => 'textinputNewProducer','class' => 'col-md-12 fieldStyle','style' => 'Display: none;']])
    ->textInput(['value' => 'Herstellername'])->label('Neuer Hersteller: ');

echo $form->field($model, 'serialNumber',       [ 'options' => ['class' => 'col-md-12 fieldStyle']])
    ->textInput(['value' => $model['serialNumber']], ['class' => 'col-md-6'])->label(translateField('serialNumber'));

echo $form->field($model, 'dateBought',         [ 'options' => ['class' => 'col-md-12 fieldStyle']])
    ->textInput(['value' => $model['dateBought']])->label(translateField('dateBought'));

echo $form->field($model, 'dateWarranty',       [ 'options' => ['class' => 'col-md-12 fieldStyle']])
    ->textInput(['value' => $model['dateWarranty']])->label(translateField('dateWarranty'));

echo $form->field($model, 'articlePrice',       [ 'options' => ['class' => 'col-md-12 fieldStyle']])
    ->textInput(['value' => $model['articlePrice']])->label(translateField('articlePrice'));

echo $form->field($model, 'fhnwNumber',         [ 'options' => ['class' => 'col-md-12 fieldStyle']])
    ->textInput(['value' => $model['fhnwNumber']])->label(translateField('fhnwNumber'));

echo $form->field($model, 'articleDescription', [ 'options' => ['class' => 'col-md-12 fieldStyle']])
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
        'fhnwNumber' => 'FHNW Nummer: ',
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
    $(':checkbox').change(function() {   
        if($(':checkbox').prop('checked')){
           $('#textinputNewProducer').show();  
           $('#dropdownProducers').hide();
        }
        else{
           $('#textinputNewProducer').hide();
           $('#dropdownProducers').show();
        }               
    });  
});
JS;
//$url = Url::toRoute('artikel/neuerartikel');
$this->registerJs("var urlAjax = ".json_encode(url::current()).";");
$this->registerJs($script);

ActiveForm::end();
?>