<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use kartik\dialog\Dialog;
use kartik\checkbox\CheckboxX;


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


if(Yii::$app->session->hasFlash('producerDataUpdated')){
    echo Html::beginTag('div');
    echo Alert::widget([
        'options' => ['class' => 'alert-info'],
        'body' => Yii::$app->session->getFlash('producerDataUpdated'),
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

echo $form->field($model, 'articleproducerName',[ 'options' => ['id' => 'textinputNewProducer','class' => 'col-md-12 fieldStyle','style' => 'Display: none;']])
    ->textInput(['value' => $model['articleproducerName']])->label('Neuer Hersteller: ');

echo $form->field($model, 'articleproducerDescription', [ 'options' => ['class' => 'col-md-12 fieldStyle']])
    ->textArea(['value' => $model['articleproducerDescription']])->label(translateField('articleproducerDescription'));

function translateField($paramString){
    $stringArray = [
        'articleproducerName' => 'Hersteller: ',
        'articleproducerDescription' => 'Beschreibung: '
    ];
    return $stringArray[$paramString];
}
echo Html::Button('Hersteller übernehmen', ['class' => 'btn btn-success col-md-4 btn-md btn-group','id' => 'btn-updateArticle','style' => 'margin-right:20px; margin-top:20px;']);
echo Html::Button('Hersteller löschen', ['class' => 'btn btn-danger col-md-4 btn-md btn-group','id' => 'btn-deleteArticle','style' => 'margin-right:20px; margin-top:20px;']);
// widget with default options
echo Dialog::widget();
ActiveForm::end();

echo Html::endTag('div');
$script = <<< JS
$( document ).ready(function() { 
    
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
    /* Set the width of the side navigation to 250px */
    function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    }

    /* Set the width of the side navigation to 0 */
    function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    }
});
JS;
$this->registerJs("var urlAjax = ".json_encode(url::current()).";");
$this->registerJs($script);
$this->registerCss("

");
?>