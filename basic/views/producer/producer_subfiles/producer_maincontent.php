<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\ActiveForm;
use app\models\QueryRqst;
use kartik\tabs\TabsX;
use kartik\grid\GridView;
use kartik\growl\Growl;

$this->title = 'Hersteller Details';

echo Html::tag('h1',Html::encode($this->title));

$form = ActiveForm::begin
([
    'id' => 'producerform',
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

echo $form->field($model, 'articleproducerID')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label('Hersteller ID:');
echo $form->field($model, 'articleproducerName')->textInput(['readonly'=>true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('articleproducerName'));
echo $form->field($model, 'articleproducerDescription')->textArea(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('articleproducerDescription'));

function translateField($paramString){
    $stringArray = [
        'articleproducerName' => 'Herstellername: ',
        'articleproducerDescription' => 'Beschreibung: '
    ];
    return $stringArray[$paramString];
}
ActiveForm::end();
echo Html::endTag('div');

$script = <<< JS
$( document ).ready(function() { 
   $("#btn-updateProducer").click(function(e){
    krajeeDialog.confirm("Sind sie sicher, dass sie den Hersteller bearbeiten wollen?", 
        function (result) {
            if (result) {                     
                e.preventDefault();
                $.ajax({
                    url: urlAjax,
                    type:'post',
                    headers: { '_rqstAjaxFnc': 'update' },
                    data:$('#producerform').serialize(),
                    success:function(){
                    }
                });
            }
        });
    });
    $("#btn-deleteProducer").click(function(e){
    krajeeDialog.confirm("Sind sie sicher, dass sie den Hersteller löschen wollen?", 
        function (result) {
            if (result) {
                e.preventDefault();
                $.ajax({
                    url: urlAjax,
                    type:'post',
                    headers: { '_rqstAjaxFnc': 'delete' },
                    data:$('#producerform').serialize(),
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