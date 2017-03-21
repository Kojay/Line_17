<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Producer;
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
        try {
            $model = new Producer();
            if (Yii::$app->request->headers->get('_rqstAjaxFnc') === 'create' && Yii::$app->request->post() && yii::$app->request->isAjax) {
                $model->load(Yii::$app->request->post());
                $model->validate();
                //if(!$model->validate()){                                                                                    //TODO Must be updated ASAP after DB corrections
                (new QueryRqst())->createDataArticle($model);
                Yii::$app->session->setFlash('articleDataCreated', 'Sie haben den Artikel erfolgreich erstellt.');
                //}
                $this->refresh(Url::current());
            }
            else{
                return $this->render('neuerhersteller', ['model' => $model]);
            }
        }
        catch(\yii\db\Exception $exDb) {
            $model->addError("ConnectionDB", "Datenbank meldet: " . $exDb->getMessage());
            return $this->render('//site/dberror', ['model' => $model]);
        }
    }
    public function actionReturn()
    {
        $this->redirect(Url::toRoute('hersteller/herstellerliste'));
    }  
    public function actionHersteller()
    {
        try {
            $model = new Producer();
            $model->attributes = (new QueryRqst())->getDataProducerDetails(Yii::$app->request->get('_rqstarticleProducerID'));
            return $this->render('hersteller', ['model' => $model]);
        }
        catch(\yii\db\Exception $exDb) {
            $model->addError("ConnectionDB", "Datenbank meldet: " . $exDb->getMessage());
            return $this->render('//site/dberror', ['model' => $model]);
        }
    }
    public function actionHerstellerbearbeiten()
    {
        try {
            $model = new Producer();

            if (Yii::$app->request->get('_rqstarticleproducerID') && !Yii::$app->request->post() && !Yii::$app->request->isAjax) {
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
            if (Yii::$app->request->headers->get('_rqstAjaxFnc') === 'update' && Yii::$app->request->post() && yii::$app->request->isAjax) {
                $model->load(Yii::$app->request->post());
                $model->validate();
                //if(!$model->validate()){                                                                                                      //TODO: Must be updated ASAP after DB corrections
                (new QueryRqst())->setDataArticle($model);
                Yii::$app->session->setFlash('herstellerDataUpdated', 'Sie haben erfolgreich den Hersteller gespeichert!');
                $this->refresh(Url::current());
                //  }
                //else{                                                                                                                     //TODO: ERRORHANDLING
                //}
            }
            if (Yii::$app->request->headers->get('_rqstAjaxFnc') === 'delete' && Yii::$app->request->post() && yii::$app->request->isAjax) {
                $model->load(Yii::$app->request->post());
                $model->validate();
                //if(!$model->validate()){                                                                                                      //TODO: Must be updated ASAP after DB corrections
                (new QueryRqst())->deleteDataArticle($model);
                Yii::$app->session->setFlash('articleDataDeleted', 'Sie haben erfolgreich den Artikel gelöscht!');
                $this->refresh(Url::current());
                //  }
                //else{                                                                                                                     //TODO: ERRORHANDLING
                //}
            }
        }
        catch(AdldapException $exLdap) {
            $model->addError("ConnectionAD", "Active Directory meldet: " . $exLdap->getMessage());
            return $this->render('neuerbenutzer', ['model' => $model]);
        }
        catch(\yii\db\Exception $exDb) {
            $model->addError("ConnectionDB", "Datenbank meldet: " . $exDb->getMessage());
            return $this->render('//site/dberror', ['model' => $model]);
        }
    }
}
