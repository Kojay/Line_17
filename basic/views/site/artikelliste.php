<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Artikel';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1 font size="20"><?= Html::encode($this->title) ?></h1>
    <?= Html::a('Neuer Artikel', ['/site/artikel'], ['class'=>'btn btn-primary']) ?>
    <code><?= __FILE__ ?></code>
</div>



