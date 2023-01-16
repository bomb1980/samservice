<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\CommonAction;

use app\components\UserController;

class PartialController extends Controller
{
    /**
     * {@inheritdoc}
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
                    'logout' => ['get', 'post'],
                ],
            ],
        ];
    }

    /*
    function init()
    {

        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }

        //Controller1::chkLogin();  //Check Sigle Sing-On Module
        //$this->layout = 'main';
    }
*/


   
    public function actionSync_datapaging()
	{
		if (Yii::$app->request->isPost) {
			return $this->renderPartial('sync_datapaging');
		}
	}
  
    public function actionProcess_sync_datapaging()
	{
		return $this->renderPartial('process_sync_datapaging');
	}


}
