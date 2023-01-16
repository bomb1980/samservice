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

class LogoutController extends Controller
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

    /**
     * {@inheritdoc}
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
     * Logout action.
     *
     * @return Response
     */
    public function actionIndex()
    {
		$model = new CommonAction;
		$local = Yii::$app->params['auth']['local'];

		if ($local) {
			$model->AddLoginLog("Logout", "");
			Yii::$app->user->logout();
			return $this->goHome();
		}

		$idtoken = Yii::$app->user->getState("idtoken");

		Yii::$app->user->setState('visited',null);
		$model->AddLoginLog("Logout", "");
		Yii::$app->user->logout();

		//logout เฉพาะเว็บตัวเอง
		//$this->redirect(Yii::$app->createUrl('')); 
		//$this->renderPartial('index', array("res" => 'ออกจากระบบเรียบร้อย', 'type'=>'logout' ));
		return $this->goHome();
		//exit;

		//logout at portal
		//$this->redirect(Yii::$app->params['prg_ctrl']['url']['portal']);

		//loout on idp		
		if ($idtoken) {
			foreach ($idtoken as  $key => $value) {
				if ($key === 'payload') {
					$idtoken2 = $value[0] . "." . $value[1] . "." . $value[2];
				}
			}

			$urllogout = Yii::$app->params['prg_ctrl']['url']['idplogout'] . $idtoken2 . Yii::$app->params['prg_ctrl']['url']['idplogoutparam'];
			$this->redirect($urllogout);
		} else {
			$this->redirect(Yii::$app->createUrl(''));
		}

        //Yii::$app->user->logout();

        //return $this->goHome();
    }

   

}
