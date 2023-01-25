<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
// use yii\helpers\Url;

use app\components\UserController;

class EmpdataController extends Controller
{

    public function init()
    {
        parent::init();
        if (Yii::$app->user->isGuest) {
            UserController::chkLogin();
            exit;
        }
    }


    // http://samservice/empdata/gogo
    public function actionGogo()
    {

        ini_set("default_socket_timeout", 20000);
        ini_set('memory_limit', '2048M');
        set_time_limit(0);

        $con = Yii::$app->dbdpis;

        $con2 = Yii::$app->dbdpisemp;

        $arr = [
            'per_cardno',
            'per_name',
            'per_surname',
            'per_status',
            'per_eng_name',
            'per_eng_surname',
            'per_startdate',
            'per_occupydate',
        ];


        $sql = "
            SELECT 
                MAX( per_id ) as max_id
            FROM per_personal 
            ORDER BY per_id DESC
            
        ";

        $gogog = [1, 2];

        foreach ($gogog as $kg => $vg) {

            if ($vg == 1) {

                $cmd = $con->createCommand($sql);
            } else {

                $cmd = $con2->createCommand($sql);
            }


            $per_ids[$vg] = 0;
            foreach ($cmd->queryAll() as $ka => $va) {
                $per_ids[$vg] = $va['MAX_ID'];
            }

            $keep[$vg] = [];
        }

        $sql = "
            SELECT 
                per_cardno,
                per_name,
                per_surname,
                per_status,
                per_eng_name,
                per_eng_surname,
                per_startdate,
                per_occupydate,
                level_no,
                per_id
            FROM per_personal 
            ORDER BY per_id ASC
        ";

        $gogog = [1, 2];

        foreach ($gogog as $kg => $vg) {

            if ($vg == 1) {

                $cmd = $con->createCommand($sql);
            } else {

                $cmd = $con2->createCommand($sql);
            }

            foreach ($cmd->queryAll() as $ka => $va) {

                $concat = '';
                foreach ($arr as $kf => $vf) {

                    $vf = strtoupper($vf);

                    $concat .= $va[$vf] . '-';
                }

                $keep[$vg][] = $concat;
                $per_ids[$vg] = $va['PER_ID'];
            }
        }


        // arr( $per_ids, 1 );



        $nocard = 0;

        $sql = "SELECT level_no, level_name FROM per_level";
        $cmd = $con->createCommand($sql);
        $levels = [];
        foreach ($cmd->queryAll() as $ka => $va) {

            $levels[$va['LEVEL_NAME']] = $va['LEVEL_NO'];
        }

        $url_gettoken = 'https://sso.dpis.go.th/oapi/login';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url_gettoken,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "username":"niras_s@hotmail.com",
                "password":"LcNRemVEmAbS4Cv"
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));


        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            return false;
        }

        curl_close($curl);
        $result = json_decode($response, true);

        // arr( $result );
        $accessToken = '';
        $encrypt_key = '';

        if (json_last_error() === JSON_ERROR_NONE) {
            if (array_key_exists("error", $result)) {
                $arrsms = array(
                    'status' => 'error',
                    'msg' => $result['error']['message'],
                );
                return $arrsms;
            }
            $accessToken = $result['accessToken'];
            $encrypt_key = $result['encrypt_key'];
        } else {
            $arrsms = array(
                'status' => 'error',
                'msg' => "",
            );
            return $arrsms;
        }


        $url = "https://sso.dpis.go.th/oapi/open_api_users/callapi";
        $header = array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: ' . $accessToken
        );

        $SqlUnion = [];
        for ($i = 1; $i <= 40; $i++) {

            $param = array(
                'endpoint' => 'sso_personal',
                'limit' => 1000,
                'page' => $i
            );

            $data_result = $this->calleservice($url, $header, $param);

            if ($data_result['message'] != "success") {
                $arrsms = array(
                    'status' => 'error',
                    'msg' => "",
                );
                continue;
            }

            $decrypt_data = $this->ssl_decrypt_api($data_result["data"], $encrypt_key);

            $js = json_decode($decrypt_data);

            $cJs = count($js);
            if ($cJs == 0) {

                break;
            }

            $dir_name = 'save_file';

            if (!is_dir($dir_name)) {
                mkdir($dir_name);
            }

            $save_file = $dir_name . '/' . $i . '.txt';

            if (file_exists($save_file)) {

                if (file_get_contents($save_file) ==  $data_result["data"]) {

                    //continue;
                }
            }

            $mymess[] = 'บันทึกไฟล์ ' . $save_file . ' จำนวน ' . $cJs . ' ';

            file_put_contents($save_file, $data_result["data"]);

            foreach ($js as $ka => $va) {

                // $mymess[] = 'ปรับปรุงข้อมูลคุณ ' . $va->per_name . 'เลขที่บัตรปชช ' . $va->per_cardno . ' เข้าระบบ';


                if (empty($va->per_cardno)) {

                    ++$nocard;
                    continue;
                }

                $cards[$va->per_cardno] = 1;

                if (in_array($va->pertype_id, [5, 42, 43, 44])) {

                    $setType = 1;
                } else {
                    $setType = 2;
                }

                /*  if (!isset($per_ids[$setType])) {

                    $per_ids[$setType] = 0;
                }*/

                if (!isset($levels[$va->levelname_th])) {
                    $levels[$va->levelname_th] = '-';
                }

                $concat = '';
                foreach ($arr as $kf => $vf) {

                    $concat .= $va->$vf . '-';
                }


                if (in_array($concat, $keep[$setType])) {
                    continue;
                }

                /*  ++$per_ids[$setType];
                $new_id =  $per_ids[$setType];*/

                // echo 'dsadsfddss'; exit;

                //$sql = "SELECT PER_PERSONAL_SEQ.nextval FROM DUAL";

                if (isset($per_ids[$setType])) {
                    echo $per_ids[$setType] += 1;
                } else {
                    $sql = "SELECT max(per_id) as MAXID  FROM PER_PERSONAL";
                    if ($setType == 1) {
                        $cmd = $con->createCommand($sql);
                    } else {

                        $cmd = $con2->createCommand($sql);
                    }
                    foreach ($cmd->queryAll() as $ka => $vz) {

                        echo $per_ids[$setType] = $vz['MAXID'] + 1;
                    }
                }


                $SqlUnion[$setType][] = "
                    SELECT 
                        '" . $va->pertype_id . "' AS pertype_id,
                        9999  AS per_id,
                        '" . $va->per_name . "' AS per_name,
                        '" . $va->per_cardno . "' AS per_cardno,
                        '" . $va->per_surname . "' AS per_surname,
                        '" . $va->per_eng_name . "' AS per_eng_name,
                        '" . $va->per_eng_surname . "' AS per_eng_surname,
                        '" . $va->birth_date . "' AS per_birthdate,
                        '" . $va->per_startdate . "' AS per_startdate,
                        '" . $va->per_occupydate . "' AS per_occupydate,
                        '" . $va->per_status . "' AS per_status,
                        '" . $levels[$va->levelname_th] . "' AS level_no
                    FROM dual
                ";

                foreach ($SqlUnion as $ks => $vs) {

                    if (count($vs) == 1) {
                        /*
                        $sql = "
                            MERGE INTO per_personal d
                            USING ( 
                                " . implode(' UNION ', $vs) . "
                            ) s ON ( 1 = 0 )
                            WHEN NOT MATCHED THEN
                                INSERT  ( level_no, level_no_salary, per_type, per_id, per_name, per_cardno, per_surname, per_eng_name, per_eng_surname, per_birthdate, per_startdate, per_occupydate, per_status,
                                ot_code, pn_code, org_id, pos_id, poem_id, per_orgmgt, per_salary, per_mgtsalary, per_spsalary, per_gender, mr_code, per_offno, per_taxno, per_blood, re_code, per_retiredate, per_posdate, per_saldate, pn_code_f, per_fathername, per_fathersurname, pn_code_m, per_mothername, per_mothersurname, per_add1, per_add2, pv_code, mov_code, per_ordain, per_soldier, per_member, update_user, update_date, department_id, approve_per_id, replace_per_id, absent_flag, poems_id, per_hip_flag, per_cert_occ, per_nickname, per_home_tel, per_office_tel, per_fax, per_mobile, per_email, per_file_no, per_bank_account, per_id_ref, per_id_ass_ref, per_contact_person, per_remark, per_start_org, per_cooperative, per_cooperative_no, per_memberdate, per_seq_no, pay_id, es_code, pl_name_work, org_name_work, per_docno, per_docdate, per_effectivedate, per_pos_reason, per_pos_year, per_pos_doctype, per_pos_docno, per_pos_org, per_ordain_detail, per_pos_orgmgt, per_pos_docdate, per_pos_desc, per_pos_remark, per_book_no, per_book_date, per_contact_count, per_disability, pot_id, per_union, per_uniondate, per_job, org_id_1, org_id_2, org_id_3, org_id_4, org_id_5, per_union2, per_uniondate2, per_union3, per_uniondate3, per_union4, per_uniondate4, per_union5, per_uniondate5, per_set_ass, per_audit_flag, per_probation_flag, department_id_ass, per_birth_place, per_scar, per_renew, per_leveldate, per_postdate, per_ot_flag  
                            ) VALUES
                                ( s.level_no, 'C4', 1, s.per_id, s.per_name, s.per_cardno, s.per_surname, s.per_eng_name, s.per_eng_surname, s.per_birthdate, s.per_startdate, s.per_occupydate, s.per_status, '11', '004', '13950.00', '17.00', NULL, '0.00', '28100.00', '0.00', '0.00', '2.00', '1 ', NULL, NULL, NULL, NULL, '2036-10-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '21345     ', '0.00', '0.00', '0.00', '7827.00', '2020-05-16 13:24:23', '3062.00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sakawduan.b@sso.go.th', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, NULL, '4009.00', '17.00', '02', NULL, NULL, '9282/2565', '2022-07-12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1.00', NULL, '0.00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, '0.00', NULL, '0.00', NULL, '0.00', NULL, '1.00', '0.00', '0.00', '3062.00', NULL, NULL, NULL, NULL, NULL, NULL )
                        ";
						*/
                        $sql = "

						 INSERT into per_personal (per_id, per_type,ot_code,pn_code,per_name,per_surname,per_eng_name,per_eng_surname,org_id,pos_id,poem_id,level_no,per_orgmgt,per_salary,per_mgtsalary,per_spsalary,per_gender,mr_code,per_cardno,per_offno,per_taxno,per_blood,re_code,per_birthdate,per_retiredate,per_startdate,per_occupydate,per_posdate,per_saldate,pn_code_f,per_fathername,per_fathersurname,pn_code_m,per_mothername,per_mothersurname,per_add1,per_add2,pv_code,mov_code,per_ordain,per_soldier,per_member,per_status,update_user,update_date,department_id,approve_per_id,replace_per_id,absent_flag,poems_id,per_hip_flag,per_cert_occ,level_no_salary,per_nickname,per_home_tel,per_office_tel,per_fax,per_mobile,per_email,per_file_no,per_bank_account,per_id_ref,per_id_ass_ref,per_contact_person,per_remark,per_start_org,per_cooperative,per_cooperative_no,per_memberdate,per_seq_no,pay_id,es_code,pl_name_work,org_name_work,per_docno,per_docdate,per_effectivedate,per_pos_reason,per_pos_year,per_pos_doctype,per_pos_docno,per_pos_org,per_ordain_detail,per_pos_orgmgt,per_pos_docdate,per_pos_desc,per_pos_remark,per_book_no,per_book_date,per_contact_count,per_disability,pot_id,per_union,per_uniondate,per_job,org_id_1,org_id_2,org_id_3,org_id_4,org_id_5,per_union2,per_uniondate2,per_union3,per_uniondate3,per_union4,per_uniondate4,per_union5,per_uniondate5,per_set_ass,per_audit_flag,per_probation_flag,department_id_ass,per_birth_place,per_scar,per_renew,per_leveldate,per_postdate,per_ot_flag) 
						 values ( '" . $per_ids[$ks] . "', 1,'09','004','AAA','ทัศนสุวรรณ','sanit','thatsanasuwan',11545,2670,null,'S2',0,32140,0,0,2,'1 ','3720400644876',null,null,null,null,'1966-01-07 ','2026-10-01 ','1995-07-14 ','1995-07-14 ',null,null,null,null,null,null,null,null,null,null,null,'21345 ',0,0,0,1,7827,'2021-01-15 14:14:59',3062,null,null,null,null,null,null,'s4',null,null,null,null,null,'sanit.t@sso.go.th',null,null,null,null,null,null,null,0,null,null,3571,3804,'02',null,null,'1788/2565','2022-05-09',null,null,null,null,null,null,null,null,null,null,null,null,null,null,1,null,0,null,null,null,null,null,null,null,0,null,0,null,0,null,0,null,1,0,0,3062,null,null,0,null,null,null)

						";
                        //echo $sql;
                        //echo $ks;exit;
                        if ($ks == 1) {
                            $cmd = $con->createCommand($sql);
                        } else {

                            $cmd = $con2->createCommand($sql);
                        }

                        $cmd->execute();

                        $SqlUnion[$ks] = [];
                        // echo "wr";
                        // exit;
                    }
                }
            }
        }


        // foreach ($SqlUnion as $ks => $vs) {

        //     if (count($vs) > 0) {

        //         $sql = "
        //             MERGE INTO per_personal d
        //             USING ( 
        //                 " . implode(' UNION ', $vs) . "
        //             ) s ON ( 1 = 0 )
        //             WHEN NOT MATCHED THEN
        //                 INSERT  ( level_no, level_no_salary, per_type, per_id, per_name, per_cardno, per_surname, per_eng_name, per_eng_surname, per_birthdate, per_startdate, per_occupydate, per_status,
        //                 ot_code, pn_code, org_id, pos_id, poem_id, per_orgmgt, per_salary, per_mgtsalary, per_spsalary, per_gender, mr_code, per_offno, per_taxno, per_blood, re_code, per_retiredate, per_posdate, per_saldate, pn_code_f, per_fathername, per_fathersurname, pn_code_m, per_mothername, per_mothersurname, per_add1, per_add2, pv_code, mov_code, per_ordain, per_soldier, per_member, update_user, update_date, department_id, approve_per_id, replace_per_id, absent_flag, poems_id, per_hip_flag, per_cert_occ, per_nickname, per_home_tel, per_office_tel, per_fax, per_mobile, per_email, per_file_no, per_bank_account, per_id_ref, per_id_ass_ref, per_contact_person, per_remark, per_start_org, per_cooperative, per_cooperative_no, per_memberdate, per_seq_no, pay_id, es_code, pl_name_work, org_name_work, per_docno, per_docdate, per_effectivedate, per_pos_reason, per_pos_year, per_pos_doctype, per_pos_docno, per_pos_org, per_ordain_detail, per_pos_orgmgt, per_pos_docdate, per_pos_desc, per_pos_remark, per_book_no, per_book_date, per_contact_count, per_disability, pot_id, per_union, per_uniondate, per_job, org_id_1, org_id_2, org_id_3, org_id_4, org_id_5, per_union2, per_uniondate2, per_union3, per_uniondate3, per_union4, per_uniondate4, per_union5, per_uniondate5, per_set_ass, per_audit_flag, per_probation_flag, department_id_ass, per_birth_place, per_scar, per_renew, per_leveldate, per_postdate, per_ot_flag
                        
                        
        //             ) VALUES
        //                 ( s.level_no, 'C4', s.pertype_id, s.per_id, s.per_name, s.per_cardno, s.per_surname, s.per_eng_name, s.per_eng_surname, s.per_birthdate, s.per_startdate, s.per_occupydate, s.per_status, '11', '004', '13950.00', '17.00', NULL, '0.00', '28100.00', '0.00', '0.00', '2.00', '1 ', NULL, NULL, NULL, NULL, '2036-10-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '21345     ', '0.00', '0.00', '0.00', '7827.00', '2020-05-16 13:24:23', '3062.00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sakawduan.b@sso.go.th', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, NULL, '4009.00', '17.00', '02', NULL, NULL, '9282/2565', '2022-07-12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1.00', NULL, '0.00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, '0.00', NULL, '0.00', NULL, '0.00', NULL, '1.00', '0.00', '0.00', '3062.00', NULL, NULL, NULL, NULL, NULL, NULL )
                   
        //         ";

        //         if ($ks == 1) {
        //             $cmd = $con->createCommand($sql);
        //         } else {

        //             $cmd = $con2->createCommand($sql);
        //         }

        //         $cmd->execute();

        //         $SqlUnion[$ks] = [];
        //     }
        // }

        $keep = [];

        $levels = [];

        $return['msg'] = 'ไม่มีการปรับปรุงข้อมูลใดๆ';
        if (!empty($mymess)) {

            $return['msg'] = implode('<br>', $mymess);
        }

        $return['status'] = 'success';

        echo json_encode($return);
    }

    public function actionUser_permission()
    {

        $datas['columns'] = [

            [
                'name' => 'uid',
                'label' => 'ชื่อ Login',
                'className' => "text-center",
                'orderable' => false
            ],
            [
                'name' => 'displayname',
                'label' => 'ชื่อ-นามสกุล',
                'className' => "text-center",
                'orderable' => false
            ],
            [
                'name' => 'ssobranch_code',
                'label' => 'รหัสหน่วยงาน',
                'className' => "text-center",
                'orderable' => false
            ],
            [
                'name' => 'branch_name',
                'label' => 'ชื่อหน่วยงาน',
                'className' => "text-center",
                'orderable' => false
            ],

            [
                'name' => 'btn1',
                'label' => 'ยกเลิกสิทธิ์',
                'className' => "text-center",
                'orderable' => false
            ],
            [
                'name' => 'btn',
                'label' => 'แก้ไข',
                'className' => "text-center",
                'orderable' => false
            ],
        ];

        $datas['tableUrl'] = '';

        return $this->render('view_user', $datas);
    }

    public function actionSyndata()
    {

        // arr( Yii::$app->params['prg_ctrl'] );

        $datas['columns'] = [
            [
                'name' => 'PER_CARDNO',
                'label' => 'เลขบัตร',
                'className' => "text-center",
                'orderable' => false
            ],
            [
                'name' => 'PER_NAME',
                'label' => 'ชื่อ',
                'className' => "text-center",
                'orderable' => false
            ],
            [
                'name' => 'PER_SURNAME',
                'label' => 'นามสกุล',
                'className' => "text-center",
                'orderable' => false
            ],
            [
                'name' => 'PER_STATUS',
                'label' => 'สถานะ',
                'className' => "text-center",
                'orderable' => false
            ],
            [
                'name' => 'PER_ENG_NAME',
                'label' => 'ชื่ออังกฤษ',
                'className' => "text-center",
                'orderable' => false
            ],
            [
                'name' => 'PER_ENG_SURNAME',
                'label' => 'นามสกุลอังกฤษ',
                'className' => "text-center",
                'orderable' => false
            ],
            [
                'name' => 'PER_STARTDATE',
                'label' => 'เริ่มงานเมื่อ',
                'className' => "text-center",
                'orderable' => false
            ],
            [
                'name' => 'PER_OCCUPYDATE',
                'label' => 'PER_OCCUPYDATE',
                'className' => "text-center",
                'orderable' => false
            ],
            [
                'name' => 'LEVEL_NO',
                'label' => 'ระดับ',
                'className' => "text-center",
                'orderable' => false
            ],

        ];


        // arr($columns);
        return $this->render('view', $datas);
    }


    public function actionTest()
    {

        //localhost
        // /samservice/empdata/gogo 
        // url: "/samservice/empdata/gogo",

        // /empdata/gogo 
        // url: "/empdata/gogo",
        echo Yii::$app->urlManager->createUrl("");


        exit;
        $con1 = Yii::$app->dbdpis;
        $con2 = Yii::$app->dbdpisemp;

        $sql = "
            SELECT
                per_cardno,
                per_name,
                per_surname,
                per_status,
                per_eng_name,
                per_eng_surname,
                per_startdate,
                per_occupydate,
                level_no,
                per_id
            FROM per_personal 
            
            ORDER BY per_id ASC
            OFFSET 0 ROWS FETCH NEXT 10 ROWS ONLY
        ";

        $sql1 = $con1->createCommand($sql);
        $sql2 = $con2->createCommand($sql);

        // $command = $con1->createCommand($sql);
        // $command->bindValue(':id', $_GET['id']);
        $post = $sql1->queryAll();

        // $ddsfa = $post->queryAll();
        arr($post, 0);


        // arr( $post );



        exit;








        $gogo = $sql1->union($sql2);

        echo $gogo->sql;



        $ddsfa = $gogo->queryAll();
        arr($ddsfa, 0);
        // $ddsfa = $sql2->queryAll();
        // arr( $ddsfa, 0 );


        // $mydb = new \yii\db\Query();

        // $command  =  $con1
        //     ->select(['per_name'])
        //     ->from('per_personal')
        //     ->limit(10)
        //     ->createCommand();

        // echo $command->sql;


        // arr( $command->queryAll( ), 0 );
    }



    function ssl_decrypt_api($string, $skey)
    {
        $output = false;
        if ($skey != '') {

            $encrypt_method = "AES-256-CBC";
            $secret_key = base64_encode(md5($skey));
            $secret_iv = md5(base64_encode(md5($skey)));
            $key = hash('sha256', $secret_key);
            $iv = substr(hash('sha256', $secret_iv), 0, 16);
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }



    public function actionSelect()
    {
        try {

            $conn = Yii::$app->db;

            $sql = "
			SELECT description FROM trn_richmenu WHERE id=:id
  			";
            $rchk = $conn->createCommand($sql)->bindValue('id', 21)->queryAll();
            if (count($rchk) != 0) {
                var_dump($rchk);
                //Yii::info('info log message');
            }
        } catch (\Exception $e) {
            echo 'error ' . $e->getMessage();
        }
    }

    public function actionGetapiinfomation()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        error_reporting(E_ALL | E_STRICT);
        try {

            $url_gettoken = "https://dpis6uat.sso.go.th/oapi/login";

            $url_gettoken = 'https://sso.dpis.go.th/oapi/login';
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url_gettoken,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
                "username":"niras_s@hotmail.com",
                "password":"LcNRemVEmAbS4Cv"
            }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));
            // UAT DJs4FkJcxzZUp9T
            // PRD LcNRemVEmAbS4Cv

            $response = curl_exec($curl);
            if (curl_errno($curl)) {
                return false;
            }

            curl_close($curl);
            $result = json_decode($response, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                if (array_key_exists("error", $result)) {
                    $arrsms = array(
                        'status' => 'error',
                        'msg' => $result['error']['message'],
                    );
                    return $arrsms;
                }
                $accessToken = $result['accessToken'];
                $encrypt_key = $result['encrypt_key'];
            } else {
                $arrsms = array(
                    'status' => 'error',
                    'msg' => "",
                );
                return $arrsms;
            }

            //echo $accessToken;
            //exit;

            $url = "https://dpis6uat.sso.go.th/oapi/open_api_users/callapi";
            $url = "https://sso.dpis.go.th/oapi/open_api_users/callapi";
            $header = array(
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: ' . $accessToken
            );
            $param = array(
                'endpoint' => 'sso_personal',
                'limit' => 1000,
            );

            $data_result = $this->calleservice($url, $header, $param);

            if ($data_result['message'] != "success") {
                $arrsms = array(
                    'status' => 'error',
                    'msg' => "",
                );
                return $arrsms;
            }

            $data = $data_result["data"];
            $decrypt_data = $this->ssl_decrypt_api($data, $encrypt_key);
            $js = json_decode($decrypt_data, true);

            $totalPage = $data_result['totalPage'];
            $limit = $data_result['limit'];
            $totalRow = $data_result['totalRow'];

            $arrsms = array(
                'status' => 'success',
                'totalPage' => $totalPage,
                'limit' => $limit,
                'totalRow' => $totalRow,
            );
            return $arrsms;
        } catch (\Exception $e) {
            return 'error ' . $e->getMessage();
        }
    }


    public function actionProcesssyndata_()
    {
        $seltype = null;
        if (!empty($_REQUEST['seltype'])) $seltype = $_REQUEST['seltype'];

        if (is_null($seltype)) {
            $arrsms = array(
                'status' => 'error',
                'msg' => "กรุณาใส่ประเภทเจ้าหน้าที่",
            );
            return $arrsms;
        }

        error_reporting(E_ALL | E_STRICT);
        try {

            ini_set("default_socket_timeout", 20000);

            $conn = Yii::$app->dbdpis;
            $connemp = Yii::$app->dbdpisemp;




            ini_set('memory_limit', '2048M');
            //ini_set('max_execution_time', 0);
            set_time_limit(0);

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $url_gettoken = "https://dpis6uat.sso.go.th/oapi/login";

            $url_gettoken = 'https://sso.dpis.go.th/oapi/login';
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url_gettoken,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
                    "username":"niras_s@hotmail.com",
                    "password":"LcNRemVEmAbS4Cv"
                }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));
            // UAT DJs4FkJcxzZUp9T
            // PRD LcNRemVEmAbS4Cv

            $response = curl_exec($curl);
            if (curl_errno($curl)) {
                return false;
            }

            curl_close($curl);
            $result = json_decode($response, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                if (array_key_exists("error", $result)) {
                    $arrsms = array(
                        'status' => 'error',
                        'msg' => $result['error']['message'],
                    );
                    return $arrsms;
                }
                $accessToken = $result['accessToken'];
                $encrypt_key = $result['encrypt_key'];
            } else {
                $arrsms = array(
                    'status' => 'error',
                    'msg' => "",
                );
                return $arrsms;
            }

            //echo $accessToken;
            //exit;


            // https://dpis6uat.sso.go.th/oapi/login
            // https://dpis6uat.sso.go.th/oapi/open_api_users/callapi
            $url = "https://dpis6uat.sso.go.th/oapi/open_api_users/callapi";
            $url = "https://sso.dpis.go.th/oapi/open_api_users/callapi";
            $header = array(
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: ' . $accessToken
            );
            $param = array(
                'endpoint' => 'sso_personal',
                'limit' => 1000,
                'page' => 1
            );

            $data_result = $this->calleservice($url, $header, $param);

            if ($data_result['message'] != "success") {
                $arrsms = array(
                    'status' => 'error',
                    'msg' => "",
                );
                return $arrsms;
            }

            $data = $data_result["data"];
            $decrypt_data = $this->ssl_decrypt_api($data, $encrypt_key);
            $js = json_decode($decrypt_data, true);

            $log_path = Yii::$app->getRuntimePath() . '\logs\logAll_' . date('d-M-Y') . '.log';
            $results = print_r($decrypt_data, true);
            \app\components\CommonFnc::write_log($log_path, $results);
            exit;

            echo count($js);

            exit;




            $totalPage = $data_result['totalPage'];

            $merge = array_merge($js, array());

            if ($totalPage > 1) {
                for ($i = 2; $i <= $totalPage; $i++) {
                    $param['page'] = $i;

                    $next_data_result = $this->calleservice($url, $header, $param);
                    $next_data = $next_data_result["data"];
                    $page = $next_data_result['page'];
                    //echo $page . "<br>";

                    $next_decrypt_data = $this->ssl_decrypt_api($next_data, $encrypt_key);
                    $next_js = json_decode($next_decrypt_data, true);
                    //var_dump($next_js) . "<br>";

                    array_push($js, $next_js);
                    $merge = array_merge($merge, $next_js);
                }
            }




            $per_id = "";
            $per_cardno = "";
            $birth_date = "";
            $fullname_th = "";
            $prename_th = "";
            $per_name = "";
            $per_surname = "";
            $prename_en = "";
            $per_eng_name = "";
            $per_eng_surname = "";
            $fullname_en = "";
            $per_startdate = "";
            $per_occupydate = "";
            $pertype_id = "";
            $pertype = "";
            $linename_th = "";
            $pos_no = "";
            $levelname_th = "";
            $organize_th = "";
            $organize_th_ass = "";
            $per_status = "";

            $arrGov = array();
            $arrEmp = array();

            $arrNoGov = array();
            $arrNoEmp = array();


            if (json_last_error() === JSON_ERROR_NONE) {


                $SQL = "SELECT * FROM PER_PERSONAL";
                $cmd = $conn->createCommand($SQL);
                $rowsGov = $cmd->queryAll();


                $cmd = $connemp->createCommand($SQL);
                $rowsEmp = $cmd->queryAll();


                foreach ($merge as $key => $value) {
                    //echo $value["per_id"] . "\n";
                    $per_id = $value["per_id"];
                    //$per_cardno = $value["per_cardno"]; 
                    $per_cardno = substr($value["per_cardno"], 0, 13);
                    $birth_date = $value["birth_date"];
                    $fullname_th = $value["fullname_th"];
                    $prename_th = $value["prename_th"];
                    $per_name = $value["per_name"];
                    $per_surname = $value["per_surname"];
                    $prename_en = $value["prename_en"];
                    $per_eng_name = $value["per_eng_name"];
                    $per_eng_surname = $value["per_eng_surname"];
                    $fullname_en = $value["fullname_en"];
                    $per_startdate = $value["per_startdate"];
                    $per_occupydate = $value["per_occupydate"];
                    $pertype_id = $value["pertype_id"]; //ประเภท
                    $pertype = $value["pertype"];
                    $linename_th = $value["linename_th"];
                    $pos_no = $value["pos_no"];
                    $levelname_th = $value["levelname_th"];
                    $organize_th = $value["organize_th"];
                    $organize_th_ass = $value["organize_th_ass"];
                    $per_status = $value["per_status"];

                    $connmy = Yii::$app->db;
                    /*
                    $sql = "SELECT * FROM trn_ssobranch WHERE ssobranch_code=:ssobranch_code ";
                    $commandmy = $connmy->createCommand($sql);
                    $commandmy->bindValue(":ssobranch_code", $this->branchcode);
                    $rows = $commandmy->queryAll();var_dump($rows);exit;*/

                    /*
                    $sql = "SELECT * FROM personal_tmp WHERE per_cardno=:per_cardno ";
                    $commandmy = $connmy->createCommand($sql);
                    $commandmy->bindValue(":per_cardno", $per_cardno);
                    $rowsmy = $commandmy->queryAll();*/

                    $noemp = false;
                    //[pertype_id] 
                    // 5 , 43 , 43  ข้าราชการ ลูกจ้าง
                    // 66 พนักงานประกันสังคม


                    switch ($pertype_id) {
                        case 5:
                        case 42:
                        case 43:
                        case 44:
                            //update db ข้าราชการ
                            $sql = "UPDATE PER_PERSONAL SET 
                            PER_NAME=:PER_NAME ,PER_SURNAME=:PER_SURNAME ,
                            PER_ENG_NAME=:PER_ENG_NAME ,PER_ENG_SURNAME=:PER_ENG_SURNAME, 
                            PER_BIRTHDATE=:PER_BIRTHDATE, 
                            PER_STARTDATE=:PER_STARTDATE, PER_OCCUPYDATE=:PER_OCCUPYDATE, 
                            PER_STATUS=:PER_STATUS 
                            WHERE PER_CARDNO=:PER_CARDNO ";
                            $cmd = $conn->createCommand($sql);
                            //$cmd->bindValue(":PN_CODE", $this->cover);
                            $cmd->bindValue(":PER_NAME", $per_name);
                            $cmd->bindValue(":PER_SURNAME", $per_surname);
                            $cmd->bindValue(":PER_ENG_NAME", $per_eng_name);
                            $cmd->bindValue(":PER_ENG_SURNAME", $per_eng_surname);
                            $cmd->bindValue(":PER_BIRTHDATE", $birth_date);
                            $cmd->bindValue(":PER_STARTDATE", $per_startdate);
                            $cmd->bindValue(":PER_OCCUPYDATE", $per_occupydate);
                            $cmd->bindValue(":PER_STATUS", $per_status);
                            $cmd->bindValue(":PER_CARDNO", $per_cardno);
                            //$intup = $cmd->execute();
                            $intup = '';

                            //echo  'ข้าราชการ '  . $per_id . $per_name . " ";
                            //echo  'ผล ' . $intup . "<br>";
                            if ($per_cardno == "") {
                                $log_path = Yii::$app->getRuntimePath() . '\logs\lognoidcard_' . date('d-M-Y') . '.txt';
                                $results = 'ข้าราชการ '  . $per_id . " " . $per_name . " " . $per_surname;
                                \app\components\CommonFnc::write_log($log_path, $results);
                            } else {

                                $sql = "UPDATE PER_PERSONAL SET 
                                PER_NAME='{$per_name}' ,PER_SURNAME='{$per_surname}' ,
                                PER_ENG_NAME='{$per_eng_name}' ,PER_ENG_SURNAME='{$per_eng_surname}', 
                                PER_BIRTHDATE='{$birth_date}', 
                                PER_STARTDATE='{$per_startdate}', PER_OCCUPYDATE='{$per_occupydate}', 
                                PER_STATUS='{$per_status}' 
                                WHERE PER_CARDNO='{$per_cardno}' ";
                                $string = str_replace(array("\n", "\r"), '', $sql);
                                $arrGov[] = $string;
                            }

                            $have = true;
                            //หาคนที่เพิ่มเข้ามาใหม่
                            foreach ($rowsGov as $dataitem) {
                                //var_dump( array_search($per_cardno,$dataitem,true)) ;

                                if (array_search($per_cardno, $dataitem, true)) {
                                    $have = true;
                                    break;
                                } else {
                                    $have = false;
                                }
                            }

                            if (!$have) {
                                $arrNoGov = $value;
                            }

                            break;
                        case 66:

                            //update db พนักงาน
                            $sql = "UPDATE PER_PERSONAL SET 
                            PER_NAME=:PER_NAME ,PER_SURNAME=:PER_SURNAME ,
                            PER_ENG_NAME=:PER_ENG_NAME ,PER_ENG_SURNAME=:PER_ENG_SURNAME, 
                            PER_BIRTHDATE=:PER_BIRTHDATE, 
                            PER_STARTDATE=:PER_STARTDATE, PER_OCCUPYDATE=:PER_OCCUPYDATE, 
                            PER_STATUS=:PER_STATUS 
                            WHERE PER_CARDNO=:PER_CARDNO ";
                            $cmdemp = $connemp->createCommand($sql);
                            //$cmdemp->bindValue(":PN_CODE", $PN_);
                            $cmdemp->bindValue(":PER_NAME", $per_name);
                            $cmdemp->bindValue(":PER_SURNAME", $per_surname);
                            $cmdemp->bindValue(":PER_ENG_NAME", $per_eng_name);
                            $cmdemp->bindValue(":PER_ENG_SURNAME", $per_eng_surname);
                            $cmdemp->bindValue(":PER_BIRTHDATE", $birth_date);
                            $cmdemp->bindValue(":PER_STARTDATE", $per_startdate);
                            $cmdemp->bindValue(":PER_OCCUPYDATE", $per_occupydate);
                            $cmdemp->bindValue(":PER_STATUS", $per_status);
                            $cmdemp->bindValue(":PER_CARDNO", $per_cardno);
                            $intup = '';
                            //$intup = $cmdemp->execute();

                            if ($per_cardno == "") {
                                $log_path = Yii::$app->getRuntimePath() . '\logs\lognoidcardemp_' . date('d-M-Y') . '.txt';
                                $results = 'พนักงาน '  . $per_id . " " . $per_name . " " . $per_surname;
                                \app\components\CommonFnc::write_log($log_path, $results);
                            } else {
                                $sql = "UPDATE PER_PERSONAL SET 
                                PER_NAME='{$per_name}' ,PER_SURNAME='{$per_surname}' ,
                                PER_ENG_NAME='{$per_eng_name}' ,PER_ENG_SURNAME='{$per_eng_surname}', 
                                PER_BIRTHDATE='{$birth_date}', 
                                PER_STARTDATE='{$per_startdate}', PER_OCCUPYDATE='{$per_occupydate}', 
                                PER_STATUS='{$per_status}' 
                                WHERE PER_CARDNO='{$per_cardno}' ";
                                $string = str_replace(array("\n", "\r"), '', $sql);
                                $arrEmp[] = $string;
                            }

                            $have = true;
                            //หาคนที่เพิ่มเข้ามาใหม่
                            foreach ($rowsEmp as $dataitem) {
                                //var_dump( array_search($per_cardno,$dataitem,true)) ;

                                if (array_search($per_cardno, $dataitem, true)) {
                                    $have = true;
                                    break;
                                } else {
                                    $have = false;
                                }
                            }

                            if (!$have) {
                                $arrNoEmp = $value;
                            }

                            $resid =  $this->isValidNationalId(substr($per_cardno, 0, 13));



                            if ($intup == 0) {
                            }
                            break;
                    }


                    $noemp = false;
                }



                $List = implode(';', $arrNoGov);
                $log_path = Yii::$app->getRuntimePath() . '\logs\NoGov' . date('d-M-Y') . '.txt';
                \app\components\CommonFnc::write_log($log_path, $List);

                $List = implode(';', $arrNoEmp);
                $log_path = Yii::$app->getRuntimePath() . '\logs\NoEmp' . date('d-M-Y') . '.txt';
                \app\components\CommonFnc::write_log($log_path, $List);


                if ($seltype == 1) {
                    $arrsplit = array_chunk($arrGov, 100, false);
                    foreach ($arrsplit as $item) {
                        $sql = implode(';', $item);
                        $cmd = $conn->createCommand("BEGIN " . $sql . "; END;");
                        $govup = $cmd->execute();
                    }

                    $arrsms = array(
                        'status' => 'success',
                        'msg' => count($arrGov),
                    );
                }

                if ($seltype == 2) {
                    $arrsplit = array_chunk($arrEmp, 100, false);
                    foreach ($arrsplit as $item) {
                        $sql = implode(';', $arrEmp);
                        $cmdemp = $connemp->createCommand("BEGIN " . $sql . "; END;");
                        $empup = $cmdemp->execute();
                    }

                    $arrsms = array(
                        'status' => 'success',
                        'msg' => count($arrEmp),
                    );
                }
                /*
                $arrsms = array(
                    'status' => 'success',
                    'msg' => count($merge),
                );
                */
                return $arrsms;
            } else {
                $arrsms = array(
                    'status' => 'error',
                    'msg' => "",
                );
                return $arrsms;
            }
        } catch (\Exception $e) {
            return 'error ' . $e->getMessage();
        }
    }

    public function actionProcesssyndata()
    {
        $seltype = null;
        if (!empty($_REQUEST['seltype'])) $seltype = $_REQUEST['seltype'];

        if (is_null($seltype)) {
            $arrsms = array(
                'status' => 'error',
                'msg' => "กรุณาใส่ประเภทเจ้าหน้าที่",
            );
            return $arrsms;
        }

        error_reporting(E_ALL | E_STRICT);
        try {

            ini_set("default_socket_timeout", 20000);

            $conn = Yii::$app->dbdpis;
            $connemp = Yii::$app->dbdpisemp;




            ini_set('memory_limit', '2048M');
            //ini_set('max_execution_time', 0);
            set_time_limit(0);

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $url_gettoken = "https://dpis6uat.sso.go.th/oapi/login";

            $url_gettoken = 'https://sso.dpis.go.th/oapi/login';
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url_gettoken,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
                    "username":"niras_s@hotmail.com",
                    "password":"LcNRemVEmAbS4Cv"
                }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));
            // UAT DJs4FkJcxzZUp9T
            // PRD LcNRemVEmAbS4Cv

            $response = curl_exec($curl);
            if (curl_errno($curl)) {
                return false;
            }

            curl_close($curl);
            $result = json_decode($response, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                if (array_key_exists("error", $result)) {
                    $arrsms = array(
                        'status' => 'error',
                        'msg' => $result['error']['message'],
                    );
                    return $arrsms;
                }
                $accessToken = $result['accessToken'];
                $encrypt_key = $result['encrypt_key'];
            } else {
                $arrsms = array(
                    'status' => 'error',
                    'msg' => "",
                );
                return $arrsms;
            }

            //echo $accessToken;
            //exit;


            // https://dpis6uat.sso.go.th/oapi/login
            // https://dpis6uat.sso.go.th/oapi/open_api_users/callapi
            $url = "https://dpis6uat.sso.go.th/oapi/open_api_users/callapi";
            $url = "https://sso.dpis.go.th/oapi/open_api_users/callapi";
            $header = array(
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: ' . $accessToken
            );
            $param = array(
                'endpoint' => 'sso_personal',
                //'limit' => 1000,
                'page' => 1
            );

            $data_result = $this->calleservice($url, $header, $param);

            if ($data_result['message'] != "success") {
                $arrsms = array(
                    'status' => 'error',
                    'msg' => "",
                );
                return $arrsms;
            }

            $data = $data_result["data"];
            $decrypt_data = $this->ssl_decrypt_api($data, $encrypt_key);
            $js = json_decode($decrypt_data, true);

            /*
            $log_path = Yii::$app->getRuntimePath() . '\logs\logAll_' . date('d-M-Y') . '.log'; 
            $results = print_r($decrypt_data, true);
             \app\components\CommonFnc::write_log($log_path, $results);exit;

            echo count($js);
            
            exit;*/




            $totalPage = $data_result['totalPage'];

            $merge = array_merge($js, array());

            if ($totalPage > 1) {
                for ($i = 2; $i <= $totalPage; $i++) {
                    $param['page'] = $i;

                    $next_data_result = $this->calleservice($url, $header, $param);
                    $next_data = $next_data_result["data"];
                    $page = $next_data_result['page'];
                    //echo $page . "<br>";

                    $next_decrypt_data = $this->ssl_decrypt_api($next_data, $encrypt_key);
                    $next_js = json_decode($next_decrypt_data, true);
                    //var_dump($next_js) . "<br>";

                    array_push($js, $next_js);
                    $merge = array_merge($merge, $next_js);
                }
            }


            $log_path = Yii::$app->getRuntimePath() . '\logs\logAll_' . date('d-M-Y') . '.txt';
            $results = print_r($merge, true);
            \app\components\CommonFnc::write_log($log_path, $results);
            exit;

            echo count($js);

            exit;




            $per_id = "";
            $per_cardno = "";
            $birth_date = "";
            $fullname_th = "";
            $prename_th = "";
            $per_name = "";
            $per_surname = "";
            $prename_en = "";
            $per_eng_name = "";
            $per_eng_surname = "";
            $fullname_en = "";
            $per_startdate = "";
            $per_occupydate = "";
            $pertype_id = "";
            $pertype = "";
            $linename_th = "";
            $pos_no = "";
            $levelname_th = "";
            $organize_th = "";
            $organize_th_ass = "";
            $per_status = "";

            $arrGov = array();
            $arrEmp = array();

            $arrNoGov = array();
            $arrNoEmp = array();


            if (json_last_error() === JSON_ERROR_NONE) {


                $SQL = "SELECT * FROM PER_PERSONAL";
                $cmd = $conn->createCommand($SQL);
                $rowsGov = $cmd->queryAll();


                $cmd = $connemp->createCommand($SQL);
                $rowsEmp = $cmd->queryAll();


                foreach ($merge as $key => $value) {
                    //echo $value["per_id"] . "\n";
                    $per_id = $value["per_id"];
                    //$per_cardno = $value["per_cardno"]; 
                    $per_cardno = substr($value["per_cardno"], 0, 13);
                    $birth_date = $value["birth_date"];
                    $fullname_th = $value["fullname_th"];
                    $prename_th = $value["prename_th"];
                    $per_name = $value["per_name"];
                    $per_surname = $value["per_surname"];
                    $prename_en = $value["prename_en"];
                    $per_eng_name = $value["per_eng_name"];
                    $per_eng_surname = $value["per_eng_surname"];
                    $fullname_en = $value["fullname_en"];
                    $per_startdate = $value["per_startdate"];
                    $per_occupydate = $value["per_occupydate"];
                    $pertype_id = $value["pertype_id"]; //ประเภท
                    $pertype = $value["pertype"];
                    $linename_th = $value["linename_th"];
                    $pos_no = $value["pos_no"];
                    $levelname_th = $value["levelname_th"];
                    $organize_th = $value["organize_th"];
                    $organize_th_ass = $value["organize_th_ass"];
                    $per_status = $value["per_status"];

                    $connmy = Yii::$app->db;
                    /*
                    $sql = "SELECT * FROM trn_ssobranch WHERE ssobranch_code=:ssobranch_code ";
                    $commandmy = $connmy->createCommand($sql);
                    $commandmy->bindValue(":ssobranch_code", $this->branchcode);
                    $rows = $commandmy->queryAll();var_dump($rows);exit;*/

                    /*
                    $sql = "SELECT * FROM personal_tmp WHERE per_cardno=:per_cardno ";
                    $commandmy = $connmy->createCommand($sql);
                    $commandmy->bindValue(":per_cardno", $per_cardno);
                    $rowsmy = $commandmy->queryAll();*/

                    $noemp = false;
                    //[pertype_id] 
                    // 5 , 43 , 43  ข้าราชการ ลูกจ้าง
                    // 66 พนักงานประกันสังคม


                    switch ($pertype_id) {
                        case 5:
                        case 42:
                        case 43:
                        case 44:
                            //update db ข้าราชการ
                            $sql = "UPDATE PER_PERSONAL SET 
                            PER_NAME=:PER_NAME ,PER_SURNAME=:PER_SURNAME ,
                            PER_ENG_NAME=:PER_ENG_NAME ,PER_ENG_SURNAME=:PER_ENG_SURNAME, 
                            PER_BIRTHDATE=:PER_BIRTHDATE, 
                            PER_STARTDATE=:PER_STARTDATE, PER_OCCUPYDATE=:PER_OCCUPYDATE, 
                            PER_STATUS=:PER_STATUS 
                            WHERE PER_CARDNO=:PER_CARDNO ";
                            $cmd = $conn->createCommand($sql);
                            //$cmd->bindValue(":PN_CODE", $this->cover);
                            $cmd->bindValue(":PER_NAME", $per_name);
                            $cmd->bindValue(":PER_SURNAME", $per_surname);
                            $cmd->bindValue(":PER_ENG_NAME", $per_eng_name);
                            $cmd->bindValue(":PER_ENG_SURNAME", $per_eng_surname);
                            $cmd->bindValue(":PER_BIRTHDATE", $birth_date);
                            $cmd->bindValue(":PER_STARTDATE", $per_startdate);
                            $cmd->bindValue(":PER_OCCUPYDATE", $per_occupydate);
                            $cmd->bindValue(":PER_STATUS", $per_status);
                            $cmd->bindValue(":PER_CARDNO", $per_cardno);
                            //$intup = $cmd->execute();
                            $intup = '';

                            //echo  'ข้าราชการ '  . $per_id . $per_name . " ";
                            //echo  'ผล ' . $intup . "<br>";
                            if ($per_cardno == "") {
                                $log_path = Yii::$app->getRuntimePath() . '\logs\lognoidcard_' . date('d-M-Y') . '.txt';
                                $results = 'ข้าราชการ '  . $per_id . " " . $per_name . " " . $per_surname;
                                \app\components\CommonFnc::write_log($log_path, $results);
                            } else {

                                $sql = "UPDATE PER_PERSONAL SET 
                                PER_NAME='{$per_name}' ,PER_SURNAME='{$per_surname}' ,
                                PER_ENG_NAME='{$per_eng_name}' ,PER_ENG_SURNAME='{$per_eng_surname}', 
                                PER_BIRTHDATE='{$birth_date}', 
                                PER_STARTDATE='{$per_startdate}', PER_OCCUPYDATE='{$per_occupydate}', 
                                PER_STATUS='{$per_status}' 
                                WHERE PER_CARDNO='{$per_cardno}' ";
                                $string = str_replace(array("\n", "\r"), '', $sql);
                                $arrGov[] = $string;
                            }

                            $have = true;
                            //หาคนที่เพิ่มเข้ามาใหม่
                            foreach ($rowsGov as $dataitem) {
                                //var_dump( array_search($per_cardno,$dataitem,true)) ;

                                if (array_search($per_cardno, $dataitem, true)) {
                                    $have = true;
                                    break;
                                } else {
                                    $have = false;
                                }
                            }

                            if (!$have) {
                                $arrNoGov = $value;
                            }

                            break;
                        case 66:

                            //update db พนักงาน
                            $sql = "UPDATE PER_PERSONAL SET 
                            PER_NAME=:PER_NAME ,PER_SURNAME=:PER_SURNAME ,
                            PER_ENG_NAME=:PER_ENG_NAME ,PER_ENG_SURNAME=:PER_ENG_SURNAME, 
                            PER_BIRTHDATE=:PER_BIRTHDATE, 
                            PER_STARTDATE=:PER_STARTDATE, PER_OCCUPYDATE=:PER_OCCUPYDATE, 
                            PER_STATUS=:PER_STATUS 
                            WHERE PER_CARDNO=:PER_CARDNO ";
                            $cmdemp = $connemp->createCommand($sql);
                            //$cmdemp->bindValue(":PN_CODE", $PN_);
                            $cmdemp->bindValue(":PER_NAME", $per_name);
                            $cmdemp->bindValue(":PER_SURNAME", $per_surname);
                            $cmdemp->bindValue(":PER_ENG_NAME", $per_eng_name);
                            $cmdemp->bindValue(":PER_ENG_SURNAME", $per_eng_surname);
                            $cmdemp->bindValue(":PER_BIRTHDATE", $birth_date);
                            $cmdemp->bindValue(":PER_STARTDATE", $per_startdate);
                            $cmdemp->bindValue(":PER_OCCUPYDATE", $per_occupydate);
                            $cmdemp->bindValue(":PER_STATUS", $per_status);
                            $cmdemp->bindValue(":PER_CARDNO", $per_cardno);
                            $intup = '';
                            //$intup = $cmdemp->execute();

                            if ($per_cardno == "") {
                                $log_path = Yii::$app->getRuntimePath() . '\logs\lognoidcardemp_' . date('d-M-Y') . '.txt';
                                $results = 'พนักงาน '  . $per_id . " " . $per_name . " " . $per_surname;
                                \app\components\CommonFnc::write_log($log_path, $results);
                            } else {
                                $sql = "UPDATE PER_PERSONAL SET 
                                PER_NAME='{$per_name}' ,PER_SURNAME='{$per_surname}' ,
                                PER_ENG_NAME='{$per_eng_name}' ,PER_ENG_SURNAME='{$per_eng_surname}', 
                                PER_BIRTHDATE='{$birth_date}', 
                                PER_STARTDATE='{$per_startdate}', PER_OCCUPYDATE='{$per_occupydate}', 
                                PER_STATUS='{$per_status}' 
                                WHERE PER_CARDNO='{$per_cardno}' ";
                                $string = str_replace(array("\n", "\r"), '', $sql);
                                $arrEmp[] = $string;
                            }

                            $have = true;
                            //หาคนที่เพิ่มเข้ามาใหม่
                            foreach ($rowsEmp as $dataitem) {
                                //var_dump( array_search($per_cardno,$dataitem,true)) ;

                                if (array_search($per_cardno, $dataitem, true)) {
                                    $have = true;
                                    break;
                                } else {
                                    $have = false;
                                }
                            }

                            if (!$have) {
                                $arrNoEmp = $value;
                            }

                            $resid =  $this->isValidNationalId(substr($per_cardno, 0, 13));



                            if ($intup == 0) {
                            }
                            break;
                    }


                    $noemp = false;
                }



                $List = implode(';', $arrNoGov);
                $log_path = Yii::$app->getRuntimePath() . '\logs\NoGov' . date('d-M-Y') . '.txt';
                \app\components\CommonFnc::write_log($log_path, $List);

                $List = implode(';', $arrNoEmp);
                $log_path = Yii::$app->getRuntimePath() . '\logs\NoEmp' . date('d-M-Y') . '.txt';
                \app\components\CommonFnc::write_log($log_path, $List);


                if ($seltype == 1) {
                    $arrsplit = array_chunk($arrGov, 100, false);
                    foreach ($arrsplit as $item) {
                        $sql = implode(';', $item);
                        $cmd = $conn->createCommand("BEGIN " . $sql . "; END;");
                        $govup = $cmd->execute();
                    }

                    $arrsms = array(
                        'status' => 'success',
                        'msg' => count($arrGov),
                    );
                }

                if ($seltype == 2) {
                    $arrsplit = array_chunk($arrEmp, 100, false);
                    foreach ($arrsplit as $item) {
                        $sql = implode(';', $arrEmp);
                        $cmdemp = $connemp->createCommand("BEGIN " . $sql . "; END;");
                        $empup = $cmdemp->execute();
                    }

                    $arrsms = array(
                        'status' => 'success',
                        'msg' => count($arrEmp),
                    );
                }
                /*
                $arrsms = array(
                    'status' => 'success',
                    'msg' => count($merge),
                );
                */
                return $arrsms;
            } else {
                $arrsms = array(
                    'status' => 'error',
                    'msg' => "",
                );
                return $arrsms;
            }
        } catch (\Exception $e) {
            return 'error ' . $e->getMessage();
        }
    }


    function callsso_personal()
    {
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
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'POST',
            //CURLOPT_SSLVERSION => 6,
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
    }

    public function wh_log($log_msg, $logpath)
    {
        //$log_filename =  $_SERVER['DOCUMENT_ROOT'] . "/wpdcore/ledtextfile/sapiens";
        $yearter = intval(date("Y")) + 543;
        $yearter2 = substr($yearter, 2);
        //echo $yearter2;
        $monter = date("m");
        //$dayter = date("d") ;
        $dayter = date("d");
        if (!file_exists($logpath)) {
            // create directory/folder uploads.
            mkdir($logpath, 0777, true);
        }
        $log_file_data = $logpath . '/log_' . $yearter2 . $monter . $dayter . '.TXT';
        file_put_contents($log_file_data, $log_msg, FILE_APPEND);
    }
    public function check_id_card($cardid)
    {
        $num_id = $cardid;
        $group_1 = substr($num_id, 0, 1); // ดึงเอาเลขเลขตัวที่ 1 ของบัตรประชาชนออกมา
        $group_5 = substr($num_id, 12, 12);  // ดึงเอาเลขเลขตัวที่ 13 ของบัตรประชาชนออกมา

        $num1 = $group_1;
        $num2 = substr($num_id, 1, 1); // ดึงเอาเลขเลขตัวที่ 2 ของบัตรประชาชนออกมา
        $num3 = substr($num_id, 2, 1); // ดึงเอาเลขเลขตัวที่ 3 ของบัตรประชาชนออกมา
        $num4 = substr($num_id, 3, 1); // ดึงเอาเลขเลขตัวที่ 4 ของบัตรประชาชนออกมา
        $num5 = substr($num_id, 4, 1); // ดึงเอาเลขเลขตัวที่ 5 ของบัตรประชาชนออกมา
        $num6 = substr($num_id, 5, 1); // ดึงเอาเลขเลขตัวที่ 6 ของบัตรประชาชนออกมา
        $num7 = substr($num_id, 6, 1); // ดึงเอาเลขเลขตัวที่ 7 ของบัตรประชาชนออกมา
        $num8 = substr($num_id, 7, 1); // ดึงเอาเลขเลขตัวที่ 8 ของบัตรประชาชนออกมา
        $num9 = substr($num_id, 8, 1); // ดึงเอาเลขเลขตัวที่ 9 ของบัตรประชาชนออกมา
        $num10 = substr($num_id, 9, 1); // ดึงเอาเลขเลขตัวที่ 10 ของบัตรประชาชนออกมา
        $num11 = substr($num_id, 10, 1); // ดึงเอาเลขเลขตัวที่ 11 ของบัตรประชาชนออกมา
        $num12 = substr($num_id, 11, 1); // ดึงเอาเลขเลขตัวที่ 12 ของบัตรประชาชนออกมา
        $num13 = $group_5;


        // จากนั้นนำเลขที่ได้มา คูณ  กันดังนี้
        $cal_num1 = $num1 * 13; // เลขตัวที่ 1 ของบัตรประชาชน
        $cal_num2 = $num2 * 12; // เลขตัวที่ 2 ของบัตรประชาชน
        $cal_num3 = $num3 * 11; // เลขตัวที่ 3 ของบัตรประชาชน
        $cal_num4 = $num4 * 10; // เลขตัวที่ 4 ของบัตรประชาชน
        $cal_num5 = $num5 * 9; // เลขตัวที่ 5 ของบัตรประชาชน
        $cal_num6 = $num6 * 8; // เลขตัวที่ 6 ของบัตรประชาชน
        $cal_num7 = $num7 * 7; // เลขตัวที่ 7 ของบัตรประชาชน
        $cal_num8 = $num8 * 6; // เลขตัวที่ 8 ของบัตรประชาชน
        $cal_num9 = $num9 * 5; // เลขตัวที่  9  ของบัตรประชาชน
        $cal_num10 = $num10 * 4; // เลขตัวที่ 10 ของบัตรประชาชน
        $cal_num11 = $num11 * 3; // เลขตัวที่ 11 ของบัตรประชาชน
        $cal_num12 = $num12 * 2; // เลขตัวที่ 12 ของบัตรประชาชน


        //นำผลลัพธ์ทั้งหมดจากการคูณมาบวกกัน

        $cal_sum = $cal_num1 + $cal_num2 + $cal_num3 + $cal_num4 + $cal_num5 + $cal_num6 + $cal_num7 + $cal_num8 + $cal_num9 + $cal_num10 + $cal_num11 + $cal_num12;

        //นำผลบวกมา modulation ด้วย 11 เพื่อหาเศษส่วน
        $cal_mod = $cal_sum % 11;
        //นำ 11 ลบ กับส่วนที่เหลือจากการ  modulation 
        $cal_2 = 11 - $cal_mod;

        //ถ้าหากเลขที่ได้มา มีค่าเท่ากับเลขสุดท้ายของเลขบัตรประชาชน ถูกว่ามีความถูกต้อง
        if ($cal_2 == $num13) {
            return true;
            //return 'หมายเลขประชาชนถูกต้อง';
        } else {
            return false;
            //return  'หมายเลขประชาชนไม่ถูกต้อง';
        }
    }
    public function isValidNationalId(string $nationalId)
    {
        if (strlen($nationalId) === 13) {
            $digits = str_split($nationalId);
            $lastDigit = array_pop($digits);
            $sum = array_sum(array_map(function ($d, $k) {
                return ($k + 2) * $d;
            }, array_reverse($digits), array_keys($digits)));
            return $lastDigit === strval((11 - $sum % 11) % 10);
        }
        return false;
    }
}
