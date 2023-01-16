<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\CommonAction;
use app\components\CustomWebUser;

use app\components\UserController;
use app\models\AdminAction;

class AdminController extends Controller
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
        return $this->render('index');
    }

    public function actionBranch()
	{
        $cwebuser = new CustomWebUser();
        $user_id = Yii::$app->user->getId();
        $ssobranch_code = $cwebuser->getInfo("ssobranch_code");
        $app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['admin'];
        $rows = \app\models\lkup_user::getUserPermission($user_id, $app_id, $ssobranch_code);

        $user_role = $rows[0]['user_role'];

        if (\app\models\lkup_data::chkAddPermission($user_role, $app_id)) {
            return $this->render('branch');
        } else {
            return false;
        }
	}



    public function actionUser_permission()
    {
        $cwebuser = new CustomWebUser();
        $user_id = Yii::$app->user->getId();
        $ssobranch_code = $cwebuser->getInfo("ssobranch_code");
        $app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['admin'];
        $rows = \app\models\lkup_user::getUserPermission($user_id, $app_id, $ssobranch_code);

        $user_role = $rows[0]['user_role'];

        if (\app\models\lkup_data::chkAddPermission($user_role, $app_id)) {
            return $this->render('user_permission');
        } else {
            return false;
        }
    }

    	// Process Action
	public function actionUpdateuserworkstatus()
	{
		if (Yii::$app->request->isPost) {
			$id = $_POST['id'];
			$status = $_POST['status'];
			if (is_null($id) || is_null($status)) {
				exit;
			}

			$model = new AdminAction;
			$model->id = $id;
			$model->status = $status;

			if ($model->Edit_Statusworkuser()) {

                $log_page = basename(Yii::$app->request->referrer);

				$log_description = 'แก้ไขสถานะการล็อกอิน <br/>';
				$log_description .= 'User ID : ' . $_POST['id'] . '<br/>';
				$log_description .= 'จากสถานะ : ' . $_POST['old_status'] . ' <br/>';
				$log_description .= 'เป็น : ' . $status . ' <br/>';

                $cwebuser = new \app\components\CustomWebUser();
				$createby = !Yii::$app->user->isGuest? $cwebuser->getInfo('uid') : 0;
				\app\models\CommonAction::AddEventLog($createby, "Update", $log_page, $log_description);
				echo json_encode(array('msg' => 'success'));
			} else {
				$msg = Yii::app()->session['errmsg_user'];
				echo json_encode(array('msg' => $msg));
				Yii::app()->session->remove('errmsg_user');
			}
		}
	}

    public function actionDatamanagement()
	{
        $cwebuser = new CustomWebUser();
        $user_id = Yii::$app->user->getId();
		$ssobranch_code = $cwebuser->getInfo("ssobranch_code");

		$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['admin'];
        $rows = \app\models\lkup_user::getUserPermission($user_id, $app_id, $ssobranch_code);
		$user_role = $rows[0]['user_role'];

		if (\app\models\lkup_data::chkAddPermission($user_role, $app_id)) {
			return $this->render('datamanagement');
		} else {
			return false;
		}
	}


    public function actionListuser()
    {
        if (Yii::$app->request->isPost) {
            $page = 1;
            if (!empty($_POST['page'])) $page = (int)$_POST['page'];

            $recordsPerPage = 10;
            if (!empty($_POST['length'])) $recordsPerPage = (int)$_POST['length'];

            $start = 0;
            if (!empty($_POST['start'])) $start = (int)$_POST['start'];

            $FSearch = "";
            if (!empty($_POST['FSearch'])) $FSearch = $_POST['FSearch'];

            $noOfRecords = 0;
            
            $model = new AdminAction;
            $model->page = $page;
            $model->recordsPerPage = $recordsPerPage;
            $model->start = $start;
            $model->noOfRecords = $noOfRecords;
            $model->FSearch = $FSearch;
            $model->Listuser();
            /* header("Content-type: application/json; charset=UTF-8");
			echo CJSON::encode($model->Listuser());
			Yii::app()->end(); */
        }
    }

	public function actionUpdateuserapppermission()
	{
		if (Yii::$app->request->isPost) {
			$user_id = $_POST['user_id'];
			$app_id = $_POST['app_id'];
			$user_role = $_POST['user_role'];
			$ssobranch_code = $_POST['ssobranch_code'];

			if (is_null($user_id) || is_null($app_id) || is_null($user_role) || is_null($ssobranch_code)) {
				exit;
			}

			$model = new AdminAction;

			$model->user_id = $user_id;
			$model->app_id = $app_id;
			$model->user_role = $user_role;
			$model->ssobranch_code = $ssobranch_code;

			if ($model->Edit_UserAppPermission()) {
				$log_page = basename(Yii::$app->request->referrer);

				$log_description = 'แก้ไข Permission ผู้ใช้งานระบบของ ' . $user_id . '  หน่วยงาน ' . $ssobranch_code . ' <br/>';
				$log_description .= 'รหัสแอฟ ' . $app_id . '<br/>';

				$log_description .= 'จากสิทธิ์ : ' . $_POST['current_role'] . ' เป็นสิทธิ์ ' . $user_role . ' <br/>';

				$cwebuser = new \app\components\CustomWebUser();
				$createby = !Yii::$app->user->isGuest? $cwebuser->getInfo('uid') : 0;
				\app\models\CommonAction::AddEventLog($createby, "Update", $log_page, $log_description);

				echo json_encode(array('msg' => 'success'));
			} else {
				$msg = Yii::$app->session['errmsg_permission'];
				echo json_encode(array('msg' => $msg));
				Yii::$app->session->remove('errmsg_permission');
			}
		}
	}

    public function actionListbranch()
	{
		$page = 1;
		if (!empty($_POST['page'])) $page = (int) $_POST['page'];

		$recordsPerPage = 10;
		if (!empty($_POST['length'])) $recordsPerPage = (int) $_POST['length'];

		$start = 0;
		if (!empty($_POST['start'])) $start = (int) $_POST['start'];

		$search = '';
		if (!empty($_POST['search'])) $search = $_POST['search'];

		$type_id = null;
		if (!empty($_POST['type_id'])) $type_id = $_POST['type_id'];

		$noOfRecords = 0;

		$model = new AdminAction;
		$model->search = $search;
		$model->page = $page;
		$model->recordsPerPage = $recordsPerPage;
		$model->start = $start;
		$model->noOfRecords = $noOfRecords;
		$model->type_id = $type_id;

        $refer = Yii::$app->request->referrer;
		if (strpos($refer, 'admin') !== false) {
			$model->pAdmin = true;
		} else {
			$model->pAdmin = false;
		}
		$model->Listbranch();
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
