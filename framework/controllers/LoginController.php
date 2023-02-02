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
		$model = new LoginForm();
		
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			
			echo Json::encode(['status' => 'success', 'msg' => '']);
			
			// exit;
			$username = $_POST['username'];
			$password = $_POST['password'];
			$remember_me = $_POST['chk_remember'];
			$encryption_key = Yii::$app->params['auth']['crypter']['encryption_key'];
			$method = Yii::$app->params['auth']['crypter']['method'];
			$crypter = new \app\components\Crypter($encryption_key, $method);
			$ePassword = $crypter->encrypt($password);

			if ($remember_me === 'true') {

				setcookie("UserName", $username, time() + (86400 * 30), "/");
				setcookie("Password", $ePassword, time() + (86400 * 30), "/");
				setcookie("checked", "checked", time() + (86400 * 30), "/");
			} else {

				setcookie("UserName", "", time() - 3600, "/");
				setcookie("Password", "", time() - 3600, "/");
				setcookie("checked", "", time() - 3600, "/");
			}

			exit;

			// $cwebuser = new \app\components\CustomWebUser();

			// $ssobranch_code = $cwebuser->getInfo("ssobranch_code");
			// $displayname = $cwebuser->getInfo("displayname");
			// $uid = !Yii::$app->user->isGuest ? $cwebuser->getInfo('uid') : 0;

			// $common = new CommonAction;
			// $common->uid = $uid;
			// $common->displayname = $displayname;
			// $common->ssobranch_code = $ssobranch_code;
			// $rows = $common->Check_mas_user();

			// $common->AddLoginSession();
			// $common->AddLoginLog("Login", "ok");

			// echo Json::encode(array('status' => 'success', 'msg' => '',));



			// exit;
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
