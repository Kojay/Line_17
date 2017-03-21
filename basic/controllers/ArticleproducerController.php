<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Articleproducer;
use app\models\QueryRqst;
use yii\helpers\Url;

class ArticleproducerController extends Controller
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
    public function actionArtikelhersteller()
    {
        return $this->render('artikelhersteller');
    }
    public function actionArtikelliste()
    {
        return $this->render('artikelliste');
    } 
    public function actionNeuerartikel()
    {
        $model = new Artikel();
        try {
            if (Yii::$app->request->headers->get('_rqstAjaxFnc') === 'create' && Yii::$app->request->post() && yii::$app->request->isAjax) {
                $model->load(Yii::$app->request->post());
                $model->validate();
                //if(!$model->validate()){                                                                                    //Must be updated ASAP after DB corrections
                (new QueryRqst())->createDataArtikel($model);
                Yii::$app->session->setFlash('articleDataCreated', 'Sie haben den Artikel erfolgreich erstellt.');
                //}
                $this->refresh(Url::current());
            }
            else {
                $dataProducer = (new QueryRqst())->getDataProducer();
                $dataArticletype = (new QueryRqst())->getDataArticletype();
                return $this->render('neuerartikel', ['model' => $model, 'modelProducers' => $dataProducer, 'modelArticletype' => $dataArticletype]);
            }
        }
        catch(\yii\db\Exception $exDb) {
            $model->addError("ConnectionDB", "Datenbank meldet: " . $exDb->getMessage());
            return $this->render('//site/dberror', ['model' => $model]);
        }
    }
    public function actionReturn()
    {
        $this->redirect(Url::toRoute('articleproducer/articleproducerList'));
    }  
    public function actionArtikel()
    {
        try {
            $model = new Artikel();
            $model->attributes = (new QueryRqst())->getDataArtikel(Yii::$app->request->get('_rqstIDfhnwNumber'));

            return $this->render('artikel', ['model' => $model]);
        }
        catch(\yii\db\Exception $exDb) {
            $model->addError("ConnectionDB", "Datenbank meldet: " . $exDb->getMessage());
            return $this->render('//site/dberror', ['model' => $model]);
        }
    }
    public function actionArtikelbearbeiten()
    {     
        $model = new Artikel();
        try {
            if (Yii::$app->request->get('_rqstIDfhnwNumber') && !Yii::$app->request->post() && !Yii::$app->request->isAjax) {
                $model->attributes = (new QueryRqst())->getDataArtikel(Yii::$app->request->get('_rqstIDfhnwNumber'));                           //schreibt in das Model vom typ Artikel die Daten des Datensatzes mit der einmaligen fhnwNummer und versucht vom ersten model des "SQLDataproviders" die Attribute zu übernehmen.
                //if(!$model->validate()){
                $dataProducer = (new QueryRqst())->getDataProducer();
                $dataArticletype = (new QueryRqst())->getDataArticletype();
                $model->validate();
                return $this->render('artikelbearbeiten', ['model' => $model, 'modelProducers' => $dataProducer, 'modelArticletype' => $dataArticletype]);
                //}
                //else{                                                                                                                         //TODO: ERRORHANDLING
                //}
            }
            if (Yii::$app->request->headers->get('_rqstAjaxFnc') === 'update' && Yii::$app->request->post() && yii::$app->request->isAjax) {
                $model->load(Yii::$app->request->post());
                $model->validate();
                //if(!$model->validate()){                                                                                                      //TODO: Must be updated ASAP after DB corrections
                (new QueryRqst())->setDataArtikel($model);
                Yii::$app->session->setFlash('articleDataUpdated', 'Sie haben erfolgreich den Artikel gespeichert!');
                $this->refresh(Url::current());
                //  }
                //else{                                                                                                                     //TODO: ERRORHANDLING
                //}
            }
            if (Yii::$app->request->headers->get('_rqstAjaxFnc') === 'delete' && Yii::$app->request->post() && yii::$app->request->isAjax) {
                $model->load(Yii::$app->request->post());
                $model->validate();
                //if(!$model->validate()){                                                                                                      //TODO: Must be updated ASAP after DB corrections
                (new QueryRqst())->deleteDataArtikel($model);
                Yii::$app->session->setFlash('articleDataDeleted', 'Sie haben erfolgreich den Artikel gelöscht!');
                $this->refresh(Url::current());
                //  }
                //else{                                                                                                                     //TODO: ERRORHANDLING
                //}
            }
        }
        catch(\yii\db\Exception $exDb) {
            $model->addError("ConnectionDB", "Datenbank meldet: " . $exDb->getMessage());
            return $this->render('//site/dberror', ['model' => $model]);
        }
    }
}
