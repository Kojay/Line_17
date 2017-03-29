<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\dialog\Dialog;
use yii\helpers\Url;
use yii\bootstrap\Alert;
use kartik\growl\Growl;


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
echo Html::beginTag('div',['style' => 'margin-top:20px']);
//TODO after db migration uncomment this:
echo $form->field($model, 'userID')->textInput(['readonly' => true,'value' => $model->userID])->label(translateField('userID'));
echo $form->field($model, 'mail')->textInput(['readonly' => true,'value' => $model->mail])->label(translateField('mail'));
echo $form->field($model, 'isUserAdmin')->inline()->radioList(['0' => 'Benutzer','1' => 'Administrator'],['value' => $model->isUserAdmin])->label(translateField('isUserAdmin'));

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
        'name'             => 'Name: ',
        'mail'             => 'E-Mail Adresse: ',
        'isUserAdmin'      => 'Berechtigungstyp: ',
    ];
    return $stringArray[$paramString];
}

ActiveForm::end();
echo Html::endTag('div');

$this->registerJs("var urlAjax = ".json_encode(url::current()).";");

$this->registerJs(<<<JS
/**
 * Javascript for page "benutzerbearbeiten.php"
 * @Author Alexander Weinbeck
 */
$(document).ready(function() {
    /**
     * Function to handle onclick event to edit "Benutzer"
     * @Author Alexander Weinbeck
     */
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
    /**
     * Function to handle onclick event to delete "Benutzer"
     * @Author Alexander Weinbeck
     */
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

JS
);
?>
