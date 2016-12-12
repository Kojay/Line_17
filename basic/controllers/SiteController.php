<?php

namespace app\controllers;

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
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', ['model' => $model ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
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
//    public function actionNeuerartikel()
//    {
//        $model = new Artikel();
//        if(Yii::$app->request->post('Artikel') && yii::$app->request->isAjax){
//            $model->load(Yii::$app->request->post());
//            $model->validate();
//            //if(!$model->validate()){                                                                                    //Must be updated ASAP after DB corrections
//                (new QueryRqst())->createDataArtikel($model); 
//                Yii::$app->session->setFlash('articleDataCreated', 'You have successfully created the article.');
//            //}
//            return $this->render('neuerartikel', ['model' => $model]); 
//        } 
//        
//        return $this->render('neuerartikel', ['model' => $model]);
//    }
    public function actionReturn()
    {
        $this->redirect(Url::toRoute('artikel/artikelliste'));
    }   
//    public function actionArtikel()
//    {
//        $model = new Artikel();
//        $articleID = Yii::$app->request->get('id');
//        $dataProvider = (new QueryRqst())->getDataArtikel($articleID);
//        $models = $dataProvider->getModels();        
//        $model->attributes = $models[0];
//        
//        yii::$app->session->open();
//        yii::$app->session->set('getArticleID', $articleID);                                                                   //Setzt session für den aktuell ausgewählten Artikel bzw. suche
//        return $this->render('artikel', ['model' => $model]);
//    }
//    public function actionArtikelbearbeiten()
//    {     
//        $model = new Artikel();
//        if(Yii::$app->request->get() && !Yii::$app->request->post('Artikel') && !Yii::$app->request->isAjax){
//            $articleID = Yii::$app->request->get(1);          
//            if($articleID != null){
//                $model->attributes = (new QueryRqst())->getDataArtikel($articleID['fhnwNumber'])->getModels()[0];
//                $model->validate();            //schreibt in das Model vom typ Artikel die Daten des Datensatzes mit der einmaligen fhnwNummer und versucht vom ersten model des "SQLDataproviders" die Attribute zu übernehmen.      
//                return $this->render('artikelbearbeiten', ['model' => $model]);  
//            } 
//            else{
//                throw new \yii\web\HttpException(404, 'Die angeforderte Seite konnte nicht geladen werden, haben Sie versucht über die Adresszeile zu navigieren?');
//            }
//        }
//        if(Yii::$app->request->post('Artikel') && yii::$app->request->isAjax){
//            $model->load(Yii::$app->request->post());
//            $model->validate();
//            //if(!$model->validate()){                                                                                            //Must be updated ASAP after DB corrections
//                (new QueryRqst())->setDataArtikel($model); 
//                Yii::$app->session->setFlash('articleDataUpdated','You have successfully updated the article.');
//                $this->refresh(Url::current()); 
//             //  }
//        }
//        if(Yii::$app->request->headers->get('REQUESTfnc') === 'delete' && Yii::$app->request->post('Artikel') && yii::$app->request->isAjax){
//            $model->load(Yii::$app->request->post());
//            $model->validate();
//            //if(!$model->validate()){                                                                                            //Must be updated ASAP after DB corrections
//                (new QueryRqst())->deleteDataArtikel($model); 
//                Yii::$app->session->setFlash('articleDataDeleted','You have successfully deleted the article.');
//                $this->refresh(Url::current()); 
//             //  }
//        }
//        else{
//                throw new \yii\web\HttpException(404, 'Die angeforderte Seite konnte nicht geladen werden, haben Sie versucht über die Adresszeile zu navigieren?');
//        }
//    }
    public function actionSuche()
    {
	$model = new Artikel();
        
	if ($model->load(Yii::$app->request->post())) {
            return $this->goBack();
        }	
        return $this->render('Suche',['model' => $model]);
    }
}
