<?php
class idplib
{

	public $accesstoken;
	public $refreshtoken;
	public $idtoken;
	public $expires;
	public $hasexpired;

	public $sub; //username
	public $SSOinitials; //คำนำหน้าชื่อ
	public $SSOfirstname; //ชื่อ
	public $SSOsurname; //นามสกุล
	public $SSOworkingdepdescription; //สำนักงาน
	public $SSOpersonclass; //ระดับชั้นเจ้าหน้าที่
	public $SSOpersonposition; //ตำแหน่งงาน
	public $SSObranchCode; //รหัสสาขา
	public $SSOmail; //อีเมล



	public function getIdpinfo()
	{

		require($_SERVER['DOCUMENT_ROOT'] . '/ihc/vendor/idplib/conf_dev.php');
		//require($_SERVER['DOCUMENT_ROOT'].'/ihc/vendor/idplib/conf_uat.php');
		//require($_SERVER['DOCUMENT_ROOT'].'/ihc/vendor/idplib/conf_prd.php');

		// send the authorization request
		if (empty($_GET['code'])) {
			$redirectUrl = $provider->getAuthorizationUrl();
			header(sprintf('Location: %s', $redirectUrl), true, 302);
			return;
		}

		// receive authorization response
		try {
			$token = $provider->getAccessToken('authorization_code', [
				'code' => $_GET['code']
			]);
		} catch (\OpenIDConnectClient\Exception\InvalidTokenException $e) {
			$errors = $provider->getValidatorChain()->getMessages();
			echo $e->getMessage();
			var_dump($errors);
			return;
		} catch (\Exception $e) {
			echo $e->getMessage();
			$errors = $provider->getValidatorChain()->getMessages();
			var_dump($errors);
			return;
		}

		$this->accesstoken = $token;
		$this->refreshtoken = $token->getRefreshToken();
		$this->idtoken = $token->getIdToken();
		$this->expires =  $token->getExpires(); //($accessToken->hasExpired() ? 'expired' : 'not expired')
		$this->hasexpired = ($token->hasExpired() ? 'expired' : 'not expired');
		$allclaims = $token->getIdToken()->getClaims();

		Yii::app()->session['accesstoken'] = $this->accesstoken;
		Yii::app()->session['idtoken'] = $this->idtoken;
		Yii::app()->user->setState("idtoken", $this->idtoken);

		foreach ($allclaims as $key => $value) {
			if ($key == 'sub') {
				$this->sub = $value;
				Yii::app()->session['sub'] = $this->sub;
				//Yii::app()->user->setState("sub", $this->sub);

				$arr = (array) $this->sub;
				$values = array_values($arr);
				Yii::app()->user->setState("sub", end($values));
			}
		} //foreach

		$url = $apigwurl . $this->sub;

		$opts = array(
			"http" => array(
				"method" => "GET",
				"header" =>
				//"Content-Type: application/xml; charset=utf-8;\r\n".
				"accept: */*\r\n" .
					"Authorization: Bearer " . $this->accesstoken . "\r\n",
				"Connection: close\r\n",
				"ignore_errors" => true,
				"timeout" => (float) 30.0,
				//"content" => $postdata,
				//'Content-type: application/xwww-form-urlencoded',
			),
			"ssl" => array(
				"verify_peer" => false,
				"verify_peer_name" => false,
			),
		);


		$content = file_get_contents($url, false, stream_context_create($opts));

		$content_jsdc = json_decode($content);

		foreach ($content_jsdc as $key => $value) {
			if ($key == '00001') {
				foreach ($value as $key2 => $value2) {
					if ($key2 == 'initials') {
						$this->SSOinitials = $value2;
						Yii::app()->session['SSOinitials'] = $this->SSOinitials;
						Yii::app()->user->setState("SSOinitials", $this->SSOinitials);
					}
					if ($key2 == 'ssofirstname') {
						$this->SSOfirstname = $value2;
						Yii::app()->session['SSOfirstname'] = $this->SSOfirstname;
						Yii::app()->user->setState("SSOfirstname", $this->SSOfirstname);
					}
					if ($key2 == 'ssosurname') {
						$this->SSOsurname = $value2;
						Yii::app()->session['SSOsurname'] = $this->SSOsurname;
						Yii::app()->user->setState("SSOsurname", $this->SSOsurname);
					}
					if ($key2 == 'workingdeptdescription') {
						$this->SSOworkingdepdescription = $value2;
						Yii::app()->session['SSOworkingdepdescription'] = $this->SSOworkingdepdescription;
						Yii::app()->user->setState("SSOworkingdepdescription", $this->SSOworkingdepdescription);
					}
					if ($key2 == 'ssopersonclass') {
						$this->SSOpersonclass = $value2;
						Yii::app()->session['SSOpersonclass'] = $this->SSOpersonclass;
						Yii::app()->user->setState("SSOpersonclass", $this->SSOpersonclass);
					}
					if ($key2 == 'ssopersonposition') {
						$this->SSOpersonposition = $value2;
						Yii::app()->session['SSOpersonposition'] = $this->SSOpersonposition;
						Yii::app()->user->setState("SSOpersonposition", $this->SSOpersonposition);
					}
					if ($key2 == 'ssobranchcode') {
						$this->SSObranchCode = $value2;
						Yii::app()->session['SSObranchCode'] = $this->SSObranchCode;
						Yii::app()->user->setState("SSObranchCode", $this->SSObranchCode);
					}
					if ($key2 == 'mail') {
						$this->SSOmail = $value2;
						Yii::app()->session['SSOmail'] = $this->SSOmail;
						Yii::app()->user->setState("SSOmail", $this->SSOmail);
					}
				} //for
			} //if
		} //for

		Yii::app()->user->setState('visited',null);
	} //function getIdPinfo()

	public function setStateuser()
	{

		/*	$arr = (array)$this->sub;
	$values = array_values($arr);
	Yii::app()->user->setState("sub", end($values));

	$arr = (array)$this->SSOinitials;
	$values = array_values($arr);
	Yii::app()->user->setState("SSOinitials", end($values));

	$arr = (array)$this->SSOfirstname;
	$values = array_values($arr);
	Yii::app()->user->setState("SSOfirstname", end($values));

	$arr = (array)$this->SSOsurname;
	$values = array_values($arr);
	Yii::app()->user->setState("SSOsurname", end($values));

	$arr = (array)$this->SSOworkingdepdescription;
	$values = array_values($arr);
	Yii::app()->user->setState("SSOworkingdepdescription", end($values));

	$arr = (array)$this->SSOpersonclass;
	$values = array_values($arr);
	Yii::app()->user->setState("SSOpersonclass", end($values));

	$arr = (array)$this->SSOpersonposition;
	$values = array_values($arr);
	Yii::app()->user->setState("SSOpersonposition", end($values));

	$arr = (array)$this->SSObranchCode;
	$values = array_values($arr);
	Yii::app()->user->setState("SSObranchCode", end($values));
*/
	}


	public function clsStateuser()
	{

		/*Yii::app()->user->setState("sub", null);
	Yii::app()->user->setState("SSOinitials", null);
	Yii::app()->user->setState("SSOfirstname", null);
	Yii::app()->user->setState("SSOsurname", null);
	Yii::app()->user->setState("SSOworkingdepdescription", null);
	Yii::app()->user->setState("SSOpersonclass", null);
	Yii::app()->user->setState("SSOpersonposition", null);
	Yii::app()->user->setState("SSObranchCode", null);*/
	}
}//class Idpfunc
