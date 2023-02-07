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

		// echo 'ggggggggg';
		$model = new LoginForm();

		// echo 'jjljllkl';

		$password = $_POST['password'];

		
		if ($model->load(Yii::$app->request->post()) && $model->login( $password )) {

			echo Json::encode(['status' => 'success', 'msg' => '']);
			
			$username = $_POST['username'];
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
 
		} else {


			echo Json::encode(array('status' => 'error', 'msg' => 'ล็อกอินไม่ถูกต้อง',));
	
		}
		exit;
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
