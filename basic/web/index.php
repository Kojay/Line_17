<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');

<<<<<<< HEAD
(new yii\web\Application($config))->run();
=======
(new yii\web\Application($config))->run();
>>>>>>> 6c0d9009d6b67985881e31d780380173f3c4596e
