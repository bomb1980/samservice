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


        for ($i = 1; $i <= 100; $i++) {

            $param = array(
                'endpoint' => 'sso_personal2',
                'limit' => 100,
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

                // arr( $va );

                // foreach ($va as $kc => $vc) {

                //     // echo $kc . ',<br>';
                //     echo $kc . ',';
                // }


                // exit;


                $setType = 2;
                if (in_array($va->pertype_id, [5, 42, 43, 44])) {

                    $setType = 1;
                }

                $SqlUnion[$setType][] = "
                    SELECT 
                        '" . trim($va->per_id) . "' as per_id,
                        '" . trim($va->org_owner) . "' as org_owner,
                        '" . trim($va->per_cardno) . "' as per_cardno,
                        '" . trim($va->per_name) . "' as per_name,
                        '" . trim($va->per_surname) . "' as per_surname,
                        '" . trim($va->d5_per_id) . "' as d5_per_id,
                        '" . trim($va->pos_id) . "' as pos_id,
                        '" . trim($va->pos_no) . "' as pos_no,
                        '" . trim($va->per_status) . "' as per_status,
                        '" . trim($va->per_offno) . "' as per_offno,
                        '" . trim($va->per_renew) . "' as per_renew,
                        '" . trim($va->per_taxno) . "' as per_taxno,
                        '" . trim($va->per_start_org) . "' as per_start_org,
                        '" . trim($va->per_startdate) . "' as per_startdate,
                        '" . trim($va->per_occupydate) . "' as per_occupydate,
                        '" . trim($va->per_effectivedate) . "' as per_effectivedate,
                        '" . trim($va->per_gender) . "' as per_gender,
                        '" . trim($va->blood_id) . "' as blood_id,
                        '" . trim($va->scar) . "' as scar,
                        '" . trim($va->birth_place) . "' as birth_place,
                        '" . trim($va->is_ordain) . "' as is_ordain,
                        '" . trim($va->ordain_date) . "' as ordain_date,
                        '" . trim($va->ordain_detail) . "' as ordain_detail,
                        '" . trim($va->is_disability) . "' as is_disability,
                        '" . trim($va->is_soldier_service) . "' as is_soldier_service,
                        '" . trim($va->per_saldate) . "' as per_saldate,
                        '" . trim($va->probation_startdate) . "' as probation_startdate,
                        '" . trim($va->probation_enddate) . "' as probation_enddate,
                        '" . trim($va->probation_passdate) . "' as probation_passdate,
                        '" . trim($va->per_posdate) . "' as per_posdate,
                        '" . trim($va->approve_per_id) . "' as approve_per_id,
                        '" . trim($va->replace_per_id) . "' as replace_per_id,
                        '" . trim($va->absent_flag) . "' as absent_flag,
                        '" . trim($va->level_no_salary) . "' as level_no_salary,
                        '" . trim($va->per_mobile) . "' as per_mobile,
                        '" . trim($va->per_email) . "' as per_email,
                        '" . trim($va->per_file_no) . "' as per_file_no,
                        '" . trim($va->per_bank_account) . "' as per_bank_account,
                        '" . trim($va->per_license_no) . "' as per_license_no,
                        '" . trim($va->per_id_ref) . "' as per_id_ref,
                        '" . trim($va->per_nickname) . "' as per_nickname,
                        '" . trim($va->per_contact_person) . "' as per_contact_person,
                        '" . trim($va->per_id_ass_ref) . "' as per_id_ass_ref,
                        '" . trim($va->per_cooperative) . "' as per_cooperative,
                        '" . trim($va->per_cooperative_no) . "' as per_cooperative_no,
                        '" . trim($va->per_seq_no) . "' as per_seq_no,
                        '" . trim($va->per_pos_reason) . "' as per_pos_reason,
                        '" . trim($va->per_pos_year) . "' as per_pos_year,
                        '" . trim($va->per_remark) . "' as per_remark,
                        '" . trim($va->per_pos_docno) . "' as per_pos_docno,
                        '" . trim($va->per_pos_org) . "' as per_pos_org,
                        '" . trim($va->per_pos_orgmgt) . "' as per_pos_orgmgt,
                        '" . trim($va->per_pos_docdate) . "' as per_pos_docdate,
                        '" . trim($va->per_pos_doctype) . "' as per_pos_doctype,
                        '" . trim($va->per_pos_remark) . "' as per_pos_remark,
                        '" . trim($va->per_book_no) . "' as per_book_no,
                        '" . trim($va->per_book_date) . "' as per_book_date,
                        '" . trim($va->per_contract_count) . "' as per_contract_count,
                        '" . trim($va->disability_id) . "' as disability_id,
                        '" . trim($va->per_pos_desc) . "' as per_pos_desc,
                        '" . trim($va->per_job) . "' as per_job,
                        '" . trim($va->is_auditor) . "' as is_auditor,
                        '" . trim($va->per_ot_flag) . "' as per_ot_flag,
                        '" . trim($va->per_type_2535) . "' as per_type_2535,
                        '" . trim($va->prename_id) . "' as prename_id,
                        '" . trim($va->prename_th) . "' as prename_th,
                        '" . trim($va->prename_en) . "' as prename_en,
                        '" . trim($va->per_eng_name) . "' as per_eng_name,
                        '" . trim($va->per_eng_surname) . "' as per_eng_surname,
                        '" . trim($va->married_id) . "' as married_id,
                        '" . trim($va->religion_id) . "' as religion_id,
                        '" . trim($va->pertype_id) . "' as pertype_id,
                        '" . trim($va->department_id) . "' as department_id,
                        '" . trim($va->province_id) . "' as province_id,
                        '" . trim($va->movement_id) . "' as movement_id,
                        '" . trim($va->pay_no) . "' as pay_no,
                        '" . trim($va->per_orgmgt) . "' as per_orgmgt,
                        '" . trim($va->per_level_id) . "' as per_level_id,
                        '" . trim($va->posstatus_id) . "' as posstatus_id,
                        '" . trim($va->probation_flag) . "' as probation_flag,
                        '" . trim($va->per_salary) . "' as per_salary,
                        '" . trim($va->per_mgtsalary) . "' as per_mgtsalary,
                        '" . trim($va->per_spsalary) . "' as per_spsalary,
                        '" . trim($va->retired_date) . "' as retired_date,
                        '" . trim($va->nbs_flag) . "' as nbs_flag,
                        '" . trim($va->hip_flag) . "' as hip_flag,
                        '" . trim($va->newwave_flag) . "' as newwave_flag,
                        '" . trim($va->tena) . "' as tena,
                        '" . trim($va->per_union) . "' as per_union,
                        '" . trim($va->per_uniondate) . "' as per_uniondate,
                        '" . trim($va->per_union2) . "' as per_union2,
                        '" . trim($va->per_uniondate2) . "' as per_uniondate2,
                        '" . trim($va->per_union3) . "' as per_union3,
                        '" . trim($va->per_uniondate3) . "' as per_uniondate3,
                        '" . trim($va->per_union4) . "' as per_union4,
                        '" . trim($va->per_uniondate4) . "' as per_uniondate4,
                        '" . trim($va->per_union5) . "' as per_union5,
                        '" . trim($va->per_uniondate5) . "' as per_uniondate5,
                        '" . trim($va->per_member) . "' as per_member,
                        '" . trim($va->per_memberdate) . "' as per_memberdate,
                        '" . trim($va->is_sync) . "' as is_sync,
                        '" . trim($va->sync_datetime) . "' as sync_datetime,
                        '" . trim($va->dcid) . "' as dcid,
                        '" . trim($va->sync_status_code) . "' as sync_status_code,
                        '" . trim($va->per_set_ass) . "' as per_set_ass,
                        '" . trim($va->organize_id_ass) . "' as organize_id_ass,
                        '" . trim($va->organize_id_work) . "' as organize_id_work,
                        '" . trim($va->organize_id_kpi) . "' as organize_id_kpi,
                        '" . trim($va->organize_id_salary) . "' as organize_id_salary,
                        '" . trim($va->scholar_flag) . "' as scholar_flag,
                        '" . trim($va->relocation_type) . "' as relocation_type,
                        '" . trim($va->relocation_name) . "' as relocation_name,
                        '" . trim($va->audit_flag) . "' as audit_flag,
                        '" . trim($va->audit_by) . "' as audit_by,
                        '" . trim($va->audit_date) . "' as audit_date,
                        '" . trim($va->department_id_ass) . "' as department_id_ass,
                        '" . trim($va->create_date) . "' as create_date,
                        '" . trim($va->creator) . "' as creator,
                        '" . trim($va->create_org) . "' as create_org,
                        '" . trim($va->update_date) . "' as update_date,
                        '" . trim($va->update_user) . "' as update_user,
                        '" . trim($va->update_name) . "' as update_name,
                        '" . trim($va->allow_sync) . "' as allow_sync,
                        '" . trim($va->edit_req_no) . "' as edit_req_no,
                        '" . trim($va->update_org) . "' as update_org,
                        '" . trim($va->birth_date) . "' as birth_date,
                        '" . trim($va->creator_name) . "' as creator_name,
                        '" . trim($va->audit_name) . "' as audit_name,
                        '" . trim($va->is_delete) . "' as is_delete,
                        '" . trim($va->exam_register_id) . "' as exam_register_id,
                        '" . trim($va->father_name) . "' as father_name,
                        '" . trim($va->father_surname) . "' as father_surname,
                        '" . trim($va->father_prename_th) . "' as father_prename_th,
                        '" . trim($va->father_prename_id) . "' as father_prename_id,
                        '" . trim($va->mother_name) . "' as mother_name,
                        '" . trim($va->mother_surname) . "' as mother_surname,
                        '" . trim($va->mother_prename_th) . "' as mother_prename_th,
                        '" . trim($va->mother_prename_id) . "' as mother_prename_id,
                        '" . trim($va->is_draft) . "' as is_draft,
                        '" . trim($va->biometric_id) . "' as biometric_id,
                        '" . trim($va->area_province_id) . "' as area_province_id,
                        '" . trim($va->decoration_date) . "' as decoration_date,
                        '" . trim($va->decoration_id) . "' as decoration_id,
                        '" . trim($va->decoration_th) . "' as decoration_th,
                        '" . trim($va->decoration_abbr) . "' as decoration_abbr,
                        '" . trim($va->per_level_date) . "' as per_level_date,
                        '" . trim($va->per_line_date) . "' as per_line_date
                    FROM dual
                ";
                // arr('dsafdf');


                foreach ($SqlUnion as $ks => $vs) {

                    if (count($vs) > 300) {
                        $sql = "
                            MERGE INTO per_personal_news d
                            USING ( 
                                " . implode(' UNION ', $vs) . "
                            ) s ON ( d.per_id = s.per_id )
                            WHEN NOT MATCHED THEN
                            INSERT  ( org_owner,per_cardno,per_id,per_name,per_surname,d5_per_id,pos_id,pos_no,per_status,per_offno,per_renew,per_taxno,per_start_org,per_startdate,per_occupydate,per_effectivedate,per_gender,blood_id,scar,birth_place,is_ordain,ordain_date,ordain_detail,is_disability,is_soldier_service,per_saldate,probation_startdate,probation_enddate,probation_passdate,per_posdate,approve_per_id,replace_per_id,absent_flag,level_no_salary,per_mobile,per_email,per_file_no,per_bank_account,per_license_no,per_id_ref,per_nickname,per_contact_person,per_id_ass_ref,per_cooperative,per_cooperative_no,per_seq_no,per_pos_reason,per_pos_year,per_remark,per_pos_docno,per_pos_org,per_pos_orgmgt,per_pos_docdate,per_pos_doctype,per_pos_remark,per_book_no,per_book_date,per_contract_count,disability_id,per_pos_desc,per_job,is_auditor,per_ot_flag,per_type_2535,prename_id,prename_th,prename_en,per_eng_name,per_eng_surname,married_id,religion_id,pertype_id,department_id,province_id,movement_id,pay_no,per_orgmgt,per_level_id,posstatus_id,probation_flag,per_salary,per_mgtsalary,per_spsalary,retired_date,nbs_flag,hip_flag,newwave_flag,tena,per_union,per_uniondate,per_union2,per_uniondate2,per_union3,per_uniondate3,per_union4,per_uniondate4,per_union5,per_uniondate5,per_member,per_memberdate,is_sync,sync_datetime,dcid,sync_status_code,per_set_ass,organize_id_ass,organize_id_work,organize_id_kpi,organize_id_salary,scholar_flag,relocation_type,relocation_name,audit_flag,audit_by,audit_date,department_id_ass,create_date,creator,create_org,update_date,update_user,update_name,allow_sync,edit_req_no,update_org,birth_date,creator_name,audit_name,is_delete,exam_register_id,father_name,father_surname,father_prename_th,father_prename_id,mother_name,mother_surname,mother_prename_th,mother_prename_id,is_draft,biometric_id,area_province_id,decoration_date,decoration_id,decoration_th,decoration_abbr,per_level_date,per_line_date ) 
                            values 
                            ( s.org_owner, s.per_cardno, s.per_id, s.per_name, s.per_surname, s.d5_per_id, s.pos_id, s.pos_no, s.per_status, s.per_offno, s.per_renew, s.per_taxno, s.per_start_org, s.per_startdate, s.per_occupydate, s.per_effectivedate, s.per_gender, s.blood_id, s.scar, s.birth_place, s.is_ordain, s.ordain_date, s.ordain_detail, s.is_disability, s.is_soldier_service, s.per_saldate, s.probation_startdate, s.probation_enddate, s.probation_passdate, s.per_posdate, s.approve_per_id, s.replace_per_id, s.absent_flag, s.level_no_salary, s.per_mobile, s.per_email, s.per_file_no, s.per_bank_account, s.per_license_no, s.per_id_ref, s.per_nickname, s.per_contact_person, s.per_id_ass_ref, s.per_cooperative, s.per_cooperative_no, s.per_seq_no, s.per_pos_reason, s.per_pos_year, s.per_remark, s.per_pos_docno, s.per_pos_org, s.per_pos_orgmgt, s.per_pos_docdate, s.per_pos_doctype, s.per_pos_remark, s.per_book_no, s.per_book_date, s.per_contract_count, s.disability_id, s.per_pos_desc, s.per_job, s.is_auditor, s.per_ot_flag, s.per_type_2535, s.prename_id, s.prename_th, s.prename_en, s.per_eng_name, s.per_eng_surname, s.married_id, s.religion_id, s.pertype_id, s.department_id, s.province_id, s.movement_id, s.pay_no, s.per_orgmgt, s.per_level_id, s.posstatus_id, s.probation_flag, s.per_salary, s.per_mgtsalary, s.per_spsalary, s.retired_date, s.nbs_flag, s.hip_flag, s.newwave_flag, s.tena, s.per_union, s.per_uniondate, s.per_union2, s.per_uniondate2, s.per_union3, s.per_uniondate3, s.per_union4, s.per_uniondate4, s.per_union5, s.per_uniondate5, s.per_member, s.per_memberdate, s.is_sync, s.sync_datetime, s.dcid, s.sync_status_code, s.per_set_ass, s.organize_id_ass, s.organize_id_work, s.organize_id_kpi, s.organize_id_salary, s.scholar_flag, s.relocation_type, s.relocation_name, s.audit_flag, s.audit_by, s.audit_date, s.department_id_ass, s.create_date, s.creator, s.create_org, s.update_date, s.update_user, s.update_name, s.allow_sync, s.edit_req_no, s.update_org, s.birth_date, s.creator_name, s.audit_name, s.is_delete, s.exam_register_id, s.father_name, s.father_surname, s.father_prename_th, s.father_prename_id, s.mother_name, s.mother_surname, s.mother_prename_th, s.mother_prename_id, s.is_draft, s.biometric_id, s.area_province_id, s.decoration_date, s.decoration_id, s.decoration_th, s.decoration_abbr, s.per_level_date, s.per_line_date )
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
                                absent_flag = s.absent_flag,
                                level_no_salary = s.level_no_salary,
                                per_mobile = s.per_mobile,
                                per_email = s.per_email,
                                per_file_no = s.per_file_no,
                                per_bank_account = s.per_bank_account,
                                per_license_no = s.per_license_no,
                                per_id_ref = s.per_id_ref,
                                per_nickname = s.per_nickname,
                                per_contact_person = s.per_contact_person,
                                per_id_ass_ref = s.per_id_ass_ref,
                                per_cooperative = s.per_cooperative,
                                per_cooperative_no = s.per_cooperative_no,
                                per_seq_no = s.per_seq_no,
                                per_pos_reason = s.per_pos_reason,
                                per_pos_year = s.per_pos_year,
                                per_remark = s.per_remark,
                                per_pos_docno = s.per_pos_docno,
                                per_pos_org = s.per_pos_org,
                                per_pos_orgmgt = s.per_pos_orgmgt,
                                per_pos_docdate = s.per_pos_docdate,
                                per_pos_doctype = s.per_pos_doctype,
                                per_pos_remark = s.per_pos_remark,
                                per_book_no = s.per_book_no,
                                per_book_date = s.per_book_date,
                                per_contract_count = s.per_contract_count,
                                disability_id = s.disability_id,
                                per_pos_desc = s.per_pos_desc,
                                per_job = s.per_job,
                                is_auditor = s.is_auditor,
                                per_ot_flag = s.per_ot_flag,
                                per_type_2535 = s.per_type_2535,
                                prename_id = s.prename_id,
                                prename_th = s.prename_th,
                                prename_en = s.prename_en,
                                per_eng_name = s.per_eng_name,
                                per_eng_surname = s.per_eng_surname,
                                married_id = s.married_id,
                                religion_id = s.religion_id,
                                pertype_id = s.pertype_id,
                                department_id = s.department_id,
                                province_id = s.province_id,
                                movement_id = s.movement_id,
                                pay_no = s.pay_no,
                                per_orgmgt = s.per_orgmgt,
                                per_level_id = s.per_level_id,
                                posstatus_id = s.posstatus_id,
                                probation_flag = s.probation_flag,
                                per_salary = s.per_salary,
                                per_mgtsalary = s.per_mgtsalary,
                                per_spsalary = s.per_spsalary,
                                retired_date = s.retired_date,
                                nbs_flag = s.nbs_flag,
                                hip_flag = s.hip_flag,
                                newwave_flag = s.newwave_flag,
                                tena = s.tena,
                                per_union = s.per_union,
                                per_uniondate = s.per_uniondate,
                                per_union2 = s.per_union2,
                                per_uniondate2 = s.per_uniondate2,
                                per_union3 = s.per_union3,
                                per_uniondate3 = s.per_uniondate3,
                                per_union4 = s.per_union4,
                                per_uniondate4 = s.per_uniondate4,
                                per_union5 = s.per_union5,
                                per_uniondate5 = s.per_uniondate5,
                                per_member = s.per_member,
                                per_memberdate = s.per_memberdate,
                                is_sync = s.is_sync,
                                sync_datetime = s.sync_datetime,
                                dcid = s.dcid,
                                sync_status_code = s.sync_status_code,
                                per_set_ass = s.per_set_ass,
                                organize_id_ass = s.organize_id_ass,
                                organize_id_work = s.organize_id_work,
                                organize_id_kpi = s.organize_id_kpi,
                                organize_id_salary = s.organize_id_salary,
                                scholar_flag = s.scholar_flag,
                                relocation_type = s.relocation_type,
                                relocation_name = s.relocation_name,
                                audit_flag = s.audit_flag,
                                audit_by = s.audit_by,
                                audit_date = s.audit_date,
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
                                exam_register_id = s.exam_register_id,
                                father_name = s.father_name,
                                father_surname = s.father_surname,
                                father_prename_th = s.father_prename_th,
                                father_prename_id = s.father_prename_id,
                                mother_name = s.mother_name,
                                mother_surname = s.mother_surname,
                                mother_prename_th = s.mother_prename_th,
                                mother_prename_id = s.mother_prename_id,
                                is_draft = s.is_draft,
                                biometric_id = s.biometric_id,
                                area_province_id = s.area_province_id,
                                decoration_date = s.decoration_date,
                                decoration_id = s.decoration_id,
                                decoration_th = s.decoration_th,
                                decoration_abbr = s.decoration_abbr,
                                per_level_date = s.per_level_date,
                                per_line_date = s.per_line_date
                                
                        ";

                        if ($ks == 1) {
                            $cmd = $con->createCommand($sql);

                            $cmd->execute();
                            $SqlUnion[$ks] = [];
                        } else {

                            //$cmd = $con2->createCommand($sql);

                            // $cmd->execute();
                            // $SqlUnion[$ks] = [];
                        }
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
                    INSERT  ( org_owner,per_cardno,per_id,per_name,per_surname,d5_per_id,pos_id,pos_no,per_status,per_offno,per_renew,per_taxno,per_start_org,per_startdate,per_occupydate,per_effectivedate,per_gender,blood_id,scar,birth_place,is_ordain,ordain_date,ordain_detail,is_disability,is_soldier_service,per_saldate,probation_startdate,probation_enddate,probation_passdate,per_posdate,approve_per_id,replace_per_id,absent_flag,level_no_salary,per_mobile,per_email,per_file_no,per_bank_account,per_license_no,per_id_ref,per_nickname,per_contact_person,per_id_ass_ref,per_cooperative,per_cooperative_no,per_seq_no,per_pos_reason,per_pos_year,per_remark,per_pos_docno,per_pos_org,per_pos_orgmgt,per_pos_docdate,per_pos_doctype,per_pos_remark,per_book_no,per_book_date,per_contract_count,disability_id,per_pos_desc,per_job,is_auditor,per_ot_flag,per_type_2535,prename_id,prename_th,prename_en,per_eng_name,per_eng_surname,married_id,religion_id,pertype_id,department_id,province_id,movement_id,pay_no,per_orgmgt,per_level_id,posstatus_id,probation_flag,per_salary,per_mgtsalary,per_spsalary,retired_date,nbs_flag,hip_flag,newwave_flag,tena,per_union,per_uniondate,per_union2,per_uniondate2,per_union3,per_uniondate3,per_union4,per_uniondate4,per_union5,per_uniondate5,per_member,per_memberdate,is_sync,sync_datetime,dcid,sync_status_code,per_set_ass,organize_id_ass,organize_id_work,organize_id_kpi,organize_id_salary,scholar_flag,relocation_type,relocation_name,audit_flag,audit_by,audit_date,department_id_ass,create_date,creator,create_org,update_date,update_user,update_name,allow_sync,edit_req_no,update_org,birth_date,creator_name,audit_name,is_delete,exam_register_id,father_name,father_surname,father_prename_th,father_prename_id,mother_name,mother_surname,mother_prename_th,mother_prename_id,is_draft,biometric_id,area_province_id,decoration_date,decoration_id,decoration_th,decoration_abbr,per_level_date,per_line_date ) 
                    values 
                    ( s.org_owner, s.per_cardno, s.per_id, s.per_name, s.per_surname, s.d5_per_id, s.pos_id, s.pos_no, s.per_status, s.per_offno, s.per_renew, s.per_taxno, s.per_start_org, s.per_startdate, s.per_occupydate, s.per_effectivedate, s.per_gender, s.blood_id, s.scar, s.birth_place, s.is_ordain, s.ordain_date, s.ordain_detail, s.is_disability, s.is_soldier_service, s.per_saldate, s.probation_startdate, s.probation_enddate, s.probation_passdate, s.per_posdate, s.approve_per_id, s.replace_per_id, s.absent_flag, s.level_no_salary, s.per_mobile, s.per_email, s.per_file_no, s.per_bank_account, s.per_license_no, s.per_id_ref, s.per_nickname, s.per_contact_person, s.per_id_ass_ref, s.per_cooperative, s.per_cooperative_no, s.per_seq_no, s.per_pos_reason, s.per_pos_year, s.per_remark, s.per_pos_docno, s.per_pos_org, s.per_pos_orgmgt, s.per_pos_docdate, s.per_pos_doctype, s.per_pos_remark, s.per_book_no, s.per_book_date, s.per_contract_count, s.disability_id, s.per_pos_desc, s.per_job, s.is_auditor, s.per_ot_flag, s.per_type_2535, s.prename_id, s.prename_th, s.prename_en, s.per_eng_name, s.per_eng_surname, s.married_id, s.religion_id, s.pertype_id, s.department_id, s.province_id, s.movement_id, s.pay_no, s.per_orgmgt, s.per_level_id, s.posstatus_id, s.probation_flag, s.per_salary, s.per_mgtsalary, s.per_spsalary, s.retired_date, s.nbs_flag, s.hip_flag, s.newwave_flag, s.tena, s.per_union, s.per_uniondate, s.per_union2, s.per_uniondate2, s.per_union3, s.per_uniondate3, s.per_union4, s.per_uniondate4, s.per_union5, s.per_uniondate5, s.per_member, s.per_memberdate, s.is_sync, s.sync_datetime, s.dcid, s.sync_status_code, s.per_set_ass, s.organize_id_ass, s.organize_id_work, s.organize_id_kpi, s.organize_id_salary, s.scholar_flag, s.relocation_type, s.relocation_name, s.audit_flag, s.audit_by, s.audit_date, s.department_id_ass, s.create_date, s.creator, s.create_org, s.update_date, s.update_user, s.update_name, s.allow_sync, s.edit_req_no, s.update_org, s.birth_date, s.creator_name, s.audit_name, s.is_delete, s.exam_register_id, s.father_name, s.father_surname, s.father_prename_th, s.father_prename_id, s.mother_name, s.mother_surname, s.mother_prename_th, s.mother_prename_id, s.is_draft, s.biometric_id, s.area_province_id, s.decoration_date, s.decoration_id, s.decoration_th, s.decoration_abbr, s.per_level_date, s.per_line_date )
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
                        absent_flag = s.absent_flag,
                        level_no_salary = s.level_no_salary,
                        per_mobile = s.per_mobile,
                        per_email = s.per_email,
                        per_file_no = s.per_file_no,
                        per_bank_account = s.per_bank_account,
                        per_license_no = s.per_license_no,
                        per_id_ref = s.per_id_ref,
                        per_nickname = s.per_nickname,
                        per_contact_person = s.per_contact_person,
                        per_id_ass_ref = s.per_id_ass_ref,
                        per_cooperative = s.per_cooperative,
                        per_cooperative_no = s.per_cooperative_no,
                        per_seq_no = s.per_seq_no,
                        per_pos_reason = s.per_pos_reason,
                        per_pos_year = s.per_pos_year,
                        per_remark = s.per_remark,
                        per_pos_docno = s.per_pos_docno,
                        per_pos_org = s.per_pos_org,
                        per_pos_orgmgt = s.per_pos_orgmgt,
                        per_pos_docdate = s.per_pos_docdate,
                        per_pos_doctype = s.per_pos_doctype,
                        per_pos_remark = s.per_pos_remark,
                        per_book_no = s.per_book_no,
                        per_book_date = s.per_book_date,
                        per_contract_count = s.per_contract_count,
                        disability_id = s.disability_id,
                        per_pos_desc = s.per_pos_desc,
                        per_job = s.per_job,
                        is_auditor = s.is_auditor,
                        per_ot_flag = s.per_ot_flag,
                        per_type_2535 = s.per_type_2535,
                        prename_id = s.prename_id,
                        prename_th = s.prename_th,
                        prename_en = s.prename_en,
                        per_eng_name = s.per_eng_name,
                        per_eng_surname = s.per_eng_surname,
                        married_id = s.married_id,
                        religion_id = s.religion_id,
                        pertype_id = s.pertype_id,
                        department_id = s.department_id,
                        province_id = s.province_id,
                        movement_id = s.movement_id,
                        pay_no = s.pay_no,
                        per_orgmgt = s.per_orgmgt,
                        per_level_id = s.per_level_id,
                        posstatus_id = s.posstatus_id,
                        probation_flag = s.probation_flag,
                        per_salary = s.per_salary,
                        per_mgtsalary = s.per_mgtsalary,
                        per_spsalary = s.per_spsalary,
                        retired_date = s.retired_date,
                        nbs_flag = s.nbs_flag,
                        hip_flag = s.hip_flag,
                        newwave_flag = s.newwave_flag,
                        tena = s.tena,
                        per_union = s.per_union,
                        per_uniondate = s.per_uniondate,
                        per_union2 = s.per_union2,
                        per_uniondate2 = s.per_uniondate2,
                        per_union3 = s.per_union3,
                        per_uniondate3 = s.per_uniondate3,
                        per_union4 = s.per_union4,
                        per_uniondate4 = s.per_uniondate4,
                        per_union5 = s.per_union5,
                        per_uniondate5 = s.per_uniondate5,
                        per_member = s.per_member,
                        per_memberdate = s.per_memberdate,
                        is_sync = s.is_sync,
                        sync_datetime = s.sync_datetime,
                        dcid = s.dcid,
                        sync_status_code = s.sync_status_code,
                        per_set_ass = s.per_set_ass,
                        organize_id_ass = s.organize_id_ass,
                        organize_id_work = s.organize_id_work,
                        organize_id_kpi = s.organize_id_kpi,
                        organize_id_salary = s.organize_id_salary,
                        scholar_flag = s.scholar_flag,
                        relocation_type = s.relocation_type,
                        relocation_name = s.relocation_name,
                        audit_flag = s.audit_flag,
                        audit_by = s.audit_by,
                        audit_date = s.audit_date,
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
                        exam_register_id = s.exam_register_id,
                        father_name = s.father_name,
                        father_surname = s.father_surname,
                        father_prename_th = s.father_prename_th,
                        father_prename_id = s.father_prename_id,
                        mother_name = s.mother_name,
                        mother_surname = s.mother_surname,
                        mother_prename_th = s.mother_prename_th,
                        mother_prename_id = s.mother_prename_id,
                        is_draft = s.is_draft,
                        biometric_id = s.biometric_id,
                        area_province_id = s.area_province_id,
                        decoration_date = s.decoration_date,
                        decoration_id = s.decoration_id,
                        decoration_th = s.decoration_th,
                        decoration_abbr = s.decoration_abbr,
                        per_level_date = s.per_level_date,
                        per_line_date = s.per_line_date
                        
                ";

                if ($ks == 1) {
                    $cmd = $con->createCommand($sql);

                    $cmd->execute();
                    $SqlUnion[$ks] = [];
                } else {

                    //$cmd = $con2->createCommand($sql);

                    // $cmd->execute();
                    // $SqlUnion[$ks] = [];
                }

            }
        }




        $keep = [];

        $levels = [];

        $return['msg'] = 'ไม่มีการปรับปรุงข้อมูลใดๆ';

        if (!empty($mymess)) {

            $return['msg'] = implode('<br>', $mymess);
        }

        $return['status'] = 'success';

        echo json_encode($return);

        $log_page = basename(Yii::$app->request->referrer);

        $log_description = 'อัพเดตข้อมูลเจ้าหน้าที่';

        $createby = Yii::$app->user->getId();

        \app\models\CommonAction::AddEventLog($createby, "Update", $log_page, $log_description);
    }


    public static function getFromApi_backup($user_id = 1)
    {


        global $params;

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


        arr($result);
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
        // $url = "https://172.16.12.248/oapi/open_api_users/callapi";

        // $url = "https://sso.dpis.go.th/oapi/open_api_users/callapi";

        $header = array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: ' . $accessToken
        );

        $SqlUnion = [];

        $file_pass = 0;

        $total_api_rec = [];
        $total_new_rec = [];
        for ($i = 1; $i <= 20; $i++) {

            $param = array(
                'endpoint' => 'ssotest',
                'limit' => 300,
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

                break;
            }

            $dir_name = 'save_file';

            if (!is_dir($dir_name)) {
                mkdir($dir_name);
            }

            $save_file = $dir_name . '/' . $i . '.txt';

            if (file_exists($save_file)) {

                if (file_get_contents($save_file) ==  $data_result["data"]) {

                    // continue;
                }
            }

            ++$file_pass;




            // file_put_contents($save_file, $data_result["data"]);
            file_put_contents($save_file, $data_result["data"]);

            // $SqlOrgs = [];

            foreach ($js as $ka => $va) {


                arr($va);
                // if( $va->per_cardno == 5939900016532 ) {

                // }

                $setType = 2;
                if (in_array($va->pertype_id, [5, 42, 43, 44])) {

                    $setType = 1;
                }

                // if (!isset($total_api_rec[$setType])) {
                //     $total_api_rec[$setType] = 0;
                // }

                // ++$total_api_rec[$setType];

                // if (empty($va->per_cardno)) {

                //     continue;
                // }

                // $cards[$va->per_cardno] = 1;



                // $concat = '';
                // foreach ($arr as $kf => $vf) {
                //     $concat .= trim($va->$vf) . '-';
                // }


                // if (isset($keep[$setType][$concat])) {
                //     continue;
                // }







                // if (!isset($total_new_rec[$setType])) {
                //     $total_new_rec[$setType] = 0;
                // }

                // ++$total_new_rec[$setType];

                // if ($setType == 1) {

                //     $mymess[$setType] = 'มีข้อมูล <b>ข้าราชการ</b> ถูกดึงมาจำนวน <b>' . $total_api_rec[$setType] . '</b>เรคคอร์ด, ข้อมูลใหม่ <b>' . $total_new_rec[$setType] . '</b>เรคคอร์ด';
                // } else {
                //     $mymess[$setType] = 'มีข้อมูล <b>พนักงาน</b> ถูกดึงมาจำนวน <b>' . $total_api_rec[$setType] . '</b>เรคคอร์ด, ข้อมูลใหม่ <b>' . $total_new_rec[$setType] . '</b>เรคคอร์ด';
                // }

                // if (!isset($orgs[$setType][$va->organize_th_ass])) {

                //     $orgs[$setType][$va->organize_th_ass] = json_encode(NULL);
                // }



                if (empty($va->d5_per_id)) {
                    // continue;

                    $per_id = $va->per_id;
                } else {

                    $per_id = $va->d5_per_id;
                }
                // $otcods[$setType];

                // arr($otcods);
                // arr( $va );

                if ($setType == 1) {


                    if (!isset($otcods[$setType][$va->pertype_id])) {
                        $otcods[$setType][$va->pertype_id] = '01';
                    }
                } else {

                    if (!isset($otcods[$setType][$va->pertype_id])) {
                        $otcods[$setType][$va->pertype_id] = '11';
                    }
                }

                // arr( $va );

                if (!isset($genders[$va->prename_th])) {
                    $genders[$va->prename_th] = 1;
                }

                if (empty($va->organize_id_ass)) {

                    $va->organize_id_ass = 0;
                }

                if ($setType == 1) {

                    if (!isset($levels[$va->per_level_id])) {


                        $levels[$va->per_level_id] = 'O1';
                    }
                } else {

                    if (!isset($levels[$va->per_level_id])) {
                        $levels[$va->per_level_id] = NULL;
                    }
                }

                if (!isset($pn_codes[$va->prename_th])) {
                    $pn_codes[$va->prename_th] = '003';
                }

                $gogo['levelname_th'] = $levels[$va->per_level_id];
                $gogo['organize_th'] = 'dsdfsadf';
                $gogo['organize_th_ass'] = 'dsdfsadf';

                $SqlUnion[$setType][] = "
                    SELECT 
                        " . $per_id . "  AS per_id,
                        'dsd' AS dpis6_data,
                        '" . $va->pertype_id . "' AS pertype_id,
                        '" . $va->per_name . "' AS per_name,
                        '" . $va->per_cardno . "' AS per_cardno,
                        '" . $va->per_surname . "' AS per_surname,
                        '" . $va->per_eng_name . "' AS per_eng_name,
                        '" . $va->per_eng_surname . "' AS per_eng_surname,
                        '" . $va->birth_date . "' AS per_birthdate,
                        '" . $va->per_startdate . "' AS per_startdate,
                        '" . $va->per_occupydate . "' AS per_occupydate,
                        '" . $va->per_status . "' AS per_status,
                        '" . $va->pos_id . "' AS pos_id,
                        '" . $levels[$va->per_level_id] . "' AS level_no,
                        '" . $va->level_no_salary . "' AS level_no_salary,
                        '" . $genders[$va->prename_th] . "' AS per_gender,
                        '" . $pn_codes[$va->prename_th] . "' AS pn_code,
                        '" . $otcods[$setType][$va->pertype_id] . "' AS ot_code,
                        " . $va->organize_id_ass . " AS org_id
                    FROM dual
                ";
                // arr('dsafdf');


                foreach ($SqlUnion as $ks => $vs) {

                    if (count($vs) == 300) {
                        $sql = "
                            MERGE INTO per_personal d
                            USING ( 
                                " . implode(' UNION ', $vs) . "
                            ) s ON ( d.per_id = s.per_id )
                            WHEN NOT MATCHED THEN
                            INSERT  ( 
                                level_no_salary, level_no, pos_id, dpis6_data, per_status, per_gender, org_id, ot_code, per_occupydate, per_startdate, per_birthdate, per_eng_surname, per_eng_name, per_surname, per_cardno, per_name, per_id, per_type, pn_code, poem_id, per_orgmgt, per_salary, per_mgtsalary, per_spsalary, mr_code, per_offno, per_taxno, per_blood, re_code, per_retiredate, per_posdate, per_saldate, pn_code_f, per_fathername, per_fathersurname, pn_code_m, per_mothername, per_mothersurname, per_add1, per_add2, pv_code, mov_code, per_ordain, per_soldier, per_member, update_user, update_date, department_id, approve_per_id, replace_per_id, absent_flag, poems_id, per_hip_flag, per_cert_occ, per_nickname, per_home_tel, per_office_tel, per_fax, per_mobile, per_email, per_file_no, per_bank_account, per_id_ref, per_id_ass_ref, per_contact_person, per_remark, per_start_org, per_cooperative, per_cooperative_no, per_memberdate, per_seq_no, pay_id, es_code, pl_name_work, org_name_work, per_docno, per_docdate, per_effectivedate, per_pos_reason, per_pos_year, per_pos_doctype, per_pos_docno, per_pos_org, per_ordain_detail, per_pos_orgmgt, per_pos_docdate, per_pos_desc, per_pos_remark, per_book_no, per_book_date, per_contact_count, per_disability, pot_id, per_union, per_uniondate, per_job, org_id_1, org_id_2, org_id_3, org_id_4, org_id_5, per_union2, per_uniondate2, per_union3, per_uniondate3, per_union4, per_uniondate4, per_union5, per_uniondate5, per_set_ass, per_audit_flag, per_probation_flag, department_id_ass, per_birth_place, per_scar, per_renew, per_leveldate, per_postdate, per_ot_flag) 
                            values ( s.level_no_salary, s.level_no, s.pos_id, s.dpis6_data, s.per_status, s.per_gender, s.org_id, s.ot_code, s.per_occupydate, s.per_startdate, s.per_birthdate, s.per_eng_surname, s.per_eng_name, s.per_surname, s.per_cardno, s.per_name, s.per_id, 1, s.pn_code, null,  0, 0, 0, 0, 1, null, null, null, null, '-', null, null, null, null, null, null, null, null, null, null, null, '11894', 0, 0, 0, :user_id, TO_CHAR(CURRENT_TIMESTAMP ,'YYYY-MM-DD HH24:MI:SS'), 3062, null, null, null, null, null, null, null, null, null, null, null, '-', null, null, null, null, null, null, null, 0, null, null, 3571, 3804, '02', null, null, '-', '-', null, null, null, null, null, null, null, null, null, null, null, null, null, null, 1, null, 0, null, null, null, null, null, null, null, 0, null, 0, null, 0, null, 0, null, 1, 0, 0, 3062, null, null, 0, null, null, null )
                            WHEN MATCHED THEN
                            UPDATE
                            SET     
                                update_date = TO_CHAR( CURRENT_TIMESTAMP ,'YYYY-MM-DD HH24:MI:SS' ),
                                update_user = :user_id,
                                per_status = s.per_status,
                                per_gender = s.per_gender,
                                org_id = s.org_id,
                                pn_code = s.pn_code,
                                ot_code = s.ot_code,
                                per_eng_surname = s.per_eng_surname,
                                per_eng_name = s.per_eng_name,
                                per_occupydate = s.per_occupydate,
                                per_birthdate = s.per_birthdate,
                                per_name = s.per_name,
                                level_no_salary = s.level_no_salary,
                                level_no = s.level_no,
                                per_surname = s.per_surname,
                                per_startdate = s.per_startdate
                                
                        ";

                        if ($ks == 1) {
                            $cmd = $con->createCommand($sql);
                        } else {

                            $cmd = $con2->createCommand($sql);
                        }

                        $cmd->bindValue(":user_id", $user_id);

                        $cmd->execute();

                        $SqlUnion[$ks] = [];

                        // arr('asfddsdfsasddasadsd');

                        // arr('xxxxx');
                    }
                }
            }
        }


        foreach ($SqlUnion as $ks => $vs) {

            if (count($vs) == 0) {
                $sql = "
                    MERGE INTO per_personal d
                    USING ( 
                        " . implode(' UNION ', $vs) . "
                    ) s ON ( d.per_id = s.per_id )
                    WHEN NOT MATCHED THEN
                    INSERT  ( 
                        level_no_salary, level_no, pos_id, dpis6_data, per_status, per_gender, org_id, ot_code, per_occupydate, per_startdate, per_birthdate, per_eng_surname, per_eng_name, per_surname, per_cardno, per_name, per_id, per_type, pn_code, poem_id, per_orgmgt, per_salary, per_mgtsalary, per_spsalary, mr_code, per_offno, per_taxno, per_blood, re_code, per_retiredate, per_posdate, per_saldate, pn_code_f, per_fathername, per_fathersurname, pn_code_m, per_mothername, per_mothersurname, per_add1, per_add2, pv_code, mov_code, per_ordain, per_soldier, per_member, update_user, update_date, department_id, approve_per_id, replace_per_id, absent_flag, poems_id, per_hip_flag, per_cert_occ, per_nickname, per_home_tel, per_office_tel, per_fax, per_mobile, per_email, per_file_no, per_bank_account, per_id_ref, per_id_ass_ref, per_contact_person, per_remark, per_start_org, per_cooperative, per_cooperative_no, per_memberdate, per_seq_no, pay_id, es_code, pl_name_work, org_name_work, per_docno, per_docdate, per_effectivedate, per_pos_reason, per_pos_year, per_pos_doctype, per_pos_docno, per_pos_org, per_ordain_detail, per_pos_orgmgt, per_pos_docdate, per_pos_desc, per_pos_remark, per_book_no, per_book_date, per_contact_count, per_disability, pot_id, per_union, per_uniondate, per_job, org_id_1, org_id_2, org_id_3, org_id_4, org_id_5, per_union2, per_uniondate2, per_union3, per_uniondate3, per_union4, per_uniondate4, per_union5, per_uniondate5, per_set_ass, per_audit_flag, per_probation_flag, department_id_ass, per_birth_place, per_scar, per_renew, per_leveldate, per_postdate, per_ot_flag) 
                    values ( s.level_no_salary, s.level_no, s.pos_id, s.dpis6_data, s.per_status, s.per_gender, s.org_id, s.ot_code, s.per_occupydate, s.per_startdate, s.per_birthdate, s.per_eng_surname, s.per_eng_name, s.per_surname, s.per_cardno, s.per_name, s.per_id, 1, s.pn_code, null,  0, 0, 0, 0, 1, null, null, null, null, '-', null, null, null, null, null, null, null, null, null, null, null, '11894', 0, 0, 0, :user_id, TO_CHAR(CURRENT_TIMESTAMP ,'YYYY-MM-DD HH24:MI:SS'), 3062, null, null, null, null, null, null, null, null, null, null, null, '-', null, null, null, null, null, null, null, 0, null, null, 3571, 3804, '02', null, null, '-', '-', null, null, null, null, null, null, null, null, null, null, null, null, null, null, 1, null, 0, null, null, null, null, null, null, null, 0, null, 0, null, 0, null, 0, null, 1, 0, 0, 3062, null, null, 0, null, null, null )
                    WHEN MATCHED THEN
                    UPDATE
                    SET     
                        update_date = TO_CHAR( CURRENT_TIMESTAMP ,'YYYY-MM-DD HH24:MI:SS' ),
                        update_user = :user_id,
                        per_status = s.per_status,
                        per_gender = s.per_gender,
                        org_id = s.org_id,
                        pn_code = s.pn_code,
                        ot_code = s.ot_code,
                        per_eng_surname = s.per_eng_surname,
                        per_eng_name = s.per_eng_name,
                        per_occupydate = s.per_occupydate,
                        per_birthdate = s.per_birthdate,
                        per_name = s.per_name,
                        level_no_salary = s.level_no_salary,
                        level_no = s.level_no,
                        per_surname = s.per_surname,
                        per_startdate = s.per_startdate
                        
                ";

                if ($ks == 1) {
                    $cmd = $con->createCommand($sql);
                } else {

                    $cmd = $con2->createCommand($sql);
                }

                $cmd->bindValue(":user_id", $user_id);

                $cmd->execute();

                $SqlUnion[$ks] = [];

                // arr('asfddsdfsasddasadsd');

                // arr('xxxxx');
            }
        }



        $keep = [];

        $levels = [];

        $return['msg'] = 'ไม่มีการปรับปรุงข้อมูลใดๆ';

        if (!empty($mymess)) {

            $return['msg'] = implode('<br>', $mymess);
        }

        $return['status'] = 'success';

        echo json_encode($return);

        $log_page = basename(Yii::$app->request->referrer);

        $log_description = 'อัพเดตข้อมูลเจ้าหน้าที่';

        $createby = Yii::$app->user->getId();

        \app\models\CommonAction::AddEventLog($createby, "Update", $log_page, $log_description);
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
