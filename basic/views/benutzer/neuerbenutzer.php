<?php
\yii\widgets\Pjax::begin();
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\ActiveForm;
use kartik\dialog\Dialog;

$this->title = 'Artikel erstellen';

echo Breadcrumbs::widget([
    'links' => [
        [
            'label' => 'Artikelliste',
            'url' => ['artikel/artikelliste'],
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
                ['label' => 'Artikel Bearbeiten', 'url' => false],
                ['label' => 'Etikette Drucken', 'url' => false],
                ['label' => 'Ausleihen', 'url' => false],
                
            ],
            'options' => ['class' =>'nav nav-tabs'],
        ]);

Yii::$app->session->setFlash('articleDataCreated', 'Der Artikel wurde erfolgreich erstellt!');

echo Html::beginTag('div',['style' => 'margin-top:20px']);

    $form = ActiveForm::begin
    ([
        'id' => 'artikelspeichern-formActive',
        'action' => 'artikel/artikelbearbeiten',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => 
        [
            'template' => '{label}{input}{error}',
            'labelOptions' => ['class' => 'col-md-2'],
            'inputOptions' => ['class' => 'col-md-4'],
            'errorOptions' => ['class' => 'col-md-4'],
        ],
    ]);
    
    echo $form->field($model, 'userID')->textInput(['value' => $model->userID])->label(translateField('userID'));
    echo $form->field($model, 'personFirstname')->textInput(['value' => $model->personFirstname])->label(translateField('personFirstname'));  
    echo $form->field($model, 'personLastname')->textInput(['value' => $model->personLastname])->label(translateField('personLastname'));  
    echo $form->field($model, 'personMail')->textInput(['value' => $model->personMail])->label(translateField('personMail'));  
    echo $form->field($model, 'userPassword')->textInput(['value' => ''])->label('Neues Passwort:');
    echo $form->field($model, 'userPassword')->textInput(['value' => ''])->label('Passwort bestätigen:');
    echo $form->field($model, 'isUserAdmin')->inline()->radioList(['0' => 'Benutzer','1' => 'Administrator'])->label(translateField('isUserAdmin'));
    
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
    echo Html::Button('Benutzer erstellen', ['class' => 'btn btn-success','id' => 'btn-createUser']);    
    // widget with default options
    echo Dialog::widget();
    ActiveForm::end();  
echo Html::Tag('div','',['style' => 'margin-bottom:20px']);
    echo Html::Tag('textfield','Artikel erfolgreich erstellt!',['id' => 'SuccessText','style' => 'display:none']);
echo Html::endTag('div', ['style' => 'margin-bottom:50px']);

$script = <<< JS
$( document ).ready(function() {
        var form=$("#artikelspeichern-formActive");
    $(function(){
       $("#btn-createUser").click(function(e){
        krajeeDialog.confirm("Sind sie sicher, dass sie den Artikel erstellen wollen?", function (result) {
            if (result) {
                        //$("#artikelspeichern-formActive").submit();
                        e.preventDefault();
                        $.ajax({
                                url: urlAjax,
                                type:'post',
                                data:$('#artikelspeichern-formActive').serialize(),
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
});
JS;
$url = Url::toRoute('benutzer/neuerbenutzer');
$this->registerJs("var urlAjax = ".json_encode($url).";");
$this->registerJs($script);
\yii\widgets\Pjax::end();