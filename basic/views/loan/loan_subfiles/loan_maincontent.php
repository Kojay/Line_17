<?php
    use yii\helpers\Url;
    use yii\helpers\Html;
    use yii\widgets\Menu;
    use yii\widgets\Breadcrumbs;
    use yii\bootstrap\ActiveForm;
/**
 * Loan details view
 * @author Alexander Weinbeck
 * @date 18.12.2016
 */

$this->title = 'Ausleihe Details';

echo Html::tag('h1',Html::encode($this->title));

$form = ActiveForm::begin
([
    'id' => 'rental-form',
    'layout' => 'horizontal',
    'fieldConfig' =>
        [
            'template' => "{label}{input}{error}",
            'labelOptions' => ['class' => 'col-md-2'],
            'inputOptions' => ['class' => 'col-md-4'],
        ],
]);

echo Html::beginTag('div',['style' => 'margin-top:20px']);

echo $form->errorSummary($model);


echo $form->field($model, 'personMail')->textInput(['readonly'=>true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('personMail'));
echo $form->field($model, 'articleName')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('articleName'));
echo $form->field($model, 'lvLoanLendingDate')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('lvLoanLendingDate'));
echo $form->field($model, 'lvLoanReturnDate')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('lvLoanReturnDate'));
echo $form->field($model, 'personFirstname')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('personFirstname'));
echo $form->field($model, 'personLastname')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('personLastname'));
echo $form->field($model, 'department')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('department'));
echo $form->field($model, 'fhnwNumber')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('fhnwNumber'));
echo $form->field($model, 'articleTypeName')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('articleTypeName'));
//echo $form->field($model, 'loanInstitute')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('loanInstitute'));
//echo $form->field($model, 'loanGUID')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('loanDescription'));
echo $form->field($model, 'loanLocation')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('loanLocation'));
echo $form->field($model, 'loanDescription')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('loanDescription'));

/**
 * @author Alexander Weinbeck
 * @param $paramString
 * @return mixed
 */
function translateField($paramString){
    $stringArray = [
        'articleName' => 'Artikelname: ',
        'articleTypeName' => 'Typ: ',
        'personMail' => 'E-Mail Ausleihende/Ausleihender: ',
        'lvLoanLendingDate' => 'Ausleihdatum: ',
        'lvLoanReturnDate' => 'Rückgabedatum: ',
        'loanAuthorityMail' => 'E-Mail Vorgesetzte/Vorgesetzter: ',
        'loanLocation' => 'Ausleihort: ',
        'personFirstname' => 'Vorname: ',
        'personLastname' => 'Nachname: ',
        'department' => 'Abteilung: ',
        'fhnwNumber' => 'FHNW Nummer: ',
        'personMail' => 'Mail: ',
        'loanDescription' => 'Beschreibung: '
    ];
    return $stringArray[$paramString];
}
ActiveForm::end();
echo Html::endTag('div');

$script = <<< JS
$( document ).ready(function() { 
   $("#btn-updateArticle").click(function(e){
    krajeeDialog.confirm("Sind sie sicher, dass sie den Artikel bearbeiten wollen?", 
        function (result) {
            $("#fnc").value = 'update';
            if (result) {                     
                e.preventDefault();
                $.ajax({
                    url: urlAjax,
                    type:'post',
                    headers: { 'REQUESTfnc': 'update' },
                    data:$('#articleUpdate-form').serialize(),
                    success:function(){
                    }
                });
            }
        });
    });
    $("#btn-deleteArticle").click(function(e){
    krajeeDialog.confirm("Sind sie sicher, dass sie den Artikel löschen wollen?", 
        function (result) {
            if (result) {
                e.preventDefault();
                $.ajax({
                    url: urlAjax,
                    type:'post',
                    headers: { '_rqstAjaxFnc': 'delete' },
                    data:$('#articleUpdate-form').serialize(),
                    success:function(){
                    }
                });
            }
        });
    });
});
JS;
$this->registerJs("var urlAjax = ".json_encode(url::current()).";");
$this->registerJs($script);
?>