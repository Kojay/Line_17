<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\dialog\Dialog;
use yii\helpers\Url;
use yii\bootstrap\Alert;

$this->registerJs("var urlAjax = ".json_encode(url::current()).";");
$this->registerJsFile('@web/js/useredit.js');
//init Krajee
Dialog::widget();

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
//TODO after db migration uncomment this:
//echo $form->field($model, 'name')->textInput(['value' => $model->personLastname])->label(translateField('personLastname'));
//echo $form->field($model, 'mail')->textInput(['value' => $model->personMail])->label(translateField('personMail'));
echo $form->field($model, 'isUserAdmin')->inline()->radioList(['0' => 'Benutzer','1' => 'Administrator'])->label(translateField('isUserAdmin'));

echo Html::Button('Benutzer speichern', ['class' => 'btn btn-success','id' => 'btn-saveUser','style' => 'margin-right:20px']);
echo Html::Button('Benutzer löschen', ['class' => 'btn btn-danger','id' => 'btn-deleteUser']);

/**
 * Translates db column name to german readable word
 * @author Alexander Weinbeck
 * @param $paramString
 * @return mixed
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

ActiveForm::end();
echo Html::endTag('div');
?>
