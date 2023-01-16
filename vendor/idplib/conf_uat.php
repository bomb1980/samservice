<?php
	
		require $_SERVER['DOCUMENT_ROOT'] . '/ihc/vendor/idplib/vendor/autoload.php';
		//$key = sprintf('file://%s/server_uat.pem', realpath($_SERVER['DOCUMENT_ROOT'] . '/ihc/vendor/idplib'));
		$key = sprintf('file://%s/server_uat.pem', realpath(__DIR__));
			
		$signer   = new \Lcobucci\JWT\Signer\Rsa\Sha256();
		$provider = new \OpenIDConnectClient\OpenIDConnectProvider([
			'clientId'				   => 'IuvZr4WhdT5Oq6Hz1sEs5fxEn5sa',
			'clientSecret'			=> 'K2spvA7NvK2GzLlo9kImbgvTwfca',
			'idTokenIssuer'           => 'https://idpws02uat.sso.go.th:443/oauth2/token',
			// Your server
			'redirectUri'             => 'https://uat2.sso.go.th/ihc/',
			'urlAuthorize'            => 'https://idpws02uat.sso.go.th:443/oauth2/authorize',
			'urlAccessToken'          => 'https://idpws02uat.sso.go.th:443/oauth2/token',
			'urlResourceOwnerDetails' => 'https://idpws02uat.sso.go.th:443/oauth2/userinfo',
			// Find the public key here: https://github.com/bshaffer/oauth2-demo-php/blob/master/data/pubkey.pem
			// to test against brentertainment.com
			'publicKey'               => $key,
		],
			[
				'signer' => $signer
			]
		);
		$apigwurl = "https://apigw02uat.sso.go.th:443/api/ldapgw/class_b/v1.0.0/getUsers/";
	?>
