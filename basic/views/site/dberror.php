<?php
/**
 * Database error view
 * @author Alexander Weinbeck
 * @var $this yii\web\View
 */

use yii\helpers\Html;

$this->title = 'Datenbankfehler:';

echo Html::tag('h1',Html::encode($this->title));

foreach ($model->getErrors('ConnectionDB') as $error) echo Html::encode($error);

echo Html::tag('h3',Html::encode(__FILE__));

?>