<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\dialog\Dialog;
use yii\helpers\Url;
use yii\bootstrap\Alert;

$this->title = 'Benutzer bearbeiten';

echo Html::tag('h1',Html::encode($this->title));

$form = ActiveForm::begin
([
    'id' => 'userupdate-form',
    'layout' => 'horizontal',
    'fieldConfig' =>
        [
            'template' => "{label}{input}",
            'labelOptions' => ['class' => 'col-md-2'],
            'inputOptions' => ['class' => 'col-md-4'],
        ],
]);

if(Yii::$app->session->hasFlash('userDataUpdated'))
{
    echo Alert::widget([
        'options' => ['class' => 'alert-info'],
        'body' => Yii::$app->session->getFlash('userDataUpdated'),
    ]);
}
echo Html::beginTag('div',['style' => 'margin-top:20px']);

echo $form->field($model, 'userID')->textInput(['readonly'=>true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('userID'));
echo $form->field($model, 'personFirstname')->textInput(['value' => $model->personFirstname])->label(translateField('personFirstname'));
echo $form->field($model, 'personLastname')->textInput(['value' => $model->personLastname])->label(translateField('personLastname'));
echo $form->field($model, 'personMail')->textInput(['value' => $model->personMail])->label(translateField('personMail'));
echo $form->field($model, 'userPassword')->textInput(['value' => ''])->label('Neues Passwort:');
echo $form->field($model, 'userPassword')->textInput(['value' => ''])->label('Passwort bestätigen:');
echo $form->field($model, 'isUserAdmin')->inline()->radioList(['0' => 'Benutzer','1' => 'Administrator'])->label(translateField('isUserAdmin'));

echo Html::Button('Benutzer speichern', ['class' => 'btn btn-success','id' => 'btn-saveUser','style' => 'margin-right:20px']);
echo Html::Button('Benutzer löschen', ['class' => 'btn btn-danger','id' => 'btn-deleteUser']);


function translateFieldPermission($paramAdmin){
    if ($paramAdmin === 1): return 'Administrator'; else: return 'Benutzer'; endif;
}
function translateField($paramString){
    $stringArray = [
        'userID'           => 'BenutzerID: ',
        'personFirstname'  => 'Vorname: ',
        'personLastname'   => 'Nachname: ',
        'personMail'       => 'E-Mail Adresse: ',
        'isUserAdmin'      => 'Berechtigungstyp: ',
    ];
    return $stringArray[$paramString];
}
echo Dialog::widget();


$script = <<< JS
$( document ).ready(function() { 
   $("#btn-saveUser").click(function(e){
    krajeeDialog.confirm("Sind sie sicher, dass sie den Benutzer bearbeiten wollen?", 
        function (result) {
            if (result) {                     
                e.preventDefault();
                $.ajax({
                    url: urlAjax,
                    type:'post',
                    headers: { '_rqstAjaxFnc': 'update' },
                    data:$('#userupdate-form').serialize(),
                    success:function(){
                    }
                });
            }
        });
    });
    $("#btn-deleteUser").click(function(e){
    krajeeDialog.confirm("Sind sie sicher, dass sie den Benutzer löschen wollen?", 
        function (result) {
            if (result) {
                e.preventDefault();
                $.ajax({
                    url: urlAjax,
                    type:'post',
                    headers: { '_rqstAjaxFnc': 'delete' },
                    data:$('#userupdate-form').serialize(),
                    success:function(){
                    }
                });
            }
        });
    });
});
JS;
//Url::remember();
//$url = Url::toRoute('benutzer/benutzerbearbeiten');
$this->registerJs("var urlAjax = ".json_encode(url::current()).";");
$this->registerJs($script);
ActiveForm::end();
echo Html::endTag('div');
?>
