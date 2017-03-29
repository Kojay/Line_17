<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use kartik\dialog\Dialog;
use kartik\checkbox\CheckboxX;
use kartik\growl\Growl;

$this->title = 'Hersteller bearbeiten';
/*
echo Breadcrumbs::widget([
    'links' => [
        [
            'label' => 'Herstellerliste',
            'url' => ['producer/herstellerliste','id' => yii::$app->request->get('_rqstarticleProducerID')],
            'template' => "<li>{link}</li>\n", // template for this link only
        ],
        $this->title
    ],
]);
*/
echo Html::tag('h1',Html::encode($this->title));
echo Html::beginTag('div');

if(Yii::$app->session->hasFlash('producerSuccess')) {
    echo Growl::widget([
        'type' => Growl::TYPE_SUCCESS,
        'title' => 'Erfolg!',
        'icon' => 'glyphicon glyphicon-ok-sign',
        'body' => Yii::$app->session->getFlash('producerSuccess'),
        'showSeparator' => true,
        'delay' => 0,
        'pluginOptions' => [
            'showProgressbar' => true,
            'placement' => [
                'from' => 'top',
                'align' => 'center',
            ]
        ]
    ]);
}
if(Yii::$app->session->hasFlash('producerError')) {
    echo Growl::widget([
        'type' => Growl::TYPE_DANGER,
        'title' => 'Fehler!',
        'icon' => 'glyphicon glyphicon-remove-sign',
        'body' => Yii::$app->session->getFlash('producerError'),
        'showSeparator' => true,
        'delay' => 0,
        'pluginOptions' => [
            'showProgressbar' => true,
            'placement' => [
                'from' => 'top',
                'align' => 'center',
            ]
        ]
    ]);
}

$form = ActiveForm::begin
([
    'id' => 'producerupdate-form',
    'action' => 'producer/produceredit',
    'options' => ['class' => 'producerupdate-style'],
    'fieldConfig' =>
        [
            'template' => '{label}{input}{error}',
            'labelOptions' => ['class' => 'producerupdate-style col-md-2'],
            'inputOptions' => ['class' => 'producerupdate-style col-md-4'],
            'errorOptions' => ['class' => 'producerupdate-style col-md-4'],
        ],
]);

echo $form->field($model, 'articleproducerID',[ 'options' => ['id' => 'textinputArticleproducerID','class' => 'col-md-12 fieldStyle']])
    ->textInput(['readonly' => true,'style' => 'border:0;','value' => $model['articleproducerID']])->label('Hersteller ID: ');
//echo $form->field($model, 'articleproducerID')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label('Hersteller ID:');
echo $form->field($model, 'articleproducerName',[ 'options' => ['id' => 'textinputNewProducer','class' => 'col-md-12 fieldStyle']])
    ->textInput(['value' => $model['articleproducerName']])->label('Hersteller: ');

echo $form->field($model, 'articleproducerDescription', [ 'options' => ['class' => 'col-md-12 fieldStyle']])
    ->textArea(['value' => $model['articleproducerDescription']])->label('Beschreibung: ');

echo Html::Button('Hersteller übernehmen', ['class' => 'btn btn-success col-md-4 btn-md btn-group','id' => 'btn-updateProducer','style' => 'margin-right:20px; margin-top:20px;']);
echo Html::Button('Hersteller löschen', ['class' => 'btn btn-danger col-md-4 btn-md btn-group','id' => 'btn-deleteProducer','style' => 'margin-right:20px; margin-top:20px;']);
// widget with default options
echo Dialog::widget();
ActiveForm::end();

echo Html::endTag('div');
$script = <<< JS
$( document ).ready(function() { 
    $("#btn-deleteProducer").click(function(e){
        krajeeDialog.confirm("Sind sie sicher, dass sie den Hersteller löschen wollen?", 
        function (result) {
            if (result) {
                e.preventDefault();
                $.ajax({
                    url: urlAjax,
                    type:'post',
                    headers: { '_rqstAjaxFnc': 'delete' },
                    data:$('#producerupdate-form').serialize(),
                    success:function(){
                    }
                });
            }
        });
    });
    $("#btn-updateProducer").click(function(e){
        krajeeDialog.confirm("Sind sie sicher, dass sie den Hersteller bearbeiten wollen?", 
        function (result) {
            if (result) {
                e.preventDefault();
                $.ajax({
                    url: urlAjax,
                    type:'post',
                    headers: { '_rqstAjaxFnc': 'update' },
                    data:$('#producerupdate-form').serialize(),
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
$this->registerCss("

");
?>