<?php
/**
 * @author Alexander Weinbeck
 */
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = 'Benutzerprofil';


echo Html::tag('h1',Html::encode($this->title));


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
//echo var_dump($model);
echo $form->field($model, 'name')->textInput(['readonly'=>true,'value' => ArrayHelper::getValue($model,'name','N/A'), 'type' => 'text', 'style' => 'border:0;'])->label(translateField('name'));
echo $form->field($model, 'userID')->textInput(['readonly'=>true,'value' => ArrayHelper::getValue($model,'userID','N/A'),'type' => 'text', 'style' => 'border:0;'])->label(translateField('userID'));
echo $form->field($model, 'isUserAdmin')->textInput(['readonly' => true, 'value' => translateFieldPermission($model,'isUserAdmin','N/A'), 'type' => 'text', 'style' => 'border:0;'])->label(translateField('isUserAdmin'));
echo $form->field($model, 'mail')->textInput(['readonly'=>true,'value' => $model->mail,'type' => 'text', 'style' => 'border:0;'])->label('E-Mail: ');
echo $form->field($model, 'department')->textInput(['readonly'=>true,'value' => $model->department,'type' => 'text', 'style' => 'border:0;'])->label('Abteilung: ');
echo $form->field($model, 'company')->textInput(['readonly'=>true,'value' => $model->company,'type' => 'text', 'style' => 'border:0;'])->label('Firma: ');

/**
 * @author Alexander Weinbeck
 */
function translateFieldPermission($paramAdmin){
    if ($paramAdmin === 1): return 'Administrator'; else: return 'Benutzer'; endif;
}
/**
 * @author Alexander Weinbeck
 */
function translateField($paramString){
    $stringArray = [
        'userID' => 'BenutzerID: ',
        'name' => 'Name: ',
        'mail' => 'E-Mail Adresse: ',
        'isUserAdmin' => 'Berechtigungstyp: ',
    ];
    return $stringArray[$paramString];
}
ActiveForm::end();
echo Html::endTag('div');
?>