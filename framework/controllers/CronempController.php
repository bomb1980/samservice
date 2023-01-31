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

	// http://samservice/cronemp/
	public function actionIndex()
	{

		if ( 0 ) {
			
			$simple_string = "ksukrit";

			$encryption = CommonFnc::getEncrypter( $simple_string );
			
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
