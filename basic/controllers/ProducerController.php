<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Producer;
use app\models\QueryRqst;
use yii\helpers\Url;

class ProducerController extends Controller
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
    public function actionProducerlist()
    {
        return $this->render('producerlist');
    } 
    
    public function actionNewproducer()
    {
        try {
            $model = new Producer();
            if (Yii::$app->request->headers->get('_rqstAjaxFnc') === 'create' && Yii::$app->request->post() && yii::$app->request->isAjax) {
                $model->setAttributes(Yii::$app->request->getBodyParams('Producer'),false);
                $model->validate();
                //if(!$model->validate()){                                                                                    //TODO Must be updated ASAP after DB corrections
                (new QueryRqst())->createDataArticle($model);
                Yii::$app->session->setFlash('producerDataUpdated', 'Sie haben den Hersteller erfolgreich hinzugefügt.');
                //}
                return Yii::$app->response->redirect(Url::to(['producer/producerlist']));
            }
            else{
                return $this->render('newproducer', ['model' => $model]);
            }
        }
        catch(\yii\db\Exception $exDb) {
            $model->addError("ConnectionDB", "Datenbank meldet: " . $exDb->getMessage());
            return $this->render('//site/dberror', ['model' => $model]);
        }
    }
    public function actionReturn()
    {
        $this->redirect(Url::toRoute('producer/producerlist'));
    }  
    public function actionProducer()
    {
        try {
            $model = new Producer();
            if (Yii::$app->request->get('_rqstIDarticleProducerID') && Yii::$app->request->isGet) {
                $model->setAttributes((new QueryRqst())->getDataProducerDetails(Yii::$app->request->get('_rqstIDarticleProducerID')), false);
                $model->validate();
                return $this->render('producer', ['model' => $model]);
            }
        }
        catch(\yii\db\Exception $exDb) {
            $model->addError("ConnectionDB", "Datenbank meldet: " . $exDb->getMessage());
            return $this->render('//site/dberror', ['model' => $model]);
        }
    }
    public function actionProduceredit()
    {
        //try {
            $model = new Producer();

            if (Yii::$app->request->get('_rqstIDarticleProducerID') && Yii::$app->request->isGet && !Yii::$app->request->isPost && !Yii::$app->request->isAjax) {
                $model->setAttributes((new QueryRqst())->getDataProducerDetails(Yii::$app->request->get('_rqstIDarticleProducerID')),false);                           //schreibt in das Model vom typ Artikel die Daten des Datensatzes mit der einmaligen fhnwNummer und versucht vom ersten model des "SQLDataproviders" die Attribute zu übernehmen.
                //if(!$model->validate()){
                    //$model->validate();
                    return $this->render('produceredit', ['model' => $model]);
                //}
                //else{                                                                                                                         //TODO: ERRORHANDLING
                //}
            }
            if (Yii::$app->request->headers->get('_rqstAjaxFnc') === 'update' && Yii::$app->request->isPost && Yii::$app->request->isAjax) {
                $model->setAttributes(Yii::$app->request->getBodyParams('Producer'),false);
                $model->validate();
                //if(!$model->validate()){                                                                                                      //TODO: Must be updated ASAP after DB corrections
                (new QueryRqst())->setDataProducer($model);
                Yii::$app->session->setFlash('producerDataUpdated', 'Sie haben erfolgreich den Hersteller gespeichert!');
                return Yii::$app->response->redirect(Url::to(['producer/producerlist']));
                //  }
                //else{                                                                                                                     //TODO: ERRORHANDLING
                //}
            }
            if (Yii::$app->request->headers->get('_rqstAjaxFnc') === 'delete' && Yii::$app->request->isPost && Yii::$app->request->isAjax) {
                $model->setAttributes(Yii::$app->request->post('Producer'),false);
                //$model->attributes = Yii::$app->request->post();
                //$model->validate();                 //TODO: Must be updated ASAP after DB corrections
                //if(!$model->validate()){                                                                                                      //TODO: Must be updated ASAP after DB corrections
                (new QueryRqst())->deleteDataProducer($model);
                Yii::$app->session->setFlash('producerDataUpdated', 'Sie haben erfolgreich den Hersteller gelöscht!');
                return Yii::$app->response->redirect(Url::to(['producer/producerlist']));
                //  }
                //else{                                                                                                                     //TODO: ERRORHANDLING
                //}
            }
       // }
        /*
        catch(AdldapException $exLdap) {
            $model->addError("ConnectionAD", "Active Directory meldet: " . $exLdap->getMessage());
            Yii::$app->session->setFlash('producerError', "ERROR -> Active Directory meldet: " . $exLdap->getMessage());
            $this->refresh();
        }
        catch(\yii\db\Exception $exDb) {
            $model->addError("ConnectionDB", "Datenbank meldet: " . $exDb->getMessage());
            return $this->render('@app/views/site/dberror', ['model' => $model]);
        }*/
    }
}
