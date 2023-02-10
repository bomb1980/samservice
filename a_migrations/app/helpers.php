<?php

use App\Models\OoapLogTransModel;
use App\Models\OoapMasRolePer;
use App\Models\OoapMasSubmenu;
use App\Models\OoapMasUserPer;
use App\Models\OoapTblEmployee;
use App\Models\OoapTblFiscalyear;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use App\Models\syslog;
use Illuminate\Encryption\Encrypter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


if (!function_exists('createSeedText')) {
    function createSeedText($modelName = null)
    {
        $skip = ['remember_token',];

        $load = 'App\\Models\\' . $modelName . '';

        $model = new $load();

        // foreach ($model->get()->skip(0)->take(10) as $km => $vm) {
        foreach ($model->get() as $km => $vm) {
            $keep = [];
            foreach ($model->getFillable() as $kf => $name) {
                if (in_array($name, $skip)) {
                    continue;
                }

                if (empty($vm->$name)) {
                    //continue;
                    $keep[] = '"' . $name . '" => NULL';
                } else {
                    $keep[] = '"' . $name . '" => "' . addslashes($vm->$name) . '"';
                }
            }

            echo '[' . implode(', ', $keep) . '],<br>';
        }
    }
}



if (!function_exists('datetimeToThaiDatetime')) {
    function datetimeToThaiDatetime($date, $format = 'd/M/Y H:i:s')
    {
        if ($date == NULL)
            return '-';

        $en = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

        $th = array("ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");

        $date = date_create($date);

        date_add($date, date_interval_create_from_date_string('543 year'));


        return str_replace($en, $th, date_format($date, $format));
    }
}



if (!function_exists('datePickerThaiToDB')) {
    function datePickerThaiToDB($date)
    {
        if ($date) {
            $arr_date = explode('/', $date);

            if(  count( $arr_date ) < 3 ) {
                return false;

            }

            if( !checkdate( $arr_date[1], $arr_date[0], ($arr_date[2] - 543) ) ) {
                return false;

            }
            return ($arr_date[2] - 543) . '-' . $arr_date[1] . '-' . $arr_date[0];
        } else {
            return null;
        }
    }
}

if (!function_exists('datetoview')) {
    function datetoview($date)
    {
        if (!empty($date) && (strtotime($date) > 0)) {
            $dateTh = date('d/m/Y', strtotime("+543 years", strtotime($date)));
            return $dateTh;
        }
    }
}


if (!function_exists('getEmployeeImg')) {
    function getEmployeeImg($citizen_id)
    {


        /*

        Access Token : TbGFbI4N1mGrKHSOMvWyux8ABEEyeVNJ7P2ODMLd
        Cipher : AES-256-CBC
        Salt : iM3UeG15DK31Zn6t
        */



        $resultData = Http::withHeaders([
            'Authorization' => 'Bearer re400Mahk1ObnovUOAzo6kNeg5oNiWEMcrZiqaec',
            'Accept' => 'application/json'
        ])->post('http://apigateway.mol.go.th/api/ooap/getprofileimg', [

            'citizen_id' => '3101702349539',
            'salt' => '1uQugGp7bnLYJ2vH',
            'cipher' => 'AES-256-CBC',
        ]);

        //dd( $resultData );
        // $resultDecrypted = Crypt::decrypt(trim($resultData ) );


        // if ($resultData->status() == '200') {

        // $resultDecrypted = Crypt::decrypt(trim($resultData->json()), config('app.TokenSalt'));
        $resultDecrypted = ApiDecrypt('AES-256-CBC', '1uQugGp7bnLYJ2vH', $resultData->body());

        // $resultDecrypted = json_decode($resultDecrypted);


        //  dd( $resultDecrypted);

        if ($resultDecrypted->files_gen != '') {

            return 'https://e-office.mol.go.th/storage/photos/profile/' . $resultDecrypted->files_gen;
        } else {

            return null;
        }
        // } else {

        //     return null;
        // }
    }
}


if (!function_exists('ApiDecrypt')) {

    function ApiDecrypt($getCipher, $getSalt, $encrypted)
    {
        $frameware = $encrypted;
        $encrypt_method = $getCipher;
        $secret_key = $getSalt;
        $secret_iv = $getSalt;

        $key = hash('sha256', $secret_key);

        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        $decryptToken = openssl_decrypt(base64_decode($frameware), $encrypt_method, $key, 0, $iv);
        // return $decryptToken;

        // กรณีต้องการข้อมูลรูปแบบ Array
        // $decryptTokenArray =
        return json_decode($decryptToken);

        //  $decryptTokenArray;
    }
}




if (!function_exists('check_duplicate_files')) {

    function check_duplicate_files($new_files, $old_files, $edit_files = [])
    {
        $file_names = [];

        foreach ($old_files as $file) {
            $file_names[] = $file->getClientOriginalName();
        }

        foreach ($edit_files as $file) {
            $file_names[] = $file['file_name'];
        }

        foreach ($new_files as $file) {
            if (in_array($file->getClientOriginalName(), $file_names)) {
                return true;
            }
        }

        return false;
    }
}


if (!function_exists('formatDateThai')) {
    function formatDateThai($strDate)
    {
        if (!is_null($strDate)) {
            $strYear = date("Y", strtotime($strDate)) + 543;
            $strMonth = date("n", strtotime($strDate));
            $strDay = date("j", strtotime($strDate));
            $strHour = date("H", strtotime($strDate));
            $strMinute = date("i", strtotime($strDate));
            $strSeconds = date("s", strtotime($strDate));
            $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
            $strMonthThai = $strMonthCut[$strMonth];
            // $strHour:$strMinute
            return "$strDay $strMonthThai $strYear";
        }
    }

}



if (!function_exists('onlyMonthThai')) {

    function onlyMonthThai($strDate)
    {
        if (!is_null($strDate)) {
            $strYear = date("Y", strtotime($strDate)) + 543;
            $strMonth = date("n", strtotime($strDate));
            $strDay = date("j", strtotime($strDate));
            $strHour = date("H", strtotime($strDate));
            $strMinute = date("i", strtotime($strDate));
            $strSeconds = date("s", strtotime($strDate));
            $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
            $strMonthThai = $strMonthCut[$strMonth];
            // $strHour:$strMinute
            return "$strMonthThai $strYear";
        }
    }
}



if (!function_exists('logSys')) {
    function logSys($logTable, $logActionid, $logName, $logControl, $logDetail)
    {
        // return 'logSys';
        $logIP = request()->ip();
        $remember_token = csrf_token();
        $createby = auth()->user()->id;

        $log = new syslog();
        $log->logIP = $logIP;
        $log->logTable = $logTable ?? '';
        $log->logActionid = $logActionid ?? '';
        $log->logName = $logName ?? '';
        $log->logControl = $logControl ?? '';
        $log->logDetail = $logDetail ?? '';
        $log->createby = $createby;
        $log->remember_token = $remember_token;
        $log->save();
    }
}

if (!function_exists('system_key')) {
    function system_key()
    {
        return auth()->user()->myooapsys;
    }
}

if (!function_exists('datetodatabase')) {
    function datetodatabase($date)
    {
        if (!empty($date) && (strtotime($date) > 0)) {
            $dateTh = date('d-m-Y', strtotime("-543 years", strtotime($date)));
            return $dateTh;
        }
    }
}





if (!function_exists('datetimeToDate')) {
    function datetimeToDate($date)
    {
        if ($date == NULL) {
            return '-';
        } else {
            // $date = gmdate("Y-m-d", $date);
            $date = date("Y-m-d", $date);
            $arr_date = explode('-', $date);

            // $arr_month = [1 => 'มกราคม', 2 => 'กุมภาพันธ์', 3 => 'มีนาคม', 4 => 'เมษายน', 5 => 'พฤษภาคม', 6 => 'มิถุนายน', 7 => 'กรกฎาคม', 8 => 'สิงหาคม', 9 => 'กันยายน', 10 => 'ตุลาคม', 11 => 'พฤศจิกายน', 12 => 'ธันวาคม'];

            return ($arr_date[2] + 0) . ' ' . ($arr_date[1]) . ' ' . ($arr_date[0]);
        }
    }
}

if (!function_exists('getRole')) {
    function getRole()
    {

        return auth()->user()->emp_citizen_id;
    }
}

if (!function_exists('dayThaiName')) {
    function dayThaiName($date)
    {
        if ($date) {
            $array = [
                0 => 'วันอาทิตย์',
                1 => 'วันจันทร์',
                2 => 'วันอังคาร',
                3 => 'วันพุธ',
                4 => 'วันพฤหัสบดี',
                5 => 'วันศุกร์',
                6 => 'วันเสาร์',
            ];
            return $array[date("w", strtotime($date))];
        } else {
            return null;
        }
    }
}

if (!function_exists('montYearsToDate')) {
    function montYearsToDate($date)
    {
        if ($date) {
            $arr_date = explode('-', $date);
            return ($arr_date[1] - 543) . '-' . $arr_date[0] . '-01';
        } else {
            return null;
        }
    }
}

if (!function_exists('dateToMontYears')) {
    function dateToMontYears($date)
    {
        if ($date) {
            $arr_datetime = explode(' ', $date);
            $arr_date = explode('-', $arr_datetime[0]);
            return ($arr_date[1]) . '-' . $arr_date[0] + 543;
        } else {
            return null;
        }
    }
}

if (!function_exists('dateToNewDatetime')) {
    function dateToNewDatetime($date)
    {
        if ($date) {
            return new DateTime($date);
        } else {
            return null;
        }
    }
}

if (!function_exists('monthThaiName')) {
    function monthThaiName($date)
    {
        if ($date) {
            $array = [
                '01' => 'มกราคม',
                '02' => 'กุมภาพันธ์',
                '03' => 'มีนาคม',
                '04' => 'เมษายน',
                '05' => 'พฤษภาคม',
                '06' => 'มิถุนายน',
                '07' => 'กรกฎาคม',
                '08' => 'สิงหาคม',
                '09' => 'กันยายน',
                '10' => 'ตุลาคม',
                '11' => 'พฤศจิกายน',
                '12' => 'ธันวาคม',
            ];
            $arr_date = explode('-', $date);
            return  $array[$arr_date[1]] . ' ' . ($arr_date[0] + 543);
        } else {
            return null;
        }
    }
}

if (!function_exists('showMimeIcon')) {
    function showMimeIcon($mime)
    {
        $text = explode("/", $mime);
        if ($text[0] == 'image') {
            $textshow = '<img height="20px" width="20px" src="' . asset('assets') . '/images/mime_image.png">';
        } else {
            $textend = explode(".", $text[1]);
            if (end($textend) == 'pdf') {
                $textshow = '<img height="20px" width="20px" src="' . asset('assets') . '/images/pdf-icon.png">';
            } else if (end($textend) == 'document' or $text[1] == 'msword') {
                $textshow = '<img height="20px" width="20px" src="' . asset('assets') . '/images/doc-icon.png">';
            } else if (end($textend) == 'sheet' or $text[1] == 'vnd.ms-excel') {
                $textshow = '<img height="20px" width="20px" src="' . asset('assets') . '/images/excel-icon.png">';
            } else {
                $textshow = '<img height="20px" width="20px" src="' . asset('assets') . '/images/question-mark.png">';
            }
        }
        return $textshow;
    }
}

if (!function_exists('show_name')) {
    function show_name()
    {

        if (auth()->user()->name) {
            $em_citizen_id = auth()->user()->name;
        } else {
            $em_citizen_id = auth()->user()->emp_citizen_id;
        }

        $em_id = OoapTblEmployee::where('ooap_tbl_employees.emp_citizen_id', '=', $em_citizen_id)->first();

        if ($em_id) {
            $profile = $em_id->prefix_name_th . " " . $em_id->fname_th . " " . $em_id->lname_th;
        } else {
            $profile = "ไม่พบข้อมูล";
        }
        return $profile;
    }
}

if (!function_exists('show_dept_name')) {
    function show_dept_name()
    {

        if (auth()->user()->name) {
            $em_citizen_id = auth()->user()->name;
        } else {
            $em_citizen_id = auth()->user()->emp_citizen_id;
        }

        $em_id = OoapTblEmployee::where('ooap_tbl_employees.emp_citizen_id', '=', $em_citizen_id)->first();

        if ($em_id) {
            return $em_id->dept_name_th;
        }
    }
}

if (!function_exists('DateToView')) {
    function DateToView($date)
    {

        $resultDate = Carbon::parse($date)->format('d M  Y');
        return $resultDate;
    }
}

if (!function_exists('getIcon')) {
    function getIcon($icon_name = NULL)
    {
        $icons['edit'] = '<i class="icon wb-pencil" aria-hidden="true"></i>';
        $icons['add'] = '<i class="icon wb-plus-circle" aria-hidden="true"></i>';
        $icons['delete'] = '<i class="icon wb-trash" aria-hidden="true"></i>';
        $icons['cancel'] = '<i class="icon wb-reply" aria-hidden="true"></i>';
        $icons['save'] = '<i class="icon fa-save" aria-hidden="true"></i>';
        $icons['lock'] = '<i class="icon wb-lock" aria-hidden="true"></i>';
        $icons['eye'] = '<i class="icon fa-eye" aria-hidden="true"></i>';
        $icons['excel'] = '<i class="icon fa-file-excel-o" aria-hidden="true"></i>';
        $icons['setting'] = '<i class="icon wb-settings bg-red-600 white icon-circle"
        aria-hidden="true"></i>';

        return $icons[$icon_name];
    }
}

if (!function_exists('arr')) {
    function arr($arr)
    {
        echo '<pre>';
        print_r($arr);
    }
}


if (!function_exists('getEncrypter')) {

    function getEncrypter($code = NULL, $type = 'encrypt')
    {

        $encrypter = new Encrypter('PeVKxcage5QNJqiC', 'AES-128-CBC');

        if ($type == 'encrypt') {

            return $encrypter->encrypt($code);
        }

        return $encrypter->decrypt($code);
    }
}

if (!function_exists('date_mdy_format')) {
    function date_mdy_format($date)
    { //y-m-d 2022-10-14 03:31:28.000
        if (!empty($date) && (strtotime($date) > 0)) {
            $first = explode(" ", $date);
            if (count($first) > 1) {
                array_pop($first);
            }
            $array = explode("-", $first[0]);
            $dateT = $array[1] . '/' . $array[2] . '/' . $array[0];
            return $dateT;
        }
    }
}

if (!function_exists('date_dmy_format')) {
    function date_dmy_format($date)
    { //y-m-d 2022-10-14 03:31:28.000
        if (!empty($date) && (strtotime($date) > 0)) {
            $first = explode(" ", $date);
            if (count($first) > 1) {
                array_pop($first);
            }
            $array = explode("-", $first[0]);
            $dateT = $array[2] . '/' . $array[1] . '/' . $array[0];
            return $dateT;
        }
    }
}

if (!function_exists('getFiscalyearStatus')) {
    function getFiscalyearStatus($index = NULL)
    {

        $status[1] = 'รวบรวมคำขอ';
        $status[2] = 'สรุปคำของบ';
        $status[3] = 'อนุมัติงบ';
        $status[4] = 'ปิดปีงบประมาณ';


        if (!empty($status[$index])) {
            return $status[$index];
        }

        return $status;
    }
}


if (!function_exists('makeFrontZero')) {
    function makeFrontZero($number, $require_zero = 2)
    {
        return str_pad($number, $require_zero, 0, STR_PAD_LEFT);
    }
}

if (!function_exists('getMonths')) {
    function getMonths()
    {
        $saddsfd = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
    }
}



if (!function_exists('getCanEditTblRequests')) {
    function getCanEditTblRequests($datas)
    {

        //  dd(  $datas->req_year  );
        $OoapTblFiscalyear = OoapTblFiscalyear::getDatas($id = NULL)->where('fiscalyear_code',  $datas->req_year)->first();

        //dd( $OoapTblFiscalyear);


        if ($OoapTblFiscalyear) {
            if ($OoapTblFiscalyear->req_enddate > now()) {
                return true;
            }
        }

        return false;
    }
}

if (!function_exists('dateToMonth')) {
    function dateToMonth($date)
    {
        $ex = explode('-', $date);

        return date("m/Y", mktime(0, 0, 0, $ex[1],   date("d"),    $ex[0] + 543));
    }
}



if (!function_exists('titlename')) {
    function titlename($data)
    {
        if($data == null){
            $title = '';
        }
        if ($data == 1) {
            $title = 'นาย';
        }
        if ($data == 2) {
            $title = 'นาง';
        }
        if ($data == 3) {
            $title = 'นางสาว';
        }

        return $title;
    }
}

if (!function_exists('rolelist')) {
    function rolelist($data)
    {
        if ($data == 1) {
            $role = 'วิทยากร';
        }
        if ($data == 2) {
            $role = 'ผู้ร่วมกิจกรรม';
        }
        if ($data == 3) {
            $role = 'ผู้นำชุมชน';
        }

        return $role;
    }
}

if (!function_exists('DateToSqlExpSlash')) {
    function DateToSqlExpSlash($strDate)
    {
        if ($strDate != '') {
            $arr = explode('/', $strDate);
            return $arr[2] -
                543 .
                '-' .
                str_pad($arr[1], 2, '0', STR_PAD_LEFT) .
                '-' .
                $arr[0];
        } else {
            return '';
        }
    }
}

if (!function_exists('hideStr')) {
    function hideStr($text = NULL)
    {

        $newCode = '';

        $strLen =  strlen($text);
        for ($i = 0; $i <  strlen($text); ++$i) {

            if ($strLen > 4) {
                $new = 'x';
            } else {

                $new = substr($text, $i, 1);
            }

            $newCode .= $new;

            $strLen -= 1;
        }

        return $newCode;
    }
}

if (!function_exists('arr')) {
    function arr($arr)
    {

        echo '<pre>';

        print_r($arr);
    }
}

if (!function_exists('callLinkgate')) {
    function callLinkgate($citizen_id, $AgentID)
    {
        // $AgentID = 'auth()->user()->emp_citizen_id';
        $consumer_key = '80436ebe-0e42-453b-9a87-ad79e3bf03e7';
        $consumer_secret = '0zyAvsQnKl3';
        $agent_id = trim($AgentID);
        $CitizenID = trim($citizen_id);

        $token = getToken($consumer_key, $consumer_secret, $agent_id);

        $URL = "https://api.egov.go.th/ws/dopa/linkage/v1/link?OfficeID=00023&ServiceID=001&Version=01&CitizenID=$CitizenID";

        $response = getDataLinkage($URL, $consumer_key, $token);
        return $response;
    }
}

if (!function_exists('callLinkgateHome')) {
    function callLinkgateHome($citizen_id, $AgentID)
    {
        // $AgentID = auth()->user()->em_citizen_id;
        $consumer_key = '80436ebe-0e42-453b-9a87-ad79e3bf03e7';
        $consumer_secret = '0zyAvsQnKl3';
        $agent_id = trim($AgentID);
        $CitizenID = trim($citizen_id);

        $token = getToken($consumer_key, $consumer_secret, $agent_id);

        $URL = "https://api.egov.go.th/ws/dopa/linkage/v1/link?OfficeID=00023&ServiceID=008&Version=01&CitizenID=$CitizenID";

        $response = getDataLinkage($URL, $consumer_key, $token);
        return $response;
    }
}

if (!function_exists('getToken')) {
    function getToken($ConsumerKey, $ConsumerSecret, $AgentID)
    {
        // dd($ConsumerSecret);
        // $AgentID = '1499900133611';
        try {
            $ch = curl_init();
            $headers = [];
            $headers[] = 'Content-Type:application/json'; // set content type
            $headers[] = 'Consumer-Key:' . $ConsumerKey; // set consumer key replace %s
            // set request url
            curl_setopt(
                $ch,
                CURLOPT_URL,
                'https://api.egov.go.th/ws/auth/validate?ConsumerSecret=' .
                    $ConsumerSecret .
                    '&AgentID=' .
                    $AgentID
            ); // set ConsumerSecret and AgentID
            // set header
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            // return header when response
            curl_setopt($ch, CURLOPT_HEADER, true);

            //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            // return the response
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // send the request and store the response to $data
            $data = curl_exec($ch);
            // get httpcode
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($httpcode == 200) {
                // if response ok
                // separate header and body
                $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
                $header = substr($data, 0, $header_size);
                $body = substr($data, $header_size);

                // convert json to array or object
                $result = json_decode($body);

                // access to token value
                $token = $result->Result;
            } else {
                $token = 'ไม่สามารถเชื่อมต่อกับระบบส่วนกลางได้';
            }
            // end session
            // dd($token);

            return $token;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
        curl_close($ch);
    }
}

if (!function_exists('getDataLinkage')) {
    function getDataLinkage($URL, $ConsumerKey, $Token)
    {
        $client = new GuzzleHttp\Client();

        try {
            $response = $client->request(
                'GET',
                $URL,
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Consumer-Key' => $ConsumerKey,
                        'Token' => $Token
                    ],
                ]
            );
            return $response_data = json_decode((string) $response->getBody(), true);
        } catch (Exception $exception) {
            // return $exception;
            return null;
        }
    }
}

if (!function_exists('getAge')) {
    function getAge($date, $html = false)
    {

        if (!$html) {
            if (empty($date))
                return NULL;

            $now = date('Y-m-d H:i:s');
            //$date = $data->applications_birthday;
            $age = round(
                (strtotime($now) - strtotime($date)) / (60 * 60 * 24 * 365)
            );

            return $age;
        } else {


            if (empty($date))
                return NULL;

            $now = date('Y-m-d H:i:s');
            //$date = $data->applications_birthday;
            $age = round(
                (strtotime($now) - strtotime($date)) / (60 * 60 * 24 * 365)
            );

            if (empty($age)) {
                return NULL;
            }

            return '<small>อายุ' . $age . 'ปี</small>';
        }
    }
}

if (!function_exists('timegi')) {
    function timegi($data1, $data2)
    {
        $data1 = Carbon::parse($data1)->timestamp;
        $data1 = date("H:i:s", $data1);

        $data2 = Carbon::parse($data2)->timestamp;
        $data2 = date("Y-m-d", $data2);

        $data_all = $data2 . " " . $data1;
        return $data_all;
    }
}

if (!function_exists('LoginDecrypt')) {
    function LoginDecrypt($encrypted)
    {

        $frameware = $encrypted;
        $encrypt_method = 'AES-256-CBC';
        $secret_key = 'LoginEncrypt';
        $secret_iv = 'LoginEncrypt';
        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        // decrypt token
        $decryptToken = openssl_decrypt(base64_decode($frameware), $encrypt_method, $key, 0, $iv);
        return $decryptToken;
        // convert in array
        $decryptTokenArray = json_decode($decryptToken, 1);
        // output
        return $decryptTokenArray;
    }
}

if (!function_exists('datetimeTotime')) {
    function datetimeTotime($data)
    {
        $data = Carbon::parse($data)->timestamp;
        $data = date("H:i", $data);
        return $data;
    }
}

if (!function_exists('datetimeToDateThai')) {
    function datetimeToDateThai($date)
    {

        if ($date == NULL) {
            return '-';
        } else {

            $ex = explode(' ', $date);
            $ex = explode('-', $ex[0]);
            return date("d/m/Y", mktime(0, 0, 0, $ex[1],   $ex[2],    $ex[0] + 543));
        }
    }
}



// $datas  = [
//     'log_type' => $datas['log_type'], ( add edit delete view)
//     'route_name' => $datas['route_name'], $request->route()->getName()
//     'log_name' => $datas['submenu_name'],
//     'submenu_id' => $datas['submenu_id'],
//     'data_array' => json_encode([]),

// ]
if (!function_exists('createLogTrans')) {


    function createLogTrans($datas, $inputs = [], $offen = 'd/M/Y H:i')
    {

        foreach (OoapLogTransModel::getLastLog($datas)->get() as $ka => $va) {

            $d1 = date_create($va->log_date);

            $d1 = date_format($d1, $offen);

            $d2 = date_create(now());

            $d2 = date_format($d2, $offen);

            if ($d1 == $d2) {

                return false;
            }
        }

        $datas['log_type'] = isset($datas['log_type']) ? $datas['log_type'] : 'view';

        if (empty($datas['route_name'])) {

            $datas['route_name'] = NULL;
        }

        $datas['submenu_id'] = !empty($datas['submenu_id']) ? $datas['submenu_id'] : NULL;
        $datas['submenu_name'] = !empty($datas['submenu_name']) ? $datas['submenu_name'] : NULL;
        OoapLogTransModel::create([
            'data_array' => json_encode($inputs),
            'log_type' => $datas['log_type'],
            'route_name' => $datas['route_name'],
            'log_name' => $datas['submenu_name'],
            'full_name' =>  auth()->user()->fname_th . ' ' . auth()->user()->lname_th,
            'submenu_id' => $datas['submenu_id'],
            'log_date' => now(),
            'ip' => $_SERVER['REMOTE_ADDR'],
            'username' => auth()->user()->emp_citizen_id,
            'created_by' => auth()->user()->emp_citizen_id,
            'created_at' => now(),
        ]);
    }
}

if (!function_exists('getTimeAgo')) {

    function getTimeAgo($t1 = null, $t2 = null)
    {

        $t1 = strtotime($t1);
        $t2 = strtotime($t2);

        $diff = $t2 - $t1;

        $config['year'] = ['factor' => 60 * 60 * 24 * 365, 'label' => 'ปี'];
        $config['month'] = ['factor' => 60 * 60 * 24 * 30, 'label' => 'เดือน'];
        $config['week'] = ['factor' => 60 * 60 * 24 * 7, 'label' => 'สัปดาห์'];
        $config['day'] = ['factor' => 60 * 60 * 24, 'label' => 'วัน'];
        $config['hr'] = ['factor' => 60 * 60, 'label' => 'ชม.'];
        $config['min'] = ['factor' => 60, 'label' => 'นาที'];


        if ($diff >= 0) {

            foreach ($config as $kc => $vc) {


                if ($diff >= $vc['factor']) {

                    return ROUND($diff / $vc['factor']) . ' ' . $vc['label'];
                }
            }

            return 'เมือสักครู่';
        } else {

            $diff  *= -1;


            foreach ($config as $kc => $vc) {


                if ($diff >= $vc['factor']) {

                    return 'จะเกิดขึ้นในอีก ' . ROUND($diff / $vc['factor']) . ' ' . $vc['label'];
                }
            }

            return 'อีกสักครู่';
        }
    }
}

if (!function_exists('numberFormat')) {
    function numberFormat($number, $decimals = 0)
    {

        // $number = 555;
        // $decimals=0;
        // $number = 555.000;
        // $number = 555.123456;

        if (strpos($number, '.') != null) {
            $decimalNumbers = substr($number, strpos($number, '.'));
            $decimalNumbers = substr($decimalNumbers, 1, $decimals);
        } else {
            $decimalNumbers = 0;
            for ($i = 2; $i <= $decimals; $i++) {
                $decimalNumbers = $decimalNumbers . '0';
            }
        }
        // return $decimalNumbers;



        $number = (int) $number;
        // reverse
        $number = strrev($number);

        $n = '';
        $stringlength = strlen($number);

        for ($i = 0; $i < $stringlength; $i++) {
            if ($i % 2 == 0 && $i != $stringlength - 1 && $i > 1) {
                $n = $n . $number[$i] . ',';
            } else {
                $n = $n . $number[$i];
            }
        }

        $number = $n;
        // reverse
        $number = strrev($number);

        ($decimals != 0) ? $number = $number . '.' . $decimalNumbers : $number;

        return $number;
    }
}

if (!function_exists('show_menu')) {
    function show_menu($activePage = NULL, $routeName = NULL)
    {
        //Request $request,
        // Request $request;

        $routeName= request()->route()->getName();

        $allow_menus = [];
        if (auth()->user()->role_id != 1) {

            $allow_menus = OoapMasUserPer::getPermission(auth()->user()->emp_id)->pluck('submenu_id')->toArray();

            if (empty($allow_menus)) {

                $allow_menus = OoapMasRolePer::getPermission(auth()->user()->role_id)->pluck('submenu_id')->toArray();
            }
        }

        $menus = [];
        foreach (OoapMasSubmenu::getDatas($allow_menus, NULL, $show_on_menu = 1) as $ks => $vs) {

            if ($routeName == $vs->route_name) {
                $activeByRoute = 1;
            }

            $menus[$vs->menu_id][] = $vs;
        }

        $lis = [];
        foreach ($menus as $km => $vm) {

            $menu = $vm[0];

            $active = '';

            $sub_lis = [];

            foreach ($vm as $ks => $vs) {

                $active_submenu = NULL;


                if ($routeName == $vs->route_name) {
                    $active = 'active';
                    $active_submenu = ' active';
                }

                if ($vs->error == 1) {
                    // $sub_lis[] = '
                    //     <li class="site-menu-item">
                    //         <a class="animsition-link" href="#">
                    //             <span style="color: red;" class="site-menu-title">' . $vs->submenu_name . '</span>
                    //         </a>
                    //     </li>
                    // ';
                    $sub_lis[] = '
                        <li class="site-menu-item">
                            <a class="animsition-link" href="#">
                                <span style="" class="site-menu-title">' . $vs->submenu_name . '</span>
                            </a>
                        </li>
                    ';
                }
                // else if ($vs->route_name == 'activity.plan_adjust.index') {
                //     $sub_lis[] = '
                //         <li class="site-menu-item">
                //             <a class="animsition-link" href="#">
                //                 <span class="site-menu-title">' . $vs->submenu_name . '</span>
                //             </a>
                //         </li>
                //     ';
                // }
                else {

                    if (Route::has($vs->route_name)) {

                        $sub_lis[] = '
                            <li class="site-menu-item">
                                <a class="animsition-link '. $active_submenu .'" href="' . route($vs->route_name) . '">
                                    <span class="site-menu-title">' . $vs->submenu_name . '</span>
                                </a>
                            </li>
                        ';
                    }


                }
            }


            if (empty($activeByRoute)) {

                if ($activePage == $menu->activepage_name) {
                    $active = 'active';
                }
            }

            $lis[] = '
                <li class="dropdown site-menu-item has-sub  ' . $active . '">
                    <a data-toggle="dropdown" href="javascript:void(0)" data-dropdown-toggle="false">
                        <i class="site-menu-icon site-menu-icon wb-layout" aria-hidden="true"></i>
                        <span class="site-menu-title">' . $menu->menu_name . '</span>
                        <span class="site-menu-arrow"></span>
                    </a>
                    <div class="dropdown-menu">
                        <div class="site-menu-scroll-wrap">
                            <ul class="site-menu-sub">
                                ' . implode('', $sub_lis) . '
                            </ul>
                        </div>
                    </div>
                </li>
            ';
        }

        unset($menus);

        return  implode('', $lis);
    }
}

if (!function_exists('doMoney')) {


    function doMoney( $val = NULL ) {


        return  floatval( str_replace(',', '', $val ));


    }
}


if (!function_exists('getRequestsStatus')) {
    function getRequestsStatus($index = NULL)
    {



        $status[1] = 'บันทึกแบบร่าง';
        $status[2] = 'รอพิจารณา';
        $status[3] = 'ผ่านการพิจารณา';
        $status[4] = 'ไม่ผ่านการพิจารณา';
        $status[5] = 'ส่งคำขอกลับ';


        if (!empty($status[$index])) {
            return $status[$index];
        }

        return $status;
    }
}
