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
        // arr($params['apiUrl']);

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

        $url_gettoken = ''. $params['apiUrl'] .'/oapi/login'; //prd domain
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

            echo json_encode( ['success'=>'fail', 'msg'=>'เชื่อมฐานข้อมูลไม่สำเร็จ']);
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


        $url = "". $params['apiUrl'] ."/oapi/open_api_users/callapi";
        // $url = "https://172.16.12.248/oapi/open_api_users/callapi";
        $header = array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: ' . $accessToken
        );

        $SqlUnion = [];

        $file_pass = 0;

        $total_api_rec = [];
        $total_new_rec = [];
        for ($i = 1; $i <= 50; $i++) {

            $param = array(
                'endpoint' => 'sso_personal',
                'limit' => 1000,
                'page' => $i
            );

            $data_result = self::calleservice($url, $header, $param);

            // arr( $data_result );

            if (!isset($data_result['message']) || $data_result['message'] != "success") {
                $arrsms = array(
                    'status' => 'error',
                    'msg' => "",
                );
                continue;
            }

            $decrypt_data = self::ssl_decrypt_api($data_result["data"], $encrypt_key);

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

                    // continue;
                }
            }

            ++$file_pass;

            if( $file_pass == 1 ) {


                $orgs = [];
        
                foreach ([1, 2] as $kg => $vg) {
        
        
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
        
                    if ($vg == 1) {
        
                        $cmd = $con->createCommand($sql);
                    } else {
        
                        $cmd = $con2->createCommand($sql);
                    }
        
        
                    $old_level_nos[$vg] = [];
        
                    $keep[$vg] = [];
        
                    $per_ids[$vg] = 0;
        
                    foreach ($cmd->queryAll() as $ka => $va) {
        
                        $concat = '';
                        foreach ($arr as $kf => $vf) {
        
                            $vf = strtoupper($vf);
        
                            $concat .= trim($va[$vf]) . '-';
                        }


                        // if( $va['PER_CARDNO'] == '3819900090281') {
                    
                            
                        //     arr($concat, 0);
                            
                        // }
        
                        $keep[$vg][$concat] = 1;
        
                        $old_level_nos[$vg][$va['PER_CARDNO']] = $va['LEVEL_NO'];
        
        
                        $per_ids[$vg] = $va['PER_ID'];
        
                    }
        
        
                    $sql = "SELECT * FROM per_org_ass";
        
                    if ($vg == 1) {
        
                        $cmd = $con->createCommand($sql);
                    } else {
        
                        $cmd = $con2->createCommand($sql);
                    }
                    $orgs[$vg] = [];
                    foreach ($cmd->queryAll() as $ka => $va) {
        
                        $orgs[$vg][$va['ORG_NAME']] = $va['ORG_ID'];
                    }
                }
        
                $sql = "SELECT level_no, level_name FROM per_level";
                $cmd = $con->createCommand($sql);
                $levels = [];
                foreach ($cmd->queryAll() as $ka => $va) {
        
                    $levels[$va['LEVEL_NAME']] = $va['LEVEL_NO'];
                }
        
                $sql = "SELECT * FROM per_off_type";
                $cmd = $con->createCommand($sql);
                $otcods = [];
                foreach ($cmd->queryAll() as $ka => $va) {
        
                    $otcods[$va['OT_NAME']] = $va['OT_CODE'];
                }
        
                $sql = "SELECT * FROM per_prename ORDER BY PN_NAME ASC ";
                $cmd = $con->createCommand($sql);
                $pn_codes = [];
                foreach ($cmd->queryAll() as $ka => $va) {
        
                    $pn_codes[$va['PN_NAME']] = $va['PN_CODE'];
                }
        
                $genders['นาย'] = 1;
                $genders['นาง'] = 2;
                $genders['นางสาว'] = 2;
        
            }


            // file_put_contents($save_file, $data_result["data"]);
            file_put_contents($save_file, $data_result["data"]);

            foreach ($js as $ka => $va) {



                // arr();

              

                // if( $ka <= 10 ) {
                //     arr( $va, 0);

                //     continue;
                // }


                if (in_array($va->pertype_id, [5, 42, 43, 44])) {

                    $setType = 1;
                } else {
                    $setType = 2;
                }


                if( !isset( $total_api_rec[$setType] ) ) {
                    $total_api_rec[$setType] = 0;
                }
                ++$total_api_rec[$setType];
                

                if (empty($va->per_cardno)) {

                    continue;
                }

                

                $cards[$va->per_cardno] = 1;

                

                if ($setType == 1) {

                    if (!isset($levels[$va->levelname_th])) {

                        if (isset($old_level_nos[$setType][$va->per_cardno])) {

                            $levels[$va->levelname_th] = $old_level_nos[$setType][$va->per_cardno];
                        } else {

                            $levels[$va->levelname_th] = 'O1';
                        }
                    }
                } else {

                    if (!isset($levels[$va->levelname_th])) {
                        $levels[$va->levelname_th] = NULL;
                    }
                }

                $concat = '';
                foreach ($arr as $kf => $vf) {
                    $concat .= trim($va->$vf) . '-';
                }
                
                // if( $va->per_cardno == '3819900090281') {
                    
                //    arr($concat);
                    
                // }
              

                if (isset($keep[$setType][$concat])) {
                    continue;
                }

              

                if (!isset($pn_codes[$va->prename_th])) {
                    $pn_codes[$va->prename_th] = '003';
                }

                if (!isset($genders[$va->prename_th])) {
                    $genders[$va->prename_th] = 1;
                }

                if (!isset($otcods[$va->pertype])) {
                    $otcods[$va->pertype] = '01';
                }


                // if( in_array( $va->per_name, ['ติณณภพ', 'จารุณี'])  ) {

                //     arr( $va, 0 );
                // }


                if (!isset($orgs[$setType][$va->organize_th_ass])) {
                    // continue;


                    if( !isset( $total_new_rec[$setType] ) ) {
                        $total_new_rec[$setType] = 0;
                    }
    
                    ++$total_new_rec[$setType];
                    
                    if( $setType == 1 ) {
    
                        $mymess[$setType] = 'มีข้อมูล <b>ข้าราชการ</b> ถูกดึงมาจำนวน <b>'. $total_api_rec[$setType] .'</b>เรคคอร์ด, ข้อมูลใหม่ <b>' . $total_new_rec[$setType] . '</b>เรคคอร์ด';
                    }
                    else {
                        $mymess[$setType] = 'มีข้อมูล <b>พนักงาน</b> ถูกดึงมาจำนวน <b>'. $total_api_rec[$setType] .'</b>เรคคอร์ด, ข้อมูลใหม่ <b>' . $total_new_rec[$setType] . '</b>เรคคอร์ด';
                        
                    }
    
                    $SqlUnion[$setType][] = "
                        SELECT 
                            '" . $va->pertype_id . "' AS pertype_id,
                            " . ++$per_ids[$setType] . "  AS per_id,
                            '" . $va->per_name . "' AS per_name,
                            '" . $va->per_cardno . "' AS per_cardno,
                            '" . $va->per_surname . "' AS per_surname,
                            '" . $va->per_eng_name . "' AS per_eng_name,
                            '" . $va->per_eng_surname . "' AS per_eng_surname,
                            '" . $va->birth_date . "' AS per_birthdate,
                            '" . $va->per_startdate . "' AS per_startdate,
                            '" . $va->per_occupydate . "' AS per_occupydate,
                            '" . $va->per_status . "' AS per_status,
                            '" . $levels[$va->levelname_th] . "' AS level_no,
                            '" . $genders[$va->prename_th] . "' AS genders,
                            '" . $pn_codes[$va->prename_th] . "' AS pn_code,
                            '" . $otcods[$va->pertype] . "' AS otcode,
                            NULL AS org
                        FROM dual
                    ";
                } 
                else {


                    if( !isset( $total_new_rec[$setType] ) ) {
                        $total_new_rec[$setType] = 0;
                    }
    
                    ++$total_new_rec[$setType];
                    
                    if( $setType == 1 ) {
    
                        $mymess[$setType] = 'มีข้อมูล <b>ข้าราชการ</b> ถูกดึงมาจำนวน <b>'. $total_api_rec[$setType] .'</b>เรคคอร์ด, ข้อมูลใหม่ <b>' . $total_new_rec[$setType] . '</b>เรคคอร์ด';
                    }
                    else {
                        $mymess[$setType] = 'มีข้อมูล <b>พนักงาน</b> ถูกดึงมาจำนวน <b>'. $total_api_rec[$setType] .'</b>เรคคอร์ด, ข้อมูลใหม่ <b>' . $total_new_rec[$setType] . '</b>เรคคอร์ด';
                        
                    }
    
                    $SqlUnion[$setType][] = "
                        SELECT 
                            '" . $va->pertype_id . "' AS pertype_id,
                            " . ++$per_ids[$setType] . "  AS per_id,
                            '" . $va->per_name . "' AS per_name,
                            '" . $va->per_cardno . "' AS per_cardno,
                            '" . $va->per_surname . "' AS per_surname,
                            '" . $va->per_eng_name . "' AS per_eng_name,
                            '" . $va->per_eng_surname . "' AS per_eng_surname,
                            '" . $va->birth_date . "' AS per_birthdate,
                            '" . $va->per_startdate . "' AS per_startdate,
                            '" . $va->per_occupydate . "' AS per_occupydate,
                            '" . $va->per_status . "' AS per_status,
                            '" . $levels[$va->levelname_th] . "' AS level_no,
                            '" . $genders[$va->prename_th] . "' AS genders,
                            '" . $pn_codes[$va->prename_th] . "' AS pn_code,
                            '" . $otcods[$va->pertype] . "' AS otcode,
                            " . $orgs[$setType][$va->organize_th_ass] . " AS org
                        FROM dual
                    ";
                }

               


                foreach ($SqlUnion as $ks => $vs) {

                    if (count($vs) == 1000) {
                        $sql = "
                            MERGE INTO per_personal d
                            USING ( 
                                " . implode(' UNION ', $vs) . "
                            ) s ON ( 1 = 0 )
                            WHEN NOT MATCHED THEN
                            INSERT  ( 
                                per_occupydate, per_startdate, per_birthdate, per_eng_surname, per_eng_name, per_surname, per_cardno, per_name, level_no_salary, level_no, per_id, per_type, ot_code, pn_code, org_id, pos_id, poem_id, per_orgmgt, per_salary, per_mgtsalary, per_spsalary, per_gender, mr_code, per_offno, per_taxno, per_blood, re_code, per_retiredate, per_posdate, per_saldate, pn_code_f, per_fathername, per_fathersurname, pn_code_m, per_mothername, per_mothersurname, per_add1, per_add2, pv_code, mov_code, per_ordain, per_soldier, per_member, per_status, update_user, update_date, department_id, approve_per_id, replace_per_id, absent_flag, poems_id, per_hip_flag, per_cert_occ, per_nickname, per_home_tel, per_office_tel, per_fax, per_mobile, per_email, per_file_no, per_bank_account, per_id_ref, per_id_ass_ref, per_contact_person, per_remark, per_start_org, per_cooperative, per_cooperative_no, per_memberdate, per_seq_no, pay_id, es_code, pl_name_work, org_name_work, per_docno, per_docdate, per_effectivedate, per_pos_reason, per_pos_year, per_pos_doctype, per_pos_docno, per_pos_org, per_ordain_detail, per_pos_orgmgt, per_pos_docdate, per_pos_desc, per_pos_remark, per_book_no, per_book_date, per_contact_count, per_disability, pot_id, per_union, per_uniondate, per_job, org_id_1, org_id_2, org_id_3, org_id_4, org_id_5, per_union2, per_uniondate2, per_union3, per_uniondate3, per_union4, per_uniondate4, per_union5, per_uniondate5, per_set_ass, per_audit_flag, per_probation_flag, department_id_ass, per_birth_place, per_scar, per_renew, per_leveldate, per_postdate, per_ot_flag) 
                            values ( s.per_occupydate, s.per_startdate, s.per_birthdate, s.per_eng_surname, s.per_eng_name, s.per_surname, s.per_cardno, s.per_name, s.level_no, s.level_no, s.per_id, 1, s.otcode, s.pn_code, s.org, 2670, null,  0, 0, 0, 0, s.genders,1, null, null, null, null, '-', null, null, null, null, null, null, null, null, null, null, null, '11894', 0, 0, 0, s.per_status, :user_id, TO_CHAR(CURRENT_TIMESTAMP ,'YYYY-MM-DD HH24:MI:SS'), 3062, null, null, null, null, null, null, null, null, null, null, null, '-', null, null, null, null, null, null, null, 0, null, null, 3571, 3804, '02', null, null, '-', '-', null, null, null, null, null, null, null, null, null, null, null, null, null, null, 1, null, 0, null, null, null, null, null, null, null, 0, null, 0, null, 0, null, 0, null, 1, 0, 0, 3062, null, null, 0, null, null, null )
                        ";

                        if ($ks == 1) {
                            $cmd = $con->createCommand($sql);
                        } else {

                            $cmd = $con2->createCommand($sql);
                        }

                        $cmd->bindValue(":user_id", $user_id);


                        $cmd->execute();

                        $SqlUnion[$ks] = [];

                        //arr('xxxxx');
                    }
                }
            }
        }

        foreach ($SqlUnion as $ks => $vs) {

            if (count($vs) > 0) {

                $sql = "
                    MERGE INTO per_personal d
                    USING ( 
                        " . implode(' UNION ', $vs) . "
                    ) s ON ( 1 = 0 )
                    WHEN NOT MATCHED THEN
                    INSERT  ( 
                        per_occupydate, per_startdate, per_birthdate, per_eng_surname, per_eng_name, per_surname, per_cardno, per_name, level_no_salary, level_no, per_id, per_type, ot_code, pn_code, org_id, pos_id, poem_id, per_orgmgt, per_salary, per_mgtsalary, per_spsalary, per_gender, mr_code, per_offno, per_taxno, per_blood, re_code, per_retiredate, per_posdate, per_saldate, pn_code_f, per_fathername, per_fathersurname, pn_code_m, per_mothername, per_mothersurname, per_add1, per_add2, pv_code, mov_code, per_ordain, per_soldier, per_member, per_status, update_user, update_date, department_id, approve_per_id, replace_per_id, absent_flag, poems_id, per_hip_flag, per_cert_occ, per_nickname, per_home_tel, per_office_tel, per_fax, per_mobile, per_email, per_file_no, per_bank_account, per_id_ref, per_id_ass_ref, per_contact_person, per_remark, per_start_org, per_cooperative, per_cooperative_no, per_memberdate, per_seq_no, pay_id, es_code, pl_name_work, org_name_work, per_docno, per_docdate, per_effectivedate, per_pos_reason, per_pos_year, per_pos_doctype, per_pos_docno, per_pos_org, per_ordain_detail, per_pos_orgmgt, per_pos_docdate, per_pos_desc, per_pos_remark, per_book_no, per_book_date, per_contact_count, per_disability, pot_id, per_union, per_uniondate, per_job, org_id_1, org_id_2, org_id_3, org_id_4, org_id_5, per_union2, per_uniondate2, per_union3, per_uniondate3, per_union4, per_uniondate4, per_union5, per_uniondate5, per_set_ass, per_audit_flag, per_probation_flag, department_id_ass, per_birth_place, per_scar, per_renew, per_leveldate, per_postdate, per_ot_flag) 
                    values ( s.per_occupydate, s.per_startdate, s.per_birthdate, s.per_eng_surname, s.per_eng_name, s.per_surname, s.per_cardno, s.per_name, s.level_no, s.level_no, s.per_id, 1, s.otcode, s.pn_code, s.org, 2670, null,  0, 0, 0, 0, s.genders,1, null, null, null, null, '-', null, null, null, null, null, null, null, null, null, null, null, '11894', 0, 0, 0, s.per_status, :user_id, TO_CHAR(CURRENT_TIMESTAMP ,'YYYY-MM-DD HH24:MI:SS'), 3062, null, null, null, null, null, null, null, null, null, null, null, '-', null, null, null, null, null, null, null, 0, null, null, 3571, 3804, '02', null, null, '-', '-', null, null, null, null, null, null, null, null, null, null, null, null, null, null, 1, null, 0, null, null, null, null, null, null, null, 0, null, 0, null, 0, null, 0, null, 1, 0, 0, 3062, null, null, 0, null, null, null )
                ";

                if ($ks == 1) {
                    $cmd = $con->createCommand($sql);
                } else {

                    $cmd = $con2->createCommand($sql);
                }

                $cmd->bindValue(":user_id", $user_id);

                $cmd->execute();

                $SqlUnion[$ks] = [];

                //arr('xxxxx');
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
