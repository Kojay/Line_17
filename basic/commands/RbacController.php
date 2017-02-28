<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // add "usercontrol" permission
        $controlUser = $auth->createPermission('usercontrol');
        $controlUser->description = 'Control Users';
        $auth->add($controlUser);

        // add "author" role and give this role the "usercontrol" permission
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $controlUser);

		
        $auth->assign($admin, 1);

    }
}