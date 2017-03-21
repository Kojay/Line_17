<?php
/**
 * New user view
 * @author Alexander Weinbeck
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use kartik\dialog\Dialog;


$this->registerJs("var urlAjax = ".json_encode(Url::toRoute('user/newuser')).";");
if(!$model->hasErrors('ConnectionAD')) $this->registerJs("var searchADNames = ".json_encode($adUsers).";");
$this->registerJsFile('@web/js/newuser.js');
//init Krajee
Dialog::widget();


$this->title = 'Benutzer erstellen';

echo Html::tag('h1',Html::encode($this->title));


echo Html::beginTag('div',['style' => 'margin-top:20px']);

$form = ActiveForm::begin
([
    'id' => 'createuser-formActive',
    'action' => 'user/useredit',
    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' =>
        [
            'template' => '{label}{input}{error}',
            'labelOptions' => ['class' => 'col-md-2'],
            'inputOptions' => ['class' => 'col-md-4'],
            'errorOptions' => ['class' => 'col-md-4'],
        ],
]);

if(Yii::$app->session->hasFlash('userDataCreated'))
{
    echo Html::beginTag('div',['style' => 'margin-top:20px']);
    echo Alert::widget([
        'options' => ['class' => 'alert-info'],
        'body' => Yii::$app->session->getFlash('userDataCreated'),
    ]);
    echo Html::endTag('div',['style' => 'margin-bottom:20px']);
}
echo $form->errorSummary($model);

echo $form
    ->field($model, 'name')
    ->label('Namen eingeben:',['for' => 'searchNamesAD'])
    ->input('',['id' => 'searchNamesAD','placeholder' => 'Name eingeben...']);

echo $form
    ->field($model, 'personMail')
    ->textInput(['value' => $model->personMail])
    ->label(translateField('personMail'));
echo $form
    ->field($model, 'userPassword')
    ->textInput(['value' => ''])
    ->label('Neues Passwort:');
echo $form
    ->field($model, 'userPassword')
    ->textInput(['value' => ''])
    ->label('Passwort bestätigen:');
echo $form
    ->field($model, 'isUserAdmin')
    ->inline()
    ->radioList(['0' => 'Benutzer','1' => 'Administrator'])
    ->label(translateField('isUserAdmin'));

/**
 * Translates db column name to german readable word
 * @author Alexander Weinbeck
 * @param $paramString
 * @return String
 */
function translateFieldPermission($paramAdmin){
    if ($paramAdmin === 1): return 'Administrator'; else: return 'Benutzer'; endif;
}
/**
 * Translates db column name to german readable word
 * @author Alexander Weinbeck
 * @param $paramString
 * @return mixed
 */
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
echo Html::Button('Benutzer erstellen', ['class' => 'btn btn-success','id' => 'btn-createUser']);


ActiveForm::end();
echo Html::Tag('div','',['style' => 'margin-bottom:20px']);
echo Html::Tag('textfield','Artikel erfolgreich erstellt!',['id' => 'SuccessText','style' => 'display:none']);
echo Html::endTag('div', ['style' => 'margin-bottom:50px']);

