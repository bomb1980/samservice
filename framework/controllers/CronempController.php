<?php

namespace app\controllers;

use app\models\MasUser;
use Yii;
use yii\web\Controller;
// use yii\helpers\Url;

use app\models\PerPersonal1;

class CronempController extends Controller
{


	function getAuthorizationHeader()
	{

		$headers = null;

		if (function_exists('apache_request_headers')) {
			$requestHeaders = apache_request_headers();
			// Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
			$requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
			//print_r($requestHeaders);
			if (isset($requestHeaders['Authorization'])) {
				$headers = trim($requestHeaders['Authorization']);
			}
		}
		return $headers;
	}



	// http://samservice/cronemp/
	public function actionIndex()
	{

		$headers = $this->getAuthorizationHeader();

		if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {


			// arr($matches);

			// $request = Yii::$app->request;
			$uid = $matches[1];
			
			// $request->get("uid"); //'ksukrit'

			// $password = $request->get("password","sukrit6290" );

			$MasUser = MasUser::find()
				->where(['uid' => $uid])
				->one();

			if ($MasUser) {

				// if (password_verify($password, $MasUser->password)) {


				// }

				echo PerPersonal1::getFromApi($MasUser->id);
				exit;
			}



			//   return $matches[1];
		}

		$datas['status'] = 'fail';
		$datas['msg'] = 'ไม่สำเร็จ';

		echo json_encode($datas);

		exit;
	}
}
