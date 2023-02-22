<?php

namespace app\controllers;

use app\components\CommonFnc;
use app\models\MasUser;
use Yii;
use yii\web\Controller;
// use yii\helpers\Url;

use app\models\PerPersonal1;

class CronempController extends Controller
{

	public function actionPertype()
	{

		if (Yii::$app->user->getId()) {

			 
			echo PerPersonal1::getPertypeApi(Yii::$app->user->getId());

			
			exit;
		}
		else {

			$r = Yii::$app->request->get();
	
			$headers = CommonFnc::getAuthorizationHeader();
	
			if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
	
				$ciphering = $r['ciphering'];
				$encryption_iv = $r['encryption_iv'];
	
				$MasUser = MasUser::find()
					->where(['uid' => CommonFnc::getEncrypter($matches[1], 'decypt', $ciphering, $encryption_iv)])
					->one();
	
				if ($MasUser) {
	
					// arr($MasUser->id );
					echo PerPersonal1::getPertypeApi($MasUser->id);
	
					 
					exit;
				}
			}
		}



		$datas['status'] = 'fail';
		$datas['msg'] = 'ไม่สำเร็จ';

		echo json_encode($datas);

		exit;
	}


	public function actionLevel()
	{

		if (Yii::$app->user->getId()) {

			
			echo PerPersonal1::getlevelApi(Yii::$app->user->getId());

			
			exit;
		}
		else {

			$r = Yii::$app->request->get();
	
			$headers = CommonFnc::getAuthorizationHeader();
	
			if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
	
				$ciphering = $r['ciphering'];
				$encryption_iv = $r['encryption_iv'];
	
				$MasUser = MasUser::find()
					->where(['uid' => CommonFnc::getEncrypter($matches[1], 'decypt', $ciphering, $encryption_iv)])
					->one();
	
				if ($MasUser) {
	
					// arr($MasUser->id );
					echo PerPersonal1::getlevelApi($MasUser->id);
	
					exit;
				}
			}
		}



		$datas['status'] = 'fail';
		$datas['msg'] = 'ไม่สำเร็จ';

		echo json_encode($datas);

		exit;
	}

	


	// http://samservice/cronemp/perpersonal/?ciphering=AES-256-CBC&encryption_iv=1234567891011121
	public function actionPerpersonal()
	{

		// echo 'sddfsd';exit;
		// echo PerPersonal1::getFromApi(1);
		// exit;

		if (Yii::$app->user->getId()) {

			
			echo PerPersonal1::getFromApi(Yii::$app->user->getId());
			exit;
			 
		}
		else {


			$r = Yii::$app->request->get();
	
			$headers = CommonFnc::getAuthorizationHeader();
	
			if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
	
				$ciphering = $r['ciphering'];
				$encryption_iv = $r['encryption_iv'];
	
				$MasUser = MasUser::find()
					->where(['uid' => CommonFnc::getEncrypter($matches[1], 'decypt', $ciphering, $encryption_iv)])
					->one();
	
				if ($MasUser) {
	
					// arr($MasUser->id );
					echo PerPersonal1::getFromApi($MasUser->id);
					exit;
				}
			}
	
		}
		
		$datas['status'] = 'fail';
		$datas['msg'] = 'ไม่สำเร็จ';

		echo json_encode($datas);

		exit;
	}

	public function actionLine()
	{

		if (Yii::$app->user->getId()) {

			
			echo PerPersonal1::getlineApi(Yii::$app->user->getId());

			$datas['status'] = 'success';
			$datas['msg'] = 'อัพเดทเรียบร้อย';

			echo json_encode($datas);
			exit;
	
			 
		}
		else{


			$r = Yii::$app->request->get();
	
			$headers = CommonFnc::getAuthorizationHeader();
	
			if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
	
				$ciphering = $r['ciphering'];
				$encryption_iv = $r['encryption_iv'];
	
				$MasUser = MasUser::find()
					->where(['uid' => CommonFnc::getEncrypter($matches[1], 'decypt', $ciphering, $encryption_iv)])
					->one();
	
				if ($MasUser) {
	
					// arr($MasUser->id );
					echo PerPersonal1::getlineApi($MasUser->id);
	
					$datas['status'] = 'success';
					$datas['msg'] = 'อัพเดทเรียบร้อย';
	
					echo json_encode($datas);
					exit;
				}
			}
	
		}
		$datas['status'] = 'fail';
		$datas['msg'] = 'ไม่สำเร็จ';

		echo json_encode($datas);

		exit;


	}

	public function actionPosition()
	{

		if (Yii::$app->user->getId()) {

			
			echo PerPersonal1::getPositionApi(Yii::$app->user->getId());

			 
			exit;
		}
		else{


			$r = Yii::$app->request->get();
	
			$headers = CommonFnc::getAuthorizationHeader();
	
			if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
	
				$ciphering = $r['ciphering'];
				$encryption_iv = $r['encryption_iv'];
	
				$MasUser = MasUser::find()
					->where(['uid' => CommonFnc::getEncrypter($matches[1], 'decypt', $ciphering, $encryption_iv)])
					->one();
	
				if ($MasUser) {
	
					// arr($MasUser->id );
					echo PerPersonal1::getPositionApi($MasUser->id);
	
					
					exit;
				}
			}
		}




		$datas['status'] = 'fail';
		$datas['msg'] = 'ไม่สำเร็จ';

		echo json_encode($datas);

		exit;
	}

	public function actionOganize()
	{

		if (Yii::$app->user->getId()) {

			
			echo PerPersonal1::getOganizeApi(Yii::$app->user->getId());

		 
			exit;
		}
		else {


			$r = Yii::$app->request->get();
	
			$headers = CommonFnc::getAuthorizationHeader();
	
			if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
	
				$ciphering = $r['ciphering'];
				$encryption_iv = $r['encryption_iv'];
	
				$MasUser = MasUser::find()
					->where(['uid' => CommonFnc::getEncrypter($matches[1], 'decypt', $ciphering, $encryption_iv)])
					->one();
	
				if ($MasUser) {
	
					// arr($MasUser->id );
					echo PerPersonal1::getOganizeApi($MasUser->id);
	
					
					exit;
				}
			}
		}



		$datas['status'] = 'fail';
		$datas['msg'] = 'ไม่สำเร็จ';

		echo json_encode($datas);

		exit;
	}

	
	
	 
}
