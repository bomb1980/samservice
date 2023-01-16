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

class SiteController extends Controller
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

    public function init()
    {
        parent::init();
        if (Yii::$app->user->isGuest) {
            UserController::chkLogin();
            exit;
        }
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        //return $this->render('index');        
        $this->redirect(Yii::$app->urlManager->createUrl('/dashboard'));
    }

    /**
     * Login action.
     *
     * @return Response|string
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

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
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

    /**
     * Displays contact page.
     *
     * @return Response|string
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
    public function actionAbout()
    {
        return $this->render('about');
    }
}
