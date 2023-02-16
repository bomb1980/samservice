<?php

namespace app\controllers;

use app\components\CommonFnc;
use Yii;
use yii\web\Controller;
// use yii\helpers\Url;

use app\components\UserController;
use app\models\LogEvent;
use app\models\MasSsobranch;
use app\models\MasUser;
use app\models\PerPersonal1;
use yii\helpers\Url;

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

        $user_id = 1;
        if (Yii::$app->user->getId()) {


            $user_id = Yii::$app->user->getId();
        }

        $this->actionOganize($user_id);

        echo PerPersonal1::getFromApi($user_id);



        exit;
    }

    public function actionOganize($user_id = 1)
    {

        // $user_id = Yii::$app->user->getId();
        $con = Yii::$app->dbdpis;
        $con2 = Yii::$app->dbdpisemp;
        ini_set('memory_limit', '2048M');
        //ini_set('max_execution_time', 0);
        set_time_limit(0);
        global $params;
        $url_gettoken = $params['apiUrl'] . '/oapi/login'; //prd domain
        // $url_gettoken = 'https://172.16.12.248/oapi/login'; //prd ip
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

            echo json_encode(['success' => 'fail', 'msg' => 'เชื่อมฐานข้อมูลไม่สำเร็จ']);
            return false;
        }

        curl_close($curl);
        $result = json_decode($response, true);


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


        $url = $params['apiUrl'] . "/oapi/open_api_users/callapi";
        $header = array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: ' . $accessToken
        );

        $SqlOrgs = [];
        for ($p = 1; $p <= 20; ++$p) {


            $param = array(
                'endpoint' => 'sso_organize',
                'limit' => 1000,
                'page' => $p
            );

            $data_result = $this->calleservice($url, $header, $param);

            if ($data_result['message'] != "success") {
                $arrsms = array(
                    'status' => 'error',
                    'msg' => "",
                );
                return $arrsms;
            }

            $js = json_decode($this->ssl_decrypt_api($data_result["data"], $encrypt_key));

            if (count($js) == 0) {

                // echo $p;

                break;
            }

            foreach ($js as $ka => $va) {


                if ($va->department_id != 1640000) {
                    continue;
                }


                if ($va->orgclass_id == 1) {

                    $ot_code = '01';
                } else {
                    $ot_code = '03';
                }


                $SqlOrgs[] = "
                    SELECT 
                        " . $va->organize_id . " AS org_id,
                        '" . $va->organize_code . "' AS org_code,
                        '" . $va->organize_th . "' AS org_name,
                        '" . $va->department_id . "' AS department_id,
                        '" . $va->org_id_ass . "' AS org_id_ass,
                        '" . $va->org_seq_no . "' AS org_seq_no,
                        '" . $va->organize_add1 . "' AS org_addr1,
                        '" . $va->organize_add2 . "' AS org_addr2,
                        '" . $va->organize_add3 . "' AS org_addr3,
                        '" . $va->organize_job . "' AS org_job,
                        '" . $va->org_dopa_code . "' AS org_dopa_code,
                        '" . $ot_code . "' AS ot_code,
                        '" . $va->province_id . "' AS pv_code,
                        '" . $va->latitude . "' AS pos_lat,
                        '" . $va->longitude . "' AS pos_long
                    FROM dual
                ";

              

                if (count($SqlOrgs) > 300) {
                    // TO_CHAR( CURRENT_TIMESTAMP ,'YYYY-MM-DD HH24:MI:SS' )
                    $sql = "
                        MERGE INTO per_org_ass d
                        USING ( " . implode(' UNION ', $SqlOrgs) . " ) s ON ( d.org_id = s.org_id )
                        WHEN NOT MATCHED THEN
                        INSERT ( pos_lat, pos_long, pv_code, ot_code, org_dopa_code, org_job, org_addr2, org_addr3, org_addr1, department_id, update_user, update_date, org_id, org_code, org_name, org_short, ol_code, ap_code, ct_code, org_date, org_id_ref, org_active, org_website, org_seq_no, org_eng_name, dt_code, mg_code, pg_code, org_zone, org_id_ass ) VALUES
                        (  s.pos_lat, s.pos_long, s.pv_code, s.ot_code, s.org_dopa_code, s.org_job, s.org_addr2, s.org_addr3, s.org_addr1, s.department_id, :user_id, TO_CHAR( CURRENT_TIMESTAMP , 'YYYY-MM-DD HH24:MI:SS' ), s.org_id, s.org_code, s.org_name, '-', '-', NULL, '-', NULL, '0', '1', NULL, s.org_seq_no, NULL, NULL, NULL, NULL, NULL, s.org_id_ass )
                        WHEN MATCHED THEN
                        UPDATE
                        SET
                            update_date = TO_CHAR( CURRENT_TIMESTAMP, 'YYYY-MM-DD HH24:MI:SS' ),
                            org_code = s.org_code,
                            org_name = s.org_name,
                            department_id = s.department_id,
                            org_id_ass = s.org_id_ass,
                            org_seq_no = s.org_seq_no,
                            org_addr1 = s.org_addr1,
                            org_addr2 = s.org_addr2,
                            org_addr3 = s.org_addr3,
                            org_job = s.org_job,
                            org_dopa_code = s.org_dopa_code,
                            ot_code = s.ot_code,
                            pv_code = s.pv_code,
                            pos_lat = s.pos_lat,
                            pos_long = s.pos_long,
                            update_user = :user_id
                    ";

                    foreach ([1, 2] as $kg => $vg) {

                        if ($vg == 1) {

                            $cmd = $con->createCommand($sql);
                        } else {

                            $cmd = $con2->createCommand($sql);
                        }

                        $cmd->bindValue(":user_id", $user_id);

                        $cmd->execute();
                    }

                    $SqlOrgs = [];
                }
            }
        }

        if (count($SqlOrgs) > 0) {
            // TO_CHAR( CURRENT_TIMESTAMP ,'YYYY-MM-DD HH24:MI:SS' )
            $sql = "
                MERGE INTO per_org_ass d
                USING ( " . implode(' UNION ', $SqlOrgs) . " ) s ON ( d.org_id = s.org_id )
                WHEN NOT MATCHED THEN
                INSERT ( pos_lat, pos_long, pv_code, ot_code, org_dopa_code, org_job, org_addr2, org_addr3, org_addr1, department_id, update_user, update_date, org_id, org_code, org_name, org_short, ol_code, ap_code, ct_code, org_date, org_id_ref, org_active, org_website, org_seq_no, org_eng_name, dt_code, mg_code, pg_code, org_zone, org_id_ass ) VALUES
                (  s.pos_lat, s.pos_long, s.pv_code, s.ot_code, s.org_dopa_code, s.org_job, s.org_addr2, s.org_addr3, s.org_addr1, s.department_id, :user_id, TO_CHAR( CURRENT_TIMESTAMP , 'YYYY-MM-DD HH24:MI:SS' ), s.org_id, s.org_code, s.org_name, '-', '-', NULL, '-', NULL, '0', '1', NULL, s.org_seq_no, NULL, NULL, NULL, NULL, NULL, s.org_id_ass )
                WHEN MATCHED THEN
                UPDATE
                SET
                    update_date = TO_CHAR( CURRENT_TIMESTAMP, 'YYYY-MM-DD HH24:MI:SS' ),
                    org_code = s.org_code,
                    org_name = s.org_name,
                    department_id = s.department_id,
                    org_id_ass = s.org_id_ass,
                    org_seq_no = s.org_seq_no,
                    org_addr1 = s.org_addr1,
                    org_addr2 = s.org_addr2,
                    org_addr3 = s.org_addr3,
                    org_job = s.org_job,
                    org_dopa_code = s.org_dopa_code,
                    ot_code = s.ot_code,
                    pv_code = s.pv_code,
                    pos_lat = s.pos_lat,
                    pos_long = s.pos_long,
                    update_user = :user_id
            ";

            foreach ([1, 2] as $kg => $vg) {

                if ($vg == 1) {

                    $cmd = $con->createCommand($sql);
                } else {

                    $cmd = $con2->createCommand($sql);
                }

                $cmd->bindValue(":user_id", $user_id);

                $cmd->execute();
            }


            $SqlOrgs = [];
        }



        $log_path = Yii::$app->getRuntimePath() . '\logs\log_SSO_Organize_' . date('d-M-Y') . '.log';
        $results = print_r($js, true);
        \app\components\CommonFnc::write_log($log_path, $results);


        return;


        // exit;
    }

    public function actionTest1()
    {

        // 120
        $old_arr = [
            'org_id',
            'level_no',
            'level_no_salary',
            'per_id',
            'pos_id',
            'dpis6_data',
            'update_date',
            'per_status',
            'per_gender',
            'org_id_1',
            'org_id_2',
            'org_id_3',
            'org_id_4',
            'org_id_5',
            'pn_code',
            'ot_code',
            'per_name',
            'per_cardno',
            'per_eng_surname',
            'per_occupydate',
            'update_user',
            'bomb',
            'per_type',
            'per_surname',
            'per_eng_name',
            'per_birthdate',
            'per_startdate',
            'poem_id',
            'per_orgmgt',
            'per_salary',
            'per_mgtsalary',
            'per_spsalary',
            'mr_code',
            'per_offno',
            'per_taxno',
            'per_blood',
            're_code',
            'per_retiredate',
            'per_posdate',
            'per_saldate',
            'pn_code_f',
            'per_fathername',
            'per_fathersurname',
            'pn_code_m',
            'per_mothername',
            'per_mothersurname',
            'per_add1',
            'per_add2',
            'pv_code',
            'mov_code',
            'per_ordain',
            'per_soldier',
            'per_member',
            'department_id',
            'approve_per_id',
            'replace_per_id',
            'absent_flag',
            'poems_id',
            'per_hip_flag',
            'per_cert_occ',
            'per_nickname',
            'per_home_tel',
            'per_office_tel',
            'per_fax',
            'per_mobile',
            'per_email',
            'per_file_no',
            'per_bank_account',
            'per_id_ref',
            'per_id_ass_ref',
            'per_contact_person',
            'per_remark',
            'per_start_org',
            'per_cooperative',
            'per_cooperative_no',
            'per_memberdate',
            'per_seq_no',
            'pay_id',
            'es_code',
            'pl_name_work',
            'org_name_work',
            'per_docno',
            'per_docdate',
            'per_effectivedate',
            'per_pos_reason',
            'per_pos_year',
            'per_pos_doctype',
            'per_pos_docno',
            'per_pos_org',
            'per_ordain_detail',
            'per_pos_orgmgt',
            'per_pos_docdate',
            'per_pos_desc',
            'per_pos_remark',
            'per_book_no',
            'per_book_date',
            'per_contact_count',
            'per_disability',
            'pot_id',
            'per_union',
            'per_uniondate',
            'per_job',
            'per_union2',
            'per_uniondate2',
            'per_union3',
            'per_uniondate3',
            'per_union4',
            'per_uniondate4',
            'per_union5',
            'per_uniondate5',
            'per_set_ass',
            'per_audit_flag',
            'per_probation_flag',
            'department_id_ass',
            'per_birth_place',
            'per_scar',
            'per_renew',
            'per_leveldate',
            'per_postdate',
            'per_ot_flag',
        ];

        // exit;
        //     SELECT
        //     p.per_id,p.per_cardno,p.birth_date,concat(p.prename_th,p.per_name," ",p.per_surname) as fullname_th,
        //     p.prename_th,
        //     p.per_name,
        //     per_surname,
        //     p.prename_en,
        //     p.per_eng_name,
        //     per_eng_surname,
        //     concat(p.prename_en,p.per_eng_name," ",p.per_eng_surname) as fullname_en,
        //     p.per_startdate,
        //     p.per_occupydate,
        //     p.pertype_id,   
        //     (select organize_th from organize where organize_id=p.organize_id_ass) as organize_th_ass,
        //     p.per_status,
        //     p.organize_id_ass,
        //     p.pos_id,
        //     p.per_level_id,

        //     tb_level.level_code,
        //     tb_level.positiontype_id as level_positiontype_id,
        //     tb_level.pertype_id as level_pertype_id,
        //     tb_level.levelname_th,

        //     tb_line.line_code,
        //     tb_line.positiontype_id as line_positiontype_id,
        //     tb_line.pertype_id as line_pertype_id,
        //     tb_line.linename_th,

        //     tb_pertype.pertype_code,
        //     tb_pertype.pertype,

        //     o.organize_code,
        //     o.organize_th,

        //     po.pertype_id as position_pertype_id,
        //     po.organize_id,
        //     po.pos_no,
        //     po.pos_salary,
        //     po.line_id,


        // FROM per_personal p
        // LEFT JOIN pos_position po ON p.pos_id=po.pos_id
        // LEFT JOIN organize o ON po.organize_id=o.organize_id
        // INNER JOIN tb_pertype ON p.pertype_id=tb_pertype.pertype_id 
        // LEFT JOIN tb_line ON po.line_id=tb_line.line_id
        // LEFT JOIN tb_level ON p.per_level_id=tb_level.level_id
        $decrypt_data = '[{"org_owner":"1640000","per_cardno":"3539900052242","per_id":"353990005224201","per_name":"\u0e2a\u0e38\u0e01\u0e24\u0e15","per_surname":"\u0e01\u0e21\u0e25\u0e27\u0e31\u0e12\u0e19\u0e32","d5_per_id":"670","pos_id":"0","pos_no":null,"per_status":"2","per_offno":null,"per_renew":null,"per_taxno":null,"per_start_org":null,"per_startdate":"2002-10-01","per_occupydate":"2002-10-01","per_effectivedate":"2018-03-01","per_gender":"1","blood_id":null,"scar":null,"birth_place":null,"is_ordain":"0","ordain_date":null,"ordain_detail":null,"is_disability":"1","is_soldier_service":"0","per_saldate":null,"probation_startdate":null,"probation_enddate":null,"probation_passdate":null,"per_posdate":"2018-03-01","approve_per_id":null,"replace_per_id":null,"absent_flag":null,"level_no_salary":"03","per_mobile":null,"per_email":"sukrit.k@sso.go.th","per_file_no":null,"per_bank_account":null,"per_license_no":null,"per_id_ref":null,"per_nickname":null,"per_contact_person":null,"per_id_ass_ref":null,"per_cooperative":"0","per_cooperative_no":null,"per_seq_no":"1703","per_pos_reason":null,"per_pos_year":"2561","per_remark":null,"per_pos_docno":null,"per_pos_org":" ","per_pos_orgmgt":null,"per_pos_docdate":null,"per_pos_doctype":"\u0e25\u0e32\u0e2d\u0e2d\u0e01 1\/3\/2561 \u0e40\u0e19\u0e37\u0e48\u0e2d\u0e07\u0e08\u0e32\u0e01\u0e01\u0e25\u0e31\u0e1a\u0e44\u0e1b\u0e14\u0e39\u0e41\u0e25\u0e1a\u0e34\u0e14\u0e32\u0e41\u0e25\u0e30\u0e21\u0e32\u0e23\u0e14\u0e32\u0e17\u0e35\u0e48\u0e20\u0e39\u0e21\u0e34\u0e25\u0e33\u0e40\u0e19\u0e32","per_pos_remark":null,"per_book_no":null,"per_book_date":null,"per_contract_count":null,"disability_id":null,"per_pos_desc":"\u0e2d\u0e19\u0e38\u0e0d\u0e32\u0e15\u0e43\u0e2b\u0e49\u0e1e\u0e19\u0e31\u0e01\u0e07\u0e32\u0e19\u0e25\u0e32\u0e2d\u0e2d\u0e01\u0e08\u0e32\u0e01\u0e23\u0e32\u0e0a\u0e01\u0e32\u0e23","per_job":null,"is_auditor":"0","per_ot_flag":null,"per_type_2535":null,"prename_id":"3","prename_th":"\u0e19\u0e32\u0e22","prename_en":"Mr.","per_eng_name":"SUKRIT","per_eng_surname":"KAMOLWATTANA","married_id":"1","religion_id":"-1","pertype_id":"66","department_id":"1640000","province_id":null,"movement_id":"66","pay_no":null,"per_orgmgt":"0","per_level_id":"-1","posstatus_id":null,"probation_flag":"0","per_salary":"24640.00","per_mgtsalary":"0.00","per_spsalary":"0.00","retired_date":"2035-10-01","nbs_flag":"0","hip_flag":"0","newwave_flag":"0","tena":"0","per_union":"0","per_uniondate":null,"per_union2":"0","per_uniondate2":null,"per_union3":"0","per_uniondate3":null,"per_union4":"0","per_uniondate4":null,"per_union5":"0","per_uniondate5":null,"per_member":"0","per_memberdate":null,"is_sync":"0","sync_datetime":null,"dcid":"1071948","sync_status_code":null,"per_set_ass":"1","organize_id_ass":"1640028","organize_id_work":null,"organize_id_kpi":"0","organize_id_salary":"0","scholar_flag":"0","relocation_type":"0","relocation_name":"0","audit_flag":null,"audit_by":null,"audit_date":null,"department_id_ass":"1640000","create_date":"2017-11-02 14:37:52","creator":"-1","create_org":"1640000","update_date":"2022-12-11 10:30:09","update_user":"-1","update_name":"Administrator","allow_sync":"1","edit_req_no":null,"update_org":"1640000","birth_date":"1974-10-04","creator_name":"Administrator","audit_name":null,"is_delete":"0","exam_register_id":null,"father_name":null,"father_surname":null,"father_prename_th":"","father_prename_id":null,"mother_name":null,"mother_surname":null,"mother_prename_th":"","mother_prename_id":null,"is_draft":"0","biometric_id":"3539900052242","area_province_id":null,"decoration_date":null,"decoration_id":null,"decoration_th":null,"decoration_abbr":null,"per_level_date":null,"per_line_date":null}]';


        $js = json_decode($decrypt_data, true);
        foreach ($js[0] as $kj => $vj) {
            if (in_array($kj, $old_arr)) {
            } else {

                arr($kj, 0);
            }
        }
        // arr($js[0]);

        exit;



        global $params;

        $url_gettoken = $params['apiUrl'] . '/oapi/login'; //prd domain

        // $url_gettoken = 'https://172.16.12.248/oapi/login'; //prd ip
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

            echo json_encode(['success' => 'fail', 'msg' => 'เชื่อมฐานข้อมูลไม่สำเร็จ']);
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
        $url = "https://dpis6uat.sso.go.th/oapi/open_api_users/callapi";
        $url = "https://sso.dpis.go.th/oapi/open_api_users/callapi";
        $header = array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: ' . $accessToken
        );
        $param = array(
            'endpoint' => 'ssotest',
            'limit' => 1,
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
        echo $decrypt_data = $this->ssl_decrypt_api($data, $encrypt_key);

        exit;

        $js = json_decode($decrypt_data, true);
        arr($js);
    }

 public function actionPos_position( $user_id = 1 )
    {

        $con = Yii::$app->dbdpis;
        $con2 = Yii::$app->dbdpisemp;

        // echo 'dasffddsa';exit;


        ini_set('memory_limit', '2048M');
        //ini_set('max_execution_time', 0);
        set_time_limit(0);
        global $params;

        $url_gettoken = $params['apiUrl'] . '/oapi/login'; //prd domain

        // $url_gettoken = 'https://172.16.12.248/oapi/login'; //prd ip
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

            echo json_encode(['success' => 'fail', 'msg' => 'เชื่อมฐานข้อมูลไม่สำเร็จ']);
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
        // $url = "https://dpis6uat.sso.go.th/oapi/open_api_users/callapi";
        $url = $params['apiUrl'] ."/oapi/open_api_users/callapi";
        $header = array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: ' . $accessToken
        );


        for( $p = 1; $p <= 100; ++$p ) {

            $param = array(
                'endpoint' => 'pos_position',
                'limit' => 1000,
                'page' => $p
    
            );
    
            $data_result = $this->calleservice( $url, $header, $param );
    
    
            if ($data_result['message'] != "success") {
                $arrsms = array(
                    'status' => 'error',
                    'msg' => "",
                );
                return $arrsms;
            }
    
            $data = $data_result["data"];
            $decrypt_data = $this->ssl_decrypt_api($data, $encrypt_key);
            
    
            $js = json_decode($decrypt_data);


            if( count($js) == 0 ) {
                break;
            }
    
            foreach( $js as $ka => $va ) {
                
                // arr(  $va );
                // [pos_id] => 1
                // [dcid] => 727784
                // [pertype_id] => 5
                // [organize_id] => 1640001
                // [pos_no] => 1
                // [pos_no_name] => 
                // [pos_salary] => 65880.00
                // [pos_mgtsalary] => 14500.00
                // [min_salary] => 
                // [max_salary] => 
                // [group_salary] => 
                // [pos_condition] => 
                // [pos_doc_no] => 
                // [pos_remark] => 
                // [pos_date] => 2002-10-01
                // [approve_name] => 
                // [approve_docno] => 
                // [approve_date] => 
                // [pos_get_date] => 2002-10-01
                // [pos_change_date] => 2021-10-01
                // [pos_vacant_date] => 2021-10-01
                // [pos_orgmgt] => 
                // [line_id] => 1
                // [mposition_id] => 4
                // [colevel_id] => 93
                // [level_id] => 24
                // [level_id_min] => 
                // [level_id_max] => 
                // [flag_level] => 
                // [condition_id] => 77
                // [frametype_id] => 
                // [skill_id] => 665
                // [positionstat_id] => 
                // [audit_flag] => 
                
                // [pos_south] => 
                // [pos_spec] => 
                // [pos_job_description] => 
                // [d5_pg_code] => 
                // [allow_decor] => 
                // [practicetype_id] => 
                // [self_ratio] => 
                // [chief_ratio] => 
                // [friend_ratio] => 
                // [sub_ratio] => 
                // [update_user] => 384060004041801
                // [update_date] => 2023-02-02 14:18:14
                // [is_sync] => 0
                // [sync_datetime] => 2023-02-02 14:18:14
                // [sync_status_code] => 200
                // [recruit_plan] => 
                // [creator] => -1
                // [create_date] => 2022-12-02 20:31:59
                // [exper_skill] => 
                // [work_location_id] => 
                // [governor_flag] => 0
                // [province_id] => 0
                // [d5_pos_id] => 1
                // [org_owner] => 1640000
                // [audit_by] => 
                // [audit_date] => 
                // [create_org] => 1640000
                // [update_org] => 1640000
                // [pos_value] => 
                // [update_name] => Administrator
                // [creator_name] => Administrator
                // [pos_retire] => 
                // [pos_retire_remark] => 
                // [reserve_flag] => 
                // [posreserve_id] => 
                // [pos_reserve_desc] => 
                // [pos_reserve_docno] => 
                // [pos_reserve_date] => 

                if( empty($va->d5_pos_id )) {

                    $pos_id = $va->pos_id;
                }
                else {

                    $pos_id = $va->d5_pos_id;
                }

                $SqlOrgs[] = "
                    SELECT 
                        ". $pos_id ." as pos_id, 
                        '". $va->ppt_code ."' as ppt_code, 
                        '". $va->pos_status ."' as pos_status, 
                        '". $va->pos_no ."' as pos_no, 
                        '". $va->pos_seq_no ."' as pos_seq_no, 
                        ". $va->organize_id ." as org_id, 
                        '". $va->pay_no ."' as pay_no, 
                        'test' as skill_code, 
                        ". $user_id ." as update_user, 
                        'ggg' as cl_name,  
                        'ddddd' as level_no, 
                        1 as org_id_1, 
                        1 as org_id_2, 
                        1 as org_id_3, 
                        1 as org_id_4, 
                        1 as org_id_5, 
                        'test' as ot_code, 
                        'test' as pm_code, 
                        'test' as pl_code, 
                        'test' as pos_salary, 
                        'test' as pos_mgtsalary, 
                        'test' as pt_code, 
                        'test' as pc_code, 
                        'test' as pos_condition, 
                        'test' as pos_doc_no, 
                        'test' as pos_remark, 
                        'test' as pos_date, 
                        'test' as pos_get_date, 
                        'test' as pos_change_date, 
                         
                        'test' as department_id, 
                        'test' as pos_orgmgt, 
                        'test' as pos_no_name, 
                        'test' as audit_flag, 
                        'test' as pos_retire, 
                        'test' as pos_reserve, 
                        'test' as pos_reserve_desc, 
                        'test' as pos_reserve_docno, 
                        'test' as pos_retire_remark, 
                        'test' as pr_code, 
                        'test' as pos_reserve2, 
                        'test' as pos_vacant_date, 
                        'test' as flag_level, 
                        'test' as pn_code
                    FROM dual
                ";

                if (count($SqlOrgs) == 100 ) {
                    $sql = "
                        MERGE INTO per_position d
                        USING ( " . implode(' UNION ', $SqlOrgs) . " ) s ON ( d.pos_id = s.pos_id )
                        WHEN NOT MATCHED THEN
                        INSERT  ( update_date, pos_id, cl_name, level_no, org_id, org_id_1, org_id_2, org_id_3, org_id_4, org_id_5, pos_no, ot_code, pm_code, pl_code, pos_salary, pos_mgtsalary, skill_code, pt_code, pc_code, pos_condition, pos_doc_no, pos_remark, pos_date, pos_get_date, pos_change_date, pos_status, update_user,  department_id, pos_seq_no, pay_no, pos_orgmgt, pos_no_name, audit_flag, ppt_code, pos_retire, pos_reserve, pos_reserve_desc, pos_reserve_docno, pos_retire_remark, pr_code, pos_reserve2, pos_vacant_date, flag_level, pn_code) VALUES
                        ( TO_CHAR( CURRENT_TIMESTAMP, 'YYYY-MM-DD HH24:MI:SS' ), s.pos_id, s.cl_name, s.level_no, s.org_id, s.org_id_1, s.org_id_2, s.org_id_3, s.org_id_4, s.org_id_5, s.pos_no, s.ot_code, s.pm_code, s.pl_code, s.pos_salary, s.pos_mgtsalary, s.skill_code, s.pt_code, s.pc_code, s.pos_condition, s.pos_doc_no, s.pos_remark, s.pos_date, s.pos_get_date, s.pos_change_date, s.pos_status, s.update_user, s. department_id, s.pos_seq_no, s.pay_no, s.pos_orgmgt, s.pos_no_name, s.audit_flag, s.ppt_code, s.pos_retire, s.pos_reserve, s.pos_reserve_desc, s.pos_reserve_docno, s.pos_retire_remark, s.pr_code, s.pos_reserve2, s.pos_vacant_date, s.flag_level, s.pn_code )
                        
                        WHEN MATCHED THEN
                        UPDATE
                        SET
                            update_date = TO_CHAR( CURRENT_TIMESTAMP, 'YYYY-MM-DD HH24:MI:SS' ),
                            cl_name = s.cl_name, 
                            level_no = s.level_no, 
                            org_id = s.org_id, 
                            org_id_1 = s.org_id_1, 
                            org_id_2 = s.org_id_2, 
                            org_id_3 = s.org_id_3, 
                            org_id_4 = s.org_id_4, 
                            org_id_5 = s.org_id_5, 
                            pos_no = s.pos_no, 
                            ot_code = s.ot_code, 
                            pm_code = s.pm_code, 
                            pl_code = s.pl_code, 
                            pos_salary = s.pos_salary, 
                            pos_mgtsalary = s.pos_mgtsalary, 
                            skill_code = s.skill_code, 
                            pt_code = s.pt_code, 
                            pc_code = s.pc_code, 
                            pos_condition = s.pos_condition, 
                            pos_doc_no = s.pos_doc_no, 
                            pos_remark = s.pos_remark, 
                            pos_date = s.pos_date, 
                            pos_get_date = s.pos_get_date, 
                            pos_change_date = s.pos_change_date, 
                            pos_status = s.pos_status, 
                            update_user = s.update_user, 
                            department_id = s.department_id, 
                            pos_seq_no = s.pos_seq_no, 
                            pay_no = s.pay_no, 
                            pos_orgmgt = s.pos_orgmgt, 
                            pos_no_name = s.pos_no_name, 
                            audit_flag = s.audit_flag, 
                            ppt_code = s.ppt_code, 
                            pos_retire = s.pos_retire, 
                            pos_reserve = s.pos_reserve, 
                            pos_reserve_desc = s.pos_reserve_desc, 
                            pos_reserve_docno = s.pos_reserve_docno, 
                            pos_retire_remark = s.pos_retire_remark, 
                            pr_code = s.pr_code, 
                            pos_reserve2 = s.pos_reserve2, 
                            pos_vacant_date = s.pos_vacant_date, 
                            flag_level = s.flag_level, 
                            pn_code = s.pn_code
                            
                        
                    ";

                    foreach ([1, 2] as $kg => $vg) {

                        if ($vg == 1) {
                            $cmd = $con->createCommand($sql);

                        } else {

                            $cmd = $con2->createCommand($sql);
                        }

                        // $cmd->bindValue(":user_id", $user_id);

                        $cmd->execute();
                    }

                    $SqlOrgs = [];

                    // exit;
                }
            

            }
        }

    
        if (count($SqlOrgs) == 0 ) {
            $sql = "
                MERGE INTO per_position d
                USING ( " . implode(' UNION ', $SqlOrgs) . " ) s ON ( d.pos_id = s.pos_id )
                WHEN NOT MATCHED THEN
                INSERT  ( update_date, pos_id, cl_name, level_no, org_id, org_id_1, org_id_2, org_id_3, org_id_4, org_id_5, pos_no, ot_code, pm_code, pl_code, pos_salary, pos_mgtsalary, skill_code, pt_code, pc_code, pos_condition, pos_doc_no, pos_remark, pos_date, pos_get_date, pos_change_date, pos_status, update_user,  department_id, pos_seq_no, pay_no, pos_orgmgt, pos_no_name, audit_flag, ppt_code, pos_retire, pos_reserve, pos_reserve_desc, pos_reserve_docno, pos_retire_remark, pr_code, pos_reserve2, pos_vacant_date, flag_level, pn_code) VALUES
                ( TO_CHAR( CURRENT_TIMESTAMP, 'YYYY-MM-DD HH24:MI:SS' ), s.pos_id, s.cl_name, s.level_no, s.org_id, s.org_id_1, s.org_id_2, s.org_id_3, s.org_id_4, s.org_id_5, s.pos_no, s.ot_code, s.pm_code, s.pl_code, s.pos_salary, s.pos_mgtsalary, s.skill_code, s.pt_code, s.pc_code, s.pos_condition, s.pos_doc_no, s.pos_remark, s.pos_date, s.pos_get_date, s.pos_change_date, s.pos_status, s.update_user, s. department_id, s.pos_seq_no, s.pay_no, s.pos_orgmgt, s.pos_no_name, s.audit_flag, s.ppt_code, s.pos_retire, s.pos_reserve, s.pos_reserve_desc, s.pos_reserve_docno, s.pos_retire_remark, s.pr_code, s.pos_reserve2, s.pos_vacant_date, s.flag_level, s.pn_code )
                
                WHEN MATCHED THEN
                UPDATE
                SET
                    update_date = TO_CHAR( CURRENT_TIMESTAMP, 'YYYY-MM-DD HH24:MI:SS' ),
                    cl_name = s.cl_name, 
                    level_no = s.level_no, 
                    org_id = s.org_id, 
                    org_id_1 = s.org_id_1, 
                    org_id_2 = s.org_id_2, 
                    org_id_3 = s.org_id_3, 
                    org_id_4 = s.org_id_4, 
                    org_id_5 = s.org_id_5, 
                    pos_no = s.pos_no, 
                    ot_code = s.ot_code, 
                    pm_code = s.pm_code, 
                    pl_code = s.pl_code, 
                    pos_salary = s.pos_salary, 
                    pos_mgtsalary = s.pos_mgtsalary, 
                    skill_code = s.skill_code, 
                    pt_code = s.pt_code, 
                    pc_code = s.pc_code, 
                    pos_condition = s.pos_condition, 
                    pos_doc_no = s.pos_doc_no, 
                    pos_remark = s.pos_remark, 
                    pos_date = s.pos_date, 
                    pos_get_date = s.pos_get_date, 
                    pos_change_date = s.pos_change_date, 
                    pos_status = s.pos_status, 
                    update_user = s.update_user, 
                    department_id = s.department_id, 
                    pos_seq_no = s.pos_seq_no, 
                    pay_no = s.pay_no, 
                    pos_orgmgt = s.pos_orgmgt, 
                    pos_no_name = s.pos_no_name, 
                    audit_flag = s.audit_flag, 
                    ppt_code = s.ppt_code, 
                    pos_retire = s.pos_retire, 
                    pos_reserve = s.pos_reserve, 
                    pos_reserve_desc = s.pos_reserve_desc, 
                    pos_reserve_docno = s.pos_reserve_docno, 
                    pos_retire_remark = s.pos_retire_remark, 
                    pr_code = s.pr_code, 
                    pos_reserve2 = s.pos_reserve2, 
                    pos_vacant_date = s.pos_vacant_date, 
                    flag_level = s.flag_level, 
                    pn_code = s.pn_code
                    
                
            ";

            foreach ([1, 2] as $kg => $vg) {

                if ($vg == 1) {
                    $cmd = $con->createCommand($sql);

                } else {

                    $cmd = $con2->createCommand($sql);
                }

                // $cmd->bindValue(":user_id", $user_id);

                $cmd->execute();
            }

            $SqlOrgs = [];

            // exit;
        }

        
        $log_path = Yii::$app->getRuntimePath() . '\logs\log_pos_position_' . date('d-M-Y') . '.log';
        $results = print_r($js, true);
        \app\components\CommonFnc::write_log($log_path, $results);
    }

    public function actionPos_position___()
    {

        ini_set('memory_limit', '2048M');
        //ini_set('max_execution_time', 0);
        set_time_limit(0);
        global $params;

        $url_gettoken = $params['apiUrl'] . '/oapi/login'; //prd domain

        // $url_gettoken = 'https://172.16.12.248/oapi/login'; //prd ip
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

            echo json_encode(['success' => 'fail', 'msg' => 'เชื่อมฐานข้อมูลไม่สำเร็จ']);
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
        $url = "https://dpis6uat.sso.go.th/oapi/open_api_users/callapi";
        $url = "https://sso.dpis.go.th/oapi/open_api_users/callapi";
        $header = array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: ' . $accessToken
        );
        $param = array(
            'endpoint' => 'pos_position',
            'limit' => 10000,
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
        
        $log_path = Yii::$app->getRuntimePath() . '\logs\log_pos_position_' . date('d-M-Y') . '.log';
        $results = print_r($js, true);
        \app\components\CommonFnc::write_log($log_path, $results);
    }

    public function actionTb_pertype()
    {

        ini_set('memory_limit', '2048M');
        //ini_set('max_execution_time', 0);
        set_time_limit(0);
        global $params;

        $url_gettoken = $params['apiUrl'] . '/oapi/login'; //prd domain

        // $url_gettoken = 'https://172.16.12.248/oapi/login'; //prd ip
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

            echo json_encode(['success' => 'fail', 'msg' => 'เชื่อมฐานข้อมูลไม่สำเร็จ']);
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
        $url = "https://dpis6uat.sso.go.th/oapi/open_api_users/callapi";
        $url = "https://sso.dpis.go.th/oapi/open_api_users/callapi";
        $header = array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: ' . $accessToken
        );
        $param = array(
            'endpoint' => 'tb_pertype',
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
        
        $log_path = Yii::$app->getRuntimePath() . '\logs\log_tb_pertype_' . date('d-M-Y') . '.log';
        $results = print_r($js, true);
        \app\components\CommonFnc::write_log($log_path, $results);
    }

    public function actionTb_line()
    {

        ini_set('memory_limit', '2048M');
        //ini_set('max_execution_time', 0);
        set_time_limit(0);
        global $params;

        $url_gettoken = $params['apiUrl'] . '/oapi/login'; //prd domain

        // $url_gettoken = 'https://172.16.12.248/oapi/login'; //prd ip
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

            echo json_encode(['success' => 'fail', 'msg' => 'เชื่อมฐานข้อมูลไม่สำเร็จ']);
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
        $url = "https://dpis6uat.sso.go.th/oapi/open_api_users/callapi";
        $url = "https://sso.dpis.go.th/oapi/open_api_users/callapi";
        $header = array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: ' . $accessToken
        );
        $param = array(
            'endpoint' => 'tb_line',
            'limit' => 10000,
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
        
        $log_path = Yii::$app->getRuntimePath() . '\logs\log_tb_line_' . date('d-M-Y') . '.log';
        $results = print_r($js, true);
        \app\components\CommonFnc::write_log($log_path, $results);
    }

    public function actionTb_level()
    {

        $con = Yii::$app->dbdpis;
        $con2 = Yii::$app->dbdpisemp;

        ini_set('memory_limit', '2048M');
        //ini_set('max_execution_time', 0);
        set_time_limit(0);
        global $params;

        $url_gettoken = $params['apiUrl'] . '/oapi/login'; //prd domain

        // $url_gettoken = 'https://172.16.12.248/oapi/login'; //prd ip
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

            echo json_encode(['success' => 'fail', 'msg' => 'เชื่อมฐานข้อมูลไม่สำเร็จ']);
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
        $url = "https://dpis6uat.sso.go.th/oapi/open_api_users/callapi";
        $url = "https://sso.dpis.go.th/oapi/open_api_users/callapi";
        $header = array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: ' . $accessToken
        );
        $param = array(
            'endpoint' => 'tb_level',
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

        
        if (count($js) == 0) {

            // echo $p;

            break;
        }

        foreach ($js as $ka => $va) {


            if ($va->department_id != 1640000) {
                continue;
            }


            if ($va->orgclass_id == 1) {

                $ot_code = '01';
            } else {
                $ot_code = '03';
            }


            $SqlOrgs[] = "
                SELECT 
                    " . $va->level_id . " AS id,
                    '" . $va->level_code . "' AS level_no,
                    '" . $va->levelname_th . "' AS level_name,

                    '" . $va->updatedate . "' AS update_date,

                    '" . $va->org_id_ass . "' AS org_id_ass,
                    '" . $va->org_seq_no . "' AS org_seq_no,
                    '" . $va->organize_add1 . "' AS org_addr1,
                    '" . $va->organize_add2 . "' AS org_addr2,
                    '" . $va->organize_add3 . "' AS org_addr3,
                    '" . $va->organize_job . "' AS org_job,
                    '" . $va->org_dopa_code . "' AS org_dopa_code,
                    '" . $ot_code . "' AS ot_code,
                    '" . $va->province_id . "' AS pv_code,
                    '" . $va->latitude . "' AS pos_lat,
                    '" . $va->longitude . "' AS pos_long
                FROM dual
            ";

            // [org_status] => 1, [organize_pid] => 17, [org_date] => , [org_start_date] => , [org_end_date] => , [organize_en] => , [organize_abbrth] => สำนักงานประกันสังคม, [organize_abbren] => 
            // , [country_id] => 41,  [amphur_id] => , [tambon_id] => , [postcode] => , [risk_zone] => , [orglevel_id] => 2, [orgstat_id] => , [orgclass_id] => 1, [orgtype_id] => 1, [org_owner_id] => 0, [org_mode] => 1, [org_website] => , [org_gps] => , [ministrygroup_id] => , [sector_id] => , [org_chart_level] => , [command_no] => , [command_date] => , [canceldate] => , [telephone] => , [fax] => , [email] => , [remark] => , [sortorder] => , [parent_flag] => 1, [creator] => -1, [createdate] => 2020-02-05 11:02:19, [create_org] => 0, [updateuser] => 310210128083701, [updatedate] => 2022-12-14 14:05:44, [update_org] => 100000, [is_sync] => 0, [sync_datetime] => 2022-12-20 15:44:22, [sync_status_code] => NULL, [org_path] => /17/1640000/, [ministry_id] => 17, [ministry] => กระทรวงแรงงาน, [department] => สำนักงานประกันสังคม, [division_id] => , [division] => , [subdiv1] => , [subdiv2] => , [subdiv3] => , [subdiv4] => , [subdiv5] => , [subdiv6] => , [d5_org_id] => 0, [org_model_id] => , [org_model_dlt_id] => , [leader_pos_id] => 0, [org_path_name] => /กระทรวงแรงงาน/สำนักงานประกันสังคม/

            if (count($SqlOrgs) > 300) {
                // TO_CHAR( CURRENT_TIMESTAMP ,'YYYY-MM-DD HH24:MI:SS' )
                $sql = "
                    MERGE INTO per_org_ass d
                    USING ( " . implode(' UNION ', $SqlOrgs) . " ) s ON ( d.org_id = s.org_id )
                    WHEN NOT MATCHED THEN
                    INSERT ( pos_lat, pos_long, pv_code, ot_code, org_dopa_code, org_job, org_addr2, org_addr3, org_addr1, department_id, update_user, update_date, org_id, org_code, org_name, org_short, ol_code, ap_code, ct_code, org_date, org_id_ref, org_active, org_website, org_seq_no, org_eng_name, dt_code, mg_code, pg_code, org_zone, org_id_ass ) VALUES
                    (  s.pos_lat, s.pos_long, s.pv_code, s.ot_code, s.org_dopa_code, s.org_job, s.org_addr2, s.org_addr3, s.org_addr1, s.department_id, :user_id, TO_CHAR( CURRENT_TIMESTAMP , 'YYYY-MM-DD HH24:MI:SS' ), s.org_id, s.org_code, s.org_name, '-', '-', NULL, '-', NULL, '0', '1', NULL, s.org_seq_no, NULL, NULL, NULL, NULL, NULL, s.org_id_ass )
                    WHEN MATCHED THEN
                    UPDATE
                    SET
                        update_date = TO_CHAR( CURRENT_TIMESTAMP, 'YYYY-MM-DD HH24:MI:SS' ),
                        org_code = s.org_code,
                        org_name = s.org_name,
                        department_id = s.department_id,
                        org_id_ass = s.org_id_ass,
                        org_seq_no = s.org_seq_no,
                        org_addr1 = s.org_addr1,
                        org_addr2 = s.org_addr2,
                        org_addr3 = s.org_addr3,
                        org_job = s.org_job,
                        org_dopa_code = s.org_dopa_code,
                        ot_code = s.ot_code,
                        pv_code = s.pv_code,
                        pos_lat = s.pos_lat,
                        pos_long = s.pos_long,
                        update_user = :user_id
                ";

                foreach ([1, 2] as $kg => $vg) {

                    if ($vg == 1) {

                        $cmd = $con->createCommand($sql);
                    } else {

                        $cmd = $con2->createCommand($sql);
                    }

                    $cmd->bindValue(":user_id", $user_id);

                    $cmd->execute();
                }

                $SqlOrgs = [];
            }
        }
    
        if (count($SqlOrgs) > 0) {
            // TO_CHAR( CURRENT_TIMESTAMP ,'YYYY-MM-DD HH24:MI:SS' )
            $sql = "
                MERGE INTO per_org_ass d
                USING ( " . implode(' UNION ', $SqlOrgs) . " ) s ON ( d.org_id = s.org_id )
                WHEN NOT MATCHED THEN
                INSERT ( pos_lat, pos_long, pv_code, ot_code, org_dopa_code, org_job, org_addr2, org_addr3, org_addr1, department_id, update_user, update_date, org_id, org_code, org_name, org_short, ol_code, ap_code, ct_code, org_date, org_id_ref, org_active, org_website, org_seq_no, org_eng_name, dt_code, mg_code, pg_code, org_zone, org_id_ass ) VALUES
                (  s.pos_lat, s.pos_long, s.pv_code, s.ot_code, s.org_dopa_code, s.org_job, s.org_addr2, s.org_addr3, s.org_addr1, s.department_id, :user_id, TO_CHAR( CURRENT_TIMESTAMP , 'YYYY-MM-DD HH24:MI:SS' ), s.org_id, s.org_code, s.org_name, '-', '-', NULL, '-', NULL, '0', '1', NULL, s.org_seq_no, NULL, NULL, NULL, NULL, NULL, s.org_id_ass )
                WHEN MATCHED THEN
                UPDATE
                SET
                    update_date = TO_CHAR( CURRENT_TIMESTAMP, 'YYYY-MM-DD HH24:MI:SS' ),
                    org_code = s.org_code,
                    org_name = s.org_name,
                    department_id = s.department_id,
                    org_id_ass = s.org_id_ass,
                    org_seq_no = s.org_seq_no,
                    org_addr1 = s.org_addr1,
                    org_addr2 = s.org_addr2,
                    org_addr3 = s.org_addr3,
                    org_job = s.org_job,
                    org_dopa_code = s.org_dopa_code,
                    ot_code = s.ot_code,
                    pv_code = s.pv_code,
                    pos_lat = s.pos_lat,
                    pos_long = s.pos_long,
                    update_user = :user_id
            ";

            foreach ([1, 2] as $kg => $vg) {

                if ($vg == 1) {
                    $cmd = $con->createCommand($sql);
                } else {
                    $cmd = $con2->createCommand($sql);
                }

                $cmd->bindValue(":user_id", $user_id);

                $cmd->execute();
            }


            $SqlOrgs = [];
        }

        
        $log_path = Yii::$app->getRuntimePath() . '\logs\log_tb_level_' . date('d-M-Y') . '.log';
        $results = print_r($js, true);
        \app\components\CommonFnc::write_log($log_path, $results);
    }


    public function actionTest()
    {
        exit;
        $log_page = basename(Yii::$app->request->referrer);

        $log_description = 'อัพเดตข้อมูลเจ้าหน้าที่';

        $createby = Yii::$app->user->getId();


        \app\models\CommonAction::AddEventLog($createby, "Update", $log_page, $log_description);
    }

    public function actionSyndata()
    {

        // arr( Yii::$app->params['prg_ctrl'] );

        $datas['columns'] = [
            // [
            //     'name' => 'PER_ID',
            //     'label' => 'id',
            //     'className' => "text-center",
            //     'orderable' => false
            // ],
            [
                'name' => 'PER_CARDNO',
                'label' => 'เลขบัตร',
                'className' => "text-center",
                'orderable' => false
            ],
            [
                'name' => 'POS_ID',
                'label' => 'เลขที่ตำแหน่ง',
                'className' => "text-center",
                'orderable' => false
            ],
            [
                'name' => 'FULL_NAME_THAI',
                'label' => 'ชื่อ นามสกุล',
                'className' => "text-center",
                'orderable' => false
            ],
            [
                'name' => 'LEVEL_NO',
                'label' => 'ระดับผู้ดำรงตำแหน่ง',
                'className' => "text-center",
                'orderable' => false
            ],
            [
                'name' => 'ORGANIZE_TH',
                'label' => 'สังกัดตามกฏหมาย',
                'className' => "text-center",
                'orderable' => false
            ],
            [
                'name' => 'ORGANIZE_TH_ASS',
                'label' => 'สังกัดตามมอบหมายงาน',
                'className' => "text-center",
                'orderable' => false
            ],
            // [
            //     'name' => 'PER_STARTDATE',
            //     'label' => 'เริ่มงานเมื่อ',
            //     'className' => "text-center",
            //     'orderable' => false
            // ],

            // [
            //     'name' => 'UPDATE_DATE_',
            //     'label' => 'อัพเดทเมื่อ',
            //     'className' => "text-center",
            //     'orderable' => false
            // ],
            [
                'name' => 'OT_NAME',
                'label' => 'ประเภทบุคลากร',
                'className' => "text-center",
                'orderable' => false
            ],
            [
                'name' => 'PER_STATUS_NAME',
                'label' => 'สถานะ',
                'className' => "text-center",
                'orderable' => false
            ],



        ];


        $LogEvents = LogEvent::find(['log_page' => 'syndata'])->orderBy(['log_id' => SORT_DESC])->limit(1)->all();


        $datas['last_user'] = NULL;
        foreach ($LogEvents as $ka => $LogEvent) {

            // arr( $LogEvent );

            if ($LogEvent['log_user'] == yii::$app->user->getId()) {

                $datas['last_user'] = '<div>อัพเดทข้อมูลล่าสุดเมื่อ <b style="color: #df390c;">' . $LogEvent->log_date . '</b> โดย <b style="color: #a53f6f;">คุณ</b> </div>';
            } else {

                $res = MasUser::findOne($LogEvent->log_user);

                if ($res) {
                    $datas['last_user'] = '<div>อัพเดทข้อมูลล่าสุดเมื่อ <b style="color: #df390c;">' . $LogEvent->log_date . '</b> โดยคุณ  <b style="color: #a53f6f;">' . $res['displayname'] . '</b> </div>';
                }
            }
        }

        return $this->render('view', $datas);
    }

    // http://samservice/empdata/user_register
    public function actionUser_register($id = NULL)
    {

        // arr(Yii::$app->user->identity->role_id);

        $res = MasUser::findOne($id);

        //form action
        if (Yii::$app->request->isPost) {


            $keep_errors = [];


            $r = Yii::$app->request->post();

            if (!$res) {

                $res = new MasUser();

                $res->load(\Yii::$app->request->post());


                if (empty($r['password'])) {

                    $keep_errors['password'] = 'please input user password';
                }
            }

            // arr( $r );

            $res->uid = $r['uid'];


            if (!empty($r['password'])) {

                if ($r['password'] != $r['passwordcheck']) {

                    $keep_errors['passwordcheck'] = 'confirm password not match';
                }

                $res->password = Yii::$app->getSecurity()->generatePasswordHash($r['password']);
            }
            // ssobranch_code

            $res->displayname = $r['displayname'];
            $res->ssobranch_code = $r['ssobranch_code'];
            $res->status = 1;
            $res->role_id = $r['role_id'];
            $res->create_by = json_encode(Yii::$app->user->getId());

            if (!$res->validate()) {

                foreach ($res->errors as $ke => $ve) {
                    $keep_errors[$ke] = $ve;
                }
            }

            if (!empty($keep_errors)) {

                Yii::$app->session->setFlash('warning', json_encode($keep_errors));
                $log_page = Yii::$app->request->referrer;

                return Yii::$app->getResponse()->redirect($log_page);
            }

            $res->save();

            $log_page = Url::to(['empdata/user_register', 'id' => $res->id]);

            return Yii::$app->getResponse()->redirect($log_page);
        }

        //view
        $datas['form']['id'] = NULL;
        $datas['form']['uid'] = NULL;
        $datas['form']['displayname'] = NULL;
        $datas['form']['ssobranch_code'] = NULL;
        $datas['button_text'] = 'เพิ่มผู้ใช้งาน';


        $datas['check1'] = 'checked';
        $datas['check2'] = NULL;
        if ($res) {

            $datas['form'] = $res;
            $datas['button_text'] = 'แก้ไขผู้ใช้งาน';

            if ($res->role_id != 1) {

                $datas['check1'] = NULL;
                $datas['check2'] = 'checked';
            }
        }

        $datas['MasSsobranch'] = MasSsobranch::find()->all();

        return $this->render('view_user_new', $datas);
    }



    // http://samservice/empdata/user_register
    public function actionUser_list($id = NULL)
    {
        $res = MasUser::findOne($id);

        //form action
        if (Yii::$app->request->isPost) {
        }

        //view
        if ($res) {
            $datas['form'] = $res;
            $datas['button_text'] = 'แก้ไขผู้ใช้งาน';
        } else {

            $datas['form']['uid'] = NULL;
            $datas['form']['displayname'] = NULL;
            $datas['form']['ssobranch_code'] = NULL;
            $datas['button_text'] = 'เพิ่มผู้ใช้งาน';
        }

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

        return $this->render('view_user_list', $datas);
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
            $url_gettoken = 'https://172.16.12.248/oapi/login';
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
            $url = "https://172.16.12.248/oapi/open_api_users/callapi";
            $header = array(
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: ' . $accessToken
            );
            $param = array(
                'endpoint' => 'sso_personal2',
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
