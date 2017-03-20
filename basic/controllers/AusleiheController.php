<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\QueryRqst;
use app\models\ldap;
use app\models\Ausleihe;
use yii\helpers\Url;

class AusleiheController extends Controller
{
    /**
     * @author Alexander Weinbeck
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
     * @author Alexander Weinbeck
     */
    public function actionAusleihliste()
    {
        return $this->render('ausleihliste');
    }
    /**
     * @author Alexander Weinbeck
     */
    public function actionNeueAusleihe()
    {
        $model = new Ausleihe();
        if(Yii::$app->request->headers->get('_rqstAjaxFnc') === 'create' && Yii::$app->request->post() && yii::$app->request->isAjax){
            $model->load(Yii::$app->request->post());
            $model->validate();
            //if(!$model->validate()){                                                                                    //TODO Must be updated ASAP after DB corrections
                (new QueryRqst())->createDataArtikel($model); 
                Yii::$app->session->setFlash('RentalDataCreated', 'Sie haben die Ausleihe erfolgreich erstellt.');
            //}
            $this->refresh(Url::current());
        }
        else{
            return $this->render('neueAusleihe', ['model' => $model]);
        }
    }
    /**
     * @author Alexander Weinbeck
     */
    public function actionReturn()
    {
        $this->redirect(Url::toRoute('artikel/ausleihliste'));
    }
    /**
     * @author Alexander Weinbeck
     */
    public function actionAusleihe()
    {
        $model = new Ausleihe();
        $model->attributes = (new QueryRqst())->getDataAusleihe(Yii::$app->request->get('_rqstIDfhnwNumber'));
        //TODO: If running on server comment following line: so the actual user gets requested
        $model->loanPersonMail = 'alexander.weinbeck@students.fhnw.ch';
        $model->attributes = (new ldap())->getDataLoan($model->loanPersonMail);

        return $this->render('ausleihe', ['model' => $model]);
    }
    /**
     * @author Alexander Weinbeck
     */
    public function actionAusleihebearbeiten()
    {     
        $model = new Ausleihe();
        if(Yii::$app->request->get('_rqstIDfhnwNumber') && !Yii::$app->request->post() && !Yii::$app->request->isAjax)
        {
            $model->attributes = (new QueryRqst())->getDataAusleihe(Yii::$app->request->get('_rqstIDfhnwNumber'));                           //schreibt in das Model vom typ Artikel die Daten des Datensatzes mit der einmaligen fhnwNummer und versucht vom ersten model des "SQLDataproviders" die Attribute zu übernehmen.
            //if(!$model->validate()){
                $model->validate();
                return $this->render('artikelbearbeiten', ['model' => $model]);
            //} 
            //else{                                                                                                                         //TODO: ERRORHANDLING
            //}
        }
        if(Yii::$app->request->headers->get('_rqstAjaxFnc') === 'update' && Yii::$app->request->post() && yii::$app->request->isAjax){
            $model->load(Yii::$app->request->post());
            $model->validate();
            //if(!$model->validate()){                                                                                                      //TODO: Must be updated ASAP after DB corrections
                (new QueryRqst())->setDataArtikel($model); 
                Yii::$app->session->setFlash('articleDataUpdated','Sie haben erfolgreich den Artikel gespeichert!');
                $this->refresh(Url::current()); 
             //  }
                //else{                                                                                                                     //TODO: ERRORHANDLING
            //}
        }
        if(Yii::$app->request->headers->get('_rqstAjaxFnc') === 'delete' && Yii::$app->request->post() && yii::$app->request->isAjax){
            $model->load(Yii::$app->request->post());
            $model->validate();
            //if(!$model->validate()){                                                                                                      //TODO: Must be updated ASAP after DB corrections
                (new QueryRqst())->deleteDataArtikel($model); 
                Yii::$app->session->setFlash('articleDataDeleted','Sie haben erfolgreich den Artikel gelöscht!');
                $this->refresh(Url::current()); 
             //  } 
                //else{                                                                                                                     //TODO: ERRORHANDLING
            //}
        }   
    }
}
