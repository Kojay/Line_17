<?php
\yii\widgets\Pjax::begin();
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\ActiveForm;

$this->title = 'Benutzer Details';

echo Breadcrumbs::widget([
    'links' => [
        [
            'label' => 'Benutzerliste',
            'url' => ['benutzer/benutzerverwaltung'],
            'template' => "<li>{link}</li>\n", // template for this link only
        ],      
        $this->title
    ],
]);

echo Html::tag('h1',Html::encode($this->title));

echo Menu::widget([
    'items' =>
    [
        ['label' => 'Zurück', 'url' => ['benutzer/benutzerverwaltung','_rqstIDUserID' => yii::$app->request->get('_rqstIDUserID')]],
        ['label' => 'Benutzer Bearbeiten','url' => ['benutzer/benutzerbearbeiten','_rqstIDUserID' => yii::$app->request->get('_rqstIDUserID')]],
    ],
    'options' => ['class' =>'nav nav-tabs'],
]);

$form = ActiveForm::begin
([
    'id' => 'article-form',
    'layout' => 'horizontal',
    'fieldConfig' =>
    [
        'template' => "{label}{input}",
        'labelOptions' => ['class' => 'col-md-2'],
        'inputOptions' => ['class' => 'col-md-4'],
    ],
]);

echo Html::beginTag('div',['style' => 'margin-top:20px']);

echo $form->errorSummary($model);

echo $form->field($model, 'userID')->textInput(['readonly'=>true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('userID'));
echo $form->field($model, 'personFirstname')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('personFirstname'));
echo $form->field($model, 'personLastname')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('personLastname'));
echo $form->field($model, 'personMail')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('personMail'));
echo $form->field($model, 'isUserAdmin')->textInput(['readonly' => true, 'value' => translateFieldPermission($model), 'type' => 'text', 'style' => 'border:0;'])->label(translateField('isUserAdmin'));

function translateFieldPermission($paramAdmin){
    if ($paramAdmin === 1): return 'Administrator'; else: return 'Benutzer'; endif;
}
function translateField($paramString){
    $stringArray = [
                         'userID' => 'BenutzerID: ',
                         'personFirstname' => 'Vorname: ',
                         'personLastname' => 'Nachname: ',
                         'personMail' => 'E-Mail Adresse: ',
                         'isUserAdmin' => 'Berechtigungstyp: ',
                    ];
    return $stringArray[$paramString];
}
ActiveForm::end();
\yii\widgets\Pjax::end();
        
