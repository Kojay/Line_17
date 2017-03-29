<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\ActiveForm;

$this->title = 'Benutzer Details';


echo Html::tag('h1',Html::encode($this->title));

if(Yii::$app->session->hasFlash('userDataUpdated')) {
    echo Growl::widget([
        'type' => Growl::TYPE_SUCCESS,
        'title' => 'Erfolg!',
        'icon' => 'glyphicon glyphicon-ok-sign',
        'body' => Yii::$app->session->getFlash('userDataUpdated'),
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
//TODO insert placeholders
echo $form->field($model, 'userID')->textInput(['readonly'=>true,'type' => 'text', 'style' => 'border:0;'])->label('ID: ');
echo $form->field($model, 'displayname')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label('Name: ');
echo $form->field($model, 'department')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label('Abteilung: ');
echo $form->field($model, 'company')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label('Firma: ');
echo $form->field($model, 'mail')->textInput(['readonly' => true, 'value' => $model->mail,'type' => 'text', 'style' => 'border:0;'])->label('Email: ');
echo $form->field($model, 'isUserAdmin')->textInput(['readonly' => true, 'value' => translateFieldPermission($model->isUserAdmin), 'type' => 'text', 'style' => 'border:0;'])->label('Benutzerberechtigung:');



ActiveForm::end();
echo Html::endTag('div');


/**
 * Translates db column name to german readable word
 * @author Alexander Weinbeck
 * @param $paramString
 * @return mixed
 */
function translateFieldPermission($paramAdmin){
    if ($paramAdmin): return 'Administrator'; else: return 'Benutzer'; endif;
}