<?php

namespace app\controllers;

use Adldap\Exceptions\AdldapException;
use app\models\Benutzer;
use app\models\ldap;
use app\models\QueryRqst;
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
        return $this->redirect(Url::toRoute('site/gastsuche'));
    }

    /**
     * Login action.
     * @author Alexander Weinbeck
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
     * @author Alexander Weinbeck
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->render('gastsuche');
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
    public function actionGastsuche()
    {
        return $this->render('gastsuche');
    }
    /**
     * @author Alexander Weinbeck
     */
    public function actionReturn()
    {
        $this->redirect(Url::toRoute('artikel/artikelliste'));
    }
    /**
     * @author Alexander Weinbeck
     */
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
     * @author Alexander Weinbeck
     */
    public function actionProfile()
    {
        $model = new Benutzer();
        try {
            //TODO: Needs to be implemented when there's a dedicated usertable for AFC
            $model->userID = yii::$app->user->identity->userID;
            $model->isUserAdmin = yii::$app->user->identity->isUserAdmin;
            $model->personMail = yii::$app->user->identity->personMail;
            //TODO: Testserver implementation
            //Change EMail if Servermigration is done

            $model->attributes = (new QueryRqst())->getDataBenutzerID(yii::$app->user->identity->userID);
            $model->attributes = (new ldap())->getDataBenutzer('alexander.weinbeck@students.fhnw.ch');

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

            return $this->render('profile', ['model' => $model]);
        }
    }
}