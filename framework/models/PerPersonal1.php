<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "PER_PERSONAL".
 *
 * @property int $PER_ID
 * @property string|null $PER_NAME
 */
class PerPersonal1 extends \yii\db\ActiveRecord
{

    
    public static function getlevelApi($user_id = 1)
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

            $data_result = self::calleservice($url, $header, $param);

            if ($data_result['message'] != "success") {
                $arrsms = array(
                    'status' => 'error',
                    'msg' => "",
                );
                return $arrsms;
            }

            $data = $data_result["data"];
            $decrypt_data = self::ssl_decrypt_api($data, $encrypt_key);


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


        $log_page = basename(Yii::$app->request->referrer); 
        $log_description = 'อัพเดตข้อมูลระดับชั้น';
        \app\models\CommonAction::AddEventLog($user_id, "Update", $log_page, $log_description);
        $return['msg'] = 'ปรับปรุงข้อมูลเสร็จสิ้น';

        $return['status'] = 'success';

        return json_encode($return );
    }

    public static function getFromApi($user_id = 1)
    {
        global $params;

        ini_set("default_socket_timeout", 20000);
        ini_set('memory_limit', '2048M');
        set_time_limit(0);

        $con = Yii::$app->dbdpis;

        $con2 = Yii::$app->dbdpisemp;


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

        $url = $params['apiUrl'] . "/oapi/open_api_users/callapi";

        $header = array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: ' . $accessToken
        );

        $SqlUnion = [];


        $totals = [];
        for ($i = 1; $i <= 100; $i++) {

            $param = array(
                'endpoint' => 'sso_personal2',
                'limit' => 200,
                'page' => $i
            );

            $data_result = self::calleservice($url, $header, $param);

            if (!isset($data_result['message']) || $data_result['message'] != "success") {
                $arrsms = array(
                    'status' => 'error',
                    'msg' => "",
                );
                continue;
            }

            $decrypt_data = self::ssl_decrypt_api($data_result["data"], $encrypt_key);

            $js = json_decode($decrypt_data);

            // arr( $js );
            $cJs = count($js);
            if ($cJs == 0) {

                // echo $i;
                break;
            }

            foreach ($js as $ka => $va) {

                // arr($va);

                $setType = 2;
                if (in_array($va->pertype_id, [5, 42, 43, 44])) {

                    $setType = 1;
                }


                if( !isset( $totals[$setType] )) {
                    $totals[$setType] = 0;

                }

                if($setType == 1 ) {


                    $mymess[$setType] = 'มีข้อมูล <b>ข้าราชการ</b> ถูกดึงมาจำนวน <b>' . ++$totals[$setType] . '</b>เรคคอร์ด';
                }
                else {

                    $mymess[$setType] = 'มีข้อมูล <b>พนักงาน</b> ถูกดึงมาจำนวน <b>' . ++$totals[$setType] . '</b>เรคคอร์ด';
                }

                $SqlUnion[$setType][] = "
                    SELECT 
                        '". trim($va->org_owner) ."' as org_owner,
                        '". trim($va->per_cardno) ."' as per_cardno,
                        '". trim($va->per_id) ."' as per_id,
                        '". trim($va->per_name) ."' as per_name,
                        '". trim($va->per_surname) ."' as per_surname,
                        '". trim($va->d5_per_id) ."' as d5_per_id,
                        '". trim($va->pos_id) ."' as pos_id,
                        '". trim($va->pos_no) ."' as pos_no,
                        '". trim($va->per_status) ."' as per_status,
                        '". trim($va->per_offno) ."' as per_offno,
                        '". trim($va->per_renew) ."' as per_renew,
                        '". trim($va->per_taxno) ."' as per_taxno,
                        '". trim($va->per_start_org) ."' as per_start_org,
                        '". trim($va->per_startdate) ."' as per_startdate,
                        '". trim($va->per_occupydate) ."' as per_occupydate,
                        '". trim($va->per_effectivedate) ."' as per_effectivedate,
                        '". trim($va->per_gender) ."' as per_gender,
                        '". trim($va->blood_id) ."' as blood_id,
                        '". trim($va->scar) ."' as scar,
                        '". trim($va->birth_place) ."' as birth_place,
                        '". trim($va->is_ordain) ."' as is_ordain,
                        '". trim($va->ordain_date) ."' as ordain_date,
                        '". trim($va->ordain_detail) ."' as ordain_detail,
                        '". trim($va->is_disability) ."' as is_disability,
                        '". trim($va->is_soldier_service) ."' as is_soldier_service,
                        '". trim($va->per_saldate) ."' as per_saldate,
                        '". trim($va->probation_startdate) ."' as probation_startdate,
                        '". trim($va->probation_enddate) ."' as probation_enddate,
                        '". trim($va->probation_passdate) ."' as probation_passdate,
                        '". trim($va->per_posdate) ."' as per_posdate,
                        '". trim($va->approve_per_id) ."' as approve_per_id,
                        '". trim($va->replace_per_id) ."' as replace_per_id,
                        '". trim($va->per_mobile) ."' as per_mobile,
                        '". trim($va->per_email) ."' as per_email,
                        '". trim($va->per_license_no) ."' as per_license_no,
                        '". trim($va->per_id_ref) ."' as per_id_ref,
                        '". trim($va->per_nickname) ."' as per_nickname,
                        '". trim($va->per_pos_org) ."' as per_pos_org,
                        '". trim($va->per_pos_orgmgt) ."' as per_pos_orgmgt,
                        '". trim($va->per_pos_docdate) ."' as per_pos_docdate,
                        '". trim($va->per_pos_doctype) ."' as per_pos_doctype,
                        '". trim($va->per_pos_remark) ."' as per_pos_remark,
                        '". trim($va->per_book_no) ."' as per_book_no,
                        '". trim($va->per_pos_desc) ."' as per_pos_desc,
                        '". trim($va->per_job) ."' as per_job,
                        '". trim($va->per_ot_flag) ."' as per_ot_flag,
                        '". trim($va->per_type_2535) ."' as per_type_2535,
                        '". trim($va->prename_id) ."' as prename_id,
                        '". trim($va->prename_th) ."' as prename_th,
                        '". trim($va->prename_en) ."' as prename_en,
                        '". trim($va->per_eng_name) ."' as per_eng_name,
                        '". trim($va->per_eng_surname) ."' as per_eng_surname,
                        '". trim($va->pertype_id) ."' as pertype_id,
                        '". trim($va->department_id) ."' as department_id,
                        '". trim($va->province_id) ."' as province_id,
                        '". trim($va->movement_id) ."' as movement_id,
                        '". trim($va->pay_no) ."' as pay_no,
                        '". trim($va->per_orgmgt) ."' as per_orgmgt,
                        '". trim($va->per_level_id) ."' as per_level_id,
                        '". trim($va->posstatus_id) ."' as posstatus_id,
                        '". trim($va->per_salary) ."' as per_salary,
                        '". trim($va->hip_flag) ."' as hip_flag,
                        '". trim($va->is_sync) ."' as is_sync,
                        '". trim($va->sync_datetime) ."' as sync_datetime,
                        '". trim($va->sync_status_code) ."' as sync_status_code,
                        '". trim($va->per_set_ass) ."' as per_set_ass,
                        '". trim($va->organize_id_ass) ."' as organize_id_ass,
                        '". trim($va->organize_id_work) ."' as organize_id_work,
                        '". trim($va->organize_id_kpi) ."' as organize_id_kpi,
                        '". trim($va->organize_id_salary) ."' as organize_id_salary,
                        '". trim($va->department_id_ass) ."' as department_id_ass,
                        '". trim($va->create_date) ."' as create_date,
                        '". trim($va->creator) ."' as creator,
                        '". trim($va->create_org) ."' as create_org,
                        '". trim($va->update_date) ."' as update_date,
                        '". trim($va->update_user) ."' as update_user,
                        '". trim($va->update_name) ."' as update_name,
                        '". trim($va->allow_sync) ."' as allow_sync,
                        '". trim($va->edit_req_no) ."' as edit_req_no,
                        '". trim($va->update_org) ."' as update_org,
                        '". trim($va->birth_date) ."' as birth_date,
                        '". trim($va->creator_name) ."' as creator_name,
                        '". trim($va->audit_name) ."' as audit_name,
                        '". trim($va->is_delete) ."' as is_delete,
                        '". trim($va->per_level_date) ."' as per_level_date,
                        '". trim($va->per_line_date) ."' as per_line_date
                    FROM dual
                ";

                foreach ($SqlUnion as $ks => $vs) {

                    if (count($vs) > 300) {
                        $sql = "
                            MERGE INTO per_personal_news d
                            USING ( 
                                " . implode(' UNION ', $vs) . "
                            ) s ON ( d.per_id = s.per_id )
                            WHEN NOT MATCHED THEN
                            INSERT  ( org_owner,per_cardno, per_id,per_name,per_surname,d5_per_id,pos_id,pos_no,per_status,per_offno,per_renew,per_taxno,per_start_org,per_startdate,per_occupydate,per_effectivedate,per_gender,blood_id,scar,birth_place,is_ordain,ordain_date,ordain_detail,is_disability,is_soldier_service,per_saldate,probation_startdate,probation_enddate,probation_passdate,per_posdate,approve_per_id,replace_per_id,per_mobile,per_email,per_license_no,per_id_ref,per_nickname,per_pos_org,per_pos_orgmgt,per_pos_docdate,per_pos_doctype,per_pos_remark,per_book_no,per_pos_desc,per_job,per_ot_flag,per_type_2535,prename_id,prename_th,prename_en,per_eng_name,per_eng_surname,pertype_id,department_id,province_id,movement_id,pay_no,per_orgmgt,per_level_id,posstatus_id,per_salary,hip_flag,is_sync,sync_datetime,sync_status_code,per_set_ass,organize_id_ass,organize_id_work,organize_id_kpi,organize_id_salary,department_id_ass,create_date,creator,create_org,update_date,update_user,update_name,allow_sync,edit_req_no,update_org,birth_date,creator_name,audit_name,is_delete,per_level_date,per_line_date ) 
                            values 
                            (  org_owner, s.per_cardno, s.per_id, s.per_name, s.per_surname, s.d5_per_id, s.pos_id, s.pos_no, s.per_status, s.per_offno, s.per_renew, s.per_taxno, s.per_start_org, s.per_startdate, s.per_occupydate, s.per_effectivedate, s.per_gender, s.blood_id, s.scar, s.birth_place, s.is_ordain, s.ordain_date, s.ordain_detail, s.is_disability, s.is_soldier_service, s.per_saldate, s.probation_startdate, s.probation_enddate, s.probation_passdate, s.per_posdate, s.approve_per_id, s.replace_per_id, s.per_mobile, s.per_email, s.per_license_no, s.per_id_ref, s.per_nickname, s.per_pos_org, s.per_pos_orgmgt, s.per_pos_docdate, s.per_pos_doctype, s.per_pos_remark, s.per_book_no, s.per_pos_desc, s.per_job, s.per_ot_flag, s.per_type_2535, s.prename_id, s.prename_th, s.prename_en, s.per_eng_name, s.per_eng_surname, s.pertype_id, s.department_id, s.province_id, s.movement_id, s.pay_no, s.per_orgmgt, s.per_level_id, s.posstatus_id, s.per_salary, s.hip_flag, s.is_sync, s.sync_datetime, s.sync_status_code, s.per_set_ass, s.organize_id_ass, s.organize_id_work, s.organize_id_kpi, s.organize_id_salary, s.department_id_ass, s.create_date, s.creator, s.create_org, s.update_date, s.update_user, s.update_name, s.allow_sync, s.edit_req_no, s.update_org, s.birth_date, s.creator_name, s.audit_name, s.is_delete, s.per_level_date, s.per_line_date )
                            WHEN MATCHED THEN
                            UPDATE
                            SET     
                                org_owner = s.org_owner,
                                per_cardno = s.per_cardno,
                                per_name = s.per_name,
                                per_surname = s.per_surname,
                                d5_per_id = s.d5_per_id,
                                pos_id = s.pos_id,
                                pos_no = s.pos_no,
                                per_status = s.per_status,
                                per_offno = s.per_offno,
                                per_renew = s.per_renew,
                                per_taxno = s.per_taxno,
                                per_start_org = s.per_start_org,
                                per_startdate = s.per_startdate,
                                per_occupydate = s.per_occupydate,
                                per_effectivedate = s.per_effectivedate,
                                per_gender = s.per_gender,
                                blood_id = s.blood_id,
                                scar = s.scar,
                                birth_place = s.birth_place,
                                is_ordain = s.is_ordain,
                                ordain_date = s.ordain_date,
                                ordain_detail = s.ordain_detail,
                                is_disability = s.is_disability,
                                is_soldier_service = s.is_soldier_service,
                                per_saldate = s.per_saldate,
                                probation_startdate = s.probation_startdate,
                                probation_enddate = s.probation_enddate,
                                probation_passdate = s.probation_passdate,
                                per_posdate = s.per_posdate,
                                approve_per_id = s.approve_per_id,
                                replace_per_id = s.replace_per_id,
                                per_mobile = s.per_mobile,
                                per_email = s.per_email,
                                per_license_no = s.per_license_no,
                                per_id_ref = s.per_id_ref,
                                per_nickname = s.per_nickname,
                                per_pos_org = s.per_pos_org,
                                per_pos_orgmgt = s.per_pos_orgmgt,
                                per_pos_docdate = s.per_pos_docdate,
                                per_pos_doctype = s.per_pos_doctype,
                                per_pos_remark = s.per_pos_remark,
                                per_book_no = s.per_book_no,
                                per_pos_desc = s.per_pos_desc,
                                per_job = s.per_job,
                                per_ot_flag = s.per_ot_flag,
                                per_type_2535 = s.per_type_2535,
                                prename_id = s.prename_id,
                                prename_th = s.prename_th,
                                prename_en = s.prename_en,
                                per_eng_name = s.per_eng_name,
                                per_eng_surname = s.per_eng_surname,
                                pertype_id = s.pertype_id,
                                department_id = s.department_id,
                                province_id = s.province_id,
                                movement_id = s.movement_id,
                                pay_no = s.pay_no,
                                per_orgmgt = s.per_orgmgt,
                                per_level_id = s.per_level_id,
                                posstatus_id = s.posstatus_id,
                                per_salary = s.per_salary,
                                hip_flag = s.hip_flag,
                                is_sync = s.is_sync,
                                sync_datetime = s.sync_datetime,
                                sync_status_code = s.sync_status_code,
                                per_set_ass = s.per_set_ass,
                                organize_id_ass = s.organize_id_ass,
                                organize_id_work = s.organize_id_work,
                                organize_id_kpi = s.organize_id_kpi,
                                organize_id_salary = s.organize_id_salary,
                                department_id_ass = s.department_id_ass,
                                create_date = s.create_date,
                                creator = s.creator,
                                create_org = s.create_org,
                                update_date = s.update_date,
                                update_user = s.update_user,
                                update_name = s.update_name,
                                allow_sync = s.allow_sync,
                                edit_req_no = s.edit_req_no,
                                update_org = s.update_org,
                                birth_date = s.birth_date,
                                creator_name = s.creator_name,
                                audit_name = s.audit_name,
                                is_delete = s.is_delete,
                                per_level_date = s.per_level_date,
                                per_line_date = s.per_line_date   
                        ";

                        if( in_array( $ks, $params['dbInserts'])) {

                            if ($ks == 1) {

                                $cmd = $con->createCommand($sql);
                            }
                            else {
                                $cmd = $con2->createCommand($sql); 
                            }
                            
                            $cmd->execute();
                        }

                        $SqlUnion[$ks] = [];
                      
                    }
                }
            }
        }

        foreach ($SqlUnion as $ks => $vs) {

            if (count($vs) > 0) {
                $sql = "
                    MERGE INTO per_personal_news d
                    USING ( 
                        " . implode(' UNION ', $vs) . "
                    ) s ON ( d.per_id = s.per_id )
                    WHEN NOT MATCHED THEN
                    INSERT  (  org_owner,per_cardno, per_id,per_name,per_surname,d5_per_id,pos_id,pos_no,per_status,per_offno,per_renew,per_taxno,per_start_org,per_startdate,per_occupydate,per_effectivedate,per_gender,blood_id,scar,birth_place,is_ordain,ordain_date,ordain_detail,is_disability,is_soldier_service,per_saldate,probation_startdate,probation_enddate,probation_passdate,per_posdate,approve_per_id,replace_per_id,per_mobile,per_email,per_license_no,per_id_ref,per_nickname,per_pos_org,per_pos_orgmgt,per_pos_docdate,per_pos_doctype,per_pos_remark,per_book_no,per_pos_desc,per_job,per_ot_flag,per_type_2535,prename_id,prename_th,prename_en,per_eng_name,per_eng_surname,pertype_id,department_id,province_id,movement_id,pay_no,per_orgmgt,per_level_id,posstatus_id,per_salary,hip_flag,is_sync,sync_datetime,sync_status_code,per_set_ass,organize_id_ass,organize_id_work,organize_id_kpi,organize_id_salary,department_id_ass,create_date,creator,create_org,update_date,update_user,update_name,allow_sync,edit_req_no,update_org,birth_date,creator_name,audit_name,is_delete,per_level_date,per_line_date ) 
                    values 
                    (  org_owner, s.per_cardno, s.per_id, s.per_name, s.per_surname, s.d5_per_id, s.pos_id, s.pos_no, s.per_status, s.per_offno, s.per_renew, s.per_taxno, s.per_start_org, s.per_startdate, s.per_occupydate, s.per_effectivedate, s.per_gender, s.blood_id, s.scar, s.birth_place, s.is_ordain, s.ordain_date, s.ordain_detail, s.is_disability, s.is_soldier_service, s.per_saldate, s.probation_startdate, s.probation_enddate, s.probation_passdate, s.per_posdate, s.approve_per_id, s.replace_per_id, s.per_mobile, s.per_email, s.per_license_no, s.per_id_ref, s.per_nickname, s.per_pos_org, s.per_pos_orgmgt, s.per_pos_docdate, s.per_pos_doctype, s.per_pos_remark, s.per_book_no, s.per_pos_desc, s.per_job, s.per_ot_flag, s.per_type_2535, s.prename_id, s.prename_th, s.prename_en, s.per_eng_name, s.per_eng_surname, s.pertype_id, s.department_id, s.province_id, s.movement_id, s.pay_no, s.per_orgmgt, s.per_level_id, s.posstatus_id, s.per_salary, s.hip_flag, s.is_sync, s.sync_datetime, s.sync_status_code, s.per_set_ass, s.organize_id_ass, s.organize_id_work, s.organize_id_kpi, s.organize_id_salary, s.department_id_ass, s.create_date, s.creator, s.create_org, s.update_date, s.update_user, s.update_name, s.allow_sync, s.edit_req_no, s.update_org, s.birth_date, s.creator_name, s.audit_name, s.is_delete, s.per_level_date, s.per_line_date )
                    WHEN MATCHED THEN
                    UPDATE
                    SET     
                    org_owner = s.org_owner,
                    per_cardno = s.per_cardno,
                    per_name = s.per_name,
                    per_surname = s.per_surname,
                    d5_per_id = s.d5_per_id,
                    pos_id = s.pos_id,
                    pos_no = s.pos_no,
                    per_status = s.per_status,
                    per_offno = s.per_offno,
                    per_renew = s.per_renew,
                    per_taxno = s.per_taxno,
                    per_start_org = s.per_start_org,
                    per_startdate = s.per_startdate,
                    per_occupydate = s.per_occupydate,
                    per_effectivedate = s.per_effectivedate,
                    per_gender = s.per_gender,
                    blood_id = s.blood_id,
                    scar = s.scar,
                    birth_place = s.birth_place,
                    is_ordain = s.is_ordain,
                    ordain_date = s.ordain_date,
                    ordain_detail = s.ordain_detail,
                    is_disability = s.is_disability,
                    is_soldier_service = s.is_soldier_service,
                    per_saldate = s.per_saldate,
                    probation_startdate = s.probation_startdate,
                    probation_enddate = s.probation_enddate,
                    probation_passdate = s.probation_passdate,
                    per_posdate = s.per_posdate,
                    approve_per_id = s.approve_per_id,
                    replace_per_id = s.replace_per_id,
                    per_mobile = s.per_mobile,
                    per_email = s.per_email,
                    per_license_no = s.per_license_no,
                    per_id_ref = s.per_id_ref,
                    per_nickname = s.per_nickname,
                    per_pos_org = s.per_pos_org,
                    per_pos_orgmgt = s.per_pos_orgmgt,
                    per_pos_docdate = s.per_pos_docdate,
                    per_pos_doctype = s.per_pos_doctype,
                    per_pos_remark = s.per_pos_remark,
                    per_book_no = s.per_book_no,
                    per_pos_desc = s.per_pos_desc,
                    per_job = s.per_job,
                    per_ot_flag = s.per_ot_flag,
                    per_type_2535 = s.per_type_2535,
                    prename_id = s.prename_id,
                    prename_th = s.prename_th,
                    prename_en = s.prename_en,
                    per_eng_name = s.per_eng_name,
                    per_eng_surname = s.per_eng_surname,
                    pertype_id = s.pertype_id,
                    department_id = s.department_id,
                    province_id = s.province_id,
                    movement_id = s.movement_id,
                    pay_no = s.pay_no,
                    per_orgmgt = s.per_orgmgt,
                    per_level_id = s.per_level_id,
                    posstatus_id = s.posstatus_id,
                    per_salary = s.per_salary,
                    hip_flag = s.hip_flag,
                    is_sync = s.is_sync,
                    sync_datetime = s.sync_datetime,
                    sync_status_code = s.sync_status_code,
                    per_set_ass = s.per_set_ass,
                    organize_id_ass = s.organize_id_ass,
                    organize_id_work = s.organize_id_work,
                    organize_id_kpi = s.organize_id_kpi,
                    organize_id_salary = s.organize_id_salary,
                    department_id_ass = s.department_id_ass,
                    create_date = s.create_date,
                    creator = s.creator,
                    create_org = s.create_org,
                    update_date = s.update_date,
                    update_user = s.update_user,
                    update_name = s.update_name,
                    allow_sync = s.allow_sync,
                    edit_req_no = s.edit_req_no,
                    update_org = s.update_org,
                    birth_date = s.birth_date,
                    creator_name = s.creator_name,
                    audit_name = s.audit_name,
                    is_delete = s.is_delete,
                    per_level_date = s.per_level_date,
                    per_line_date = s.per_line_date       
                ";

                if( in_array( $ks, $params['dbInserts'])) {
                    if ($ks == 1) {

                        $cmd = $con->createCommand($sql);
                    }
                    else {
                        $cmd = $con2->createCommand($sql); 
                    }
                    
                    $cmd->execute();
                }

                $SqlUnion[$ks] = [];
              
            }
        }


        // arr('adddfddda');

        $return['msg'] = 'ไม่มีการปรับปรุงข้อมูลใดๆ';

        if (!empty($mymess)) {

            $return['msg'] = implode('<br>', $mymess);
        }

        $return['status'] = 'success';

        
        $log_page = basename(Yii::$app->request->referrer);
        
        $log_description = 'อัพเดตข้อมูลเจ้าหน้าที่';
        
        // $createby = Yii::$app->user->getId();
        
        \app\models\CommonAction::AddEventLog($user_id, "Update", $log_page, $log_description);
        return json_encode($return);
    }



     //http://samservice/empdata/tb_pertype
     public static function getPertypeApi($user_id = 1)
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
 
             $data_result = self::calleservice($url, $header, $param);
 
             if ($data_result['message'] != "success") {
                 $arrsms = array(
                     'status' => 'error',
                     'msg' => "",
                 );
                 return $arrsms;
             }
 
             $data = $data_result["data"];
             $decrypt_data = self::ssl_decrypt_api($data, $encrypt_key);
 
 
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


         $log_page = basename(Yii::$app->request->referrer); 
         $log_description = 'อัพเดตข้อมูลประเภท';
         \app\models\CommonAction::AddEventLog($user_id, "Update", $log_page, $log_description);
         $return['msg'] = 'ปรับปรุงข้อมูลเสร็จสิ้น';
 
         $return['status'] = 'success';
 
         return json_encode($return );
 
 
        
 
     }

    public static function getOganizeApi($user_id = 1)
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

            $data_result = self::calleservice($url, $header, $param);

            if ($data_result['message'] != "success") {
                $arrsms = array(
                    'status' => 'error',
                    'msg' => "",
                );
                return $arrsms;
            }

            $js = json_decode(self::ssl_decrypt_api($data_result["data"], $encrypt_key));

            if (count($js) == 0) {

                // echo $p;

                break;
            }

            foreach ($js as $ka => $va) {

                // foreach( $va as $kc => $vc ){

                //     echo $kc . ', ';
                // }


                // exit;

                if ($va->department_id != 1640000) {
                    continue;
                }


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


        $log_page = basename(Yii::$app->request->referrer); 
        $log_description = 'อัพเดตข้อมูลoganize';
        \app\models\CommonAction::AddEventLog($user_id, "Update", $log_page, $log_description);
        $return['msg'] = 'ปรับปรุงข้อมูลเสร็จสิ้น';

        $return['status'] = 'success';


        return json_encode($return );


 
    }

    // http://samservice/empdata/pos_position
    public static function getPositionApi($user_id = 1)
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

            $data_result = self::calleservice($url, $header, $param);


            if ($data_result['message'] != "success") {
                $arrsms = array(
                    'status' => 'error',
                    'msg' => "",
                );
                return $arrsms;
            }

            $data = $data_result["data"];
            $decrypt_data = self::ssl_decrypt_api($data, $encrypt_key);


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


        

        $log_page = basename(Yii::$app->request->referrer); 
        $log_description = 'อัพเดตข้อมูลตำแหน่ง';
        \app\models\CommonAction::AddEventLog($user_id, "Update", $log_page, $log_description);
        $return['msg'] = 'ปรับปรุงข้อมูลเสร็จสิ้น';

        $return['status'] = 'success';


        return json_encode($return );




        
    }

    public static function getlineApi($user_id = 1)
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

            $data_result = self::calleservice($url, $header, $param);

            if ($data_result['message'] != "success") {
                $arrsms = array(
                    'status' => 'error',
                    'msg' => "",
                );
                return $arrsms;
            }

            $data = $data_result["data"];
            $decrypt_data = self::ssl_decrypt_api($data, $encrypt_key);


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


         
        $log_page = basename(Yii::$app->request->referrer);
        
        $log_description = 'อัพเดทข้อมูลระดับ';
        
        // $createby = Yii::$app->user->getId();
        
        \app\models\CommonAction::AddEventLog($user_id, "Update", $log_page, $log_description);



    }

   
    public static function calleservice($url, $header, $param)
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




    public static  function ssl_decrypt_api($string, $skey)
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



    public static function tableName()
    {
        return 'PER_PERSONAL';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('dbdpis');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['PER_ID'], 'required'],
            [['PER_ID'], 'integer'],
            [['PER_NAME'], 'string', 'max' => 191],
            [['PER_ID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'PER_ID' => 'Per ID',
            'PER_NAME' => 'Per Name',
        ];
    }

    /**
     * {@inheritdoc}
     * @return PerPersonalQuery1 the active query used by this AR class.
     */
    public static function find()
    {
        return new PerPersonalQuery1(get_called_class());
    }
}
