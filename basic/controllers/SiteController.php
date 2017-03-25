<?php

namespace app\controllers;

use Adldap\Exceptions\AdldapException;
use app\models\User;
use app\models\ldap;
use app\models\QueryRqst;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Article;
use yii\helpers\Url;

class SiteController extends Controller
{
    /**
     * @author Alexander Weinbeck
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','profile','login'],
                'rules' => [
                    //Definition what users and guests and even RBAC role users can do and what not in case of Sitecontroller Actions
                    [
                        'actions' => ['logout','profile'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?'],
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
     * Displays homepage, which in our case is the "Gastsuche"
     * @author Alexander Weinbeck
     * @return string
     */
    public function actionIndex()
    {
        return $this->redirect(Url::toRoute('site/guestsearch'));
    }

    /**
     * Login action. Which also creates a superuser if not commented!
     * @author Alexander Weinbeck
     * @return string
     */
    public function actionLogin()
    {
        //Creates superuser be careful with this!
        //(new QueryRqst())->setSuperuser();
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //return $this->render('gastsuche');
            return $this->redirect(Url::toRoute('site/guestsearch'));
        }
        return $this->render('login', ['model' => $model]);
    }

    /**
     * Logout action.
     * @author Alexander Weinbeck
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->render('guestsearch');
    }
    /**
     * Displays contact page.
     * @author default template
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', ['model' => $model]);
    }
    /**
     * Displays about page.
     * @author Alexander Weinbeck
     * @return string
     */
    public function actionStatistik()
    {
        return $this->render('statistik');
    }
    /**
     * @author Alexander Weinbeck
     */
    public function actionGuestsearch()
    {
        return $this->render('guestsearch');
    }
    /**
     * @author Alexander Weinbeck
     */
    public function actionReturn()
    {
        $this->redirect(Url::toRoute('article/articlelist'));
    }
    /**
     * @author Alexander Weinbeck
     */
    public function actionSearch()
    {
        $columnSetting = [
            "articleName" => true,
            "fhnwNumber" => true,
            "serialNumber" => true,
            "articlePrice" => true,
            "dateBought" => true,
            "dateWarranty" => true,
            "articleDescription" => true,
            "articleProducerName" => true,
            "articleTypeName" => true,
            "loanLocation" => true,
            "loanLendingDate" => true,
        ];

	    $model = new Article();
        
	    if ($model->load(Yii::$app->request->post())) {
            return $this->goBack();
        }	
        return $this->render('search',['model' => $model]);
    }
    /**
     * @author Alexander Weinbeck
     */
    public function actionProfile()
    {
        try {
            $model = new User();
            //TODO: Needs to be implemented when there's a dedicated usertable for AFC
            //$model->userID = ;
            //$model->isUserAdmin = yii::$app->user->identity->isUserAdmin;
            //$model->email = yii::$app->user->identity->email;
            //TODO: Testserver implementation
            //Change EMail if Servermigration is done

            //$model->attributes = (new QueryRqst())->getDataUserID(yii::$app->user->identity->userID);
            $userIdentity = yii::$app->user->identity;
            if(!yii::$app->user->can('all')) {
                $model->setAttributes((new ldap())->getDataADUser($userIdentity->mail, $userIdentity->userID), false);
            }
            else {
                $model->mail = "supervisor@hwa.fhnw.ch";
                $model->department = "Keine";
                $model->company = "Keine";
                $model->name = "Supervisor";
                $model->userID = yii::$app->user->getId();
                $model->isUserAdmin = "Supervisor";
            }
            return $this->render('profile', ['model' => $model]);
        }
        catch(\yii\db\Exception $exDb) {
            $model->addError("ConnectionDB", "Datenbank meldet: " . $exDb->getMessage());
            return $this->render('//site/dberror', ['model' => $model]);
        }
        catch(AdldapException $exLdap) {
            $model->addError("Connection", "Active Directory meldet: " . $exLdap->getMessage());
            $model->name = "N/A";
            $model->department = "N/A";
            $model->title = "N/A";
            $model->company = "N/A";
            $model->mail = isset(yii::$app->user->identity->email)?yii::$app->user->identity->email:'N/A';
            $model->userID = isset(yii::$app->user->identity->userID)?yii::$app->user->identity->userID:'N/A';
            return $this->render('profile', ['model' => $model]);
        }
    }
}