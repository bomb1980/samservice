<?php
// Start the session.
if (strlen(session_id()) === 0) {
  session_start();
  unset($_SESSION['progress']);
  unset($_SESSION['executionTime']);
}
set_time_limit(0);

$start_time = microtime(true);

// The example total processes.
$sql = "SELECT * FROM mas_user ORDER by id ASC ";
$rows = Yii::app()->db->createCommand($sql)->queryAll();

$total = 50;
$total = count($rows);

$log_path = Yii::app()->getRuntimePath() . '/log_' . date('d-M-Y') . '.log';

$base_mem = memory_get_peak_usage();

// The array for storing the progress.
$arr_content = array();
$i = 1;
foreach ($rows as $item) {
  $base_mem_peruser = memory_get_peak_usage();
  CommonFnc::write_log($log_path, 'Initial Mem per User: ' . byteFormat($base_mem_peruser) . ' ');
  $uid = $item['uid'];

  if (isset($_SESSION['progress'])) {
    session_start(); //IMPORTANT!
  }

  CommonFnc::write_log($log_path, date("Y-m-d H:i:s"));
  CommonFnc::write_log($log_path, 'Write log Test by Niras UID Befor LDAP : ' . $item['uid']);
  $data = lkup_user::LDAP_LIST($uid);
  CommonFnc::write_log($log_path, 'Write log Test by Niras Affter LDAP ' . date("Y-m-d H:i:s"));


  $model = new CommonAction;

  foreach ($data as $dataitem) {

    $model->uid = $dataitem["uid"];
    $displayname = $dataitem["firstname"] . " " . $dataitem["lastname"];
    $model->displayname = $displayname;
    $model->ssobranch_code = $dataitem['ssobranchcode'];
    $model->ssomail = $dataitem['mail'];
    $model->ssoaccountactive = strtolower($dataitem['accountactive']);

    CommonFnc::write_log($log_path, 'Write log Test by Niras UID : ' . $dataitem['uid']);
    CommonFnc::write_log($log_path, 'Write log Test by Niras Name : ' . $displayname);
    CommonFnc::write_log($log_path, 'Write log Test by Niras branchcode : ' . $dataitem['ssobranchcode']);
    CommonFnc::write_log($log_path, 'Write log Test by Niras mail : ' . $dataitem['mail']);
    CommonFnc::write_log($log_path, 'Write log Test by Niras Active: ' . strtolower($dataitem['accountactive']));

    if ($model->uid == null) {
      continue;
    }
    if ($dataitem['ssobranchcode'] === null || is_null($dataitem['ssobranchcode']) || empty($dataitem['ssobranchcode'])) {
      continue;
    }
    $rows = $model->Check_mas_user();
    CommonFnc::write_log($log_path, 'Write log Test by Niras : ตรวจสอบสำเร็จ ' . date("Y-m-d H:i:s"));
  }

  // Calculate the percentation
  $percent = intval($i / $total * 100);

  // Put the progress percentage and message to array.
  $arr_content['percent'] = $percent;
  $arr_content['message'] = $i . "/" . $total . " row(s) processed.";

  $progress = json_encode($arr_content);
  $_SESSION['progress'] = $progress;

  if ($percent == 100) {
    $end_time = microtime(true);
    $executionTime = $end_time - $start_time;
    $_SESSION['executionTime'] = $executionTime;
    $_SESSION['total_user'] = $total;
  }

  session_write_close(); //IMPORTANT!

  // Sleep one second so we can see the delay
  //sleep(1);
  $i++;

  $extra_mem_peruser = memory_get_peak_usage();
  $total_mem_peruser = $extra_mem_peruser - $base_mem_peruser;

  CommonFnc::write_log($log_path, 'Total Mem per User: ' . byteFormat($total_mem_peruser) . ' ');

  $allowed_hosts = array('intranet.sso.go.th', 'ihcws.sso.go.th');
  if (in_array($_SERVER['HTTP_HOST'], $allowed_hosts)) {
    sleep(1);
    CommonFnc::write_log($log_path, 'Sleep1');
  }
  CommonFnc::write_log($log_path, '');
  CommonFnc::write_log($log_path, '');
}

$extra_mem = memory_get_peak_usage();
$total_mem = $extra_mem - $base_mem;
ob_end_flush();

CommonFnc::write_log($log_path, 'Total Mem Above Basline: ' . byteFormat($total_mem) . ' ');


// Byte formatting
function byteFormat($bytes, $unit = "", $decimals = 2)
{
  $units = array(
    'B' => 0, 'KB' => 1, 'MB' => 2, 'GB' => 3, 'TB' => 4,
    'PB' => 5, 'EB' => 6, 'ZB' => 7, 'YB' => 8
  );

  $value = 0;
  if ($bytes > 0) {
    // Generate automatic prefix by bytes 
    // If wrong prefix given
    if (!array_key_exists($unit, $units)) {
      $pow = floor(log($bytes) / log(1024));
      $unit = array_search($pow, $units);
    }

    // Calculate byte value by prefix
    $value = ($bytes / pow(1024, floor($units[$unit])));
  }

  // If decimals is not numeric or decimals is less than 0 
  // then set default value
  if (!is_numeric($decimals) || $decimals < 0) {
    $decimals = 2;
  }

  // Format output
  return sprintf('%.' . $decimals . 'f ' . $unit, $value);
}

exit;
// Loop through process
for ($i = 1; $i <= $total; $i++) {

  if (isset($_SESSION['progress'])) {
    session_start(); //IMPORTANT!
  }

  $data = lkup_user::LDAP_LIST($uid); //var_dump($data);exit;
  $model = new CommonAction;

  foreach ($data as $dataitem) {

    $model->uid = $dataitem["uid"];
    $displayname = $dataitem["firstname"] . " " . $dataitem["lastname"];
    $model->displayname = $displayname;
    $model->ssobranch_code = $dataitem['ssobranchcode'];
    $model->ssomail = $dataitem['mail'];
    $model->ssoaccountactive = $dataitem['accountactive'];

    if ($model->uid == null) {
      continue;
    }
    if ($dataitem['ssobranchcode'] === null || is_null($dataitem['ssobranchcode']) || empty($dataitem['ssobranchcode'])) {
      continue;
    }
    $rows = $model->Check_mas_user();
  }

  // Calculate the percentation
  $percent = intval($i / $total * 100);

  // Put the progress percentage and message to array.
  $arr_content['percent'] = $percent;
  $arr_content['message'] = $i . "/" . $total . " row(s) processed.";

  $progress = json_encode($arr_content);
  $_SESSION['progress'] = $progress;

  session_write_close(); //IMPORTANT!

  // Sleep one second so we can see the delay
  //sleep(1);
}
