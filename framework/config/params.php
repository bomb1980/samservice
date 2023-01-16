<?php
/*
$cf_url = 'http://localhost:8080/ihc'; 
$cf_path = 'C:\inetpub\wwwroot\ihc'; 	

$cf_themes_url = 'http://localhost:8080/themes';
$cf_themes_path = 'C:\xampp\htdocs\themes'; 
*/

if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] != "off") {
    $protocol = "https://";
} else {
    $protocol = "http://";
}
$url = $protocol . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]);

$cf_url = $url;
$cf_path =  $_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER["PHP_SELF"]);

$cf_themes_url = $url . '/themes';
$cf_themes_path = $cf_path . '/themes';

//$cf_upload_att_url = $cf_url . '/uploads/attachment' ;
//$cf_upload_att_dir = $cf_path . '/uploads/attachment' ;
$cf_upload_att_url = $protocol . $_SERVER["HTTP_HOST"] . '/ihc_data/uploads/attachment';
$cf_upload_att_dir = $_SERVER['DOCUMENT_ROOT'] . '/ihc_data/uploads/attachment';

//$cf_upload_cnt_url = $cf_url . '/uploads/content' ;
//$cf_upload_cnt_dir = $cf_path . '/uploads/content' ;
$cf_upload_cnt_url = $protocol . $_SERVER["HTTP_HOST"] . '/ihc_data/uploads/content';
$cf_upload_cnt_dir = $_SERVER['DOCUMENT_ROOT'] . '/ihc_data/uploads/content';

//$cf_upload_pt_url = $cf_url . '/uploads/portraits' ;
//$cf_upload_pt_dir = $cf_path . '/uploads/portraits' ;
$cf_upload_pt_url = $protocol . $_SERVER["HTTP_HOST"] . '/ihc_data/uploads/portraits';
$cf_upload_pt_dir = $_SERVER['DOCUMENT_ROOT'] . '/ihc_data/uploads/portraits';

$cf_name = 'SSO_DPIS6';
$cf_fullname = 'ระบบจัดการ DPIS6 ประกันสังคม';

$cf_ver = '20221126';

//$dbhost = 'mysql:host=192.168.10.123;';
$dbhost = 'mysql:host=127.0.0.1;';
$dbhostdpis = 'oci:dbname=172.20.91.111:1521/D62SORA;charset=UTF8';
return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'data_ctrl' => [
        'dbhost' => $dbhost,
		'dbhostdpis' => $dbhostdpis,
    ],
    'prg_ctrl' => [
        'domain' => $cf_url,
        /*'indextitle' => $cf_name,*/
        'name'    => $cf_name,
        'fullname'    => $cf_fullname,
        'version'    => $cf_ver,
        'fullnameversion'    => $cf_fullname . ' (' . $cf_ver . ')',
        'pagetitle'    => ' | ' . $cf_name . ' ' . $cf_ver,
        'logo' => $cf_url . '/images/common/logo_01.png',
        'logo_sq' => $cf_url . '/images/common/hrms-3.png',
        'favicon' => $cf_url . '/images/common/favicon.ico',
        'appleicon' => $cf_url . '/images/common/appleicon.png',

        'authCookieDuration' => 7,  //the duration of the user login cookie in days	
        'ldap' => [
            'server' => '172.16.19.94',
            'port' => '389',
            'bind_uid' => 'appintranet',
            'bind_pwd' => 'P@ssw0rddev',
            'bind_dn' => 'uid=appintranet,cn=App,ou=internal,DC=ESSS,DC=SSO,DC=GO,DC=TH',
            'filter_attr' => 'uid',
            'arr_search_attr' => array('initials' => 'initials', 'firstname' => 'ssofirstname', 'lastname' => 'ssosurname', 'mail' => 'mail', 'ssobranchcode' => 'ssobranchcode', 'ssopersonposition' => 'ssopersonposition', 'ssopersoncitizenid' => 'ssopersoncitizenid', 'uid' => 'uid', 'accountactive' => 'accountactive'),
            'arr_basedn' => 'cn=Users,ou=internal,dc=ESSS,dc=SSO,dc=GO,dc=TH',
        ],
        'url' => [
            'baseurl' => $cf_url,
            'upload' => $cf_url . '/uploads',
            'media' => $cf_url . '/media/',
            'themes' => $cf_themes_url . '/remark_base',
            'attachment' => $cf_upload_att_url,
            'content' => $cf_upload_cnt_url,
            'portraits' => $cf_upload_pt_url,
            'idplogout' => 'https://idpdev01.app.sso.go.th:9443/oidc/logout?id_token_hint=',
            'idplogoutparam' => '&post_logout_redirect_uri=' . $url . '/&state=state_2',
            'portal' => $protocol . $_SERVER["HTTP_HOST"] . '/portal/',
            'coverbranch' => $cf_url . '/uploads/cover',
        ],
        'path' => [
            'basepath' => $cf_path,
            'upload' => $cf_path . '\uploads',
            'media' => $cf_path . '\media',
            'themes' => $cf_themes_path . '\remark_base',
            'attachment' => $cf_upload_att_dir,
            'content' => $cf_upload_cnt_dir,
            'portraits' => $cf_upload_pt_dir,
            'coverbranch' => $cf_path . '\uploads\cover',
        ],
        'vendor' => [],
        'pagination' => [
            'default' => [
                'pagesize' => '40',
                'maxbuttoncount' => '12',
                'maxitem' => '1000',
            ]
        ],
        'app_permission' => [
            'app_id' => [
                'cms' => '1',
                'calendar' => '2',
                'admin' => '5',
                'branch' => '6',
                'ccms' => '7',
                'contact' => '8',
            ]
        ],
        'api' => [
            'line' => [
                //'server' =>'http://203.154.95.166/'
                'server' =>'http://192.168.10.122/'
            ],
            'e-service'=>[
                'server' =>'',
				'user_token' => 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c',
				'callerid' => 'line',
            ],
			'idpuat'=>[
				'server' =>'',
				'secret-id' => 'lineapp',
				'secret-key' => '50087f71-fb9f-4d6a-9200-76c1a10e3be1'
			],
			'idppro'=>[
				'server' =>'',
				'secret-id' => 'lineapp',
				'secret-key' => 'e675e7bd-2436-494b-90af-ea886f798a29'
			],
        ],
    ],
    'auth' => [
        'crypter' => [
            'encryption_key' => 'j5DiyKcoN32vCYF36Ve62l3WoIIDdfgJsw4qH7Kx8jid4G',
            'method' => 'aes-128-ctr',
        ],
        'local' => true,
    ],
];
