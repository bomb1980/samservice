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

        if( true ) {

            $user_id = 1;
            if (Yii::$app->user->getId()) {
    
    
                $user_id = Yii::$app->user->getId();
            }
    
         
    
            echo PerPersonal1::getFromApi($user_id);
        }
        else {

            $user_id = 1;
            if (Yii::$app->user->getId()) {
    
    
                $user_id = Yii::$app->user->getId();
            }
    
            $this->actionTb_line($user_id);
            $this->actionPos_position($user_id);
            $this->actionOganize($user_id);
            $this->actionTb_pertype($user_id);
            $this->actionTb_level($user_id);
    
            echo PerPersonal1::getFromApi($user_id);

        }





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

                // foreach( $va as $kc => $vc ){

                //     echo $kc . ', ';
                // }


                // exit;

                // if ($va->department_id != 1640000) {
                //     continue;
                // }


                // if ($va->orgclass_id == 1) {

                //     $ot_code = '01';
                // } else {
                //     $ot_code = '03';
                // }


                $SqlOrgs[] = "
                    SELECT 
                        '" . $va->organize_id . "' as organize_id, 
                        '" . $va->org_status . "' as org_status, 
                        '" . $va->organize_pid . "' as organize_pid, 
                        '" . $va->organize_code . "' as organize_code, 
                        '" . $va->org_date . "' as org_date, 
                        '" . $va->org_start_date . "' as org_start_date, 
                        '" . $va->org_end_date . "' as org_end_date, 
                        '" . $va->organize_th . "' as organize_th, 
                        '" . $va->organize_en . "' as organize_en, 
                        '" . $va->organize_abbrth . "' as organize_abbrth, 
                        '" . $va->organize_abbren . "' as organize_abbren, 
                        '" . $va->organize_add1 . "' as organize_add1, 
                        '" . $va->organize_add2 . "' as organize_add2, 
                        '" . $va->organize_add3 . "' as organize_add3, 
                        '" . $va->country_id . "' as country_id, 
                        '" . $va->province_id . "' as province_id, 
                        '" . $va->amphur_id . "' as amphur_id, 
                        '" . $va->tambon_id . "' as tambon_id, 
                        '" . $va->postcode . "' as postcode, 
                        '" . $va->risk_zone . "' as risk_zone, 
                        '" . $va->orglevel_id . "' as orglevel_id, 
                        '" . $va->orgstat_id . "' as orgstat_id, 
                        '" . $va->orgclass_id . "' as orgclass_id, 
                        '" . $va->orgtype_id . "' as orgtype_id, 
                        '" . $va->organize_job . "' as organize_job, 
                        '" . $va->org_owner_id . "' as org_owner_id, 
                        '" . $va->org_mode . "' as org_mode, 
                        '" . $va->org_website . "' as org_website, 
                        '" . $va->org_gps . "' as org_gps, 
                        '" . $va->latitude . "' as latitude, 
                        '" . $va->longitude . "' as longitude, 
                        '" . $va->org_dopa_code . "' as org_dopa_code, 
                        '" . $va->ministrygroup_id . "' as ministrygroup_id, 
                        '" . $va->sector_id . "' as sector_id, 
                        '" . $va->org_id_ass . "' as org_id_ass, 
                        '" . $va->org_chart_level . "' as org_chart_level, 
                        '" . $va->command_no . "' as command_no, 
                        '" . $va->command_date . "' as command_date, 
                        '" . $va->canceldate . "' as canceldate, 
                        '" . $va->telephone . "' as telephone, 
                        '" . $va->fax . "' as fax, 
                        '" . $va->email . "' as email, 
                        '" . $va->remark . "' as remark, 
                        '" . $va->sortorder . "' as sortorder, 
                        '" . $va->parent_flag . "' as parent_flag, 
                        '" . $va->creator . "' as creator, 
                        '" . $va->createdate . "' as createdate, 
                        '" . $va->create_org . "' as create_org, 
                        '" . $va->updateuser . "' as updateuser, 
                        '" . $va->updatedate . "' as updatedate, 
                        '" . $va->update_org . "' as update_org, 
                        '" . $va->is_sync . "' as is_sync, 
                        '" . $va->sync_datetime . "' as sync_datetime, 
                        '" . $va->sync_status_code . "' as sync_status_code, 
                        '" . $va->org_path . "' as org_path, 
                        '" . $va->org_seq_no . "' as org_seq_no, 
                        '" . $va->ministry_id . "' as ministry_id, 
                        '" . $va->ministry . "' as ministry, 
                        '" . $va->department_id . "' as department_id, 
                        '" . $va->department . "' as department, 
                        '" . $va->division_id . "' as division_id, 
                        '" . $va->division . "' as division, 
                        '" . $va->subdiv1 . "' as subdiv1, 
                        '" . $va->subdiv2 . "' as subdiv2, 
                        '" . $va->subdiv3 . "' as subdiv3, 
                        '" . $va->subdiv4 . "' as subdiv4, 
                        '" . $va->subdiv5 . "' as subdiv5, 
                        '" . $va->subdiv6 . "' as subdiv6, 
                        '" . $va->d5_org_id . "' as d5_org_id, 
                        '" . $va->org_model_id . "' as org_model_id, 
                        '" . $va->org_model_dlt_id . "' as org_model_dlt_id, 
                        '" . $va->leader_pos_id . "' as leader_pos_id, 
                        '" . $va->org_path_name . "' as org_path_name
                    FROM dual
                ";

                if (count($SqlOrgs) > 100) {
                    // TO_CHAR( CURRENT_TIMESTAMP ,'YYYY-MM-DD HH24:MI:SS' )
                    $sql = "
                        MERGE INTO per_org_ass_news d
                        USING ( " . implode(' UNION ', $SqlOrgs) . " ) s ON ( d.organize_id = s.organize_id )
                        WHEN NOT MATCHED THEN
                        INSERT ( organize_id, org_status, organize_pid, organize_code, org_date, org_start_date, org_end_date, organize_th, organize_en, organize_abbrth, organize_abbren, organize_add1, organize_add2, organize_add3, country_id, province_id, amphur_id, tambon_id, postcode, risk_zone, orglevel_id, orgstat_id, orgclass_id, orgtype_id, organize_job, org_owner_id, org_mode, org_website, org_gps, latitude, longitude, org_dopa_code, ministrygroup_id, sector_id, org_id_ass, org_chart_level, command_no, command_date, canceldate, telephone, fax, email, remark, sortorder, parent_flag, creator, createdate, create_org, updateuser, updatedate, update_org, is_sync, sync_datetime, sync_status_code, org_path, org_seq_no, ministry_id, ministry, department_id, department, division_id, division, subdiv1, subdiv2, subdiv3, subdiv4, subdiv5, subdiv6, d5_org_id, org_model_id, org_model_dlt_id, leader_pos_id, org_path_name ) VALUES
                        ( s.organize_id, s.org_status, s.organize_pid, s.organize_code, s.org_date, s.org_start_date, s.org_end_date, s.organize_th, s.organize_en, s.organize_abbrth, s.organize_abbren, s.organize_add1, s.organize_add2, s.organize_add3, s.country_id, s.province_id, s.amphur_id, s.tambon_id, s.postcode, s.risk_zone, s.orglevel_id, s.orgstat_id, s.orgclass_id, s.orgtype_id, s.organize_job, s.org_owner_id, s.org_mode, s.org_website, s.org_gps, s.latitude, s.longitude, s.org_dopa_code, s.ministrygroup_id, s.sector_id, s.org_id_ass, s.org_chart_level, s.command_no, s.command_date, s.canceldate, s.telephone, s.fax, s.email, s.remark, s.sortorder, s.parent_flag, s.creator, s.createdate, s.create_org, s.updateuser, s.updatedate, s.update_org, s.is_sync, s.sync_datetime, s.sync_status_code, s.org_path, s.org_seq_no, s.ministry_id, s.ministry, s.department_id, s.department, s.division_id, s.division, s.subdiv1, s.subdiv2, s.subdiv3, s.subdiv4, s.subdiv5, s.subdiv6, s.d5_org_id, s.org_model_id, s.org_model_dlt_id, s.leader_pos_id, s.org_path_name )
                        WHEN MATCHED THEN
                        UPDATE
                        SET
                            org_status = s.org_status, 
                            organize_pid = s.organize_pid, 
                            organize_code = s.organize_code, 
                            org_date = s.org_date, 
                            org_start_date = s.org_start_date, 
                            org_end_date = s.org_end_date, 
                            organize_th = s.organize_th, 
                            organize_en = s.organize_en, 
                            organize_abbrth = s.organize_abbrth, 
                            organize_abbren = s.organize_abbren, 
                            organize_add1 = s.organize_add1, 
                            organize_add2 = s.organize_add2, 
                            organize_add3 = s.organize_add3, 
                            country_id = s.country_id, 
                            province_id = s.province_id, 
                            amphur_id = s.amphur_id, 
                            tambon_id = s.tambon_id, 
                            postcode = s.postcode, 
                            risk_zone = s.risk_zone, 
                            orglevel_id = s.orglevel_id, 
                            orgstat_id = s.orgstat_id, 
                            orgclass_id = s.orgclass_id, 
                            orgtype_id = s.orgtype_id, 
                            organize_job = s.organize_job, 
                            org_owner_id = s.org_owner_id, 
                            org_mode = s.org_mode, 
                            org_website = s.org_website, 
                            org_gps = s.org_gps, 
                            latitude = s.latitude, 
                            longitude = s.longitude, 
                            org_dopa_code = s.org_dopa_code, 
                            ministrygroup_id = s.ministrygroup_id, 
                            sector_id = s.sector_id, 
                            org_id_ass = s.org_id_ass, 
                            org_chart_level = s.org_chart_level, 
                            command_no = s.command_no, 
                            command_date = s.command_date, 
                            canceldate = s.canceldate, 
                            telephone = s.telephone, 
                            fax = s.fax, 
                            email = s.email, 
                            remark = s.remark, 
                            sortorder = s.sortorder, 
                            parent_flag = s.parent_flag, 
                            creator = s.creator, 
                            createdate = s.createdate, 
                            create_org = s.create_org, 
                            updateuser = s.updateuser, 
                            updatedate = s.updatedate, 
                            update_org = s.update_org, 
                            is_sync = s.is_sync, 
                            sync_datetime = s.sync_datetime, 
                            sync_status_code = s.sync_status_code, 
                            org_path = s.org_path, 
                            org_seq_no = s.org_seq_no, 
                            ministry_id = s.ministry_id, 
                            ministry = s.ministry, 
                            department_id = s.department_id, 
                            department = s.department, 
                            division_id = s.division_id, 
                            division = s.division, 
                            subdiv1 = s.subdiv1, 
                            subdiv2 = s.subdiv2, 
                            subdiv3 = s.subdiv3, 
                            subdiv4 = s.subdiv4, 
                            subdiv5 = s.subdiv5, 
                            subdiv6 = s.subdiv6, 
                            d5_org_id = s.d5_org_id, 
                            org_model_id = s.org_model_id, 
                            org_model_dlt_id = s.org_model_dlt_id, 
                            leader_pos_id = s.leader_pos_id, 
                            org_path_name = s.org_path_name
                    ";

                    foreach ($params['dbInserts'] as $kg => $vg) {

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

        if (count($SqlOrgs) > 0) {
            // TO_CHAR( CURRENT_TIMESTAMP ,'YYYY-MM-DD HH24:MI:SS' )
            $sql = "
                MERGE INTO per_org_ass_news d
                USING ( " . implode(' UNION ', $SqlOrgs) . " ) s ON ( d.organize_id = s.organize_id )
                WHEN NOT MATCHED THEN
                INSERT ( organize_id, org_status, organize_pid, organize_code, org_date, org_start_date, org_end_date, organize_th, organize_en, organize_abbrth, organize_abbren, organize_add1, organize_add2, organize_add3, country_id, province_id, amphur_id, tambon_id, postcode, risk_zone, orglevel_id, orgstat_id, orgclass_id, orgtype_id, organize_job, org_owner_id, org_mode, org_website, org_gps, latitude, longitude, org_dopa_code, ministrygroup_id, sector_id, org_id_ass, org_chart_level, command_no, command_date, canceldate, telephone, fax, email, remark, sortorder, parent_flag, creator, createdate, create_org, updateuser, updatedate, update_org, is_sync, sync_datetime, sync_status_code, org_path, org_seq_no, ministry_id, ministry, department_id, department, division_id, division, subdiv1, subdiv2, subdiv3, subdiv4, subdiv5, subdiv6, d5_org_id, org_model_id, org_model_dlt_id, leader_pos_id, org_path_name ) VALUES
                ( s.organize_id, s.org_status, s.organize_pid, s.organize_code, s.org_date, s.org_start_date, s.org_end_date, s.organize_th, s.organize_en, s.organize_abbrth, s.organize_abbren, s.organize_add1, s.organize_add2, s.organize_add3, s.country_id, s.province_id, s.amphur_id, s.tambon_id, s.postcode, s.risk_zone, s.orglevel_id, s.orgstat_id, s.orgclass_id, s.orgtype_id, s.organize_job, s.org_owner_id, s.org_mode, s.org_website, s.org_gps, s.latitude, s.longitude, s.org_dopa_code, s.ministrygroup_id, s.sector_id, s.org_id_ass, s.org_chart_level, s.command_no, s.command_date, s.canceldate, s.telephone, s.fax, s.email, s.remark, s.sortorder, s.parent_flag, s.creator, s.createdate, s.create_org, s.updateuser, s.updatedate, s.update_org, s.is_sync, s.sync_datetime, s.sync_status_code, s.org_path, s.org_seq_no, s.ministry_id, s.ministry, s.department_id, s.department, s.division_id, s.division, s.subdiv1, s.subdiv2, s.subdiv3, s.subdiv4, s.subdiv5, s.subdiv6, s.d5_org_id, s.org_model_id, s.org_model_dlt_id, s.leader_pos_id, s.org_path_name )
                WHEN MATCHED THEN
                UPDATE
                SET
                    org_status = s.org_status, 
                    organize_pid = s.organize_pid, 
                    organize_code = s.organize_code, 
                    org_date = s.org_date, 
                    org_start_date = s.org_start_date, 
                    org_end_date = s.org_end_date, 
                    organize_th = s.organize_th, 
                    organize_en = s.organize_en, 
                    organize_abbrth = s.organize_abbrth, 
                    organize_abbren = s.organize_abbren, 
                    organize_add1 = s.organize_add1, 
                    organize_add2 = s.organize_add2, 
                    organize_add3 = s.organize_add3, 
                    country_id = s.country_id, 
                    province_id = s.province_id, 
                    amphur_id = s.amphur_id, 
                    tambon_id = s.tambon_id, 
                    postcode = s.postcode, 
                    risk_zone = s.risk_zone, 
                    orglevel_id = s.orglevel_id, 
                    orgstat_id = s.orgstat_id, 
                    orgclass_id = s.orgclass_id, 
                    orgtype_id = s.orgtype_id, 
                    organize_job = s.organize_job, 
                    org_owner_id = s.org_owner_id, 
                    org_mode = s.org_mode, 
                    org_website = s.org_website, 
                    org_gps = s.org_gps, 
                    latitude = s.latitude, 
                    longitude = s.longitude, 
                    org_dopa_code = s.org_dopa_code, 
                    ministrygroup_id = s.ministrygroup_id, 
                    sector_id = s.sector_id, 
                    org_id_ass = s.org_id_ass, 
                    org_chart_level = s.org_chart_level, 
                    command_no = s.command_no, 
                    command_date = s.command_date, 
                    canceldate = s.canceldate, 
                    telephone = s.telephone, 
                    fax = s.fax, 
                    email = s.email, 
                    remark = s.remark, 
                    sortorder = s.sortorder, 
                    parent_flag = s.parent_flag, 
                    creator = s.creator, 
                    createdate = s.createdate, 
                    create_org = s.create_org, 
                    updateuser = s.updateuser, 
                    updatedate = s.updatedate, 
                    update_org = s.update_org, 
                    is_sync = s.is_sync, 
                    sync_datetime = s.sync_datetime, 
                    sync_status_code = s.sync_status_code, 
                    org_path = s.org_path, 
                    org_seq_no = s.org_seq_no, 
                    ministry_id = s.ministry_id, 
                    ministry = s.ministry, 
                    department_id = s.department_id, 
                    department = s.department, 
                    division_id = s.division_id, 
                    division = s.division, 
                    subdiv1 = s.subdiv1, 
                    subdiv2 = s.subdiv2, 
                    subdiv3 = s.subdiv3, 
                    subdiv4 = s.subdiv4, 
                    subdiv5 = s.subdiv5, 
                    subdiv6 = s.subdiv6, 
                    d5_org_id = s.d5_org_id, 
                    org_model_id = s.org_model_id, 
                    org_model_dlt_id = s.org_model_dlt_id, 
                    leader_pos_id = s.leader_pos_id, 
                    org_path_name = s.org_path_name
            ";

            foreach ($params['dbInserts'] as $kg => $vg) {

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

    // http://samservice/empdata/pos_position
    public function actionPos_position($user_id = 1)
    {

        $con = Yii::$app->dbdpis;
        $con2 = Yii::$app->dbdpisemp;

        ini_set('memory_limit', '2048M');
        //ini_set('max_execution_time', 0);
        set_time_limit(0);
        global $params;

        $url_gettoken = $params['apiUrl'] . '/oapi/login'; //prd domain

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
        $url = $params['apiUrl'] . "/oapi/open_api_users/callapi";
        $header = array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: ' . $accessToken
        );


        for ($p = 1; $p <= 100; ++$p) {

            $param = array(
                'endpoint' => 'pos_position',
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

            $data = $data_result["data"];
            $decrypt_data = $this->ssl_decrypt_api($data, $encrypt_key);


            $js = json_decode($decrypt_data);


            if (count($js) == 0) {
                break;
            }

            foreach ($js as $ka => $va) {


                $SqlOrgs[] = "
                    SELECT 
                   '" . $va->pos_id . "' as pos_id,
                   '" . $va->dcid . "' as dcid,
                   '" . $va->pertype_id . "' as pertype_id,
                   '" . $va->organize_id . "' as organize_id,
                   '" . $va->pos_no . "' as pos_no,
                   '" . $va->pos_no_name . "' as pos_no_name,
                   '" . $va->pos_salary . "' as pos_salary,
                   '" . $va->pos_mgtsalary . "' as pos_mgtsalary,
                   '" . $va->min_salary . "' as min_salary,
                   '" . $va->max_salary . "' as max_salary,
                   '" . $va->group_salary . "' as group_salary,
                   '" . $va->pos_condition . "' as pos_condition,
                   '" . $va->pos_doc_no . "' as pos_doc_no,
                   '" . $va->pos_remark . "' as pos_remark,
                   '" . $va->pos_date . "' as pos_date,
                   '" . $va->approve_name . "' as approve_name,
                   '" . $va->approve_docno . "' as approve_docno,
                   '" . $va->approve_date . "' as approve_date,
                   '" . $va->pos_get_date . "' as pos_get_date,
                   '" . $va->pos_change_date . "' as pos_change_date,
                   '" . $va->pos_vacant_date . "' as pos_vacant_date,
                   '" . $va->pos_status . "' as pos_status,
                   '" . $va->pos_seq_no . "' as pos_seq_no,
                   '" . $va->pay_no . "' as pay_no,
                   '" . $va->pos_orgmgt . "' as pos_orgmgt,
                   '" . $va->line_id . "' as line_id,
                   '" . $va->mposition_id . "' as mposition_id,
                   '" . $va->colevel_id . "' as colevel_id,
                   '" . $va->level_id . "' as level_id,
                   '" . $va->level_id_min . "' as level_id_min,
                   '" . $va->level_id_max . "' as level_id_max,
                   '" . $va->flag_level . "' as flag_level,
                   '" . $va->condition_id . "' as condition_id,
                   '" . $va->frametype_id . "' as frametype_id,
                   '" . $va->skill_id . "' as skill_id,
                   '" . $va->positionstat_id . "' as positionstat_id,
                   '" . $va->audit_flag . "' as audit_flag,
                   '" . $va->ppt_code . "' as ppt_code,
                   '" . $va->pos_retire . "' as pos_retire,
                   '" . $va->pos_retire_remark . "' as pos_retire_remark,
                   '" . $va->reserve_flag . "' as reserve_flag,
                   '" . $va->posreserve_id . "' as posreserve_id,
                   '" . $va->pos_reserve_desc . "' as pos_reserve_desc,
                   '" . $va->pos_reserve_docno . "' as pos_reserve_docno,
                   '" . $va->pos_reserve_date . "' as pos_reserve_date,
                   '" . $va->pos_south . "' as pos_south,
                   '" . $va->pos_spec . "' as pos_spec,
                   '" . $va->pos_job_description . "' as pos_job_description,
                   '" . $va->d5_pg_code . "' as d5_pg_code,
                   '" . $va->allow_decor . "' as allow_decor,
                   '" . $va->practicetype_id . "' as practicetype_id,
                   '" . $va->self_ratio . "' as self_ratio,
                   '" . $va->chief_ratio . "' as chief_ratio,
                   '" . $va->friend_ratio . "' as friend_ratio,
                   '" . $va->sub_ratio . "' as sub_ratio,
                   '" . $va->update_user . "' as update_user,
                   '" . $va->update_date . "' as update_date,
                   '" . $va->is_sync . "' as is_sync,
                   '" . $va->sync_datetime . "' as sync_datetime,
                   '" . $va->sync_status_code . "' as sync_status_code,
                   '" . $va->recruit_plan . "' as recruit_plan,
                   '" . $va->creator . "' as creator,
                   '" . $va->create_date . "' as create_date,
                   '" . $va->exper_skill . "' as exper_skill,
                   '" . $va->work_location_id . "' as work_location_id,
                   '" . $va->governor_flag . "' as governor_flag,
                   '" . $va->province_id . "' as province_id,
                   '" . $va->d5_pos_id . "' as d5_pos_id,
                   '" . $va->org_owner . "' as org_owner,
                   '" . $va->audit_by . "' as audit_by,
                   '" . $va->audit_date . "' as audit_date,
                   '" . $va->create_org . "' as create_org,
                   '" . $va->update_org . "' as update_org,
                   '" . $va->pos_value . "' as pos_value,
                   '" . $va->update_name . "' as update_name,
                   '" . $va->creator_name . "' as creator_name
                    FROM dual
                ";

                if (count($SqlOrgs) > 100) {
                    $sql = "
                        MERGE INTO per_position_news d
                        USING ( " . implode(' UNION ', $SqlOrgs) . " ) s ON ( d.pos_id = s.pos_id )
                        WHEN NOT MATCHED THEN
                            INSERT  ( pos_id, dcid, pertype_id, organize_id, pos_no, pos_no_name, pos_salary, pos_mgtsalary, min_salary, max_salary, group_salary, pos_condition, pos_doc_no, pos_remark, pos_date, approve_name, approve_docno, approve_date, pos_get_date, pos_change_date, pos_vacant_date, pos_status, pos_seq_no, pay_no, pos_orgmgt, line_id, mposition_id, colevel_id, level_id, level_id_min, level_id_max, flag_level, condition_id, frametype_id, skill_id, positionstat_id, audit_flag, ppt_code, pos_retire, pos_retire_remark, reserve_flag, posreserve_id, pos_reserve_desc, pos_reserve_docno, pos_reserve_date, pos_south, pos_spec, pos_job_description, d5_pg_code, allow_decor, practicetype_id, self_ratio, chief_ratio, friend_ratio, sub_ratio, update_user, update_date, is_sync, sync_datetime, sync_status_code, recruit_plan, creator, create_date, exper_skill, work_location_id, governor_flag, province_id, d5_pos_id, org_owner, audit_by, audit_date, create_org, update_org, pos_value, update_name, creator_name ) 
                        VALUES
                            ( s.pos_id, s.dcid, s.pertype_id, s.organize_id, s.pos_no, s.pos_no_name, s.pos_salary, s.pos_mgtsalary, s.min_salary, s.max_salary, s.group_salary, s.pos_condition, s.pos_doc_no, s.pos_remark, s.pos_date, s.approve_name, s.approve_docno, s.approve_date, s.pos_get_date, s.pos_change_date, s.pos_vacant_date, s.pos_status, s.pos_seq_no, s.pay_no, s.pos_orgmgt, s.line_id, s.mposition_id, s.colevel_id, s.level_id, s.level_id_min, s.level_id_max, s.flag_level, s.condition_id, s.frametype_id, s.skill_id, s.positionstat_id, s.audit_flag, s.ppt_code, s.pos_retire, s.pos_retire_remark, s.reserve_flag, s.posreserve_id, s.pos_reserve_desc, s.pos_reserve_docno, s.pos_reserve_date, s.pos_south, s.pos_spec, s.pos_job_description, s.d5_pg_code, s.allow_decor, s.practicetype_id, s.self_ratio, s.chief_ratio, s.friend_ratio, s.sub_ratio, s.update_user, s.update_date, s.is_sync, s.sync_datetime, s.sync_status_code, s.recruit_plan, s.creator, s.create_date, s.exper_skill, s.work_location_id, s.governor_flag, s.province_id, s.d5_pos_id, s.org_owner, s.audit_by, s.audit_date, s.create_org, s.update_org, s.pos_value, s.update_name, s.creator_name )
                        WHEN MATCHED THEN
                        UPDATE
                        SET
                            dcid = s.dcid,
                            pertype_id = s.pertype_id,
                            organize_id = s.organize_id,
                            pos_no = s.pos_no,
                            pos_no_name = s.pos_no_name,
                            pos_salary = s.pos_salary,
                            pos_mgtsalary = s.pos_mgtsalary,
                            min_salary = s.min_salary,
                            max_salary = s.max_salary,
                            group_salary = s.group_salary,
                            pos_condition = s.pos_condition,
                            pos_doc_no = s.pos_doc_no,
                            pos_remark = s.pos_remark,
                            pos_date = s.pos_date,
                            approve_name = s.approve_name,
                            approve_docno = s.approve_docno,
                            approve_date = s.approve_date,
                            pos_get_date = s.pos_get_date,
                            pos_change_date = s.pos_change_date,
                            pos_vacant_date = s.pos_vacant_date,
                            pos_status = s.pos_status,
                            pos_seq_no = s.pos_seq_no,
                            pay_no = s.pay_no,
                            pos_orgmgt = s.pos_orgmgt,
                            line_id = s.line_id,
                            mposition_id = s.mposition_id,
                            colevel_id = s.colevel_id,
                            level_id = s.level_id,
                            level_id_min = s.level_id_min,
                            level_id_max = s.level_id_max,
                            flag_level = s.flag_level,
                            condition_id = s.condition_id,
                            frametype_id = s.frametype_id,
                            skill_id = s.skill_id,
                            positionstat_id = s.positionstat_id,
                            audit_flag = s.audit_flag,
                            ppt_code = s.ppt_code,
                            pos_retire = s.pos_retire,
                            pos_retire_remark = s.pos_retire_remark,
                            reserve_flag = s.reserve_flag,
                            posreserve_id = s.posreserve_id,
                            pos_reserve_desc = s.pos_reserve_desc,
                            pos_reserve_docno = s.pos_reserve_docno,
                            pos_reserve_date = s.pos_reserve_date,
                            pos_south = s.pos_south,
                            pos_spec = s.pos_spec,
                            pos_job_description = s.pos_job_description,
                            d5_pg_code = s.d5_pg_code,
                            allow_decor = s.allow_decor,
                            practicetype_id = s.practicetype_id,
                            self_ratio = s.self_ratio,
                            chief_ratio = s.chief_ratio,
                            friend_ratio = s.friend_ratio,
                            sub_ratio = s.sub_ratio,
                            update_user = s.update_user,
                            update_date = s.update_date,
                            is_sync = s.is_sync,
                            sync_datetime = s.sync_datetime,
                            sync_status_code = s.sync_status_code,
                            recruit_plan = s.recruit_plan,
                            creator = s.creator,
                            create_date = s.create_date,
                            exper_skill = s.exper_skill,
                            work_location_id = s.work_location_id,
                            governor_flag = s.governor_flag,
                            province_id = s.province_id,
                            d5_pos_id = s.d5_pos_id,
                            org_owner = s.org_owner,
                            audit_by = s.audit_by,
                            audit_date = s.audit_date,
                            create_org = s.create_org,
                            update_org = s.update_org,
                            pos_value = s.pos_value,
                            update_name = s.update_name,
                            creator_name = s.creator_name
                             
                    ";

                    foreach ($params['dbInserts'] as $kg => $vg) {

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


        if (count($SqlOrgs) > 0) {
            $sql = "
                MERGE INTO per_position_news d
                USING ( " . implode(' UNION ', $SqlOrgs) . " ) s ON ( d.pos_id = s.pos_id )
                WHEN NOT MATCHED THEN
                    INSERT  ( pos_id, dcid, pertype_id, organize_id, pos_no, pos_no_name, pos_salary, pos_mgtsalary, min_salary, max_salary, group_salary, pos_condition, pos_doc_no, pos_remark, pos_date, approve_name, approve_docno, approve_date, pos_get_date, pos_change_date, pos_vacant_date, pos_status, pos_seq_no, pay_no, pos_orgmgt, line_id, mposition_id, colevel_id, level_id, level_id_min, level_id_max, flag_level, condition_id, frametype_id, skill_id, positionstat_id, audit_flag, ppt_code, pos_retire, pos_retire_remark, reserve_flag, posreserve_id, pos_reserve_desc, pos_reserve_docno, pos_reserve_date, pos_south, pos_spec, pos_job_description, d5_pg_code, allow_decor, practicetype_id, self_ratio, chief_ratio, friend_ratio, sub_ratio, update_user, update_date, is_sync, sync_datetime, sync_status_code, recruit_plan, creator, create_date, exper_skill, work_location_id, governor_flag, province_id, d5_pos_id, org_owner, audit_by, audit_date, create_org, update_org, pos_value, update_name, creator_name ) 
                VALUES
                    ( s.pos_id, s.dcid, s.pertype_id, s.organize_id, s.pos_no, s.pos_no_name, s.pos_salary, s.pos_mgtsalary, s.min_salary, s.max_salary, s.group_salary, s.pos_condition, s.pos_doc_no, s.pos_remark, s.pos_date, s.approve_name, s.approve_docno, s.approve_date, s.pos_get_date, s.pos_change_date, s.pos_vacant_date, s.pos_status, s.pos_seq_no, s.pay_no, s.pos_orgmgt, s.line_id, s.mposition_id, s.colevel_id, s.level_id, s.level_id_min, s.level_id_max, s.flag_level, s.condition_id, s.frametype_id, s.skill_id, s.positionstat_id, s.audit_flag, s.ppt_code, s.pos_retire, s.pos_retire_remark, s.reserve_flag, s.posreserve_id, s.pos_reserve_desc, s.pos_reserve_docno, s.pos_reserve_date, s.pos_south, s.pos_spec, s.pos_job_description, s.d5_pg_code, s.allow_decor, s.practicetype_id, s.self_ratio, s.chief_ratio, s.friend_ratio, s.sub_ratio, s.update_user, s.update_date, s.is_sync, s.sync_datetime, s.sync_status_code, s.recruit_plan, s.creator, s.create_date, s.exper_skill, s.work_location_id, s.governor_flag, s.province_id, s.d5_pos_id, s.org_owner, s.audit_by, s.audit_date, s.create_org, s.update_org, s.pos_value, s.update_name, s.creator_name )
                WHEN MATCHED THEN
                UPDATE
                SET
                    dcid = s.dcid,
                    pertype_id = s.pertype_id,
                    organize_id = s.organize_id,
                    pos_no = s.pos_no,
                    pos_no_name = s.pos_no_name,
                    pos_salary = s.pos_salary,
                    pos_mgtsalary = s.pos_mgtsalary,
                    min_salary = s.min_salary,
                    max_salary = s.max_salary,
                    group_salary = s.group_salary,
                    pos_condition = s.pos_condition,
                    pos_doc_no = s.pos_doc_no,
                    pos_remark = s.pos_remark,
                    pos_date = s.pos_date,
                    approve_name = s.approve_name,
                    approve_docno = s.approve_docno,
                    approve_date = s.approve_date,
                    pos_get_date = s.pos_get_date,
                    pos_change_date = s.pos_change_date,
                    pos_vacant_date = s.pos_vacant_date,
                    pos_status = s.pos_status,
                    pos_seq_no = s.pos_seq_no,
                    pay_no = s.pay_no,
                    pos_orgmgt = s.pos_orgmgt,
                    line_id = s.line_id,
                    mposition_id = s.mposition_id,
                    colevel_id = s.colevel_id,
                    level_id = s.level_id,
                    level_id_min = s.level_id_min,
                    level_id_max = s.level_id_max,
                    flag_level = s.flag_level,
                    condition_id = s.condition_id,
                    frametype_id = s.frametype_id,
                    skill_id = s.skill_id,
                    positionstat_id = s.positionstat_id,
                    audit_flag = s.audit_flag,
                    ppt_code = s.ppt_code,
                    pos_retire = s.pos_retire,
                    pos_retire_remark = s.pos_retire_remark,
                    reserve_flag = s.reserve_flag,
                    posreserve_id = s.posreserve_id,
                    pos_reserve_desc = s.pos_reserve_desc,
                    pos_reserve_docno = s.pos_reserve_docno,
                    pos_reserve_date = s.pos_reserve_date,
                    pos_south = s.pos_south,
                    pos_spec = s.pos_spec,
                    pos_job_description = s.pos_job_description,
                    d5_pg_code = s.d5_pg_code,
                    allow_decor = s.allow_decor,
                    practicetype_id = s.practicetype_id,
                    self_ratio = s.self_ratio,
                    chief_ratio = s.chief_ratio,
                    friend_ratio = s.friend_ratio,
                    sub_ratio = s.sub_ratio,
                    update_user = s.update_user,
                    update_date = s.update_date,
                    is_sync = s.is_sync,
                    sync_datetime = s.sync_datetime,
                    sync_status_code = s.sync_status_code,
                    recruit_plan = s.recruit_plan,
                    creator = s.creator,
                    create_date = s.create_date,
                    exper_skill = s.exper_skill,
                    work_location_id = s.work_location_id,
                    governor_flag = s.governor_flag,
                    province_id = s.province_id,
                    d5_pos_id = s.d5_pos_id,
                    org_owner = s.org_owner,
                    audit_by = s.audit_by,
                    audit_date = s.audit_date,
                    create_org = s.create_org,
                    update_org = s.update_org,
                    pos_value = s.pos_value,
                    update_name = s.update_name,
                    creator_name = s.creator_name
                     
            ";

            foreach ($params['dbInserts'] as $kg => $vg) {

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


    //http://samservice/empdata/tb_pertype
    public function actionTb_pertype($user_id = 1)
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
        // $url = "https://dpis6uat.sso.go.th/oapi/open_api_users/callapi";
        $url = $params['apiUrl'] . "/oapi/open_api_users/callapi";
        $header = array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: ' . $accessToken
        );

        for ($p = 1; $p <= 10; ++$p) {

            $param = array(
                'endpoint' => 'tb_pertype',
                'limit' => 1000,
                'page' => $p,
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


            $js = json_decode($decrypt_data);


            // arr( $js );

            if (count($js) == 0) {
                break;
            }

            foreach ($js as $ka => $va) {

                //  foreach( $va as $kc => $vc ){

                //     echo $kc . ',<br>';
                //     // echo $kc . ',';
                // }


                // exit;

                // arr( $va );


                $SqlOrgs[] = "
                    SELECT 
                        '" . $va->pertype_id . "' as pertype_id,
                        '" . $va->pertype_pid . "' as pertype_pid,
                        '" . $va->pertype_code . "' as pertype_code,
                        '" . $va->pertype_abbr . "' as pertype_abbr,
                        '" . $va->pertype . "' as pertype,
                        '" . $va->sortorder . "' as sortorder,
                        '" . $va->flag . "' as flag,
                        '" . $va->creator . "' as creator,
                        '" . $va->createdate . "' as createdate,
                        '" . $va->create_org . "' as create_org,
                        '" . $va->updateuser . "' as updateuser,
                        '" . $va->updatedate . "' as updatedate,
                        '" . $va->recode_id . "' as recode_id,
                        '" . $va->is_delete . "' as is_delete,
                        '" . $va->require_cmd . "' as require_cmd,
                        '" . $va->is_sync . "' as is_sync,
                        '" . $va->sync_datetime . "' as sync_datetime,
                        '" . $va->sync_status_code . "' as sync_status_code,
                        '" . $va->update_org . "' as update_org,
                        '" . $va->org_owner . "' as org_owner,
                        '" . $va->org_visible . "' as org_visible
                    FROM dual
                ";
                //  [pertype_pid] => 0 [pertype_code] => 10000 [pertype_abbr] => ขรก. [pertype] => ข้าราชการ [sortorder] => 1 [flag] => 1 [creator] => -1 [createdate] => 2020-02-03 16:07:55 [create_org] => 0 [updateuser] => -1 [updatedate] => 2020-02-03 16:07:55 [recode_id] => 1 [is_delete] => 0 [require_cmd] => 0 [is_sync] => 0 [sync_datetime] => 2022-12-20 15:53:21 [sync_status_code] =>  [update_org] => 0 [org_owner] => 0 [org_visible] => 0

                if (count($SqlOrgs) > 100) {

                    $sql = "
                        MERGE INTO per_off_type_news d
                        USING ( " . implode(' UNION ', $SqlOrgs) . " ) s ON ( d.pertype_id = s.pertype_id )
                        WHEN NOT MATCHED THEN
                        INSERT ( pertype_id,pertype_pid,pertype_code,pertype_abbr,pertype,sortorder,flag,creator,createdate,create_org,updateuser,updatedate,recode_id,is_delete,require_cmd,is_sync,sync_datetime,sync_status_code,update_org,org_owner,org_visible ) 
                        VALUES
                        ( s.pertype_id, s.pertype_pid, s.pertype_code, s.pertype_abbr, s.pertype, s.sortorder, s.flag, s.creator, s.createdate, s.create_org, s.updateuser, s.updatedate, s.recode_id, s.is_delete, s.require_cmd, s.is_sync, s.sync_datetime, s.sync_status_code, s.update_org, s.org_owner, s.org_visible )               
                        WHEN MATCHED THEN
                        UPDATE
                        SET
                            pertype_pid = s.pertype_pid,
                            pertype_code = s.pertype_code,
                            pertype_abbr = s.pertype_abbr,
                            pertype = s.pertype,
                            sortorder = s.sortorder,
                            flag = s.flag,
                            creator = s.creator,
                            createdate = s.createdate,
                            create_org = s.create_org,
                            updateuser = s.updateuser,
                            updatedate = s.updatedate,
                            recode_id = s.recode_id,
                            is_delete = s.is_delete,
                            require_cmd = s.require_cmd,
                            is_sync = s.is_sync,
                            sync_datetime = s.sync_datetime,
                            sync_status_code = s.sync_status_code,
                            update_org = s.update_org,
                            org_owner = s.org_owner,
                            org_visible = s.org_visible
                            
                    ";

                    foreach ($params['dbInserts'] as $kg => $vg) {

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

        if (count($SqlOrgs) > 0) {

            $sql = "
                MERGE INTO per_off_type_news d
                USING ( " . implode(' UNION ', $SqlOrgs) . " ) s ON ( d.pertype_id = s.pertype_id )
                WHEN NOT MATCHED THEN
                INSERT ( pertype_id,pertype_pid,pertype_code,pertype_abbr,pertype,sortorder,flag,creator,createdate,create_org,updateuser,updatedate,recode_id,is_delete,require_cmd,is_sync,sync_datetime,sync_status_code,update_org,org_owner,org_visible ) 
                VALUES
                ( s.pertype_id, s.pertype_pid, s.pertype_code, s.pertype_abbr, s.pertype, s.sortorder, s.flag, s.creator, s.createdate, s.create_org, s.updateuser, s.updatedate, s.recode_id, s.is_delete, s.require_cmd, s.is_sync, s.sync_datetime, s.sync_status_code, s.update_org, s.org_owner, s.org_visible )               
                WHEN MATCHED THEN
                UPDATE
                SET
                    pertype_pid = s.pertype_pid,
                    pertype_code = s.pertype_code,
                    pertype_abbr = s.pertype_abbr,
                    pertype = s.pertype,
                    sortorder = s.sortorder,
                    flag = s.flag,
                    creator = s.creator,
                    createdate = s.createdate,
                    create_org = s.create_org,
                    updateuser = s.updateuser,
                    updatedate = s.updatedate,
                    recode_id = s.recode_id,
                    is_delete = s.is_delete,
                    require_cmd = s.require_cmd,
                    is_sync = s.is_sync,
                    sync_datetime = s.sync_datetime,
                    sync_status_code = s.sync_status_code,
                    update_org = s.update_org,
                    org_owner = s.org_owner,
                    org_visible = s.org_visible
                    
            ";

            foreach ($params['dbInserts'] as $kg => $vg) {

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


        $log_path = Yii::$app->getRuntimePath() . '\logs\log_tb_pertype_' . date('d-M-Y') . '.log';
        $results = print_r($js, true);
        \app\components\CommonFnc::write_log($log_path, $results);
    }

    // http://samservice/empdata/tb_line
    public function actionTb_line($user_id = 1)
    {

        $con = Yii::$app->dbdpis;
        $con2 = Yii::$app->dbdpisemp;

        // arr('adsfds');

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
        $url = "https://dpis6uat.sso.go.th/oapi/open_api_users/callapi";
        $url = "" . $params['apiUrl'] . "/oapi/open_api_users/callapi";
        $header = array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: ' . $accessToken
        );

        for ($p = 1; $p <= 50; ++$p) {

            $param = array(
                'endpoint' => 'tb_line',
                'limit' => 1000,
                'page' => $p,
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


            $js = json_decode($decrypt_data);

            if (count($js) == 0) {
                break;
            }

            foreach ($js as $ka => $va) {

                $SqlOrgs[] = "
                    SELECT 
                        " . $va->line_id . " as  line_id, 
                        '" . $va->line_code . "' as line_code, 
                        '" . $va->linename_abbr . "' as linename_abbr, 
                        '" . $va->linename_th . "' as linename_th, 
                        '" . $va->linename_en . "' as linename_en, 
                        '" . $va->linegroup_id . "' as linegroup_id, 
                        '" . $va->positiontype_id . "' as positiontype_id, 
                        '" . $va->pertype_id . "' as pertype_id, 
                        '" . $va->level_min . "' as level_min, 
                        '" . $va->level_max . "' as level_max, 
                        '" . $va->sortorder . "' as sortorder, 
                        '" . $va->flag . "' as flag, 
                        '" . $va->std_code . "' as std_code, 
                        '" . $va->creator . "' as creator, 
                        '" . $va->createdate . "' as createdate, 
                        '" . $va->updateuser . "' as updateuser, 
                        '" . $va->updatedate . "' as updatedate, 
                        '" . $va->create_org . "' as create_org, 
                        '" . $va->recode_id . "' as recode_id, 
                        '" . $va->is_sync . "' as is_sync, 
                        '" . $va->sync_datetime . "' as sync_datetime, 
                        '" . $va->sync_status_code . "' as sync_status_code, 
                        '" . $va->is_delete . "' as is_delete, 
                        '" . $va->update_org . "' as update_org, 
                        '" . $va->org_owner . "' as org_owner, 
                        '" . $va->org_visible . "' as org_visible
                    FROM dual
                ";

                if (count($SqlOrgs) > 100) {

                    $sql = "
                        MERGE INTO per_line_news d
                        USING ( " . implode(' UNION ', $SqlOrgs) . " ) s ON ( d.line_id = s.line_id )
                        WHEN NOT MATCHED THEN
                        INSERT ( 
                            line_id, line_code, linename_abbr, linename_th, linename_en, linegroup_id, positiontype_id, pertype_id, level_min, level_max, sortorder, flag, std_code, creator, createdate, updateuser, updatedate, create_org, recode_id, is_sync, sync_datetime, sync_status_code, is_delete, update_org, org_owner, org_visible
                        )
                        VALUES
                        ( s.line_id, s.line_code, s.linename_abbr, s.linename_th, s.linename_en, s.linegroup_id, s.positiontype_id, s.pertype_id, s.level_min, s.level_max, s.sortorder, s.flag, s.std_code, s.creator, s.createdate, s.updateuser, s.updatedate, s.create_org, s.recode_id, s.is_sync, s.sync_datetime, s.sync_status_code, s.is_delete, s.update_org, s.org_owner, s.org_visible )  
                        WHEN MATCHED THEN
                        UPDATE
                        SET
                            line_code = s.line_code, 
                            linename_abbr = s.linename_abbr,
                            linename_th = s.linename_th,
                            linename_en = s.linename_en,
                            linegroup_id = s.linegroup_id,
                            positiontype_id = s.positiontype_id,
                            pertype_id = s.pertype_id,
                            level_min = s.level_min,
                            level_max = s.level_max,
                            sortorder = s.sortorder,
                            flag = s.flag,
                            std_code = s.std_code,
                            creator = s.creator,
                            createdate = s.createdate,
                            updateuser = s.updateuser,
                            updatedate = s.updatedate,
                            create_org = s.create_org,
                            recode_id = s.recode_id,
                            is_sync = s.is_sync,
                            sync_datetime = s.sync_datetime,
                            sync_status_code = s.sync_status_code,
                            is_delete = s.is_delete,
                            update_org = s.update_org,
                            org_owner = s.org_owner,
                            org_visible = s.org_visible             
                           
                    ";




                    foreach ($params['dbInserts'] as $kg => $vg) {

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


        if (count($SqlOrgs) > 0) {

            $sql = "
                MERGE INTO per_line_news d
                USING ( " . implode(' UNION ', $SqlOrgs) . " ) s ON ( d.line_id = s.line_id )
                WHEN NOT MATCHED THEN
                INSERT ( 
                    line_id, line_code, linename_abbr, linename_th, linename_en, linegroup_id, positiontype_id, pertype_id, level_min, level_max, sortorder, flag, std_code, creator, createdate, updateuser, updatedate, create_org, recode_id, is_sync, sync_datetime, sync_status_code, is_delete, update_org, org_owner, org_visible
                )
                VALUES
                ( s.line_id, s.line_code, s.linename_abbr, s.linename_th, s.linename_en, s.linegroup_id, s.positiontype_id, s.pertype_id, s.level_min, s.level_max, s.sortorder, s.flag, s.std_code, s.creator, s.createdate, s.updateuser, s.updatedate, s.create_org, s.recode_id, s.is_sync, s.sync_datetime, s.sync_status_code, s.is_delete, s.update_org, s.org_owner, s.org_visible )  
                WHEN MATCHED THEN
                UPDATE
                SET
                    line_code = s.line_code, 
                    linename_abbr = s.linename_abbr,
                    linename_th = s.linename_th,
                    linename_en = s.linename_en,
                    linegroup_id = s.linegroup_id,
                    positiontype_id = s.positiontype_id,
                    pertype_id = s.pertype_id,
                    level_min = s.level_min,
                    level_max = s.level_max,
                    sortorder = s.sortorder,
                    flag = s.flag,
                    std_code = s.std_code,
                    creator = s.creator,
                    createdate = s.createdate,
                    updateuser = s.updateuser,
                    updatedate = s.updatedate,
                    create_org = s.create_org,
                    recode_id = s.recode_id,
                    is_sync = s.is_sync,
                    sync_datetime = s.sync_datetime,
                    sync_status_code = s.sync_status_code,
                    is_delete = s.is_delete,
                    update_org = s.update_org,
                    org_owner = s.org_owner,
                    org_visible = s.org_visible               
            ";

            foreach ($params['dbInserts'] as $kg => $vg) {

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



        $log_path = Yii::$app->getRuntimePath() . '\logs\log_tb_line_' . date('d-M-Y') . '.log';
        $results = print_r($js, true);
        \app\components\CommonFnc::write_log($log_path, $results);
    }

    // http://samservice/empdata/tb_level
    public function actionTb_level($user_id = 1)
    {

        // echo 'dasdss';exit;

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

        for ($p = 1; $p <= 1; ++$p) {

            $param = array(
                'endpoint' => 'tb_level',
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

            $data = $data_result["data"];
            $decrypt_data = $this->ssl_decrypt_api($data, $encrypt_key);


            $js = json_decode($decrypt_data);


            // arr( $js );

            if (count($js) == 0) {

                // echo $p;

                break;
            }

            foreach ($js as $ka => $va) {


                // foreach ($va as $kc => $vc) {

                //     echo $kc . ',<br>';
                //     // echo $kc . ',';
                // }


                // exit;

                // arr( $va );



                $SqlOrgs[] = "
                    SELECT 
                        '". $va->level_id ."' as level_id,
                        '". $va->level_code ."' as level_code,
                        '". $va->level_abbr ."' as level_abbr,
                        '". $va->levelname_th ."' as levelname_th,
                        '". $va->levelname_en ."' as levelname_en,
                        '". $va->positiontype_id ."' as positiontype_id,
                        '". $va->pertype_id ."' as pertype_id,
                        '". $va->flag_executive ."' as flag_executive,
                        '". $va->region_calc_flag ."' as region_calc_flag,
                        '". $va->pos_value ."' as pos_value,
                        '". $va->sortorder ."' as sortorder,
                        '". $va->flag ."' as flag,
                        '". $va->creator ."' as creator,
                        '". $va->createdate ."' as createdate,
                        '". $va->create_org ."' as create_org,
                        '". $va->updateuser ."' as updateuser,
                        '". $va->updatedate ."' as updatedate,
                        '". $va->update_org ."' as update_org,
                        '". $va->recode_id ."' as recode_id,
                        '". $va->is_sync ."' as is_sync,
                        '". $va->sync_datetime ."' as sync_datetime,
                        '". $va->sync_status_code ."' as sync_status_code,
                        '". $va->is_delete ."' as is_delete,
                        '". $va->org_owner ."' as org_owner,
                        '". $va->org_visible ."' as org_visible
                    FROM dual
                ";

                if (count($SqlOrgs) > 100) {

                    //   level_abbr] => 1,  levelname_en] => , positiontype_id] => 0,  flag_executive] => 0, region_calc_flag] => N, pos_value] => 0.00, sortorder] => 14, flag] => 1, creator] => -1, createdate] => 2020-03-02 15:46:09, create_org] => 0, updateuser] => 310210128083701, updatedate] => 2022-04-21 00:00:01, update_org] => 100000, recode_id] => 1, is_sync] => 0, sync_datetime] => 2022-12-20 15:50:29, sync_status_code] => , is_delete] => 0, org_owner] => 0, org_visible] => 1

                    // TO_CHAR( CURRENT_TIMESTAMP ,'YYYY-MM-DD HH24:MI:SS' )
                    $sql = "
                        MERGE INTO per_level_news d
                        USING ( " . implode(' UNION ', $SqlOrgs) . " ) s ON ( d.level_id = s.level_id )
                        WHEN NOT MATCHED THEN
                        INSERT ( level_id,level_code,level_abbr,levelname_th,levelname_en,positiontype_id,pertype_id,flag_executive,region_calc_flag,pos_value,sortorder,flag,creator,createdate,create_org,updateuser,updatedate,update_org,recode_id,is_sync,sync_datetime,sync_status_code,is_delete,org_owner,org_visible ) VALUES
                        ( s.level_id, s.level_code, s.level_abbr, s.levelname_th, s.levelname_en, s.positiontype_id, s.pertype_id, s.flag_executive, s.region_calc_flag, s.pos_value, s.sortorder, s.flag, s.creator, s.createdate, s.create_org, s.updateuser, s.updatedate, s.update_org, s.recode_id, s.is_sync, s.sync_datetime, s.sync_status_code, s.is_delete, s.org_owner, s.org_visible )               
                        WHEN MATCHED THEN
                        UPDATE
                        SET
                            level_code = s.level_code,
                            level_abbr = s.level_abbr,
                            levelname_th = s.levelname_th,
                            levelname_en = s.levelname_en,
                            positiontype_id = s.positiontype_id,
                            pertype_id = s.pertype_id,
                            flag_executive = s.flag_executive,
                            region_calc_flag = s.region_calc_flag,
                            pos_value = s.pos_value,
                            sortorder = s.sortorder,
                            flag = s.flag,
                            creator = s.creator,
                            createdate = s.createdate,
                            create_org = s.create_org,
                            updateuser = s.updateuser,
                            updatedate = s.updatedate,
                            update_org = s.update_org,
                            recode_id = s.recode_id,
                            is_sync = s.is_sync,
                            sync_datetime = s.sync_datetime,
                            sync_status_code = s.sync_status_code,
                            is_delete = s.is_delete,
                            org_owner = s.org_owner,
                            org_visible = s.org_visible
                    ";

                    foreach ( $params['dbInserts'] as $kg => $vg) {

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

        if (count($SqlOrgs) > 0) {

            //   level_abbr] => 1,  levelname_en] => , positiontype_id] => 0,  flag_executive] => 0, region_calc_flag] => N, pos_value] => 0.00, sortorder] => 14, flag] => 1, creator] => -1, createdate] => 2020-03-02 15:46:09, create_org] => 0, updateuser] => 310210128083701, updatedate] => 2022-04-21 00:00:01, update_org] => 100000, recode_id] => 1, is_sync] => 0, sync_datetime] => 2022-12-20 15:50:29, sync_status_code] => , is_delete] => 0, org_owner] => 0, org_visible] => 1

            // TO_CHAR( CURRENT_TIMESTAMP ,'YYYY-MM-DD HH24:MI:SS' )
            $sql = "
                MERGE INTO per_level_news d
                USING ( " . implode(' UNION ', $SqlOrgs) . " ) s ON ( d.level_id = s.level_id )
                WHEN NOT MATCHED THEN
                INSERT ( level_id,level_code,level_abbr,levelname_th,levelname_en,positiontype_id,pertype_id,flag_executive,region_calc_flag,pos_value,sortorder,flag,creator,createdate,create_org,updateuser,updatedate,update_org,recode_id,is_sync,sync_datetime,sync_status_code,is_delete,org_owner,org_visible ) VALUES
                ( s.level_id, s.level_code, s.level_abbr, s.levelname_th, s.levelname_en, s.positiontype_id, s.pertype_id, s.flag_executive, s.region_calc_flag, s.pos_value, s.sortorder, s.flag, s.creator, s.createdate, s.create_org, s.updateuser, s.updatedate, s.update_org, s.recode_id, s.is_sync, s.sync_datetime, s.sync_status_code, s.is_delete, s.org_owner, s.org_visible )               
                WHEN MATCHED THEN
                UPDATE
                SET
                    level_code = s.level_code,
                    level_abbr = s.level_abbr,
                    levelname_th = s.levelname_th,
                    levelname_en = s.levelname_en,
                    positiontype_id = s.positiontype_id,
                    pertype_id = s.pertype_id,
                    flag_executive = s.flag_executive,
                    region_calc_flag = s.region_calc_flag,
                    pos_value = s.pos_value,
                    sortorder = s.sortorder,
                    flag = s.flag,
                    creator = s.creator,
                    createdate = s.createdate,
                    create_org = s.create_org,
                    updateuser = s.updateuser,
                    updatedate = s.updatedate,
                    update_org = s.update_org,
                    recode_id = s.recode_id,
                    is_sync = s.is_sync,
                    sync_datetime = s.sync_datetime,
                    sync_status_code = s.sync_status_code,
                    is_delete = s.is_delete,
                    org_owner = s.org_owner,
                    org_visible = s.org_visible
            ";

            foreach ( $params['dbInserts'] as $kg => $vg) {

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
