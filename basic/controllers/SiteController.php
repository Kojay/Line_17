<?php

namespace app\controllers;

use app\models\Benutzer;
use app\models\ldap;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Artikel;
use yii\helpers\Url;

class SiteController extends Controller
{
    /**
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
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->redirect(Url::toRoute('site/gastsuche'));
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //return $this->render('gastsuche');
            return $this->redirect(Url::toRoute('site/gastsuche'));
        }
        return $this->render('login', ['model' => $model]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->render('gastsuche');
    }
    /**
     * Displays contact page.
     *
     * @return string
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
     *
     * @return string
     */
    public function actionStatistik()
    {
        return $this->render('statistik');
    }
    public function actionGastsuche()
    {
        return $this->render('gastsuche');
    }
    public function actionReturn()
    {
        $this->redirect(Url::toRoute('artikel/artikelliste'));
    }
    public function actionSuche()
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

	$model = new Artikel();
        
	    if ($model->load(Yii::$app->request->post())) {
            return $this->goBack();
        }	
        return $this->render('Suche',['model' => $model]);
    }
    /**
     * @return boolean
     */
    public function actionProfile()
    {
        $model = new Benutzer();
        $model->userID = yii::$app->user->identity->userID;
        //TODO: Needs to be implemented when there's a dedicated usertable for AFC
        //$model->personMail = yii::$app->user->identity->personMail;
        //$model->personFirstname = yii::$app->user->identity->personFirstname;
        //$model->personLastname = yii::$app->user->identity->personLastname;
        $model->isUserAdmin = yii::$app->user->identity->isUserAdmin;

        return $this->render('profile',['model' => $model]);
    }
}