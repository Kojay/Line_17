<?php

namespace app\controllers;

use Adldap\Exceptions\AdldapException;
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
                        'roles' => ['admin'],
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
            $model->attributes = (new QueryRqst())->getDataUserID(Yii::$app->request->get('_rqstIDUserID'));
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

            if (Yii::$app->request->get('_rqstIDUserID') && !Yii::$app->request->post() && !Yii::$app->request->isAjax) {
                $model->attributes = (new QueryRqst())->getDataUserID(Yii::$app->request->get('_rqstIDUserID'));                    //TODO: ERRORHANDLING EINFÜGEN
                $model->validate();                                                                                                     //TODO: Writes into model the attributes given as array from sqldataprovider->getmodels method
                return $this->render('useredit', ['model' => $model]);
            }
            if (Yii::$app->request->headers->get('_rqstAjaxFnc') === 'update' && Yii::$app->request->post('user') && yii::$app->request->isAjax) {
                $model->load(Yii::$app->request->post());
                $model->validate();
                //if($model->validate()){                                                                                               //TODO: Must be updated ASAP after DB corrections
                (new QueryRqst())->setUpdateDataUser($model, $model->getPasswordHash($model->userPassword));
                yii::$app->session->open();
                yii::$app->session->setFlash('userDataUpdated', 'Sie haben erfolgreich den Benutzer gespeichert.');
                //}
                //Yii::$app()->controller->createUrl(Yii::app()->controller->action->id, yii::$app->request->get());
                $this->refresh(Url::current());
            }
            if (Yii::$app->request->headers->get('_rqstAjaxFnc') === 'delete' && Yii::$app->request->post('user') && yii::$app->request->isAjax) {
                $model->load(Yii::$app->request->post());
                $model->validate();
                //if($model->validate()){                                                                                                   //TODO: Must be updated ASAP after DB corrections
                (new QueryRqst())->deleteDataUser($model);
                yii::$app->session->open();
                yii::$app->session->setFlash('userDataUpdated', 'Sie haben erfolgreich den Benutzer gelöscht.');
                //}
                //Yii::$app()->controller->createUrl(Yii::app()->controller->action->id, yii::$app->request->get());
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
            if (!$adUsers = (new ldap())->getDataADUsers()) throw new Exception(AdldapException);

            if (Yii::$app->request->headers->get('_rqstAjaxFnc') === 'create' && Yii::$app->request->post() && yii::$app->request->isAjax) {
                $model->load(Yii::$app->request->post());
                $model->validate();
                //if(!$model->validate()){                                                                                                  //TODO: Must be updated ASAP after DB corrections -> Rule checking
                (new QueryRqst())->createDataUser($model, Yii::$app->getSecurity()->generatePasswordHash($model->userPassword));        //TODO: Deprecated will be instead with AD
                //add user to RBAC
                (new RBAC())->assign($model);
                yii::$app->session->open();
                yii::$app->session->setFlash('userDataCreated', 'Sie haben den Benutzer erfolgreich erstellt.');
                //}
                $this->refresh(Url::current());
            }
            else {
                return $this->render('newuser', ['model' => $model,'adUsers' => $adUsers]);
            }
        }
        catch(AdldapException $exLdap) {
            $model->addError("ConnectionAD", "Active Directory meldet: " . $exLdap->getMessage());
            return $this->render('newuser', ['model' => $model]);
        }
        catch(\yii\db\Exception $exDb) {
            $model->addError("ConnectionDB", "Datenbank meldet: " . $exDb->getMessage());
            return $this->render('//site/dberror', ['model' => $model]);
        }
    }
}