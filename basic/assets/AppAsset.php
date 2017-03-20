<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    //public $sourcePath = '@app/assets/app';


    public $css = [
        'css/site.css',
		//Themes
		'themes/material-simple/css/materialize.css',
		'themes/material-simple/css/prism.css'
    ];
    public $js = [
        //'js/artikelbearbeiten.js',
        //'http://code.jquery.com/jquery-1.12.4.js'
        //'js/jquery.mobile-1.4.2.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\jui\JuiAsset',
        //'yii\bootstrap\BootstrapAsset'
        'yii\bootstrap\BootstrapPluginAsset'
    ];
}
