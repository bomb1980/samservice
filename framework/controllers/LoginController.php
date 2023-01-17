<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Json;

use app\models\LoginForm;
use app\models\CommonAction;

class LoginController extends Controller
{


	public function actionIndex()
	{
		//echo "punt";exit;
		/* 		$idplib = new idplib();
		$idplib->getIdpinfo();
		$idplib->setStateuser(); */

		//$this->render('index' );
	
		if (!Yii::$app->user->isGuest) {
			return $this->goHome();
		}

		return $this->renderPartial('index');
	}
	public function actionAuth()
	{
		//echo Yii::$app->request->isAjax;
		//exit;
		//echo Yii::$app->getSecurity()->validatePassword('48630711', '$2y$13$O2QRcmrlnZBMtNYizasBOuY.b.iFWJoZrl0i5vZmBBlSxhJqc/hzu');exit;

		$model = new LoginForm(); //var_dump($model->login());exit;
		if ($model->load(Yii::$app->request->post()) && $model->login()) {

			$cwebuser = new \app\components\CustomWebUser();
	
			$ssobranch_code = $cwebuser->getInfo("ssobranch_code");
			$displayname = $cwebuser->getInfo("displayname"); 
			$uid = !Yii::$app->user->isGuest? $cwebuser->getInfo('uid') : 0; 

			$common = new CommonAction; 
			$common->uid = $uid;
			$common->displayname = $displayname;
			$common->ssobranch_code = $ssobranch_code;
			$rows = $common->Check_mas_user();

			$common->AddLoginSession();
			$common->AddLoginLog("Login", "ok");

			echo Json::encode(array('status' => 'success', 'msg' => '',));
		} else {
			//var_dump($model->getErrors());
			$errors = $model->getErrors();	
			
			if (empty($errors)) {
				return;
			}
			$message = '';
			foreach ($errors as $name => $error) {
				if (!is_array($error)) {
					continue;
				}
				$message .= $name . ': ';
				foreach ($error as $e) {
					$message .= $e . '; ';
				}
			}
			//echo $message;
			$common = new CommonAction;
			$common->AddLoginLog("Login", "error:" . $message);

			Yii::$app->session->remove('errmsg_login');

			echo Json::encode(array('status' => 'error', 'msg' => $message,));
			return;
		}

		$username = $_POST['username'];
		$password = $_POST['password'];
		$remember_me = $_POST['chk_remember'];
		$encryption_key = Yii::$app->params['auth']['crypter']['encryption_key'];
		$method = Yii::$app->params['auth']['crypter']['method'];
		$crypter = new \app\components\Crypter($encryption_key, $method);
		$ePassword = $crypter->encrypt($password);

		if ($remember_me === 'true') {

			setcookie("UserName", $username, time() + (86400 * 30), "/"); // 86400 = 1 day = 1 month

			setcookie("Password", $ePassword, time() + (86400 * 30), "/");
			setcookie("checked", "checked", time() + (86400 * 30), "/");
		} else {
			// set the expiration date to one hour ago
			setcookie("UserName", "", time() - 3600, "/");
			setcookie("Password", "", time() - 3600, "/");
			setcookie("checked", "", time() - 3600, "/");
		}

		/*

		if (Yii::$app->request->isPostRequest) {
			$username = $_POST['username'];
			$password = $_POST['password'];

			$remember_me = $_POST['chk_remember'];

			$encryption_key = Yii::$app->params['auth']['crypter']['encryption_key'];
			$method = Yii::$app->params['auth']['crypter']['method'];
			$crypter = new Crypter($encryption_key, $method);
			$ePassword = $crypter->encrypt($password);

			$model = new frm_login;
			$model->username = $username;
			$model->password = $ePassword;
			if ($model->login()) {

				CommonAction::AddLoginSession();
				CommonAction::AddLoginLog("Login", "ok");
				echo CJSON::encode(array('status' => 'success', 'msg' => '',));
			} else {
				CommonAction::AddLoginLog("Login", "error:" . Yii::$app->session['errmsg_login']);
				echo CJSON::encode(array('status' => 'error', 'msg' => Yii::$app->session['errmsg_login'],));
				Yii::$app->session->remove('errmsg_login');
				exit;
			}

			if ($remember_me === 'true') {

				setcookie("UserName", $username, time() + (86400 * 30), "/"); // 86400 = 1 day = 1 month

				setcookie("Password", $ePassword, time() + (86400 * 30), "/");
				setcookie("checked", "checked", time() + (86400 * 30), "/");
			} else {
				// set the expiration date to one hour ago
				setcookie("UserName", "", time() - 3600, "/");
				setcookie("Password", "", time() - 3600, "/");
				setcookie("checked", "", time() - 3600, "/");
			}
		}
		*/
	}

	public function actionError()
	{
		if ($error = Yii::$app->errorHandler->error) {
			if (Yii::$app->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
}
