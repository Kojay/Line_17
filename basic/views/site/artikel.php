<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$this->title = 'Artikel Details';
//$this->params['breadcrumbs'][] = $this->title;


// $this is the view object currently being used
echo Breadcrumbs::widget([
    'links' => [
        [
            'label' => 'Artikelliste',
            'url' => ['site/artikelliste'],
            'template' => "<li>{link}</li>\n", // template for this link only
        ],      
        $this->title
    ],
]);


?>
<div class="site-artikel">
    <h1><?= Html::encode($this->title) ?></h1>
    
</div>