<?php
/**
 * New loan view
 * @author Alexander Weinbeck
 * @var $this yii\web\View
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\ActiveForm;
use kartik\dialog\Dialog;


//init Krajee
Dialog::widget();


$this->title = 'Ausleihe erstellen';

echo Html::tag('h1',Html::encode($this->title));

    if(Yii::$app->session->hasFlash('RentalDataCreated')){
        echo Html::beginTag('div');
        echo Alert::widget([
            'options' => ['class' => 'alert-info'],
            'body' => Yii::$app->session->getFlash('RentalDataCreated'),
        ]);
        echo Html::endTag('div');
    }
echo Html::beginTag('div',['style' => 'margin-top:20px']);

$form = ActiveForm::begin
([
    'id' => 'createRental-formActive',
    'action' => 'loan/newloan',
    'options' => ['class' => 'articleupdate-style'],
    'fieldConfig' =>
        [
            'template' => '{label}{input}{error}',
            'labelOptions' => ['class' => 'col-md-2'],
            'inputOptions' => ['class' => 'col-md-4'],
            'errorOptions' => ['class' => 'col-md-4'],
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
echo Html::Button('Ausleihe erstellen', ['class' => 'btn btn-success','id' => 'btn-create']);

echo Html::endTag('div');


$this->registerJs("var urlAjax = ".json_encode(url::current()).";");
$this->registerJs(<<<JS
/**
 * Javascript for page "neueausleihe.php"
 * @Author Alexander Weinbeck
 */
$(document).ready(function() {
    /**
     * Function to handle onclick event of create "Ausleihe"
     * @Author Alexander Weinbeck
     */
    $("#btn-create").click(function(e){
        krajeeDialog.confirm("Sind sie sicher, dass sie die Ausleihe erstellen wollen?",
        function (result) {
            if (result) {
                e.preventDefault();
                $.ajax({
                    url: urlAjax,
                    type:'post',
                    headers: { '_rqstAjaxFnc': 'create' },
                    data:$('#createRental-formActive').serialize(),
                    success:function(){
                        //execute changes if needed ...
                    }
                });
            }
        });
    });
});
JS
);
?>