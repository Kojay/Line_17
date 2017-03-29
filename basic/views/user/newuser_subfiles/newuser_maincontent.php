<?php
/**
 * New user view
 * @author Alexander Weinbeck
 */
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use kartik\dialog\Dialog;
use kartik\growl\Growl;

//init Krajee
Dialog::widget();

$this->title = 'Benutzer hinzufügen';

echo Html::tag('h1',Html::encode($this->title));
//echo var_dump($adUsers);

echo Html::beginTag('div',['style' => 'margin-top:20px']);

$form = ActiveForm::begin
([
    'id' => 'createuser-formActive',
    'action' => 'user/newuser',
    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' =>
        [
            'template' => '{label}{input}{error}',
            'labelOptions' => ['class' => 'col-md-2'],
            'inputOptions' => ['class' => 'col-md-4'],
            'errorOptions' => ['class' => 'col-md-4'],
        ],
]);

if(Yii::$app->session->hasFlash('userDataCreated')) {
    echo Growl::widget([
        'type' => Growl::TYPE_SUCCESS,
        'title' => 'Erfolg!',
        'icon' => 'glyphicon glyphicon-ok-sign',
        'body' => Yii::$app->session->getFlash('userDataCreated'),
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
echo $form->errorSummary($model);

/*
echo Html::Label('Namen eingeben:',['for' => 'inputsearchNamesAD']);
echo Html::activeInput('text',$model,'name',['id' => 'inputSearchNamesAD','placeholder' => 'Name eingeben...']);
*/
echo $form->field($model, 'mail')
    ->label('Namen eingeben:',['for' => 'inputsearchNamesAD'])
    ->input('',['id' => 'inputSearchNamesAD','placeholder' => 'Name eingeben...']);

//echo '<div class="loaderAD"></div>';

/*
echo $form
    ->field($model, 'mail')
    ->label(translateField('personMail'))
    ->input(['value' => $model->personMail,'placeholder' => 'E-Mail eingeben...']);
*/
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
echo Html::Tag('textfield','Benutzer erfolgreich erstellt!',['id' => 'SuccessText','style' => 'display:none']);
echo Html::endTag('div', ['style' => 'margin-bottom:50px']);


//$this->registerJs("var urlAjax = ".json_encode(Url::toRoute('user/newuser')).";");
//TODO: add after rules have been set
/*if(!$model->hasErrors('ConnectionAD'))*/
//$this->registerJs("var dataADarray = ".json_encode($adUsers).";");

$urlAjax = Json::htmlEncode(Url::toRoute('user/newuser'));
if(!$model->hasErrors('ConnectionAD')){
    $dataAD = Json::htmlEncode($adUsers);
} else {
    $fillerArray = ['yo','jk'];
    $dataAD = Json::htmlEncode($fillerArray);
}

//$urlScript = Json::htmlEncode(html::encode('@web/js/newuser.js'));

$this->registerJs(
    <<<JS
var urlAjax = $urlAjax;
var dataAD = $dataAD;
/**
 * Javascript for page "neuerbenutzer.php"
 * @Author Alexander Weinbeck
 */
$(document).ready(function() {
    /**
     * TODO: Autocomplete element to search Active Directory users
     * @Author Alexander Weinbeck
     */
    $("#inputSearchNamesAD").autocomplete({
        /*
        search: function(event, ui) { 
                $(".loaderAD").show();
        },
        response: function(event, ui) {
                $(".loaderAD").hide();
        },
       
        close: function(event, ui) {
                $(".loaderAD").hide();
        },*/
        source: dataAD,
        //minlength: 3
    });
    $("#inputSearchNamesAD").focus(function() {
    $("#inputSearchNamesAD").autocomplete( "option", "minLength", 3 );
    $("#inputSearchNamesAD").autocomplete( "option", "delay", 1000 );
    });
    /**
     * Function to handle onclick event to create "Benutzer"
     * @Author Alexander Weinbeck
     */
    $("#btn-createUser").click(function(e){
        krajeeDialog.confirm("Sind sie sicher, dass sie den Benutzer erstellen wollen?", function (result) {
            if (result) {
                e.preventDefault();
                $.ajax({
                    url: urlAjax,
                    type:'post',
                    headers: { '_rqstAjaxFnc': 'create' },
                    data:$('#createuser-formActive').serialize(),
                    success:function(){
                        //execute changes if needed ...

                        $('#SuccessText').delay(500).fadeIn("normal", function() {
                            $(this).delay(2500).fadeOut("normal");
                        });

                    }
                });

            }
        });
    });
});
JS
);
?>
