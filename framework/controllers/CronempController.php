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


	function actionGogo()
	{

		echo $getEncrypter = CommonFnc::getEncrypter( 'aaaaaaaaaa', $type = 'encrtyp' );


		echo CommonFnc::getEncrypter( $getEncrypter, $type = 'encdadfdsfdsfrtyp' );


	}

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

		if ( 0 ) {
			
			$simple_string = "ksukrit";
			$encryption = CommonFnc::getEncrypter( $simple_string );
			
			
			// $this->getEncrypter( $simple_string );

			arr($encryption);
		} 


		$headers = CommonFnc::getAuthorizationHeader();

		if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {

			$MasUser = MasUser::find()
				->where(['uid' => CommonFnc::getEncrypter( $matches[1], 'dadfsdfs' )])
				->one();

			if ($MasUser) {
				echo PerPersonal1::getFromApi($MasUser->id);
				exit;
			}
		}

		$datas['status'] = 'fail';
		$datas['msg'] = 'ไม่สำเร็จ';

		echo json_encode($datas);

		exit;
	}
}
