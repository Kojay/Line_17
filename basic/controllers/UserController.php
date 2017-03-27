<?php

namespace app\controllers;

use Adldap\Exceptions\AdldapException;
use app\models\ADRqst;
use yii\base\Exception;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\User;
use app\models\QueryRqst;
use yii\helpers\Url;
use app\models\ldap;


class UserController extends Controller
{
    /**
     * @author Alexander Weinbeck
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['usermanagement','useredit','user','newuser'],
                'rules' => [
                    [
                        'actions' => ['usermanagement','useredit','user','newuser'],
                        'allow' => true,
                        'roles' => ['admin','supervisor'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],  
        ];
    }
    /**
     * @author Alexander Weinbeck
     */
    public function actionUsermanagement()
    {
        return $this->render('usermanagement');
    }
    /**
     * @author Alexander Weinbeck
     */
    public function actionUser()
    {
        try {
            $model = new User();
            $model->setAttributes((new QueryRqst())->getDataUserID(Yii::$app->request->get('_rqstIDUserID')), false);
            $model->setAttributes((new ldap())->getDataADUser($model->mail,Yii::$app->request->get('_rqstIDUserID')),false);
            return $this->render('user', ['model' => $model]);
        }
        catch(AdldapException $exLdap) {
            $model->addError("ConnectionAD", "Active Directory meldet: " . $exLdap->getMessage());
            return $this->render('user', ['model' => $model]);
        }
        catch(\yii\db\Exception $exDb) {
            $model->addError("ConnectionDB", "Datenbank meldet: " . $exDb->getMessage());
            return $this->render('//site/dberror', ['model' => $model]);
        }
    }
    /**
     * @author Alexander Weinbeck
     */
    public function actionUseredit()
    {
        try {
            $model = new User();
            if (Yii::$app->request->get('_rqstIDUserID') && !Yii::$app->request->isPost && !Yii::$app->request->isAjax) {
                $model->setAttributes((new QueryRqst())->getDataUserID(Yii::$app->request->get('_rqstIDUserID')),false);                    //TODO: ERRORHANDLING EINFÜGEN
                $model->validate();                                                                                                     //TODO: Writes into model the attributes given as array from sqldataprovider->getmodels method
                return $this->render('useredit', ['model' => $model]);
            }
            if (Yii::$app->request->headers->get('_rqstAjaxFnc') === 'update' && Yii::$app->request->isPost && yii::$app->request->isAjax) {
                $model->load(Yii::$app->request->getBodyParams('User'));
                $model->validate();
                //if($model->validate()){                                                                                               //TODO: Must be updated ASAP after DB corrections
                    (new QueryRqst())->setUpdateDataUser($model);
                    yii::$app->session->open();
                    yii::$app->session->setFlash('userDataUpdated', 'Sie haben erfolgreich den Benutzer gespeichert.');
                //}
                $this->refresh(Url::current());
            }
            if (Yii::$app->request->headers->get('_rqstAjaxFnc') === 'delete' && Yii::$app->request->isPost && yii::$app->request->isAjax) {
                $model->load(Yii::$app->request->getBodyParams('User'));
                $model->validate();
                //if($model->validate()){
                  if(Yii::$app->authManager->revokeAll($model->userID)) {                                                                                                  //TODO: Must be updated ASAP after DB corrections
                      (new QueryRqst())->deleteDataUser($model);
                  }
                    yii::$app->session->open();
                    yii::$app->session->setFlash('userDataUpdated', 'Sie haben erfolgreich den Benutzer gelöscht.');
                //}
                $this->refresh(Url::current());
            }
        }
        catch(AdldapException $exLdap) {
            $model->addError("ConnectionAD", "Active Directory meldet: " . $exLdap->getMessage());
            return $this->render('useredit', ['model' => $model]);
        }
        catch(\yii\db\Exception $exDb) {
            $model->addError("ConnectionDB", "Datenbank meldet: " . $exDb->getMessage());
            return $this->render('//site/dberror', ['model' => $model]);
        }
    }
    /**
     * @author Alexander Weinbeck
     */
    public function actionNewuser()
    {
        try {
            $model = new User();
            $adUsers = (new ADRqst())->getDataADUserMails();

            if (Yii::$app->request->headers->get('_rqstAjaxFnc') === 'create' && Yii::$app->request->isPost && Yii::$app->request->isAjax) {
                $model->load(Yii::$app->request->getBodyParams('User'));
                //if($model->validate()){                                                                                                  //TODO: Must be updated ASAP after DB corrections -> Rule checking
                    (new QueryRqst())->createDataUser($model->mail, $model->isUserAdmin);
                    //add user to RBAC
                if($model->isUserAdmin === 1 && $model->userID) {
                    Yii::$app->authManager->assign(Yii::$app->authManager->getRole('admin'), $model->userID);
                }elseif($model->isUserAdmin === 1 && $model->userID){
                    Yii::$app->authManager->assign(Yii::$app->authManager->getRole('user'), $model->userID);
                }
                    yii::$app->session->open();
                    yii::$app->session->setFlash('userDataCreated', 'Sie haben den Benutzer erfolgreich erstellt.');
                //}

                $this->refresh();
            }
            else {
                return $this->render('//user/newuser', ['model' => $model,'adUsers' => $adUsers]);
            }
        }
        catch(AdldapException $exLdap) {
            $model->addError("ConnectionAD", "Active Directory meldet: " . $exLdap->getMessage());
            return $this->render('//user/newuser', ['model' => $model]);
        }
        catch(\yii\db\Exception $exDb) {
            $model->addError("ConnectionDB", "Datenbank meldet: " . $exDb->getMessage());
            return $this->render('//site/dberror', ['model' => $model]);
        }
    }
}