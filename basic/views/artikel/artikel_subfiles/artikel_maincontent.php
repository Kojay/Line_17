<?php
    use yii\helpers\Url;
    use yii\helpers\Html;
    use yii\widgets\Menu;
    use yii\widgets\Breadcrumbs;
    use yii\bootstrap\ActiveForm;
/**
 * Article view
 * @author Alexander Weinbeck
 * @var $this yii\web\View
 */
$this->title = 'Artikel Details';

echo Html::tag('h1',Html::encode($this->title));

$form = ActiveForm::begin
([
    'id' => 'article-form',
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

echo $form->field($model, 'articleName')->textInput(['readonly'=>true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('articleName'));
echo $form->field($model, 'articleTypeName')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('articleTypeName'));
echo $form->field($model, 'articleproducerName')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('articleproducerName'));
echo $form->field($model, 'serialNumber')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('serialNumber'));
echo $form->field($model, 'dateBought')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('dateBought'));
echo $form->field($model, 'dateWarranty')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('dateWarranty'));
echo $form->field($model, 'articlePrice')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('articlePrice'));
echo $form->field($model, 'fhnwNumber')->textInput(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('fhnwNumber'));
echo $form->field($model, 'articleDescription')->textArea(['readonly' => true,'type' => 'text', 'style' => 'border:0;'])->label(translateField('articleDescription'));
/**
 * Translate fields from db designators to
 * @author Alexander Weinbeck
 * @param $paramString
 * @return mixed
 */
function translateField($paramString){
    $stringArray = [
        'articleName' => 'Artikelname: ',
        'articleTypeName' => 'Typ: ',
        'articleproducerName' => 'Hersteller: ',
        'serialNumber' => 'Seriennummer: ',
        'dateBought' => 'Kaufdatum: ',
        'dateWarranty' => 'Garantiedatum: ',
        'articlePrice' => 'Artikelpreis: ',
        'fhnwNumber' => 'FHNW Nummer: ',
        'articleDescription' => 'Beschreibung: '
    ];
    return $stringArray[$paramString];
}
ActiveForm::end();
echo Html::endTag('div');
?>