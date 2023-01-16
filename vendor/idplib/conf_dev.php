<?php
		//require '/usr/share/nginx/html/ihc/protected/vendor/idplib/vendor/autoload.php';
		require $_SERVER['DOCUMENT_ROOT'] . '/ihc/vendor/idplib/vendor/autoload.php';
		//$key = sprintf('file://%s/server_dev.pem', realpath('/usr/share/nginx/html/ihc/protected/vendor/idplib'));
		//$key = sprintf('file://%s/server_dev.pem', realpath($_SERVER['DOCUMENT_ROOT'] . '/ihc/vendor/idplib')); 
		$key = sprintf('file://%s/server_dev.pem', realpath(__DIR__));
	
		$signer   = new \Lcobucci\JWT\Signer\Rsa\Sha256();
		$provider = new \OpenIDConnectClient\OpenIDConnectProvider([
			'clientId'                => 'UJchuyyoTOJv0fxVi4pL2e4_bIUa',
			'clientSecret'            => 'O6CrV6i4sX2J5Vv0JR7ZCiBsmsYa',
			'idTokenIssuer'           => 'https://idpdev01.app.sso.go.th:9443/oauth2/token',
			// Your server
			'redirectUri'             => 'https://ihcws.sso.go.th/ihc/',
			'urlAuthorize'            => 'https://idpdev01.app.sso.go.th:9443/oauth2/authorize',
			'urlAccessToken'          => 'https://idpdev01.app.sso.go.th:9443/oauth2/token',
			'urlResourceOwnerDetails' => 'https://idpdev01.app.sso.go.th:9443/oauth2/userinfo',
			// Find the public key here: https://github.com/bshaffer/oauth2-demo-php/blob/master/data/pubkey.pem
			// to test against brentertainment.com
			'publicKey'               => $key,
		],
			[
				'signer' => $signer
			]
		);
		$apigwurl = "https://apimdev01.app.sso.go.th:8243/api/ldapgw/class_b/V1.0.0/getUsers/";
	?>
