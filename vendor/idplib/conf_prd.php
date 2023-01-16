<?php
	
		require $_SERVER['DOCUMENT_ROOT'] . '/ihc/vendor/idplib/vendor/autoload.php';
		$key = sprintf('file://%s/server_prd.pem', realpath(__DIR__));
			
		$signer   = new \Lcobucci\JWT\Signer\Rsa\Sha256();
		$provider = new \OpenIDConnectClient\OpenIDConnectProvider([
			'clientId'                => '6oBr5wQHw6XwTZBdpQmlyTvHbpQa',
			'clientSecret'            => '4Jkr_WLvJKl9IfMeJDIRSu4COiga',
			'idTokenIssuer'           => 'https://wa1.sso.go.th:443/oauth2/token',
			// Your server
			'redirectUri'             => 'https://intranet.sso.go.th/ihc/',
			'urlAuthorize'            => 'https://wa1.sso.go.th:443/oauth2/authorize',
			'urlAccessToken'          => 'https://wa1.sso.go.th:443/oauth2/token',
			'urlResourceOwnerDetails' => 'https://wa1.sso.go.th:443/oauth2/userinfo',
			// Find the public key here: https://github.com/bshaffer/oauth2-demo-php/blob/master/data/pubkey.pem
			// to test against brentertainment.com
			'publicKey'               => $key,
		],
			[
				'signer' => $signer
			]
		);
	?>
