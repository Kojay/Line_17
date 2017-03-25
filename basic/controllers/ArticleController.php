<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Article;
use app\models\QueryRqst;
use yii\helpers\Url;

class ArticleController extends Controller
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
    public function actionArticleproducer()
    {
        return $this->render('articleproducer');
    }
    /**
     * @author Alexander Weinbeck
     */
    public function actionArticlelist()
    {
        return $this->render('articlelist');
    }
    /**
     * @author Alexander Weinbeck
     */
    public function actionNewarticle()
    {
        try {
            $model = new Article();
            if (Yii::$app->request->headers->get('_rqstAjaxFnc') === 'create' && Yii::$app->request->post() && yii::$app->request->isAjax) {
                $model->load(Yii::$app->request->post());
                $model->validate();
                //if(!$model->validate()){                                                                                    //Must be updated ASAP after DB corrections
                (new QueryRqst())->createDataArticle($model);
                Yii::$app->session->setFlash('articleDataCreated', 'Sie haben den Artikel erfolgreich erstellt.');
                //}
                $this->refresh(Url::current());
            }
            else {
                $dataProducer = (new QueryRqst())->getDataProducer();
                $dataArticletype = (new QueryRqst())->getDataArticletype();
                return $this->render('newarticle', ['model' => $model, 'modelProducers' => $dataProducer, 'modelArticletype' => $dataArticletype]);
            }
        }
        catch(AdldapException $exLdap) {
            $model->addError("ConnectionAD", "Active Directory meldet: " . $exLdap->getMessage());
            return $this->render('newarticle', ['model' => $model]);
        }
        catch(\yii\db\Exception $exDb) {
            $model->addError("ConnectionDB", "Datenbank meldet: " . $exDb->getMessage());
            return $this->render('//site/dberror', ['model' => $model]);
        }
    }
    /**
     * @author Alexander Weinbeck
     */
    public function actionReturn()
    {
        $this->redirect(Url::toRoute('article/articlelist'));
    }
    public function actionArticle()
    {
        try {
            $model = new Article();
            $model->setAttributes((new QueryRqst())->getDataArticle(Yii::$app->request->get('_rqstIDfhnwNumber')),false);

            if (Yii::$app->request->headers->get('_rqstAjaxFnc') === 'repair' && Yii::$app->request->post() && yii::$app->request->isAjax) {
                $model->load(Yii::$app->request->post());
                $model->validate();
                //if(!$model->validate()){                                                                                                      //TODO: Must be updated ASAP after DB corrections
                //TODO Put here query for repair
                Yii::$app->session->setFlash('articleDataRepaired', 'Sie haben erfolgreich den Artikel gespeichert!');
                $this->refresh(Url::current());
                //  }
                //else{                                                                                                                     //TODO: ERRORHANDLING
                //}
            }
            if (Yii::$app->request->headers->get('_rqstAjaxFnc') === 'archive' && Yii::$app->request->post() && yii::$app->request->isAjax) {
                $model->load(Yii::$app->request->post());
                $model->validate();
                //if(!$model->validate()){                                                                                                      //TODO: Must be updated ASAP after DB corrections
                //TODO Put here query for archive
                Yii::$app->session->setFlash('articleDataArchived', 'Sie haben erfolgreich den Artikel gelöscht!');
                $this->refresh(Url::current());
                //  }
                //else{                                                                                                                     //TODO: ERRORHANDLING
                //}
            }
            return $this->render('article', ['model' => $model]);
        }
        catch(\yii\db\Exception $exDb) {
            $model->addError("ConnectionDB", "Datenbank meldet: " . $exDb->getMessage());
            return $this->render('//site/dberror', ['model' => $model]);
        }
    }
    /**
     * @author Alexander Weinbeck
     */
    public function actionArticleedit()
    {
        try {
            $model = new Article();
            if (Yii::$app->request->get('_rqstIDfhnwNumber') && !Yii::$app->request->post() && !Yii::$app->request->isAjax) {
                $model->attributes = (new QueryRqst())->getDataArticle(Yii::$app->request->get('_rqstIDfhnwNumber'));                           //schreibt in das Model vom typ Artikel die Daten des Datensatzes mit der einmaligen fhnwNummer und versucht vom ersten model des "SQLDataproviders" die Attribute zu übernehmen.
                //if(!$model->validate()){
                $dataProducer = (new QueryRqst())->getDataProducer();
                $model->validate();
                return $this->render('articleedit', ['model' => $model, 'modelProducers' => $dataProducer]);
                //}
                //else{                                                                                                                         //TODO: ERRORHANDLING
                //}
            }
            if (Yii::$app->request->headers->get('_rqstAjaxFnc') === 'update' && Yii::$app->request->post() && yii::$app->request->isAjax) {
                $model->load(Yii::$app->request->post());
                $model->validate();
                //if(!$model->validate()){                                                                                                      //TODO: Must be updated ASAP after DB corrections
                (new QueryRqst())->setDataArticle($model);
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
            return $this->render('articleedit', ['model' => $model]);
        }
        catch(\yii\db\Exception $exDb) {
            $model->addError("ConnectionDB", "Datenbank meldet: " . $exDb->getMessage());
            return $this->render('//site/dberror', ['model' => $model]);
        }
    }
}
