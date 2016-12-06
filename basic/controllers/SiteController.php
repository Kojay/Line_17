<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\ArtikelForm;
use app\models\QueryForm;
use yii\helpers\Url;
use yii\helpers\Json;

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
        return $this->render('login', [
            'model' => $model,
        ]);
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
        return $this->render('contact', [
            'model' => $model,
        ]);
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
    
    
    public function actionArtikelliste()
    {
        return $this->render('artikelliste');
    }
    
    public function actionBenutzerverwaltung()
    {
        return $this->render('benutzerverwaltung');
    }
    
    public function actionNeuerartikel()
    {
        return $this->render('neuerartikel');
    }
    public function actionReturn()
    {
        $this->redirect(Url::toRoute('site/artikelliste'));
    }
    
    public function actionArtikel()
    {
        $model = new ArtikelForm();
        ?>
        <!--
        <script>
        $("#RefreshList").click(function(){		
		$.ajax({
				type: 'POST',
				url: '@app/site/ajax',					
				dataType: 'json',
                                contentType: "application/json; charset=utf-8",
				success: function(data) {					
			        var list = document.getElementById('DataList');		
					
					$(document.getElementById('DataList')).empty();
						
						for (var i = 0; i < data.length; i++) {
							var entry = document.createElement('li');
                                                        entry.appendChild(document.createTextNode(JSON.stringify(data[i])));
							list.appendChild(entry);
						}												
					}
		});
        });
        </script>
        -->
        <?php
        
       
        $articleID = Yii::$app->request->get('id');
        
        $dataObj = new QueryForm();
        $dataProvider = $dataObj->getDataArtikel($articleID);
        $models = $dataProvider->getModels();
        $model = $models[0];
        
        
        
        return $this->render('artikel', [
            'model' => $model,
        ]);
    }
    public function actionArtikelbearbeiten($model)
    {
        $model = $model[0];
        return $this->render('artikelbearbeiten', [
            'model' => $model,
        ]);
    }
    public function actionAjax()
    {
            echo alert('triggered');
            /*$dataObj = new QueryForm(); 
            $dataProvider = $dataObj->getData();
            
            $dataArray = \yii\helpers\ArrayHelper::toArray($dataProvider);
            //echo json_encode($dataArray);
            
            
            if (Yii::$app->request->isAjax) {
                        $data = Yii::$app->request->post();                       
                        //$log = new History();
                        //$log->name = $filename;
                        //$log->save();
                
                        $response = Yii::$app->response;
                        $response->format = \yii\web\Response::FORMAT_JSON;
                        $response->data = $dataArray;
                        $response->statusCode = 200;
                        
                        return Json::encode($response);
                }
                else throw new \yii\web\BadRequestHttpException;*/
    }       
    
    
}
