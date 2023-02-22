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

	public function actionLine()
	{

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

				$datas['status'] = 'success';
				$datas['msg'] = 'อัพเดทเรียบร้อย';

				echo json_encode($datas);
				exit;
			}
		}

		$datas['status'] = 'fail';
		$datas['msg'] = 'ไม่สำเร็จ';

		echo json_encode($datas);

		exit;
	}
	
	public function actionPosition()
	{

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

				$datas['status'] = 'success';
				$datas['msg'] = 'อัพเดทเรียบร้อย';

				echo json_encode($datas);
				exit;
			}
		}

		$datas['status'] = 'fail';
		$datas['msg'] = 'ไม่สำเร็จ';

		echo json_encode($datas);

		exit;
	}

	public function actionOganize()
	{

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

				$datas['status'] = 'success';
				$datas['msg'] = 'อัพเดทเรียบร้อย';

				echo json_encode($datas);
				exit;
			}
		}

		$datas['status'] = 'fail';
		$datas['msg'] = 'ไม่สำเร็จ';

		echo json_encode($datas);

		exit;
	}

	public function actionPertype()
	{

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

				$datas['status'] = 'success';
				$datas['msg'] = 'อัพเดทเรียบร้อย';

				echo json_encode($datas);
				exit;
			}
		}

		$datas['status'] = 'fail';
		$datas['msg'] = 'ไม่สำเร็จ';

		echo json_encode($datas);

		exit;
	}

	public function actionLevel()
	{

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

				$datas['status'] = 'success';
				$datas['msg'] = 'อัพเดทเรียบร้อย';

				echo json_encode($datas);
				exit;
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

		$datas['status'] = 'fail';
		$datas['msg'] = 'ไม่สำเร็จ';

		echo json_encode($datas);

		exit;
	}

	function actionGogo()
	{

		echo $getEncrypter = CommonFnc::getEncrypter('aaaaaaaaaa', $type = 'encrtyp');


		echo CommonFnc::getEncrypter($getEncrypter, $type = 'encdadfdsfdsfrtyp');
	}
}
