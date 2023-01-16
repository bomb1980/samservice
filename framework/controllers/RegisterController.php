<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Json;

use app\models\CommonAction;

class RegisterController extends Controller
{

	public function actionIndex()
	{
		return $this->renderPartial('index');
	}
	public function actionGenpass()
	{
		$password = "sukrit6290";
		$ePassword = Yii::$app->getSecurity()->generatePasswordHash($password);
		echo $ePassword;

	}
	public function actionReg()
	{
		if (Yii::$app->request->post()) {

			$fname = $_POST['fname'];

			$username = $_POST['username'];
			$password = $_POST['password'];
			$passwordcheck = $_POST['passwordcheck'];
			$branchcode = $_POST['dep'];

			$lkup_user =new \app\models\lkup_user;
			$rows = $lkup_user->checkuser($username);
			if (count($rows) != 0) {
				//echo CJSON::encode(array('status' => 'error', 'msg' => 'มี Username นี้อยู่ในระบบแล้ว',));
				echo JSON::encode(array('status' => 'error', 'msg' => 'มีผู้ใช้: ' . $username . '\nชื่อ-นามสกุล: ' . $rows[0]['displayname'] . '\nนี้ในระบบแล้ว',));
				exit;
			}
			if ($password != $passwordcheck) {
				echo JSON::encode(array('status' => 'error', 'msg' => 'Password และยืนยัน Password ไม่ตรงกัน',));
				exit;
			}
			if (is_null($branchcode) || $branchcode == 0 || $branchcode == "") {
				echo JSON::encode(array('status' => 'error', 'msg' => 'กรุณาเลือกหน่วยงาน',));
				exit;
			}
			if (is_null($fname) || $fname == "") {
				echo JSON::encode(array('status' => 'error', 'msg' => 'กรุณากรอก ชื่อ-นามสกุล',));
				exit;
			}

			$encryption_key = Yii::$app->params['auth']['crypter']['encryption_key'];
			$method = Yii::$app->params['auth']['crypter']['method'];
			$crypter = new \app\components\Crypter($encryption_key, $method);
			$ePassword = $crypter->encrypt($password);

			$model = new CommonAction;
			$model->uid = $username;
			
			$ePassword = Yii::$app->getSecurity()->generatePasswordHash($password);
			$model->password = $ePassword;
			$model->displayname = $fname;
			$model->ssobranch_code = $branchcode;
			$model->ssomail = null;

			$rows = $model->Check_mas_user();

			if (count($rows) == 0) {
				if ($model->Add_mas_user()) {
					echo Json::encode(array('status' => 'success', 'msg' => '',));
				} else {
					echo Json::encode(array('status' => 'error', 'msg' => Yii::$app->session['errmsg_adduser'],));
					Yii::$app->session->remove('errmsg_adduser');
				}
			} else {
				echo Json::encode(array('status' => 'error', 'msg' => 'มีผู้ใช้: ' . $username . '\nชื่อ-นามสกุล: ' . $rows[0]['displayname'] . '\nนี้ในระบบแล้ว',));
			}

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
