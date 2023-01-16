<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
//use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

use yii\rest\Controller;

use app\components\UserController;
use \app\components\CommonFnc;

use \app\models\LineAction;
use \app\models\RichmenuAction;

class ServiceController extends Controller
{
    public $enableCsrfValidation = false;

    public function idp_Authorization()
    {
        $secret_id = Yii::$app->params['prg_ctrl']['api']['idpuat']['secret-id'];
        $secret_key = Yii::$app->params['prg_ctrl']['api']['idpuat']['secret-key'];

        $secret_id = Yii::$app->params['prg_ctrl']['api']['idppro']['secret-id'];
        $secret_key = Yii::$app->params['prg_ctrl']['api']['idppro']['secret-key'];

        return "Basic " . base64_encode($secret_id . ':' . $secret_key);
    }

    public $_access_token;
    public function setaccess_token($new_value)
    {
        $this->_access_token = $new_value;
    }

    public function getaccess_token()
    {
        return $this->_access_token;
    }

    public function user_token()
    {
        return "Bearer " . $this->getaccess_token();
        //return Yii::$app->params['prg_ctrl']['api']['e-service']['user_token'];

        //$access_token = $content_jsdc['access_token'];
        //$user_token = "Bearer " . $access_token;
        //return $user_token;
    }
    public function callerid()
    {
        return Yii::$app->params['prg_ctrl']['api']['e-service']['callerid'];
    }
    public function url_idpauth()
    {
        //return 'https://idp04uat.sso.go.th/auth/realms/insured/protocol/openid-connect/token';
        return 'https://idp04.sso.go.th/auth/realms/insured/protocol/openid-connect/token';
    }
    public function url_idpauthaccess()
    {
        //return 'https://idp04uat.sso.go.th/auth/realms/insured/protocol/openid-connect/token/introspect';
        return 'https://idp04.sso.go.th/auth/realms/insured/protocol/openid-connect/token/introspect';
    }
    public function url_idpauthrefresh()
    {
        //return 'https://idp04uat.sso.go.th/auth/realms/insured/protocol/openid-connect/token';
        return 'https://idp04.sso.go.th/auth/realms/insured/protocol/openid-connect/token';
    }

    public function url_eservice()
    {
        //return 'https://uatwsg.sso.go.th/esv/esvews/service';
        return 'https://wsg.sso.go.th/esv/esvews/service';
    }
    public static function allowedDomains()
    {
        return [
            //'*',                        // star allows all domains
            'http://203.154.95.163',
            'http://203.154.95.164',
            'https://sso-line-official.com'
            //'http://test2.example.com',
        ];
    }

    /**
     * @inheritdoc
     */

    /*
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [

            // For cross-domain AJAX request
            'corsFilter'  => [
                'class' => \yii\filters\Cors::className(),
                'cors'  => [
                    // restrict access to domains:
                    'Origin'                           => static::allowedDomains(),
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                    'Access-Control-Allow-Credentials' => false,
                    'Access-Control-Max-Age'           => 3600, // Cache (seconds)
                    'Access-Control-Request-Headers' => ['*'],
                ],
            ],


        ]);
    }*/

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin'                           => static::allowedDomains(),
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Allow-Credentials' => false,
                'Access-Control-Max-Age'           => 3600,
                'Access-Control-Request-Headers' => ['*'],
            ],
        ];
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['auth', 'logout', 'signup'],
            'rules' => [
                [
                    'ips' => ['*', '203.154.95.163', '203.154.95.164'], //Fill in the allowed IP here
                    'allow' => true,
                ],
            ],
            'denyCallback' => function ($rule, $action) {
                // callback logic
                http_response_code(405);
                exit;
            }
        ];
        //var_dump($behaviors);exit;
        return $behaviors;
    }

    public function beforeAction($action)
    {
        if ($action->id == 'auth') {
            Yii::$app->request->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }


    public function actionIndex()
    {
    }

    public function actionEsv()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $request = Yii::$app->request;
        $id = $request->get("id");

        $headers = Yii::$app->request->headers;
        //var_dump($headers);

        $cmd = null;
        if (!empty($_REQUEST['cmd'])) $cmd = $_REQUEST['cmd'];

        if (is_null($cmd)) {
            return [
                'code' => 'WS003',
            ];
        }

        // verify token
        $ssoNo = null;
        if (!empty($_REQUEST['ssoNo'])) $ssoNo = $_REQUEST['ssoNo'];
        if (is_null($ssoNo)) {
            return [
                'code' => 'WS003',
            ];
        }
        $data =  $this->actionAuthtoken($ssoNo);

        if (array_key_exists("code", $data)) {
            if ($data['code'] == "WS000") {
                if (is_null($data['access_token'])) return ['code' => 'WS003'];
            } else {
                return [
                    'code' => 'WS003',
                ];
            }
        } else {
            return [
                'code' => 'WS003',
            ];
        }


        //getPersonInfo
        switch (strtolower($cmd)) {
            case strtolower("getPersonInfo"):
                return $this->getPersonInfo();
                break;
            case strtolower("getEmployeeCntr"):
                return $this->getEmployeeCntr();
                break;
            case strtolower("getEmployeeBenefitHisotry"):
                return $this->getEmployeeBenefitHisotry();
                break;
            case strtolower("getEmployeeOldAge"):
                return $this->getEmployeeOldAge();
                break;
            case strtolower("getS40Cntr"):
                return $this->getS40Cntr();
                break;
            case strtolower("getS40OldAge"):
                return $this->getS40OldAge();
                break;
            case strtolower("getS40BenefitHistory"):
                return $this->getS40BenefitHistory();
                break;
            case strtolower("getInitSelectHospital");
                return $this->getInitSelectHospital();
                break;
            case strtolower("saveSelectHospital");
                return $this->saveSelectHospital();
                break;
            case strtolower("changehospital");
                return $this->ChangeHospital();
                break;
            case strtolower("listTransaction");
                return $this->listTransaction();
                break;
            case strtolower("cancelTransaction");
                return $this->cancelTransaction();
                break;
            default:
                return [
                    'code' => 'WS003',
                ];
        }


        return [
            'id' => 'ID',
            'country' => 'Country',
            'city' => 'City',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'altitude' => 'Altitude',
        ];

        $conn = Yii::$app->db;

        $sql = "
        SELECT description FROM trn_richmenu WHERE id=:id
          ";
        $rchk = $conn->createCommand($sql)->bindValue('id', 21)->queryAll();
        if (count($rchk) != 0) {
            var_dump($rchk);
            //Yii::info('info log message');
        }
    }

    //ข้อมูลผู้ประกันตน
    function getPersonInfo()
    {
        $ssoNo = null;
        if (!empty($_REQUEST['ssoNo'])) $ssoNo = $_REQUEST['ssoNo'];
        if (is_null($ssoNo)) {
            return [
                'code' => 'WS003',
            ];
        }

        $m = new \Memcached();
        $m->addServer('localhost', 11211);
        //$m->delete('getSSOInfo' . $ssoNo);;

        $csso_info = $m->get('getSSOInfo' . $ssoNo);
        if ($csso_info) {
            $sso_info = $csso_info[1];
        } else {
            $conn = Yii::$app->db;
            $sql = "
             SELECT mas_sso_user.su_id, tran_ssoid.section_id, tran_line_id.li_line_id, tran_ssoid.ssobranch_code
             FROM
             mas_sso_user
             INNER JOIN tran_ssoid
                 ON (
                 mas_sso_user.su_id = tran_ssoid.id_sso
                 )
             INNER JOIN tran_line_id
                 ON (
                 mas_sso_user.su_id = tran_line_id.li_user_id
                 )
             where  su_idcard = :su_idcard
             ;
             ";
            $command = $conn->createCommand($sql);
            $command->bindValue(":su_idcard", $ssoNo);
            $rs = $command->queryAll();
            if (count($rs) > 0) {
                $id_sso = $rs[0]['su_id'];
                $section = $rs[0]['section_id'];
                $lineid = $rs[0]['li_line_id'];
                $ssoBranch = $rs[0]['ssobranch_code'];

                $this->linkmenutouser($id_sso, $section, $ssoBranch, $lineid);
            }
            $sso_info = $rs;
            $m->set('getSSOInfo' . $ssoNo, [date("Y-m-d H:i:s"), $rs], 3600); //หมดอายุ 1 ชั่วโมง

        }

        $getPersonInfo = $m->get('getPersonInfo' . $ssoNo);
        if ($getPersonInfo) {
            if (count($sso_info) > 0) {
                $id_sso = $sso_info[0]['su_id'];
                $section = $sso_info[0]['section_id'];
                $lineid = $sso_info[0]['li_line_id'];
                $ssoBranch = $sso_info[0]['ssobranch_code'];
                $this->linkmenutouser($id_sso, $section, $ssoBranch, $lineid);
            }
            return $getPersonInfo[1];
        } else {

            $param = [
                'cmd' => 'getPersonInfo',
                'ssoNo' => $ssoNo,
                'callerid' => $this->callerid(),
            ];

            $url = $this->url_eservice();
            $header = array(
                'Content-Type: application/x-www-form-urlencoded',
                'user_token: ' . $this->user_token()
            );
            $getinfo = $this->calleservice($url, $header, $param);

            //$getinfo = $this->calleservice($url, $header, $param);
            if ($getinfo) {
                //echo $getinfo['person']['ssoBranch'];exit;
                //var_dump($getinfo);exit;

                if (array_key_exists("code", $getinfo)) {
                    if ($getinfo['code'] = "WS000") {
                        $conn = Yii::$app->db;
                        $sql = "SELECT name FROM mas_ssobranch WHERE ssobranch_code = :ssobranch_code ";
                        $rows = $conn->createCommand($sql)->bindValue('ssobranch_code', $getinfo['person']['ssoBranch'])->queryAll();
                        if (count($rows) > 0) {
                            $getinfo['person']['branchname'] = $rows[0]['name'];
                        }
                        //var_dump($rows);
                        //$getinfo['person']['xx'] = "";
                    }
                }

                $m->set('getPersonInfo' . $ssoNo, [date("Y-m-d H:i:s"), $getinfo], 3600); //หมดอายุ 1 ชั่วโมง

                if (count($sso_info) > 0) {
                    $id_sso = $sso_info[0]['su_id'];
                    $section = $sso_info[0]['section_id'];
                    $lineid = $sso_info[0]['li_line_id'];
                    $ssoBranch = $sso_info[0]['ssobranch_code'];
                    $this->linkmenutouser($id_sso, $section, $ssoBranch, $lineid);
                }

                return $getinfo;
                /*
             if (array_key_exists("code", $getinfo)) {
                 if ($getinfo['code'] = "WS000") {
 
                 }
             }*/
            } else {
                return [
                    'code' => 'WS500',
                ];
            }
        }


        return [
            'code' => 'WS000',
            'lastIncremental' => '23/07/2564',
            'person' => [
                "ssoNum" => "1729900066822",
                "titleCodeDesc" => "นาย",
                "firstName" => "ทวิชงค์",
                "lastName" => "สดสรี",
                "genderDesc" => "ชาย",
                "gender" => "M",
                "activeStatusDesc" => "เป็นผู้ประกันตน (มาตรา 33)",
                "activeStatus" => "A"
            ],
            'personS33Info' => [
                "hospitalCode" => "2212040",
                "hospitalName" => "เกษมราษฎร์ รัตนาธิเบศร์",
                "mselStartDate" => "16/03/2563",
                "mselExpireDate" => "จนสิ้นสุดความเป็นผู้ประกันตน"
            ],
        ];
    }

    //ข้อมูลเงินสบทบมาตรา 33 39
    function getEmployeeCntr()
    {
        $ssoNo = null;
        if (!empty($_REQUEST['ssoNo'])) $ssoNo = $_REQUEST['ssoNo'];
        if (is_null($ssoNo)) {
            return [
                'code' => 'WS003',
            ];
        }
        $year = null;
        if (!empty($_REQUEST['year'])) $year = $_REQUEST['year'];
        if (is_null($year)) {
            return [
                'code' => 'WS003',
            ];
        }

        $m = new \Memcached();
        $m->addServer('localhost', 11211);
        $Fetch  = False;

        $getEmployeeCntr = $m->get('getEmployeeCntr' . $ssoNo . $year);
        if ($getEmployeeCntr) {

            $today = new \DateTime("today"); // This object represents current date/time with time set to midnight

            $match_date = \DateTime::createFromFormat("Y-m-d H:i:s", $getEmployeeCntr[0]);
            $match_date->setTime(0, 0, 0); // set time part to midnight, in order to prevent partial comparison

            $diff = $today->diff($match_date);
            $diffDays = (int)$diff->format("%R%a"); // Extract days count in interval

            $callh = \DateTime::createFromFormat("Y-m-d H:i:s", $getEmployeeCntr[0]);

            switch ($diffDays) {
                case 0:
                    if ((int)$callh->format('H') < 4 && (int)date("H") >= 4) {
                        //ถ้าเป็นวันที่ปัจจุบันและเคยเรียกก่อน ตี 4 ให้เรียกใหม่                        
                        $Fetch = true;
                    } else { //echo "www";
                        return $getEmployeeCntr[1];
                    }
                    break;
                case -1:
                    if ((int)$callh->format('H') < 4) {
                        //ถ้าเป็นเมื่อวานและเคยเรียกก่อน ตี 4 ให้เรียกใหม่
                        $Fetch  = true;
                    } else {
                        return $getEmployeeCntr[1];
                    }
                    break;
                default:
                    $Fetch  = true;
                    break;
            }
        } else {
            $Fetch  = true;
        }

        if ($Fetch == True) {
            $param = [
                'cmd' => 'getEmployeeCntr',
                'ssoNo' => $ssoNo,
                'callerid' => $this->callerid(),
                'year' => $year,
            ];

            $url = $this->url_eservice();
            $header = array(
                'Content-Type: application/x-www-form-urlencoded',
                'user_token: ' . $this->user_token()
            );
            $getinfo = $this->calleservice($url, $header, $param);
            if ($getinfo) {
                //var_dump($getinfo);
                $m->set('getEmployeeCntr' . $ssoNo . $year, [date("Y-m-d H:i:s"), $getinfo], 86400); // หมดอายุ 1 วัน
                return $getinfo;
            } else {
                return [
                    'code' => 'WS500',
                ];
            }
        }

        return [
            'code' => 'WS003',
        ];

        return [
            'code' => 'WS000',
            'lastIncremental' => '23/07/2564',
            'detail' => [
                [
                    "payPeriod" => "256406",
                    "payDate" => "08/07/2564",
                    "cntrRate" => "2.50",
                    "cntrAmount" => "271.00"
                ],
                [
                    "payPeriod" => "256405",
                    "payDate" => "11/06/2564",
                    "cntrRate" => "5.00",
                    "cntrAmount" => "543.00"
                ],
                [
                    "payPeriod" => "256404",
                    "payDate" => "12/05/2564",
                    "cntrRate" => "5.00",
                    "cntrAmount" => "543.00"
                ],
                [
                    "payPeriod" => "256403",
                    "payDate" => "08/04/2564",
                    "cntrRate" => "1.75",
                    "cntrAmount" => "54.00"
                ],
                [
                    "payPeriod" => "256402",
                    "payDate" => "15/03/2564",
                    "cntrRate" => "1.75",
                    "cntrAmount" => "54.00"
                ],
                [
                    "payPeriod" => "256401",
                    "payDate" => "10/02/2564",
                    "cntrRate" => "3.00",
                    "cntrAmount" => "326.00"
                ]
            ],
        ];
    }
    //ข้อมูลสิทธิ์ประโยชน์มาตรา 33 39
    function getEmployeeBenefitHisotry()
    {
        $ssoNo = null;
        if (!empty($_REQUEST['ssoNo'])) $ssoNo = $_REQUEST['ssoNo'];
        if (is_null($ssoNo)) {
            return [
                'code' => 'WS003',
            ];
        }
        $year = null;
        if (!empty($_REQUEST['year'])) $year = $_REQUEST['year'];
        if (is_null($year)) {
            return [
                'code' => 'WS003',
            ];
        }

        $m = new \Memcached();
        $m->addServer('localhost', 11211);
        $Fetch  = False;

        $getEmployeeBenefitHisotry = $m->get('getEmployeeBenefitHisotry' . $ssoNo . $year);
        if ($getEmployeeBenefitHisotry) {

            $today = new \DateTime("today"); // This object represents current date/time with time set to midnight

            $match_date = \DateTime::createFromFormat("Y-m-d H:i:s", $getEmployeeBenefitHisotry[0]);
            $match_date->setTime(0, 0, 0); // set time part to midnight, in order to prevent partial comparison

            $diff = $today->diff($match_date);
            $diffDays = (int)$diff->format("%R%a"); // Extract days count in interval

            $callh = \DateTime::createFromFormat("Y-m-d H:i:s", $getEmployeeBenefitHisotry[0]);

            switch ($diffDays) {
                case 0:
                    if ((int)$callh->format('H') < 4 && (int)date("H") >= 4) {
                        //ถ้าเป็นวันที่ปัจจุบันและเคยเรียกก่อน ตี 4 ให้เรียกใหม่                        
                        $Fetch = true;
                    } else { //echo "www";
                        return $getEmployeeBenefitHisotry[1];
                    }
                    break;
                case -1:
                    if ((int)$callh->format('H') < 4) {
                        //ถ้าเป็นเมื่อวานและเคยเรียกก่อน ตี 4 ให้เรียกใหม่
                        $Fetch  = true;
                    } else {
                        return $getEmployeeBenefitHisotry[1];
                    }
                    break;
                default:
                    $Fetch  = true;
                    break;
            }
        } else {
            $Fetch  = true;
        }


        if ($Fetch == True) {
            $param = [
                'cmd' => 'getEmployeeBenefitHisotry',
                'ssoNo' => $ssoNo,
                'callerid' => $this->callerid(),
                'year' => $year,
            ];

            $url = $this->url_eservice();
            $header = array(
                'Content-Type: application/x-www-form-urlencoded',
                'user_token: ' . $this->user_token()
            );
            $getinfo = $this->calleservice($url, $header, $param);
            if ($getinfo) {
                //var_dump($getinfo);
                $m->set('getEmployeeBenefitHisotry' . $ssoNo . $year, [date("Y-m-d H:i:s"), $getinfo], 86400); // หมดอายุ 1 วัน
                return $getinfo;
            } else {
                return [
                    'code' => 'WS500',
                ];
            }
        }

        return [
            'code' => 'WS003',
        ];

        return [
            'code' => 'WS000',
            'lastIncremental' => '23/07/2564',
            "detail" => [
                [
                    "paymentDate" => "27/02/2563",
                    "benefitDesc" => "เจ็บป่วย/ทันตกรรม",
                    "payAmount" => "900.00",
                    "requestDate" => "20/02/2563",
                    "payStatusDesc" => "อนุมัติแล้ว(จ่ายเงินแล้ว)"
                ]
            ]
        ];
    }

    //การคำนวณเงินชราภาพมาตรา 33 39
    function getEmployeeOldAge()
    {
        $ssoNo = null;
        if (!empty($_REQUEST['ssoNo'])) $ssoNo = $_REQUEST['ssoNo'];
        if (is_null($ssoNo)) {
            return [
                'code' => 'WS003',
            ];
        }

        $m = new \Memcached();
        $m->addServer('localhost', 11211);
        $Fetch  = False;

        $getEmployeeOldAge = $m->get('getEmployeeOldAge' . $ssoNo); //var_dump($getEmployeeOldAge);exit;
        if ($getEmployeeOldAge) {

            $today = new \DateTime("today"); // This object represents current date/time with time set to midnight

            $match_date = \DateTime::createFromFormat("Y-m-d H:i:s", $getEmployeeOldAge[0]);
            $match_date->setTime(0, 0, 0); // set time part to midnight, in order to prevent partial comparison

            $diff = $today->diff($match_date);
            $diffDays = (int)$diff->format("%R%a"); // Extract days count in interval

            $callh = \DateTime::createFromFormat("Y-m-d H:i:s", $getEmployeeOldAge[0]);

            switch ($diffDays) {
                case 0:
                    if ((int)$callh->format('H') < 4 && (int)date("H") >= 4) {
                        //ถ้าเป็นวันที่ปัจจุบันและเคยเรียกก่อน ตี 4 ให้เรียกใหม่                        
                        $Fetch = true;
                    } else { //echo "www";
                        return $getEmployeeOldAge[1];
                    }
                    break;
                case -1:
                    if ((int)$callh->format('H') < 4) {
                        //ถ้าเป็นเมื่อวานและเคยเรียกก่อน ตี 4 ให้เรียกใหม่
                        $Fetch  = true;
                    } else {
                        return $getEmployeeOldAge[1];
                    }
                    break;
                default:
                    $Fetch  = true;
                    break;
            }
        } else {
            $Fetch  = true;
        }

        if ($Fetch == True) {
            $param = [
                'cmd' => 'getEmployeeOldAge',
                'ssoNo' => $ssoNo,
                'callerid' => $this->callerid(),
            ];

            $url = $this->url_eservice();
            $header = array(
                'Content-Type: application/x-www-form-urlencoded',
                'user_token: ' . $this->user_token()
            );
            $getinfo = $this->calleservice($url, $header, $param);

            if ($getinfo) {
                //var_dump($getinfo);
                $m->set('getEmployeeOldAge' . $ssoNo, [date("Y-m-d H:i:s"), $getinfo], 86400); // หมดอายุ 1 วัน
                return $getinfo;
            } else {
                return [
                    'code' => 'WS500',
                ];
            }
        }

        return [
            'code' => 'WS003',
        ];

        return [
            "code" => "WS000",
            "totalEmployeePaid" => "49,942.50",
            "totalEmployerPaid" => "49,942.50",
            "totalGovermentPaid" => "900.00",
            "totalPaid" => "100,785.00",
            "details" => [
                [
                    "year" => "2562",
                    "employeePaid" => "5,400.00",
                    "employerPaid" => "5,400.00",
                    "govermentPaid" => "0.00",
                    "totalPaid" => "10,800.00"
                ],
                [
                    "year" => "2563",
                    "employeePaid" => "3,780.00",
                    "employerPaid" => "3,780.00",
                    "govermentPaid" => "0.00",
                    "totalPaid" => "7,560.00"
                ],
                [
                    "year" => "2564", "employeePaid" => "2,062.50",
                    "employerPaid" => "2,062.50",
                    "govermentPaid" => "0.00",
                    "totalPaid" => "4,125.00"
                ]
            ]
        ];
    }
    //ข้อมูลเงินสบทบมาตรา 40
    function getS40Cntr()
    {
        $ssoNo = null;
        if (!empty($_REQUEST['ssoNo'])) $ssoNo = $_REQUEST['ssoNo'];
        if (is_null($ssoNo)) {
            return [
                'code' => 'WS003',
            ];
        }
        $year = null;
        if (!empty($_REQUEST['year'])) $year = $_REQUEST['year'];
        if (is_null($year)) {
            return [
                'code' => 'WS003',
            ];
        }

        $m = new \Memcached();
        $m->addServer('localhost', 11211);
        $Fetch  = False;

        $getS40Cntr = $m->get('getS40Cntr' . $ssoNo . $year); //var_dump($getS40Cntr);exit;
        if ($getS40Cntr) {

            $today = new \DateTime("today"); // This object represents current date/time with time set to midnight

            $match_date = \DateTime::createFromFormat("Y-m-d H:i:s", $getS40Cntr[0]);
            $match_date->setTime(0, 0, 0); // set time part to midnight, in order to prevent partial comparison

            $diff = $today->diff($match_date);
            $diffDays = (int)$diff->format("%R%a"); // Extract days count in interval

            $callh = \DateTime::createFromFormat("Y-m-d H:i:s", $getS40Cntr[0]);

            switch ($diffDays) {
                case 0:
                    if ((int)$callh->format('H') < 4 && (int)date("H") >= 4) {
                        //ถ้าเป็นวันที่ปัจจุบันและเคยเรียกก่อน ตี 4 ให้เรียกใหม่                        
                        $Fetch = true;
                    } else { //echo "www";
                        return $getS40Cntr[1];
                    }
                    break;
                case -1:
                    if ((int)$callh->format('H') < 4) {
                        //ถ้าเป็นเมื่อวานและเคยเรียกก่อน ตี 4 ให้เรียกใหม่
                        $Fetch  = true;
                    } else {
                        return $getS40Cntr[1];
                    }
                    break;
                default:
                    $Fetch  = true;
                    break;
            }
        } else {
            $Fetch  = true;
        }

        if ($Fetch == True) {
            $param = [
                'cmd' => 'getS40Cntr',
                'ssoNo' => $ssoNo,
                'callerid' => $this->callerid(),
                'year' => $year
            ];

            $url = $this->url_eservice();
            $header = array(
                'Content-Type: application/x-www-form-urlencoded',
                'user_token: ' . $this->user_token()
            );
            $getinfo = $this->calleservice($url, $header, $param);
            if ($getinfo) {
                //var_dump($getinfo);
                $m->set('getS40Cntr' . $ssoNo . $year, [date("Y-m-d H:i:s"), $getinfo], 86400); // หมดอายุ 1 วัน
                return $getinfo;
            } else {
                return [
                    'code' => 'WS500',
                ];
            }
        }

        return [
            'code' => 'WS003',
        ];

        return [
            "code" => "WS000",
            "detail" => [
                [
                    "payPeriod" => "256104",
                    "payDate" => "15/04/2561",
                    "cntrAmount" => "100.00"
                ],
                [
                    "payPeriod" => "256106",
                    "payDate" => "18/06/2561",
                    "cntrAmount" => "100.00"
                ],
                [
                    "payPeriod" => "256108",
                    "payDate" => "21/08/2561",
                    "cntrAmount" => "100.00"
                ],
                [
                    "payPeriod" => "256111",
                    "payDate" => "09/11/2561",
                    "cntrAmount" => "100.00"
                ]
            ]
        ];
    }
    //การคำนวณเงินชราภาพมาตรา 40
    function getS40OldAge()
    {
        $ssoNo = null;
        if (!empty($_REQUEST['ssoNo'])) $ssoNo = $_REQUEST['ssoNo'];
        if (is_null($ssoNo)) {
            return [
                'code' => 'WS003',
            ];
        }

        $m = new \Memcached();
        $m->addServer('localhost', 11211);
        $Fetch  = False;

        $getS40OldAge = $m->get('getS40OldAge' . $ssoNo); //var_dump($getS40Cntr);exit;
        if ($getS40OldAge) {

            $today = new \DateTime("today"); // This object represents current date/time with time set to midnight

            $match_date = \DateTime::createFromFormat("Y-m-d H:i:s", $getS40OldAge[0]);
            $match_date->setTime(0, 0, 0); // set time part to midnight, in order to prevent partial comparison

            $diff = $today->diff($match_date);
            $diffDays = (int)$diff->format("%R%a"); // Extract days count in interval

            $callh = \DateTime::createFromFormat("Y-m-d H:i:s", $getS40OldAge[0]);

            switch ($diffDays) {
                case 0:
                    if ((int)$callh->format('H') < 4 && (int)date("H") >= 4) {
                        //ถ้าเป็นวันที่ปัจจุบันและเคยเรียกก่อน ตี 4 ให้เรียกใหม่                        
                        $Fetch = true;
                    } else { //echo "www";
                        return $getS40OldAge[1];
                    }
                    break;
                case -1:
                    if ((int)$callh->format('H') < 4) {
                        //ถ้าเป็นเมื่อวานและเคยเรียกก่อน ตี 4 ให้เรียกใหม่
                        $Fetch  = true;
                    } else {
                        return $getS40OldAge[1];
                    }
                    break;
                default:
                    $Fetch  = true;
                    break;
            }
        } else {
            $Fetch  = true;
        }

        if ($Fetch == True) {
            $param = [
                'cmd' => 'getS40OldAge',
                'ssoNo' => $ssoNo,
                'callerid' => $this->callerid(),
            ];

            $url = $this->url_eservice();
            $header = array(
                'Content-Type: application/x-www-form-urlencoded',
                'user_token: ' . $this->user_token()
            );
            $getinfo = $this->calleservice($url, $header, $param);
            if ($getinfo) {
                //var_dump($getinfo);
                $m->set('getS40OldAge' . $ssoNo, [date("Y-m-d H:i:s"), $getinfo], 86400); // หมดอายุ 1 วัน
                return $getinfo;
            } else {
                return [
                    'code' => 'WS500',
                ];
            }
        }

        return [
            'code' => 'WS003',
        ];

        return [
            "code" => "WS000",
            "sumAmtSenility" => "1550.00",
            "sumAmtSenilityExtra" => "0.00",
            "detail" => [
                [
                    "conYear" => "2560",
                    "amtSenility" => "100.00",
                    "amtSenilityExtra" => "0.00"
                ],
                [
                    "conYear" => "2561",
                    "amtSenility" => "350.00",
                    "amtSenilityExtra" => "0.00"
                ],
                [
                    "conYear" => "2562",
                    "amtSenility" => "150.00",
                    "amtSenilityExtra" => "0.00"
                ],
                [
                    "conYear" => "2563",
                    "amtSenility" => "600.00",
                    "amtSenilityExtra" => "0.00"
                ],
                [
                    "conYear" => "2564",
                    "amtSenility" => "350.00",
                    "amtSenilityExtra" => "0.00"
                ]
            ]
        ];
    }
    //ข้อมูลสิทธิ์ประโยชน์มาตรา 40
    function getS40BenefitHistory()
    {
        $ssoNo = null;
        if (!empty($_REQUEST['ssoNo'])) $ssoNo = $_REQUEST['ssoNo'];
        if (is_null($ssoNo)) {
            return [
                'code' => 'WS003',
            ];
        }
        $year = null;
        if (!empty($_REQUEST['year'])) $year = $_REQUEST['year'];
        if (is_null($year)) {
            return [
                'code' => 'WS003',
            ];
        }


        $m = new \Memcached();
        $m->addServer('localhost', 11211);
        $Fetch  = False;

        $getS40BenefitHistory = $m->get('getS40BenefitHistory' . $ssoNo . $year);
        if ($getS40BenefitHistory) {

            $today = new \DateTime("today"); // This object represents current date/time with time set to midnight

            $match_date = \DateTime::createFromFormat("Y-m-d H:i:s", $getS40BenefitHistory[0]);
            $match_date->setTime(0, 0, 0); // set time part to midnight, in order to prevent partial comparison

            $diff = $today->diff($match_date);
            $diffDays = (int)$diff->format("%R%a"); // Extract days count in interval

            $callh = \DateTime::createFromFormat("Y-m-d H:i:s", $getS40BenefitHistory[0]);

            switch ($diffDays) {
                case 0:
                    if ((int)$callh->format('H') < 4 && (int)date("H") >= 4) {
                        //ถ้าเป็นวันที่ปัจจุบันและเคยเรียกก่อน ตี 4 ให้เรียกใหม่                        
                        $Fetch = true;
                    } else { //echo "www";
                        return $getS40BenefitHistory[1];
                    }
                    break;
                case -1:
                    if ((int)$callh->format('H') < 4) {
                        //ถ้าเป็นเมื่อวานและเคยเรียกก่อน ตี 4 ให้เรียกใหม่
                        $Fetch  = true;
                    } else {
                        return $getS40BenefitHistory[1];
                    }
                    break;
                default:
                    $Fetch  = true;
                    break;
            }
        } else {
            $Fetch  = true;
        }

        if ($Fetch == True) {

            $param = [
                'cmd' => 'getS40BenefitHistory',
                'ssoNo' => $ssoNo,
                'callerid' => $this->callerid(),
                'year' => $year
            ];

            $url = $this->url_eservice();
            $header = array(
                'Content-Type: application/x-www-form-urlencoded',
                'user_token: ' . $this->user_token()
            );
            $getinfo = $this->calleservice($url, $header, $param);
            if ($getinfo) {
                //var_dump($getinfo);
                $m->set('getS40BenefitHistory' . $ssoNo . $year, [date("Y-m-d H:i:s"), $getinfo], 86400); // หมดอายุ 1 วัน
                return $getinfo;
            } else {
                return [
                    'code' => 'WS500',
                ];
            }
        }

        return [
            'code' => 'WS003',
        ];

        return [
            "code" => "WS000",
            "lastIncremental" => null,
            "detail" => [
                [
                    "paymentDate" => "29/12/2557",
                    "benefitDesc" => "ประสบอันตราย/เจ็บป่วย",
                    "payAmount" => "1800.00",
                    "paymentMethosDesc" => null,
                    "requestDate" => "29/12/2557",
                    "payStatusDesc" => "จ่ายเงินแล้ว"
                ]
            ]
        ];
    }

    //ยื่นแบบขอเปลี่ยนสถานพยาบาล - ตรวจสอบเงื่อนไขก่อนบันทึก
    function getInitSelectHospital()
    {

        $ssoNo = null;
        if (!empty($_REQUEST['ssoNo'])) $ssoNo = $_REQUEST['ssoNo'];
        if (is_null($ssoNo)) {
            return [
                'code' => 'WS003',
            ];
        }

        /*
        $m = new \Memcached();
        $m->addServer('localhost', 11211);
        $Fetch  = False;

        //$m->delete('getInitSelectHospital' . $ssoNo );exit;

        $getInitSelectHospital = $m->get('getInitSelectHospital' . $ssoNo);
        if ($getInitSelectHospital) {

            $today = new \DateTime("today"); // This object represents current date/time with time set to midnight

            $match_date = \DateTime::createFromFormat("Y-m-d H:i:s", $getInitSelectHospital[0]);
            $match_date->setTime(0, 0, 0); // set time part to midnight, in order to prevent partial comparison

            $diff = $today->diff($match_date);
            $diffDays = (int)$diff->format("%R%a"); // Extract days count in interval

            $callh = \DateTime::createFromFormat("Y-m-d H:i:s", $getInitSelectHospital[0]);

            switch ($diffDays) {
                case 0:
                    if ((int)$callh->format('H') < 4 && (int)date("H") >= 4) {
                        //ถ้าเป็นวันที่ปัจจุบันและเคยเรียกก่อน ตี 4 ให้เรียกใหม่                        
                        $Fetch = true;
                    } else { //echo "www";
                        return $getInitSelectHospital[1];
                    }
                    break;
                case -1:
                    if ((int)$callh->format('H') < 4) {
                        //ถ้าเป็นเมื่อวานและเคยเรียกก่อน ตี 4 ให้เรียกใหม่
                        $Fetch  = true;
                    } else {
                        return $getInitSelectHospital[1];
                    }
                    break;
                default:
                    $Fetch  = true;
                    break;
            }
        } else {
            $Fetch  = true;
        }*/

        $Fetch  = true;
        if ($Fetch == True) {

            $param = [
                'cmd' => 'getInitSelectHospital',
                //'ssoNo' => $ssoNo,
                'callerid' => $this->callerid(),
            ];

            $url = $this->url_eservice();
            $header = array(
                'Content-Type: application/x-www-form-urlencoded',
                'user_token: ' . $this->user_token()
            );
            $getinfo = $this->calleservice($url, $header, $param); //var_dump($getinfo);exit;
            if ($getinfo) {
                //var_dump($getinfo);
                //$m->set('getInitSelectHospital' . $ssoNo, [date("Y-m-d H:i:s"), $getinfo], 86400); // หมดอายุ 1 วัน
                return $getinfo;
            } else {
                return [
                    'code' => 'WS500',
                ];
            }
        }

        return [
            'code' => 'WS003',
        ];
    }

    //ยื่นแบบขอเปลี่ยนสถานพยาบาล - ส่งบันทึก
    function saveSelectHospital()
    {

        $ssoNo = null;
        if (!empty($_POST['ssoNo'])) $ssoNo = $_POST['ssoNo'];
        if (is_null($ssoNo)) {
            return [
                'code' => 'WS003',
            ];
        }
        $hospitalCode1 = NULL;
        if (!empty($_POST['hospitalCode1'])) $hospitalCode1 = $_POST['hospitalCode1'];
        if (is_null($hospitalCode1)) {
            return [
                'code' => 'WS003',
            ];
        }
        $changeReason = NULL;
        if (!empty($_POST['changeReason'])) $changeReason = $_POST['changeReason'];
        if (is_null($changeReason)) {
            return [
                'code' => 'WS003',
            ];
        }

        $param = [
            'cmd' => 'saveSelectHospital',
            //'ssoNo' => $ssoNo,
            'callerid' => $this->callerid(),
            'hospitalCode1' => $hospitalCode1,
            'mobile' => '',
            'changeReason' => $changeReason,
        ];

        $url = $this->url_eservice();
        $header = array(
            'Content-Type: application/x-www-form-urlencoded',
            'user_token: ' . $this->user_token()
        );
        $getinfo = $this->calleservice($url, $header, $param); //var_dump($getinfo);exit;
        if ($getinfo) {
            $conn = Yii::$app->logdb;
            $transaction = $conn->beginTransaction();
            try {

                $sql = "
                insert into log_useractivity (
                    `log_card_id`,
                    `log_line_id`,
                    `log_ip`,
                    `log_action`,
                    `log_description`,
                    `createdate`
                  )
                  values
                    (
                      :log_card_id,
                      :log_line_id,
                      :log_ip,
                      :log_action,
                      :log_description,
                      NOW()
                    );
                ";

                $command = $conn->createCommand($sql);
                $command->bindValue(":log_card_id", $ssoNo);
                $command->bindValue(":log_line_id", "");
                $command->bindValue(":log_ip", $_SERVER['REMOTE_ADDR']);
                $command->bindValue(":log_action", "Change_Hospital");
                $results = print_r($getinfo, true);
                $command->bindValue(":log_description", "เปลี่ยนโรงพยาบาล hospitalCode1 " . $hospitalCode1 . " changeReason " . $changeReason . " Return " .  $results);
                $x = $command->execute();

                $transaction->commit();
            } catch (\Exception $e) {
                \Yii::warning($e->getMessage(), 'application');
                $transaction->rollBack();
            }

            return $getinfo;
        } else {
            return [
                'code' => 'WS500',
            ];
        }

        return [
            'code' => 'WS003',
        ];
    }

    //ประวัติเปลี่ยนโรงพยาบาล
    function ChangeHospital()
    {

        $ssoNo = null;
        if (!empty($_REQUEST['ssoNo'])) $ssoNo = $_REQUEST['ssoNo'];
        if (is_null($ssoNo)) {
            return [
                'code' => 'WS003',
            ];
        }

        $m = new \Memcached();
        $m->addServer('localhost', 11211);
        $Fetch  = False;

        $ChangeHospital = $m->get('ChangeHospital' . $ssoNo);
        if ($ChangeHospital) {

            $today = new \DateTime("today"); // This object represents current date/time with time set to midnight

            $match_date = \DateTime::createFromFormat("Y-m-d H:i:s", $ChangeHospital[0]);
            $match_date->setTime(0, 0, 0); // set time part to midnight, in order to prevent partial comparison

            $diff = $today->diff($match_date);
            $diffDays = (int)$diff->format("%R%a"); // Extract days count in interval

            $callh = \DateTime::createFromFormat("Y-m-d H:i:s", $ChangeHospital[0]);

            switch ($diffDays) {
                case 0:
                    if ((int)$callh->format('H') < 4 && (int)date("H") >= 4) {
                        //ถ้าเป็นวันที่ปัจจุบันและเคยเรียกก่อน ตี 4 ให้เรียกใหม่                        
                        $Fetch = true;
                    } else { //echo "www";
                        return $ChangeHospital[1];
                    }
                    break;
                case -1:
                    if ((int)$callh->format('H') < 4) {
                        //ถ้าเป็นเมื่อวานและเคยเรียกก่อน ตี 4 ให้เรียกใหม่
                        $Fetch  = true;
                    } else {
                        return $ChangeHospital[1];
                    }
                    break;
                default:
                    $Fetch  = true;
                    break;
            }
        } else {
            $Fetch  = true;
        }

        if ($Fetch == True) {

            $client = new \SoapClient("https://wsg.sso.go.th/services/ChangeHospital?WSDL");

            $params = array(
                "username" => 'line_official',
                "password" => 'NK0B6ZGU',
                "ssoNum" => $ssoNo,
            );

            $response = $client->__soapCall('getServ02', $params);

            if ($response) {
                //var_dump($response);
                $m->set('ChangeHospital' . $ssoNo, [date("Y-m-d H:i:s"), $response], 86400); // หมดอายุ 1 วัน
                return $response;
            } else {
                return [
                    'code' => 'WS500',
                ];
            }
        }
    }

    //ประวัติการทำธุรกรรมผ่านระบบอิเล็กทรอนิกส์
    function listTransaction()
    {

        $ssoNo = null;
        if (!empty($_REQUEST['ssoNo'])) $ssoNo = $_REQUEST['ssoNo'];
        if (is_null($ssoNo)) {
            return [
                'code' => 'WS003',
            ];
        }

        $year = null;
        if (!empty($_REQUEST['year'])) $year = $_REQUEST['year'];
        if (is_null($year)) {
            return [
                'code' => 'WS003',
            ];
        }

        $txnType = null;
        if (!empty($_REQUEST['txnType'])) $txnType = $_REQUEST['txnType'];
        if (is_null($txnType)) {
            return [
                'code' => 'WS003',
            ];
        }

        /*
          $m = new \Memcached();
          $m->addServer('localhost', 11211);
          $Fetch  = False;
  
          //$m->delete('getInitSelectHospital' . $ssoNo );exit;
  
          $getInitSelectHospital = $m->get('getInitSelectHospital' . $ssoNo);
          if ($getInitSelectHospital) {
  
              $today = new \DateTime("today"); // This object represents current date/time with time set to midnight
  
              $match_date = \DateTime::createFromFormat("Y-m-d H:i:s", $getInitSelectHospital[0]);
              $match_date->setTime(0, 0, 0); // set time part to midnight, in order to prevent partial comparison
  
              $diff = $today->diff($match_date);
              $diffDays = (int)$diff->format("%R%a"); // Extract days count in interval
  
              $callh = \DateTime::createFromFormat("Y-m-d H:i:s", $getInitSelectHospital[0]);
  
              switch ($diffDays) {
                  case 0:
                      if ((int)$callh->format('H') < 4 && (int)date("H") >= 4) {
                          //ถ้าเป็นวันที่ปัจจุบันและเคยเรียกก่อน ตี 4 ให้เรียกใหม่                        
                          $Fetch = true;
                      } else { //echo "www";
                          return $getInitSelectHospital[1];
                      }
                      break;
                  case -1:
                      if ((int)$callh->format('H') < 4) {
                          //ถ้าเป็นเมื่อวานและเคยเรียกก่อน ตี 4 ให้เรียกใหม่
                          $Fetch  = true;
                      } else {
                          return $getInitSelectHospital[1];
                      }
                      break;
                  default:
                      $Fetch  = true;
                      break;
              }
          } else {
              $Fetch  = true;
          }*/

        $Fetch  = true;
        if ($Fetch == True) {

            $param = [
                'cmd' => 'listTransaction',
                //'ssoNo' => $ssoNo,
                'callerid' => $this->callerid(),
                'year' => $year,
                'txnType' => $txnType

            ];

            $url = $this->url_eservice();
            $header = array(
                'Content-Type: application/x-www-form-urlencoded',
                'user_token: ' . $this->user_token()
            );
            $getinfo = $this->calleservice($url, $header, $param); //var_dump($getinfo);exit;
            if ($getinfo) {
                //var_dump($getinfo);
                //$m->set('getInitSelectHospital' . $ssoNo, [date("Y-m-d H:i:s"), $getinfo], 86400); // หมดอายุ 1 วัน
                return $getinfo;
            } else {
                return [
                    'code' => 'WS500',
                ];
            }
        }

        return [
            'code' => 'WS003',
        ];
    }

    //ยกเลิกธุรกรรมที่ทำผ่านระบบอิเล็กทรอนิกส์
    function cancelTransaction()
    {
        $ssoNo = null;
        if (!empty($_REQUEST['ssoNo'])) $ssoNo = $_REQUEST['ssoNo'];
        if (is_null($ssoNo)) {
            return [
                'code' => 'WS003',
            ];
        }

        $txnNo = null;
        if (!empty($_REQUEST['txnNo'])) $txnNo = $_REQUEST['txnNo'];
        if (is_null($txnNo)) {
            return [
                'code' => 'WS003',
            ];
        }

        $param = [
            'cmd' => 'cancelTransaction',
            //'ssoNo' => $ssoNo,
            'callerid' => $this->callerid(),
            'txnNo' => $txnNo

        ];

        $url = $this->url_eservice();
        $header = array(
            'Content-Type: application/x-www-form-urlencoded',
            'user_token: ' . $this->user_token()
        );
        $getinfo = $this->calleservice($url, $header, $param); //var_dump($getinfo);exit;
        if ($getinfo) {
            $conn = Yii::$app->logdb;
            $transaction = $conn->beginTransaction();
            try {

                $sql = "
                  insert into log_useractivity (
                      `log_card_id`,
                      `log_line_id`,
                      `log_ip`,
                      `log_action`,
                      `log_description`,
                      `createdate`
                    )
                    values
                      (
                        :log_card_id,
                        :log_line_id,
                        :log_ip,
                        :log_action,
                        :log_description,
                        NOW()
                      );
                  ";

                $command = $conn->createCommand($sql);
                $command->bindValue(":log_card_id", $ssoNo);
                $command->bindValue(":log_line_id", "");
                $command->bindValue(":log_ip", $_SERVER['REMOTE_ADDR']);
                $command->bindValue(":log_action", "Cencel_Change_Hospital");
                $results = print_r($getinfo, true);
                $command->bindValue(":log_description", "ยกเลิกธุรกรรมที่ทำผ่านระบบอิเล็กทรอนิกส์ หมายเลข " . $txnNo . " Return " .  $results);
                $x = $command->execute();

                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
            }
            return $getinfo;
        } else {
            return [
                'code' => 'WS500',
            ];
        }
    }

    public function actionAuth($username = "", $password = "", $lineid = "Uf491d3ed8619785f4340b08676d2af8c", $lineimg = "")
    {
        Yii::$app->response->format = Response::FORMAT_JSON;


        //$username = null;
        if (!empty($_REQUEST['username'])) $username = $_REQUEST['username'];
        if (is_null($username)) {
            return [
                'code' => 'WS003',
            ];
        }
        //$password = null;
        if (!empty($_REQUEST['password'])) $password = $_REQUEST['password'];
        if (is_null($password)) {
            return [
                'code' => 'WS003',
            ];
        }

        //$lineid = "Uf491d3ed8619785f4340b08676d2af8c";
        if (!empty($_REQUEST['lineid'])) $lineid = $_REQUEST['lineid'];
        if (is_null($lineid) || $lineid == "") {
            return [
                'code' => 'WS003',
            ];
        }
        //$lineimg = "";
        if (!empty($_REQUEST['lineimg'])) $lineimg = $_REQUEST['lineimg'];
        if (is_null($lineimg) || $lineimg == "") {
            return [
                'code' => 'WS003',
            ];
        }

        //$url = 'https://idp04uat.sso.go.th/auth/realms/insured/protocol/openid-connect/token';
        //$url = 'https://idp04.sso.go.th/auth/realms/insured/protocol/openid-connect/token';
        $url = $this->url_idpauth();
        $header = array(
            'Content-Type: application/x-www-form-urlencoded',
            //'Authorization: Basic bGluZWFwcDo1ZGZjYTRhMy00MmIyLTQwNDctOGZiNi01MWFhYWU5ZTU3OWQ=',
            'Authorization: ' . $this->idp_Authorization()
        );

        // Few
        //$username = "1679900183277";
        //$password = "Kafewzz007";

        //Niras
        //$username = "3470800335083";
        //$password = "4xgmyu21";
        /*
        //Jia
        $username = "3101800062625";
        $password = "02032517";
        */

        /*
        //  fix ไว้ให้ login ได้เฉพาะบัตรประชาชนนี้
        $arrAllow = [
            "1679900183277", //ฟิวส์
            "3470800335083",
            "3101800062625", // พี่เจี๋ย
            "1669800097301", //เพื่อนฟิวส์
            "3650600200867", //แม่ฟิวส์
            "3101600563299", //um
            "3150400234720", //pepe
            "1409900370711", //genadd march
            "1571100085584", //kapook
            "1800600109195", //nui
        ];
        if (!in_array($username, $arrAllow)) {
            return [
                'code' => 'WS003',
            ];
        }*/


        $param = array(
            'username' => $username,
            'password' => $password,
            'grant_type' => 'password',
        );

        $data = $this->calleservice($url, $header, $param);

        //var_dump($data);
        //exit;
        if ($data) {

            if (array_key_exists("error", $data)) {
                if (array_key_exists("error_description", $data)) {
                    return [
                        'code' => 'WS001',
                        'description' => $data['error_description'],
                    ];
                } else {
                    return [
                        'code' => 'WS001',
                        'description' => 'unknown_error',
                    ];
                }
            }

            foreach ($data as $key => $value) {
            }

            $access_token = $data['access_token'];
            $user_token = "Bearer " . $access_token;
            //$ssoNum = $data['ssoNum'];

            $m = new \Memcached();
            $m->addServer('localhost', 11211);
            $getPersonInfo = $m->get('getPersonInfo' . $username);
            if ($getPersonInfo) {
                $getinfo = $getPersonInfo[1];
            } else {

                $param = [
                    'cmd' => 'getPersonInfo',
                    'ssoNo' => $username,
                    'callerid' => 'line',
                ];

                //$url = 'https://uatwsg.sso.go.th/esv/esvews/service';
                $url = $this->url_eservice();
                $header = array(
                    'Content-Type: application/x-www-form-urlencoded',
                    'user_token: ' . $user_token
                );
                $getinfo = $this->calleservice($url, $header, $param);

                //$m->set('getPersonInfo' . $username, [date("Y-m-d H:i:s"), $getinfo], 3600); //หมดอายุ 1 ชั่วโมง
            }


            if ($getinfo) {
                //var_dump($getinfo);exit;

                if (array_key_exists("code", $getinfo)) {
                    if ($getinfo['code'] == "WS000") {

                        $conn = Yii::$app->db;
                        $sql = "SELECT name FROM mas_ssobranch WHERE ssobranch_code = :ssobranch_code ";
                        $rows = $conn->createCommand($sql)->bindValue('ssobranch_code', $getinfo['person']['ssoBranch'])->queryAll();
                        if (count($rows) > 0) {
                            $getinfo['person']['branchname'] = $rows[0]['name'];
                        }
                        $m->set('getPersonInfo' . $username, [date("Y-m-d H:i:s"), $getinfo], 3600); //หมดอายุ 1 ชั่วโมง

                        $person = $getinfo['person'];
                        $titleCodeDesc = $person['titleCodeDesc'];
                        $firstName = $person['firstName'];
                        $lastName = $person['lastName'];
                        $activeStatusDesc = $person['activeStatusDesc'];
                        $activeStatus = $person['activeStatus'];
                        $ssoBranch = $person['ssoBranch'];
                        $section = preg_replace('/[^0-9]/', '', $activeStatusDesc);

                        /*
                        ACTIVE_STATUS_33 = "A";
                        ACTIVE_STATUS_38 = "T";
                        ACTIVE_STATUS_39 = "V";
                        ACTIVE_STATUS_40 = "F";
                        ACTIVE_STATUS_R  = "R";  // สถานะลาออก
                        */

                        switch (strtolower($activeStatus)) {
                            case strtolower("A"):
                                $section = 1;
                                break;
                            case strtolower("T"):
                                $section = 2;
                                break;
                            case strtolower("V"):
                                $section = 3;
                                break;
                            case strtolower("F"):
                                $section = 4;
                                break;
                            case strtolower("R"):
                                $section = 5;
                                break;
                        }
                        //$branchcode = $person["ssoNo"] ?? null;
                        //$branchcode = 1000;

                        $model = new LineAction();
                        $model->uid = $username;
                        $model->upassword = $password;
                        $model->section = $section;
                        $model->branchcode = $ssoBranch;
                        $model->firstName = $firstName;
                        $model->lastName = $lastName;

                        $model->lineID = $lineid;
                        $model->lineImage = $lineimg;

                        $rows = $model->Check_sso_user();

                        //IPD
                        $model->access_token = $access_token;
                        $model->expires_in = $data['expires_in'];
                        $model->refresh_token = $data['refresh_token'];
                        $model->refresh_expires_in = $data['refresh_expires_in'];

                        if (count($rows) > 0) {
                            $id_sso = $rows[0]['su_id'];
                            $model->uid_no = $id_sso;


                            if ($model->update_sso_user()) {
                                if ($model->sso_user_setloginstate()) {
                                    \app\models\CommonAction::AddUserLoginLog($id_sso, "Login", "ok");

                                    $this->linkmenutouser($id_sso, $section, $ssoBranch, $lineid);

                                    $this->setaccess_token($access_token);
                                    return [
                                        'code' => 'WS000',
                                        'section' => $activeStatus,
                                    ];
                                } else {

                                    $log_page = basename('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                                    $log_page = basename(Yii::$app->request->referrer);

                                    $log_description = 'Set state login <br/>';
                                    $log_description .= 'SSO ID : ' . $id_sso  . ' <br/>';
                                    $log_description .= "ไม่สำเร็จสถานะ " . Yii::$app->session['setloginstate'];

                                    \app\models\CommonAction::AddUserEventLog($id_sso, "Update", $log_page, $log_description);
                                    Yii::$app->session->remove('setloginstate');
                                }
                                //return $this->chkPDPA($username); //ไม่ใช้เพราะเก็บข้อมูลทั้งหมดแล้วค่อยถาม
                            };
                        } else {
                            $lastid_sso = $model->Add_sso_user();
                            if ($lastid_sso) {
                                $model->uid_no = $lastid_sso;
                                if ($model->sso_user_setloginstate()) {
                                    \app\models\CommonAction::AddUserLoginLog($lastid_sso, "Login", "ok");
                                    $this->linkmenutouser($lastid_sso, $section, $ssoBranch, $lineid);
                                    $this->setaccess_token($access_token);
                                    return [
                                        'code' => 'WS000',
                                        'section' => $activeStatus,
                                    ];
                                } else {
                                    $log_page = basename('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                                    $log_page = basename(Yii::$app->request->referrer);

                                    $log_description = 'Set state login <br/>';
                                    $log_description .= 'SSO ID : ' . $lastid_sso  . ' <br/>';
                                    $log_description .= "ไม่สำเร็จสถานะ " . Yii::$app->session['setloginstate'];

                                    \app\models\CommonAction::AddUserEventLog($lastid_sso, "Update", $log_page, $log_description);
                                    Yii::$app->session->remove('setloginstate');
                                }
                                //return $this->chkPDPA($username); //ไม่ใช้เพราะเก็บข้อมูลทั้งหมดแล้วค่อยถาม
                            }
                        }
                    } else {
                        return [
                            'code' => 'WS006',
                            'description' => 'Data not found',
                        ];
                    }
                }
            } else {
                return [
                    'code' => 'WS001',
                    'description' => 'Invalid callid or authen failed',
                ];
            }
        } else {
            return [
                'code' => 'WS500',
                'description' => 'IDP server not response',
            ];
        }

        exit;
        return [
            'code' => 'WS500',
        ];

        return [
            'code' => 'WS000',
            'ssoNum' => '1729900066822',
        ];

        return [
            'code' => 'WS006',
        ];
    }

    public function actionLogout($ssoNo = "")
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        //$username = null;
        if (!empty($_REQUEST['ssoNo'])) $username = $_REQUEST['ssoNo'];
        if (is_null($username)) {
            return [
                'code' => 'WS003',
            ];
        }

        $conn = Yii::$app->db;

        $sql = "
        SELECT su_id,li_line_id
        FROM
        mas_sso_user
        INNER JOIN tran_line_id
            ON(
            mas_sso_user.su_id = tran_line_id.li_user_id
            )
        WHERE mas_sso_user.su_idcard =:su_idcard ;
        ";
        $command = $conn->createCommand($sql);
        $command->bindValue(":su_idcard", $username);
        $rs = $command->queryAll();
        if (count($rs) == 0) {
            return [
                'code' => 'WS003',
            ];
        }
        $id_sso = $rs[0]['su_id'];
        $li_line_id = $rs[0]['li_line_id'];

        $sql = "
        DELETE tran_ssoid_state FROM tran_ssoid_state 
        INNER JOIN mas_sso_user
            ON (
            tran_ssoid_state.id_sso = mas_sso_user.su_id
            )
        WHERE mas_sso_user.su_idcard = :su_idcard ;
        ";

        $sql = "
        UPDATE tran_ssoid_state SET access_token='', access_token_expire=NOW(), refresh_token='', refresh_token_expire=NOW()
        WHERE id_sso=:id_sso
        ";
        $command = $conn->createCommand($sql);
        $command->bindValue(":id_sso", $id_sso);
        $command->execute();

        $sql = "SELECT id, menuid FROM trn_richmenu WHERE setdefault = 1;";
        $command = $conn->createCommand($sql);
        $rs = $command->queryAll();
        if (count($rs) > 0) {
            $menuid = $rs[0]['menuid'];
            $rich = new RichmenuAction;
            $rich->userid = $li_line_id;
            $rich->richmenuid = $menuid;
            $resrich =  $rich->linkmenutouser();

            if (!$resrich) {
                $log_page = basename('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                $log_page = basename(Yii::$app->request->referrer);

                $log_description = 'Set richmenu to lineid after logout <br/>';
                $log_description .= 'SSO ID : ' . $id_sso  . ' <br/>';
                $log_description .= 'Line ID : ' . $li_line_id  . ' <br/>';
                $log_description .= "ไม่สำเร็จสถานะ " . Yii::$app->session['error_LinkRichMenuToUser'];

                \app\models\CommonAction::AddUserEventLog($id_sso, "Insert", $log_page, $log_description);
                Yii::$app->session->remove('error_LinkRichMenuToUser');
                return [
                    'code' => 'WS000',
                ];
            } else {
                $conn = Yii::$app->db;
                $sql = "UPDATE tran_line_id SET currichmenu=:currichmenu WHERE li_user_id=:li_user_id";

                $command = $conn->createCommand($sql);
                $command->bindValue(":currichmenu", $rs[0]['id']);
                $command->bindValue(":li_user_id", $id_sso);
                $command->execute();
                return [
                    'code' => 'WS000',
                ];
            }
        } else {
            return [
                'code' => 'WS000',
            ];
        }
    }
    private function linkmenutouser($id_sso, $section, $branchcode, $lineid)
    {

        $sql = "SELECT * FROM trn_richmenu_custom_view WHERE section_type IN() AND ssobranch IN() AND Status=1 ORDER BY create_date DESC;";

        $conn = Yii::$app->db;

        $sql = "
        SELECT menuid, trn_richmenu.id 
        FROM
        trn_richmenu
        INNER JOIN trn_richmenu_custom_view
            ON (
            `trn_richmenu`.`id` = `trn_richmenu_custom_view`.`menu_id`
            )
        WHERE section_type REGEXP :section_type AND ssobranch REGEXP :ssobranch AND trn_richmenu.status=1 and menuid is not null ORDER BY trn_richmenu_custom_view.create_date DESC limit 1;

        ";
        $command = $conn->createCommand($sql);
        $command->bindValue(":section_type", $section);
        $command->bindValue(":ssobranch", $branchcode);
        $rs = $command->queryAll();
        if (count($rs) > 0) {
            $menuid = $rs[0]['menuid'];
            $rich = new RichmenuAction;
            $rich->userid = $lineid;
            $rich->richmenuid = $menuid;
            $resrich =  $rich->linkmenutouser();

            if (!$resrich) {
                $log_page = basename('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                $log_page = basename(Yii::$app->request->referrer);

                $log_description = 'Set richmenu to lineid after login <br/>';
                $log_description .= 'SSO ID : ' . $id_sso  . ' <br/>';
                $log_description .= 'Line ID : ' . $lineid  . ' <br/>';
                $log_description .= "ไม่สำเร็จสถานะ " . Yii::$app->session['error_LinkRichMenuToUser'];

                \app\models\CommonAction::AddUserEventLog($id_sso, "Insert", $log_page, $log_description);
                Yii::$app->session->remove('error_LinkRichMenuToUser');
            } else {
                $conn = Yii::$app->db;
                $sql = "UPDATE tran_line_id SET currichmenu=:currichmenu WHERE li_user_id=:li_user_id";

                $command = $conn->createCommand($sql);
                $command->bindValue(":currichmenu", $rs[0]['id']);
                $command->bindValue(":li_user_id", $id_sso);
                $command->execute();
            }
        }
    }


    public function actionAuthauto($username = '', $password = '')
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        echo "{$username} comes from {$password}";
    }

    public function actionAuthtoken($ssoNo = "")
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        //$ssoNo = null;
        if (!empty($_REQUEST['ssoNo'])) $ssoNo = $_REQUEST['ssoNo'];
        if (is_null($ssoNo)) {
            return [
                'code' => 'WS003',
            ];
        }

        $sql = "
        SELECT IFNULL(TIMESTAMPDIFF(SECOND, NOW(),access_token_expire), '-1') AS access_left,
            IFNULL(TIMESTAMPDIFF(SECOND, NOW(),refresh_token_expire), '-1') AS refresh_left,  
            su_id, su_idcard, li_line_id , li_img, password, access_token, refresh_token
        FROM
        tran_ssoid_state
        INNER JOIN mas_sso_user
            ON (
            tran_ssoid_state.id_sso = mas_sso_user.su_id
            )
        INNER JOIN tran_line_id
            ON(
            tran_ssoid_state.id_sso = tran_line_id.li_user_id
            )
        where mas_sso_user.su_idcard =:su_idcard;
        ";

        $conn = Yii::$app->db;
        $command = $conn->createCommand($sql);
        $command->bindValue(":su_idcard", $ssoNo);
        $rs = $command->queryAll();
        if (count($rs) > 0) {

            $access_left = $rs[0]['access_left'];
            if ($access_left > 2) { //เหลือเวลาหมดอายุมากกว่า 2 วินาที
                //$url = 'https://idp04uat.sso.go.th/auth/realms/insured/protocol/openid-connect/token/introspect';
                $url = $this->url_idpauthaccess();
                $header = array(
                    //'Authorization: Basic ZS1zZXJ2aWNlOmVhYzBkNGY5LTlhODMtNDhjMC05ZjA3LWVjYTkzOWQxOTM1Mg==',
                    'Authorization: ' . $this->idp_Authorization(),
                    'Content-Type: application/x-www-form-urlencoded'
                );
                $param = array(
                    'token' => $rs[0]['access_token'],
                );

                $data = $this->calleservice($url, $header, $param);

                if ($data) {
                    //var_dump($data);

                    if (array_key_exists("active", $data)) {
                        if ($data['active']) {
                            $this->setaccess_token($rs[0]['access_token']);
                            return [
                                'code' => 'WS000',
                                'access_token' => $rs[0]['access_token'],
                            ];
                        }
                    }
                }
            }

            $refresh_left = $rs[0]['refresh_left'];
            $id_sso = $rs[0]['su_id'];

            //echo $refresh_left;exit;

            //$left_second = 19;
            if ($refresh_left < 20) {
                //เหลืออีก 20 วินาที ก่อนจะหมดอายุ
                if ($refresh_left < 2) {
                    //เหลืออีก 2 วิ ส่งไป login auto
                    $ePassword = $rs[0]['password'];
                    $encryption_key = Yii::$app->params['auth']['crypter']['encryption_key'];
                    $password = Yii::$app->getSecurity()->decryptByPassword(utf8_decode($ePassword), $encryption_key);
                    //echo $password;exit;

                    $res =  $this->actionAuth($rs[0]['su_idcard'], $password, $rs[0]['li_line_id'],  $rs[0]['li_img']);

                    if (array_key_exists("code", $res)) {
                        if ($res['code'] = "WS000") {
                            return [
                                'code' => 'WS000',
                                'access_token' => $this->getaccess_token(),
                            ];
                        }
                    }
                    return $res;
                    //var_dump($res);
                    //exit;
                } else {
                    // เหลือมากกว่า หรือเท่ากับ 2 วิ ส่งไป refresh token

                    $refresh_token = $rs[0]['refresh_token'];
                    //$url = 'https://idp04uat.sso.go.th/auth/realms/insured/protocol/openid-connect/token';
                    $url = $this->url_idpauthrefresh();
                    $header = array(
                        'Content-Type: application/x-www-form-urlencoded',
                        //'Authorization: Basic bGluZWFwcDo1ZGZjYTRhMy00MmIyLTQwNDctOGZiNi01MWFhYWU5ZTU3OWQ=',
                        'Authorization: ' . $this->idp_Authorization()
                    );
                    $param = array(
                        'refresh_token' => $refresh_token,
                        'grant_type' => 'refresh_token',
                    );

                    $data = $this->calleservice($url, $header, $param);

                    if ($data) {

                        if (array_key_exists("error", $data)) {
                            return [
                                'code' => 'WS001',
                                'description' => $data['error_description'],
                            ];
                        }

                        $access_token = $data['access_token'];

                        $model = new LineAction();

                        //IPD
                        $model->uid_no =  $id_sso;
                        $model->access_token = $access_token;
                        $model->expires_in = $data['expires_in'];
                        $model->refresh_token = $data['refresh_token'];
                        $model->refresh_expires_in = $data['refresh_expires_in'];

                        if ($model->sso_user_setloginstate()) {
                            \app\models\CommonAction::AddUserLoginLog($id_sso, "verify refresh token", "ok");

                            return [
                                'code' => 'WS000',
                                'access_token' => $data['access_token'],
                            ];
                        } else {

                            $log_page = basename('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                            $log_page = basename(Yii::$app->request->referrer);

                            $log_description = 'verify refresh token <br/>';
                            $log_description .= 'SSO ID : ' . $id_sso  . ' <br/>';
                            $log_description .= "ไม่สำเร็จสถานะ " . Yii::$app->session['setloginstate'];

                            \app\models\CommonAction::AddUserEventLog($id_sso, "Update", $log_page, $log_description);
                            Yii::$app->session->remove('setloginstate');

                            return [
                                'code' => 'WS500',
                                'description' => 'authen failed',
                            ];
                        }
                    } else {
                        return [
                            'code' => 'WS500',
                            'description' => 'IDP server not response',
                        ];
                    }
                }
            } else {
                $this->setaccess_token($rs[0]['access_token']);
                return [
                    'code' => 'WS000',
                    'access_token' => $rs[0]['access_token'],
                ];
            }
        } else {
            //ไม่มี user ในระบบ
            return [
                'code' => 'WS500',
                'description' => 'authen failed',
            ];
        }
        exit;
    }

    function calleservice($url, $header, $param)
    {

        $postdata = http_build_query(
            $param
        );

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            //CURLOPT_TIMEOUT => 0, // timeout ไม่จำกัด
            CURLOPT_TIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSLVERSION => 6,
            //CURLOPT_POSTFIELDS => 'password=02032517&username=3101800062625&grant_type=password',
            CURLOPT_POSTFIELDS => $postdata,
            CURLOPT_HTTPHEADER => $header,
        ));
        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            //echo 'Curl error: ' . curl_error($curl);exit;
            return false;
        }

        curl_close($curl);
        $result = json_decode($response, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            return $result;
        } else {
            return false;
        }
        exit;

        //return  json_decode($response, true);

        $opts = [
            "http" => [
                [
                    "method" => "POST",
                    "header" => "Content-Type: application/x-www-form-urlencoded\r\n" .
                        "user_token: " . $this->user_token() . "\r\n",
                    'content' => $postdata,
                    "Connection: close\r\n",
                    "ignore_errors" => true,
                    "timeout" => (float)30.0,
                ]
            ],
            "ssl" => [
                "verify_peer" => false,
                "verify_peer_name" => false,
            ],
        ];

        $context  = stream_context_create($opts);

        $url = Yii::$app->params['prg_ctrl']['api']['line']['server'];
        $result = file_get_contents($url, false, $context);
    }


    public function actionMessage()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $cmd = null;
        if (!empty($_REQUEST['cmd'])) $cmd = $_REQUEST['cmd'];

        if (is_null($cmd)) {
            return [
                'code' => 'WS003',
            ];
        }

        //getPersonInfo
        switch (strtolower($cmd)) {
            case strtolower("getCountUnread"):
                return $this->getCountUnread();
                break;
            case strtolower("getMessageAll"):
                return $this->getMessageAll();
                break;
            case strtolower("setMessagereaded");
                return $this->setMessagereaded();
                break;
            case strtolower("getMessage");
                return $this->getMessage();
                break;
            case strtolower("setMessagedel");
                return $this->setMessagedel();
                break;
            default:
                return [
                    'code' => 'WS003',
                ];
        }
    }


    //ข้อมูลกล่องข้อความ
    function getCountUnread()
    {
        //$ssoNo = $_REQUEST['ssoNo'];
        $ssoNo = $_REQUEST["ssoNo"] ?? null;
        if (is_null($ssoNo)) {
            return [
                'code' => 'WS003',
            ];
        }

        //$ssoNo = "3470800335083";

        $sql = "
        SELECT count(id) as unread
            FROM
            `ssoline`.`notifications`
            INNER JOIN `ssoline`.`mas_sso_user`
                ON (
                `notifications`.`user_id` = `mas_sso_user`.`su_id`
                )
            WHERE su_idcard =:su_idcard and read_status=0 AND notifications.`status`=1";

        $conn = Yii::$app->db;

        $command = $conn->createCommand($sql);
        $command->bindValue(":su_idcard", $ssoNo);
        $rows = $command->queryAll();

        return [
            "code" => "WS000",
            "count" => $rows[0]['unread'],
        ];
    }
    //ข้อมูลกล่องข้อความทั้งหมด
    function getMessageAll()
    {
        $ssoNo = $_REQUEST["ssoNo"] ?? null;
        if (is_null($ssoNo)) {
            return [
                'code' => 'WS003',
            ];
        }

        //$ssoNo = "3470800335083";

        $sql = "
        SELECT notifications.id,
        trn_notifications.`subject`,
        trn_notifications.`message`,
        notifications.`read_status`,
        notifications.create_date
        FROM   `ssoline`.`notifications`
                INNER JOIN `ssoline`.`mas_sso_user`
                        ON ( `notifications`.`user_id` = `mas_sso_user`.`su_id` )
                INNER JOIN `ssoline`.`trn_notifications`
                        ON ( `notifications`.`noti_id` = `trn_notifications`.`id` )
        WHERE  su_idcard =:su_idcard AND notifications.`status`=1
        ORDER  BY trn_notifications.`create_by` DESC; ";

        $conn = Yii::$app->db;

        $command = $conn->createCommand($sql);
        $command->bindValue(":su_idcard", $ssoNo);
        $rows = $command->queryAll();
        $arr = array();
        if (count($rows) > 0) {
            foreach ($rows as $dataitem) {
                $create_date = \app\components\CommonFnc::DateThai($dataitem['create_date'], false);
                $dataitem['create_date'] = $create_date;
                $arr[] = $dataitem;
            }
            //var_dump($arr);exit;
            return [
                "code" => "WS000",
                "detail" => $arr,
            ];
        } else {
            return [
                'code' => 'WS006',
            ];
        }
    }

    //แสดงข้อความ
    function getMessage()
    {
        $ssoNo = $_REQUEST["ssoNo"] ?? null;
        if (is_null($ssoNo)) {
            return [
                'code' => 'WS003',
            ];
        }
        $id = $_REQUEST["id"] ?? null;
        if (is_null($id)) {
            return [
                'code' => 'WS003',
            ];
        }

        $sql = "
        SELECT trn_notifications.`message`, notifications.create_date
        FROM   `ssoline`.`notifications`
                INNER JOIN `ssoline`.`mas_sso_user`
                        ON ( `notifications`.`user_id` = `mas_sso_user`.`su_id` )
                INNER JOIN `ssoline`.`trn_notifications`
                        ON ( `notifications`.`noti_id` = `trn_notifications`.`id` )
        WHERE  su_idcard =:su_idcard AND notifications.id = :id AND notifications.`status`=1
        ORDER  BY trn_notifications.`create_by` DESC; ";

        $conn = Yii::$app->db;

        $command = $conn->createCommand($sql);
        $command->bindValue(":su_idcard", $ssoNo);
        $command->bindValue(":id", $id);
        $rows = $command->queryAll();

        if (count($rows) > 0) {
            $create_date = \app\components\CommonFnc::DateThai($rows[0]['create_date'], false);
            return [
                "code" => "WS000",
                "detail" => $rows[0]['message'],
                "create_date" => $create_date,
            ];
        } else {
            return [
                'code' => 'WS006',
            ];
        }
    }

    //update ว่าอ่านแล้ว
    function setMessagereaded()
    {
        //if (Yii::$app->request->isPost) {

        $ssoNo = $_REQUEST["ssoNo"] ?? null;
        if (is_null($ssoNo)) {
            return [
                'code' => 'WS003',
            ];
        }
        $id = $_REQUEST["id"] ?? null;
        if (is_null($id)) {
            return [
                'code' => 'WS003',
            ];
        }
        try {
            $sql = "UPDATE
            `ssoline`.`notifications`
            INNER JOIN `ssoline`.`mas_sso_user`
            ON (
            `notifications`.`user_id` = `mas_sso_user`.`su_id`
            )
            SET notifications.`read_status`=1, notifications.update_by=mas_sso_user.su_id, notifications.update_date=NOW()
            WHERE  mas_sso_user.`su_idcard` =:su_idcard AND notifications.`id`=:id ;";

            $conn = Yii::$app->db;

            $command = $conn->createCommand($sql);
            $command->bindValue(":su_idcard", $ssoNo);
            $command->bindValue(":id", $id);
            $x = $command->execute();
            //echo $x . "ssss";
            return [
                "code" => "WS000",
            ];
        } catch (Exception $e) {
            return [
                'code' => 'WS003',
            ];
        }

        //}
    }

    //update ว่าลบ
    function setMessagedel()
    {
        //if (Yii::$app->request->isPost) {

        $ssoNo = $_REQUEST["ssoNo"] ?? null;
        if (is_null($ssoNo)) {
            return [
                'code' => 'WS003',
            ];
        }
        $id = $_REQUEST["id"] ?? null;
        if (is_null($id)) {
            return [
                'code' => 'WS003',
            ];
        }
        try {
            $sql = "UPDATE
               `ssoline`.`notifications`
               INNER JOIN `ssoline`.`mas_sso_user`
               ON (
               `notifications`.`user_id` = `mas_sso_user`.`su_id`
               )
               SET notifications.`status`=0, notifications.update_by=mas_sso_user.su_id, notifications.update_date=NOW()
               WHERE  mas_sso_user.`su_idcard` =:su_idcard AND notifications.`id`=:id ;";

            $conn = Yii::$app->db;

            $command = $conn->createCommand($sql);
            $command->bindValue(":su_idcard", $ssoNo);
            $command->bindValue(":id", $id);
            $x = $command->execute();
            //echo $x . "ssss";
            return [
                "code" => "WS000",
            ];
        } catch (Exception $e) {
            return [
                'code' => 'WS003',
            ];
        }

        //}
    }

    //Service PDPA
    public function actionPdpa()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $cmd = null;
        if (!empty($_REQUEST['cmd'])) $cmd = $_REQUEST['cmd'];

        if (is_null($cmd)) {
            return [
                'code' => 'WS003',
            ];
        }

        //getPersonInfo
        switch (strtolower($cmd)) {
            case strtolower("getPDPA"):
                return $this->getPDPA();
                break;
            case strtolower("chkPDPA"):

                $ssoNo = $_REQUEST["ssoNo"] ?? null;
                if (is_null($ssoNo)) {
                    return [
                        'code' => 'WS003',
                    ];
                }

                return $this->chkPDPA($ssoNo);
                break;
            case strtolower("chkPDPALine"):

                $lineid = $_REQUEST["lineid"] ?? null;
                if (is_null($lineid)) {
                    return [
                        'code' => 'WS003',
                    ];
                }
                return $this->chkPDPALine($lineid);
                break;
            case strtolower("acceptPDPA");
                return $this->acceptPDPA();
                break;
            case strtolower(("acceptPDPALine"));

                $lineid = $_REQUEST["lineid"] ?? null;
                if (is_null($lineid)) {
                    return [
                        'code' => 'WS003',
                    ];
                }

                $id = $_REQUEST["id"] ?? null;
                if (is_null($id)) {
                    return [
                        'code' => 'WS003',
                    ];
                }
                return $this->acceptPDPALine($lineid, $id);

            default:
                return [
                    'code' => 'WS003',
                ];
        }
    }

    function getPDPA()
    {
        $conn = Yii::$app->db;

        $sql = "SELECT * FROM mas_pdpa WHERE status=1";
        $command = $conn->createCommand($sql);
        $rows = $command->queryAll();

        if (count($rows) > 0) {
            $create_date = \app\components\CommonFnc::DateThai($rows[0]['create_date'], false);
            return [
                "code" => "WS000",
                "detail" => $rows[0]['text'],
                "create_date" => $create_date,
            ];
        }
    }

    //ตรวจสอบว่า ยอมรับ pdpa
    function chkPDPA($ssoNo)
    {
        //if (Yii::$app->request->isPost) {

        /*
        $id = $_REQUEST["id"] ?? null;
        if (is_null($id)) {
            return [
                'code' => 'WS003',
            ];
        }*/
        try {
            $conn = Yii::$app->db;

            $sql = "SELECT * FROM mas_pdpa WHERE status=1";
            $command = $conn->createCommand($sql);
            $rows_mas = $command->queryAll();
            if (count($rows_mas) > 0) {
                $id = $rows_mas[0]['id'];
            } else {
                return [
                    'code' => 'WS003',
                ];
            }

            $sql = "
            SELECT *, trn_pdpa.id as trn_id
            FROM
              `ssoline`.`trn_pdpa`
              INNER JOIN `ssoline`.`mas_sso_user`
                ON (
                  `trn_pdpa`.`id_sso` = `mas_sso_user`.`su_id`
                )
            WHERE  su_idcard =:su_idcard AND trn_pdpa.id_pdpa = :id /*AND accept=1*/ ;
            ";
            $command = $conn->createCommand($sql);
            $command->bindValue(":su_idcard", $ssoNo);
            $command->bindValue(":id", $id);
            $rows = $command->queryAll();
            if (count($rows) > 0) {
                $accept = $rows[0]['accept'];
                if ($accept == 1) {
                    return [
                        "code" => "WS000",
                    ];
                } else {
                    $create_date = \app\components\CommonFnc::DateThai($rows_mas[0]['create_date'], false);
                    return [
                        "code" => "WS000",
                        "id" => $rows[0]['id'],
                        "detail" => $rows_mas[0]['text'],
                        "create_date" => $create_date,
                    ];
                }
            } else {
                //ยังไม่ยืนยืน

                $sql = "SELECT * FROM mas_sso_user WHERE su_idcard=:su_idcard";
                $command = $conn->createCommand($sql);
                $command->bindValue(":su_idcard", $ssoNo);
                $rows_su = $command->queryAll();
                if (count($rows_su) > 0) {
                    $su_id = $rows_su[0]['su_id'];
                } else {
                    return [
                        'code' => 'WS003',
                    ];
                }

                $createby = !Yii::$app->user->isGuest ? Yii::$app->user->getId() : 0;
                $sql = "INSERT INTO trn_pdpa (id_sso, id_pdpa,  create_by, create_date )
			        VALUE(:id_sso, :id_pdpa, '{$createby}', NOW())";

                $command = $conn->createCommand($sql);
                $command->bindValue(":id_sso", $su_id);
                $command->bindValue(":id_pdpa", $id);
                $command->execute();
                $lid = $conn->getLastInsertID();
            }

            $create_date = \app\components\CommonFnc::DateThai($rows_mas[0]['create_date'], false);
            return [
                "code" => "WS000",
                "id" => $lid,
                "detail" => $rows_mas[0]['text'],
                "create_date" => $create_date,
            ];
        } catch (Exception $e) {
            return [
                'code' => 'WS003',
            ];
        }

        //}
    }

    //ตรวจสอบว่า ยอมรับ pdpa เงื่อนไข Line ID
    function chkPDPALine($LineId)
    {
        //if (Yii::$app->request->isPost) {

        /*
            $id = $_REQUEST["id"] ?? null;
            if (is_null($id)) {
                return [
                    'code' => 'WS003',
                ];
            }*/
        try {
            $conn = Yii::$app->db;

            $sql = "SELECT * FROM mas_pdpa WHERE status=1";
            $command = $conn->createCommand($sql);
            $rows_mas = $command->queryAll();
            if (count($rows_mas) > 0) {
                $id = $rows_mas[0]['id'];
            } else {
                return [
                    'code' => 'WS003',
                ];
            }

            $sql = "
                SELECT *, trn_pdpa.id as trn_id
                FROM
                  `ssoline`.`trn_pdpa`
                WHERE line_id=:line_id AND id_pdpa=:id_pdpa ;
                ";
            $command = $conn->createCommand($sql);
            $command->bindValue(":line_id", $LineId);
            $command->bindValue(":id_pdpa", $id);
            $rows = $command->queryAll();
            if (count($rows) > 0) {
                $accept = $rows[0]['accept'];
                if ($accept == 1) {
                    return [
                        "code" => "WS000",
                    ];
                } else {
                    $create_date = \app\components\CommonFnc::DateThai($rows_mas[0]['create_date'], false);
                    return [
                        "code" => "WS000",
                        "id" => $rows[0]['id'],
                        "detail" => $rows_mas[0]['text'],
                        "create_date" => $create_date,
                    ];
                }
            } else {
                //ยังไม่ยืนยืน

                $createby = !Yii::$app->user->isGuest ? Yii::$app->user->getId() : 0;
                $sql = "INSERT INTO trn_pdpa (line_id, id_pdpa,  create_by, create_date )
                        VALUE(:line_id, :id_pdpa, '{$createby}', NOW())";

                $command = $conn->createCommand($sql);
                $command->bindValue(":line_id", $LineId);
                $command->bindValue(":id_pdpa", $id);
                $command->execute();
                $lid = $conn->getLastInsertID();
            }

            $create_date = \app\components\CommonFnc::DateThai($rows_mas[0]['create_date'], false);
            return [
                "code" => "WS000",
                "id" => $lid,
                "detail" => $rows_mas[0]['text'],
                "create_date" => $create_date,
            ];
        } catch (Exception $e) {
            return [
                'code' => 'WS003',
            ];
        }

        //}
    }

    //Accept PDPA
    function acceptPDPA()
    {
        //if (Yii::$app->request->isPost) {

        $ssoNo = $_REQUEST["ssoNo"] ?? null;
        if (is_null($ssoNo)) {
            return [
                'code' => 'WS003',
            ];
        }

        $id = $_REQUEST["id"] ?? null;
        if (is_null($id)) {
            return [
                'code' => 'WS003',
            ];
        }

        $createby = !Yii::$app->user->isGuest ? Yii::$app->user->getId() : 0;
        $conn = Yii::$app->db;
        $transaction = $conn->beginTransaction();
        try {
            $sql = "UPDATE trn_pdpa SET accept=1, update_by='{$createby}', update_date=NOW() 
			 WHERE id=:id";

            $sql = "UPDATE
            trn_pdpa
            INNER JOIN `ssoline`.`mas_sso_user`
            ON (
            `trn_pdpa`.`id_sso` = `mas_sso_user`.`su_id`
            )
            SET trn_pdpa.`accept`=1, trn_pdpa.update_by=mas_sso_user.su_id, trn_pdpa.update_date=NOW()
            WHERE  mas_sso_user.`su_idcard` =:su_idcard AND trn_pdpa.`id`=:id ;";

            $command = $conn->createCommand($sql);
            $command->bindValue(":su_idcard", $ssoNo);
            $command->bindValue(":id", $id);
            $x = $command->execute();

            $transaction->commit();
            return [
                "code" => "WS000",
            ];
        } catch (Exception $e) {
            $transaction->rollBack();
            return [
                "code" => "WS003",
            ];
        }

        //}
    }

    //Accept PDPA เงื่อนไข Line ID
    function acceptPDPALine($LineId, $id)
    {
        //if (Yii::$app->request->isPost) {

        $conn = Yii::$app->db;
        $transaction = $conn->beginTransaction();
        try {
            $sql = "UPDATE trn_pdpa SET accept=1, update_by=:update_by , update_date=NOW() WHERE id=:id";

            $command = $conn->createCommand($sql);
            $command->bindValue(":update_by", $LineId);
            $command->bindValue(":id", $id);
            $x = $command->execute();

            $transaction->commit();
            return [
                "code" => "WS000",
            ];
        } catch (Exception $e) {
            $transaction->rollBack();
            return [
                "code" => "WS003",
            ];
        }

        //}
    }

    public function actionLog()
    {

        //if (Yii::$app->request->isPost) {

        Yii::$app->response->format = Response::FORMAT_JSON;

        $cmd = null;
        if (!empty($_REQUEST['cmd'])) $cmd = $_REQUEST['cmd'];

        if (is_null($cmd)) {
            return [
                'code' => 'WS003',
            ];
        }
        switch (strtolower($cmd)) {
            case strtolower("activity"):
                return $this->logactivity();
                break;

            default:
                return [
                    'code' => 'WS003',
                ];
        }

        /* }else{
        return [
            'code' => 'WS003',
        ];
       }*/
    }
    private function logactivity()
    {

        $ssoNo = "";
        if (!empty($_REQUEST['ssoNo'])) $ssoNo = $_REQUEST['ssoNo'];
        if (is_null($ssoNo)) {
            return [
                'code' => 'WS003',
            ];
        }
        $lineid = "";
        if (!empty($_REQUEST['lineid'])) $lineid = $_REQUEST['lineid'];
        if (is_null($lineid)) {
            return [
                'code' => 'WS003',
            ];
        }
        $log_ip = "";
        if (!empty($_REQUEST['log_ip'])) $log_ip = $_REQUEST['log_ip'];
        if (is_null($log_ip)) {
            return [
                'code' => 'WS003',
            ];
        }
        $log_action = "";
        if (!empty($_REQUEST['log_action'])) $log_action = $_REQUEST['log_action'];
        if (is_null($log_action)) {
            return [
                'code' => 'WS003',
            ];
        }
        $log_description = "";
        if (!empty($_REQUEST['log_description'])) $log_description = $_REQUEST['log_description'];
        if (is_null($log_description)) {
            return [
                'code' => 'WS003',
            ];
        }

        $conn = Yii::$app->logdb;
        $transaction = $conn->beginTransaction();
        try {

            $sql = "
            insert into log_useractivity (
                `log_card_id`,
                `log_line_id`,
                `log_ip`,
                `log_action`,
                `log_description`,
                `createdate`
              )
              values
                (
                  :log_card_id,
                  :log_line_id,
                  :log_ip,
                  :log_action,
                  :log_description,
                  NOW()
                );
            ";

            $command = $conn->createCommand($sql);
            $command->bindValue(":log_card_id", $ssoNo);
            $command->bindValue(":log_line_id", $lineid);
            $command->bindValue(":log_ip", $log_ip);
            $command->bindValue(":log_action", $log_action);
            $command->bindValue(":log_description", $log_description);
            $x = $command->execute();

            $transaction->commit();
            return [
                "code" => "WS000",
            ];
        } catch (Exception $e) {
            $transaction->rollBack();
            return [
                "code" => "WS003",
            ];
        }
    }

    public function actionNearme()
    {

        Yii::$app->response->format = Response::FORMAT_JSON;

        $lat = null;
        if (!empty($_REQUEST['lat'])) $lat = $_REQUEST['lat'];
        if (is_null($lat)) {
            return [
                'code' => 'WS003',
            ];
        }
        $long = null;
        if (!empty($_REQUEST['long'])) $long = $_REQUEST['long'];
        if (is_null($long)) {
            return [
                'code' => 'WS003',
            ];
        }

        $conn = Yii::$app->db;

        $sql = "
        SELECT name ,latitude, longitude,ROUND( 
            ( 6371 * ACOS( LEAST(1.0,  
              COS( RADIANS(:lat) ) 
              * COS( RADIANS(latitude) ) 
              * COS( RADIANS(longitude) - RADIANS(:long) ) 
              + SIN( RADIANS(:lat) ) 
              * SIN( RADIANS(latitude) 
            ) ) ) 
          ), 2) AS distance,
          IFNULL(trn_ssobranch.address,'') AS address,
          IFNULL(trn_ssobranch.telno,'') AS telno,
          IFNULL(trn_ssobranch.location,'') AS location
          FROM mas_ssobranch 
          LEFT JOIN trn_ssobranch ON trn_ssobranch.ssobranch_code = mas_ssobranch.ssobranch_code
          WHERE mas_ssobranch.service = 1 AND mas_ssobranch.status =1
          HAVING distance <= 2000 ORDER BY distance LIMIT 10;";
        $command = $conn->createCommand($sql);
        $command->bindValue(":lat", $lat);
        $command->bindValue(":long", $long);
        $rows_mas = $command->queryAll();
        if (count($rows_mas) > 0) {
            return $rows_mas;
        } else {
            return [
                'code' => 'WS003',
            ];
        }
    }

    public function actionSearchbranch()
    {

        Yii::$app->response->format = Response::FORMAT_JSON;

        $lat = null;
        if (!empty($_REQUEST['lat'])) $lat = $_REQUEST['lat'];
        if (is_null($lat)) {
            return [
                'code' => 'WS003',
            ];
        }
        $long = null;
        if (!empty($_REQUEST['long'])) $long = $_REQUEST['long'];
        if (is_null($long)) {
            return [
                'code' => 'WS003',
            ];
        }

        $keyword = null;
        if (!empty($_REQUEST['keyword'])) $keyword = $_REQUEST['keyword'];
        if (is_null($keyword)) {
            return [
                'code' => 'WS003',
            ];
        }

        $sqlwhere = "";
        $params = array();
        $arrSqlwhere = array();
        //$pieces = explode(" ", "สีมา ปากช่อง");
        $pieces = explode(" ", $keyword);
        if (count($pieces) > 1) {
            $i = 0;
            foreach ($pieces as $value) {
                $arrSqlwhere[] = "name LIKE :param" . $i;
                $word = addcslashes($value, '%_');
                $params[':param' . $i] = "%$word%";
                $i++;
            }
            $sqlwhere = "(" . implode(" AND ", $arrSqlwhere) . ")";
        } else {
            $sqlwhere = "name LIKE :param";
            $word = addcslashes($pieces[0], '%_');
            $params[':param'] = "%$word%";
        }

        //var_dump($params);

        $conn = Yii::$app->db;

        $sql = "
        SELECT name ,ROUND( 
            ( 6371 * ACOS( LEAST(1.0,  
              COS( RADIANS(:lat) ) 
              * COS( RADIANS(latitude) ) 
              * COS( RADIANS(longitude) - RADIANS(:long) ) 
              + SIN( RADIANS(:lat) ) 
              * SIN( RADIANS(latitude) 
            ) ) ) 
          ), 2) AS distance,
          IFNULL(trn_ssobranch.address,'') AS address,
          IFNULL(trn_ssobranch.telno,'') AS telno,
          IFNULL(trn_ssobranch.location,'') AS location
          FROM mas_ssobranch 
          LEFT JOIN trn_ssobranch ON trn_ssobranch.ssobranch_code = mas_ssobranch.ssobranch_code
          WHERE mas_ssobranch.service = 1 AND mas_ssobranch.status =1
          AND " . $sqlwhere;
        $command = $conn->createCommand($sql);
        $command->bindValue(":lat", $lat);
        $command->bindValue(":long", $long);
        foreach ($params as $key => $value) {
            $command->bindValue($key, $value);
        }
        $rows_mas = $command->queryAll();
        if (count($rows_mas) > 0) {
            return $rows_mas;
        } else {
            return [
                'code' => 'WS003',
            ];
        }
    }
}
