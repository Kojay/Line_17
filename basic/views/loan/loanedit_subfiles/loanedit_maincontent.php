<?php
/**
 * Edit rental view
 * @author Alexander Weinbeck
 * @var $this yii\web\View
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use kartik\dialog\Dialog;
use kartik\checkbox\CheckboxX;

//init Krajee
Dialog::widget();


$this->title = 'Ausleihe bearbeiten';

echo Html::tag('h1',Html::encode($this->title));

if(Yii::$app->session->hasFlash('rentalDataUpdated')){
    echo Html::beginTag('div');
    echo Alert::widget([
        'options' => ['class' => 'alert-info'],
        'body' => Yii::$app->session->getFlash('rentalDataUpdated'),
    ]);
}

$form = ActiveForm::begin
([
    'id' => 'rentalupdate-form',
    'action' => 'loan/loanedit',
    'options' => ['class' => 'articleupdate-style'],
    'fieldConfig' =>
        [
            'template' => '{label}{input}{error}',
            'labelOptions' => ['class' => 'articleupdate-style col-md-2'],
            'inputOptions' => ['class' => 'articleupdate-style col-md-4'],
            'errorOptions' => ['class' => 'articleupdate-style col-md-4'],
        ],
]);

echo $form->field($model, 'loanPersonMail',        [ 'options' => ['class' => 'col-md-12 fieldStyle']])
    ->textInput(['value' => $model->loanPersonMail])->label(translateField('loanPersonMail'));

echo $form->field($model, 'articleName',    [ 'options' => ['class' => 'col-md-12 fieldStyle']])
    ->textInput(['value' => $model['articleName']])->label(translateField('articleTypeName'));

echo $form->field($model, 'lvLoanLendingDate',         [ 'options' => ['class' => 'col-md-12 fieldStyle']])
    ->textInput(['value' => $model['lvLoanLendingDate']])->label(translateField('lvLoanLendingDate'));

echo $form->field($model, 'lvLoanReturnDate',       [ 'options' => ['class' => 'col-md-12 fieldStyle']])
    ->textInput(['value' => $model['lvLoanReturnDate']])->label(translateField('lvLoanReturnDate'));

echo $form->field($model, 'loanAuthorityMail',       [ 'options' => ['class' => 'col-md-12 fieldStyle']])
    ->textInput(['value' => $model['loanAuthorityMail']])->label(translateField('loanAuthorityMail'));

echo $form->field($model, 'loanLocation',         [ 'options' => ['class' => 'col-md-12 fieldStyle']])
    ->textInput(['value' => $model['loanLocation']])->label(translateField('fhnwNumber'));

echo $form->field($model, 'loanDescription', [ 'options' => ['class' => 'col-md-12 fieldStyle']])
    ->textArea(['value' => $model['loanDescription']])->label(translateField('articleDescription'));

ActiveForm::end();
/**
 * Translates db column name to german readable word
 * @author Alexander Weinbeck
 * @param $paramString
 * @return mixed
 */
function translateField($paramString){
    $stringArray = [
        'articleName' => 'Artikelname: ',
        'articleTypeName' => 'Typ: ',
        'loanPersonMail' => 'E-Mail Ausleihende/Ausleihender: ',
        'lvLoanLendingDate' => 'Ausleihdatum: ',
        'lvLoanReturnDate' => 'Rückgabedatum: ',
        'loanAuthorityMail' => 'E-Mail Vorgesetzte/Vorgesetzter: ',
        'loanLocation' => 'Ausleihort: ',
        'loanDescription' => 'Beschreibung: '
    ];
    return $stringArray[$paramString];
}
echo Html::Button('Artikel bearbeiten', ['class' => 'btn btn-success col-md-4 btn-md btn-group','id' => 'btn-updateArticle','style' => 'margin-right:20px; margin-top:20px;']);
echo Html::Button('Artikel löschen', ['class' => 'btn btn-danger col-md-4 btn-md btn-group','id' => 'btn-deleteArticle','style' => 'margin-right:20px; margin-top:20px;']);

echo Html::endTag('div');
$this->registerJs("var urlAjax = ".json_encode(url::current()).";");
$this->registerJs(<<<JS
/**
 * Javascript for page "ausleihebearbeiten.php"
 * @Author Alexander Weinbeck
 */
$(document).ready(function() {
    /**
     * TODO Autocomplete element to search Active Directory users
     * @Author Alexander Weinbeck
     */
    var availableTags = [
        'ActionScript',
        'AppleScript',
        'Java'
    ];
    $("#searchNamesAuto").autocomplete({
        source: availableTags,
    });
    /**
     * Function to handle onclick event of edit "Ausleihe"
     * @Author Alexander Weinbeck
     */
   $("#btn-updateArticle").click(function(e){
        krajeeDialog.confirm("Sind sie sicher, dass Sie die Ausleihe bearbeiten wollen?",
        function (result) {
            $("#fnc").value = 'update';
            if (result) {                     
                e.preventDefault();
                $.ajax({
                    url: urlAjax,
                    type:'post',
                    headers: { '_rqstAjaxFnc': 'update' },
                    data:$('#rentalupdate-form').serialize(),
                    success:function(){
                    }
                });
            }
        });
    });
    /**
     * Function to handle onclick event of delete "Ausleihe"
     * @Author Alexander Weinbeck
     */
    $("#btn-deleteArticle").click(function(e){
        krajeeDialog.confirm("Sind sie sicher, dass Sie die Ausleihe l�schen wollen?",
        function (result) {
            if (result) {
                e.preventDefault();
                $.ajax({
                    url: urlAjax,
                    type:'post',
                    headers: { '_rqstAjaxFnc': 'delete' },
                    data:$('#rentalupdate-form').serialize(),
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