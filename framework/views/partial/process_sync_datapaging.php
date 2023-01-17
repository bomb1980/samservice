<?php
set_time_limit(0);

Yii::$app->session->remove('progress');
Yii::$app->session->remove('executionTime');
Yii::$app->session->remove('total_user');


if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $start_time = microtime(true);

  $page = $_REQUEST['page'];

  $perpage = $_REQUEST['perpage'];

  $total = $_REQUEST['total'];

  if (!isset(Yii::$app->session['firstTime'])) {
    Yii::$app->session['firstTime'] = $start_time;
    Yii::$app->session['total_all'] = (int)$total;
  }


  if ($page == 1) {
    $start = 0;
    $end = (int)$perpage;
  } else {
    $start = (($page - 1) * $perpage) + 1;
    $end = (($page - 1) * $perpage) + $perpage;
  }

  if ($end > $total) $end = (int)$total;

  //echo "รายการ " . $start . " - " . $end . " จาก " . $total;

  $file = new SplFileObject($filePath = Yii::$app->basePath . '/runtime/' . "d80_2.txt");

  $tmp = [];

  for ($i = $start; $i <=  $_REQUEST['end']; $i++) {
    $file->seek($i);
    $tmp[] = $file->current();
  }

  $rows = $tmp;

  $log_path = Yii::$app->getRuntimePath() . '/log_' . date('d-M-Y') . '.log';

  $i = 1;
  $subtotal = count($rows);

  foreach ($rows as $item) {

    /*
    if (!empty($item)) {

      $arr = explode("|", str_replace(
        array("?"),
        "|",
        $item
      ));

      $registernumber = trim($arr[0]);
      $oel_answer = trim($arr[1]);
      $survey_date = trim($arr[2]);
      $result = date_parse($survey_date);
      //print_r($result);
      //echo $result['year'];
      $survey_format = ($result['year']-543) . '-' . $result['month'] . '-' . $result['day'] . ' 00:00';
      echo  $survey_format;
  
    }
*/


    if (!empty($item)) {

      $arr = explode("|", str_replace(
        array("?"),
        "|",
        $item
      ));

      $registernumber = trim($arr[0]);
      $oel_answer = trim($arr[1]);
      $survey_date = trim($arr[2]);
      $result = date_parse($survey_date);
      $survey_format = ($result['year'] - 543) . '-' . $result['month'] . '-' . $result['day'] . ' 00:00';

      $conn = Yii::$app->db3;
      $sql = "select * from crop_v_bran where registernumber like :registernumber; ";
      $sql = "SELECT registernumber as oel_registernumber, acc_no as oel_accno ,registername as oel_registername ,email as oel_emailaddress,'1' as oel_emailtype , registerdate as oel_registerdate , crop_createtime as oel_createdate,'sys' as oel_createby,crop_updatetime as oel_updatedate , 'sys' as oel_updateby,SSO_BRAN_CODE as oel_remark,crop_remark as oel_status FROM wpdreportdb.crop_v_bran where crop_remark = 'P' and registernumber =:registernumber ;";

      $command = $conn->createCommand($sql);
      $command->bindValue(":registernumber", $registernumber);
      $rowsA = $command->queryAll();

      if (count($rowsA) == 0) {
        $log_path = Yii::$app->getRuntimePath() . '/log_A' . date('d-M-Y') . '.log';
        Yii::$app->CommonFnc->write_log($log_path, 'Registernumber : ' . $registernumber . ' ไม่พบข้อมูลในระบบ');
      } else {
        if ($oel_answer == "AL") {
          $conn = Yii::$app->db4;
          $sql = "select * from otp_email_tb where oel_registernumber = :registernumber; ";
          $command = $conn->createCommand($sql);
          $command->bindValue(":registernumber", $registernumber);
          $row = $command->queryAll();

          //ถ้าไม่มีให้เพิ่มเข้าไปก่อน
          if (count($row) == 0) {
            //throw new Exception('ไม่พบข้อมูลOK');
            $oel_registernumber = "";
            $oel_accno = "";
            $oel_registername = "";
            $oel_emailaddress = "";
            $oel_emailtype = "";
            $oel_registerdate = "";
            $oel_createdate = "";
            $oel_createby = "";
            $oel_updatedate = "";
            $oel_updateby = "";
            $oel_remark = "";
            $oel_status = "";
            //$oel_answer="";

            if (count($rowsA) > 0) {
              $oel_registernumber =  $rowsA[0]['oel_registernumber'];
              $oel_accno =  $rowsA[0]['oel_accno'];
              $oel_registername =  $rowsA[0]['oel_registername'];
              $oel_emailaddress =  $rowsA[0]['oel_emailaddress'];
              $oel_emailtype =  $rowsA[0]['oel_emailtype'];
              $oel_registerdate =  $rowsA[0]['oel_registerdate'];
              $oel_createdate = $rowsA[0]['oel_createdate'];
              $oel_createby =  $rowsA[0]['oel_createby'];
              $oel_updatedate =  $rowsA[0]['oel_updatedate'];
              $oel_updateby =  $rowsA[0]['oel_updateby'];
              $oel_remark =  $rowsA[0]['oel_remark'];
              $oel_status =  $rowsA[0]['oel_status'];

              //$noOfRecords2 =  $rowps[1]['oel_accno'];

              //echo($oel_registernumber."***".$oel_accno."***".$oel_registername."***".$oel_emailaddress."***".$oel_emailtype."***".$oel_registerdate."***".$oel_createdate."***".$oel_createby."***".$oel_updatedate."***".$oel_updateby."***".$oel_remark."***".$oel_status);
              /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
              $conn = Yii::$app->db4;
              $sql2 = "INSERT INTO etpdb.otp_email_tb (
              oel_registernumber 
              ,oel_accno 
              ,oel_registername 
              ,oel_emailaddress
              ,oel_emailtype
              ,oel_registerdate
              ,oel_createdate
              ,oel_createby
              ,oel_updatedate
              ,oel_updateby
              ,oel_remark
              ,oel_status
              ,oel_answer)
              value
              (:oel_registernumber
              ,:oel_accno
              ,:oel_registername
              ,:oel_emailaddress
              ,:oel_emailtype
              ,:oel_registerdate
              ,:oel_createdate
              ,:oel_createby
              ,:oel_updatedate
              ,:oel_updateby
              ,:oel_remark
              ,:oel_status
              ,:oel_answer);";
              $cmd = $conn->createCommand($sql2);
              $cmd->bindValue(":oel_registernumber", $oel_registernumber);
              $cmd->bindValue(":oel_accno", $oel_accno);
              $cmd->bindValue(":oel_registername", $oel_registername);
              $cmd->bindValue(":oel_emailaddress", $oel_emailaddress);
              $cmd->bindValue(":oel_emailtype", $oel_emailtype);
              $cmd->bindValue(":oel_registerdate", $oel_registerdate);
              $cmd->bindValue(":oel_createdate", $oel_createdate);
              $cmd->bindValue(":oel_createby", $oel_createby);
              $cmd->bindValue(":oel_updatedate", $oel_updatedate);
              $cmd->bindValue(":oel_updateby", $oel_updateby);
              $cmd->bindValue(":oel_remark", $oel_remark);
              $cmd->bindValue(":oel_status", $oel_status);
              $cmd->bindValue(":oel_answer", $oel_answer);

              $cmd->execute();
            }
          }

          $conn = Yii::$app->db3;
          $sql = "update crop_v_bran set crop_ex_opendate = null, survey_date = :survey_date where registernumber = :registernumber;";
          $command = $conn->createCommand($sql);
          $command->bindValue(":registernumber", $registernumber);
          $command->bindValue(":survey_date", $survey_format);
          $command->execute();

          $conn = Yii::$app->db4;
          $sql = "update otp_email_tb set oel_answer = :oel_answer where oel_registernumber = :registernumber ;";
          $command = $conn->createCommand($sql);
          $command->bindValue(":registernumber", $registernumber);
          $command->bindValue(":oel_answer", $oel_answer);
          $command->execute();
        } else {
          $conn = Yii::$app->db4;
          $sql = "select * from otp_email_tb where oel_registernumber = :registernumber; ";
          $command = $conn->createCommand($sql);
          $command->bindValue(":registernumber", $registernumber);
          $row = $command->queryAll();

          //var_dump(count($row));
          //exit();


          if (count($row) == 0) {
            //throw new Exception('ไม่พบข้อมูลOK');
            $oel_registernumber = "";
            $oel_accno = "";
            $oel_registername = "";
            $oel_emailaddress = "";
            $oel_emailtype = "";
            $oel_registerdate = "";
            $oel_createdate = "";
            $oel_createby = "";
            $oel_updatedate = "";
            $oel_updateby = "";
            $oel_remark = "";
            $oel_status = "";
            //$oel_answer="";

            if (count($rowsA) > 0) {
              $oel_registernumber =  $rowsA[0]['oel_registernumber'];
              $oel_accno =  $rowsA[0]['oel_accno'];
              $oel_registername =  $rowsA[0]['oel_registername'];
              $oel_emailaddress =  $rowsA[0]['oel_emailaddress'];
              $oel_emailtype =  $rowsA[0]['oel_emailtype'];
              $oel_registerdate =  $rowsA[0]['oel_registerdate'];
              $oel_createdate = $rowsA[0]['oel_createdate'];
              $oel_createby =  $rowsA[0]['oel_createby'];
              $oel_updatedate =  $rowsA[0]['oel_updatedate'];
              $oel_updateby =  $rowsA[0]['oel_updateby'];
              $oel_remark =  $rowsA[0]['oel_remark'];
              $oel_status =  $rowsA[0]['oel_status'];

              //$noOfRecords2 =  $rowps[1]['oel_accno'];

              //echo($oel_registernumber."***".$oel_accno."***".$oel_registername."***".$oel_emailaddress."***".$oel_emailtype."***".$oel_registerdate."***".$oel_createdate."***".$oel_createby."***".$oel_updatedate."***".$oel_updateby."***".$oel_remark."***".$oel_status);
              /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
              $conn = Yii::$app->db4;
              $sql2 = "INSERT INTO etpdb.otp_email_tb (
              oel_registernumber 
             ,oel_accno 
             ,oel_registername 
             ,oel_emailaddress
             ,oel_emailtype
             ,oel_registerdate
             ,oel_createdate
             ,oel_createby
             ,oel_updatedate
             ,oel_updateby
             ,oel_remark
             ,oel_status
             ,oel_answer)
             value
             (:oel_registernumber
             ,:oel_accno
             ,:oel_registername
             ,:oel_emailaddress
             ,:oel_emailtype
             ,:oel_registerdate
             ,:oel_createdate
             ,:oel_createby
             ,:oel_updatedate
             ,:oel_updateby
             ,:oel_remark
             ,:oel_status
             ,:oel_answer);";
              $cmd = $conn->createCommand($sql2);
              $cmd->bindValue(":oel_registernumber", $oel_registernumber);
              $cmd->bindValue(":oel_accno", $oel_accno);
              $cmd->bindValue(":oel_registername", $oel_registername);
              $cmd->bindValue(":oel_emailaddress", $oel_emailaddress);
              $cmd->bindValue(":oel_emailtype", $oel_emailtype);
              $cmd->bindValue(":oel_registerdate", $oel_registerdate);
              $cmd->bindValue(":oel_createdate", $oel_createdate);
              $cmd->bindValue(":oel_createby", $oel_createby);
              $cmd->bindValue(":oel_updatedate", $oel_updatedate);
              $cmd->bindValue(":oel_updateby", $oel_updateby);
              $cmd->bindValue(":oel_remark", $oel_remark);
              $cmd->bindValue(":oel_status", $oel_status);
              $cmd->bindValue(":oel_answer", $oel_answer);

              $cmd->execute();
            }
          }

          $conn = Yii::$app->db4;
          $sql = "update otp_email_tb set oel_answer = :oel_answer where oel_registernumber = :registernumber ;";
          $command = $conn->createCommand($sql);
          $command->bindValue(":registernumber", $registernumber);
          $command->bindValue(":oel_answer", $oel_answer);
          $command->execute();


          ////// ถ้าหาไม่เจอใน otp บังคับให้ระบบยกเลิกการค้นหา
          $conn = Yii::$app->db3;
          $sql = "update crop_v_bran set survey_date = :survey_date, numofemp = '0' , crop_ex_opendate = Null where registernumber = :registernumber;";
          $command = $conn->createCommand($sql);
          $command->bindValue(":survey_date", $survey_format);
          $command->bindValue(":registernumber", $registernumber);
          $command->execute();
          // echo("บันทึกสำเร็จ");
        }
      }
    }



    //usleep(150000);

    // Calculate the percentation
    $percent = intval($i / $subtotal * 100);

    // Put the progress percentage and message to array.
    $arr_content['percent'] = $percent;
    $arr_content['message'] = $i . "/" . $subtotal . " row(s) processed.";

    $progress = json_encode($arr_content);

    Yii::$app->session['progress'] = $progress;

    if ($percent == 100) {
      $end_time = microtime(true);
      $executionTime = $end_time - $start_time;
      Yii::$app->session['executionTime'] = $executionTime;
      Yii::$app->session['total_user'] = $subtotal;
    }

    // Sleep one second so we can see the delay
    //sleep(1);
    $i++;
  }

  //echo "รวม " . $i;

  //sleep(5);

  //exit;

  $end_time = microtime(true);
  $executionTime = $end_time - $start_time;

  if (round($executionTime) > 0) {
    $strTime = Yii::$app->CommonFnc->calctime(round($executionTime));
  } else {
    $strTime = $executionTime . " millisecond";
  }
  echo "จำนวนปรับปรุง : " . number_format(count($rows)) . " เร็คคอร์ด , ใช้เวลา {$strTime}";

  $executionTimeAll =  $end_time - Yii::$app->session['firstTime'];
  Yii::$app->session['executionTimeAll'] = $executionTimeAll;
}
