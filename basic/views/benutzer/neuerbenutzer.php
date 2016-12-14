<?php
\yii\widgets\Pjax::begin();
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\ActiveForm;
use kartik\dialog\Dialog;

$this->title = 'Benutzer erstellen';

echo Breadcrumbs::widget([
    'links' => [
        [
            'label' => 'Benutzer erstellen',
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
                ['label' => 'Benutzer Bearbeiten', 'url' => false],
            ],
            'options' => ['class' =>'nav nav-tabs'],
        ]);

Yii::$app->session->setFlash('benutzerDataCreated', 'Der Benutzer wurde erfolgreich erstellt!');

echo Html::beginTag('div',['style' => 'margin-top:20px']);

    $form = ActiveForm::begin
    ([
        'id' => 'createbenutzer-formActive',
        'action' => 'benutzer/benutzerbearbeiten',
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

   // echo $form->field($model, 'userID')->textInput(['readonly'=>true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('userID'));
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
    $(function(){
       $("#btn-createUser").click(function(e){
        krajeeDialog.confirm("Sind sie sicher, dass sie den Benutzer erstellen wollen?", function (result) {
            if (result) {
                        e.preventDefault();
                        $.ajax({
                                url: urlAjax,
                                type:'post',
                                headers: { '_rqstAjaxFnc': 'create' },
                                data:$('#createbenutzer-formActive').serialize(),
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