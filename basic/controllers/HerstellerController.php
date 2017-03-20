<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Hersteller;
use app\models\QueryRqst;
use yii\helpers\Url;

class HerstellerController extends Controller
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
    /*
    public function actionArtikelhersteller()
    {
        return $this->render('artikelhersteller');
    }
    */
    public function actionHerstellerliste()
    {
        return $this->render('herstellerliste');
    } 
    
    public function actionNeuerartikel()
    {
        $model = new Hersteller();
        if(Yii::$app->request->headers->get('_rqstAjaxFnc') === 'create' && Yii::$app->request->post() && yii::$app->request->isAjax){
            $model->load(Yii::$app->request->post());
            $model->validate();
            //if(!$model->validate()){                                                                                    //Must be updated ASAP after DB corrections
                (new QueryRqst())->createDataArtikel($model); 
                Yii::$app->session->setFlash('articleDataCreated', 'Sie haben den Artikel erfolgreich erstellt.');
            //}
            $this->refresh(Url::current());
        }
        else{
            //$dataProducer = (new QueryRqst())->getDataProducer();
            //$dataArticletype = (new QueryRqst())->getDataArticletype();
            return $this->render('neuerhersteller', ['model' => $model]);

        }
    }
    
    public function actionReturn()
    {
        $this->redirect(Url::toRoute('hersteller/herstellerliste'));
    }  
    public function actionHersteller()
    {
        $producerModel = new Hersteller();                                                                   
        $producerModel->attributes = (new QueryRqst())->getDataProducerDetails(Yii::$app->request->get('_rqstarticleproducerID'));   
        
        return $this->render('hersteller', ['model' => $producerModel]);
    }
    public function actionHerstellerbearbeiten()
    {     
        $model = new Hersteller();
        
        if(Yii::$app->request->get('_rqstarticleproducerID') && !Yii::$app->request->post() && !Yii::$app->request->isAjax)
        {
            $model->attributes = (new QueryRqst())->getDataProducerDetails(Yii::$app->request->get('_rqstarticleproducerID'));                           //schreibt in das Model vom typ Artikel die Daten des Datensatzes mit der einmaligen fhnwNummer und versucht vom ersten model des "SQLDataproviders" die Attribute zu übernehmen.
            //if(!$model->validate()){
            //$dataProducer = (new QueryRqst())->getDataProducer();
            //$dataArticletype = (new QueryRqst())->getDataArticletype();
            $model->validate();
            return $this->render('herstellerbearbeiten', ['model' => $model]);
            //} 
            //else{                                                                                                                         //TODO: ERRORHANDLING
            //}
        }
        if(Yii::$app->request->headers->get('_rqstAjaxFnc') === 'update' && Yii::$app->request->post() && yii::$app->request->isAjax){
            $model->load(Yii::$app->request->post());
            $model->validate();
            //if(!$model->validate()){                                                                                                      //TODO: Must be updated ASAP after DB corrections
                (new QueryRqst())->setDataArtikel($model); 
                Yii::$app->session->setFlash('herstellerDataUpdated','Sie haben erfolgreich den Hersteller gespeichert!');
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
