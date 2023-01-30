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


	function getEncrypter($code = NULL, $type = 'encrypt')
	{

		$encrypter = new Encrypter('1234567812345678', 'AES-128-CBC');

		if ($type == 'encrypt') {

			return $encrypter->encrypt($code);
		}

		return $encrypter->decrypt($code);
	}



	// http://samservice/cronemp/
	public function actionIndex()
	{

		$headers = $this->getAuthorizationHeader();

		if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {



			$simple_string = "ksukrit";

			$ciphering = "AES-128-CTR";

			$iv_length = openssl_cipher_iv_length($ciphering);
			$options = 0;

			$encryption_iv = '1234567891011121';

			$encryption_key = "GeeksforGeeks";

			$encryption = openssl_encrypt(
				$simple_string,
				$ciphering,
				$encryption_key,
				$options,
				$encryption_iv
			);

			$encryption = $matches[1];

			$decryption_iv = '1234567891011121';

			$decryption_key = "GeeksforGeeks";

			$uid = openssl_decrypt(
				$encryption,
				$ciphering,
				$decryption_key,
				$options,
				$decryption_iv
			);


			$MasUser = MasUser::find()
				->where(['uid' => $uid])
				->one();

			if ($MasUser) {

				echo PerPersonal1::getFromApi($MasUser->id);
				exit;
			}



			//   return $matches[1];
		}

		$datas['status'] = 'fail';
		$datas['msg'] = 'ไม่สำเร็จ';

		echo json_encode($datas);

		exit;





		// echo "Decrypted String: " . $decryption;


		exit;

		$secretKey = 'bombja';

		$data = 'ksukrit';


		echo Yii::$app->security->encryptByKey($data, $secretKey);

		//   $this->private_info = utf8_encode(Yii::app()->getSecurityManager()->encrypt($this->private_info));
		exit;

		header('Content-Type: text/html; charset=utf-8');


		echo $encryptedData = Yii::$app->security->encryptByKey($data, $secretKey);

		// echo 'dafadfsads';
		exit;

		// header('Content-Type: text/html; charset=utf-8');


		echo $encryptedData = Yii::$app->getSecurity()->encryptByPassword($data, $secretKey);



		// echo 'dasadfasdf';

		echo '<br>';


		echo $data = Yii::$app->getSecurity()->decryptByPassword($encryptedData, $secretKey);


		exit;
	}
}
