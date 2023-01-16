<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\CommonAction;
use app\components\CustomWebUser;

class DatamanagementController extends Controller
{

	public function init()
    {
        parent::init();
        if (Yii::$app->user->isGuest) {
            UserController::chkLogin();
            exit;
        }
    }


	public function actionIndex()
	{
	}

	public function actionGettablename()
	{
		//*********************************************************
		$tbn = $_POST['tbn'];

		$ListTB = \app\models\lkup_data::getTBName($tbn);

		//echo "{$action},{$tbn}";
		$data1 = array('tbn' => $tbn, 'ListTB' => $ListTB);
		return $this->renderPartial('/modal/gettablename', $data1);

		//*********************************************************

		if (!Yii::$app->user->isGuest) {
			if (isset(Yii::$app->user->username)) {
			} else {
			}
		} else {
		}
	} //function

	//Select Only
	public function actionExecutesqlc()
	{
		//*********************************************************
		$sqlc = $_POST['sqlc'];
		$udb1 = $_POST['udb1'];

		$tbnsql = explode(" ", $sqlc); //แยกคำสั่งออกมาเป็น ส่วนๆ เพื่อหาชื่อ table

		//$tbnsql[0]; //คำสั่ง select
		//$tbnsql[1]; //* หรือ fieldname
		//$tbnsql[2]; //from
		//$tbnsql[3]; //table name
		//$tbnsql[4]; //where , 
		//echo $tbnsql[3];
		$tbn1 = $tbnsql[3];

		$ListCL = \app\models\lkup_data::getColumnName($udb1, $tbn1);
		$data1 = array('sqlc' => $sqlc, 'udb1' => $udb1, 'tbn1' => $tbn1, 'ListCL' => $ListCL);

		return $this->renderPartial('/modal/executesqlc', $data1);
		//*********************************************************

		if (!Yii::$app->user->isGuest) {
			if (isset(Yii::$app->user->username)) {
			} else { //if

			}
		} else { //if

		}
	} //function

	//Select Insert delete
	public function actionExecutesqlcr()
	{
		//*********************************************************	
		$sqlcr = $_POST['sqlcr'];
		$udb1 = $_POST['udb1'];
		//echo "{$action},{$sqlcr}";
		$data1 = array('sqlcr' => $sqlcr,  'udb1' => $udb1);

		return $this->renderPartial('/modal/executesqlcr', $data1);
		//*********************************************************

		if (!Yii::$app->user->isGuest) {
			if (isset(Yii::$app->user->username)) {
			} else { //if

			}
		} else { //if

		}
	} //function

	public function actionListdata2()
	{

		//*********************************************************		

		$tbn1 = $_POST['tbn1']; //tablename
		$udb1 = $_POST['udb1']; //databasename
		$txtsql = $_POST['txtsql']; //sql command ที่ user key
		$txtsql = str_replace(";","",$txtsql);

		/*
		if ($udb1 == "wpddb") {
			$conn = Yii::$app->db; //get connection
		} else if ($udb1 == "wpdlogdb") {
			$conn = Yii::$app->db2; //get connection
		} else if ($udb1 == "wpdreportdb") {
			$conn = Yii::$app->db3; //get connection
		}*/

		/*
		Yii::$app->setComponents(array(
			'dynamicdb' => array('connectionString' => Yii::$app->params['data_ctrl']['dbhost'] . 'dbname=' . $udb1)
		));*/

		\Yii::$app->dynamicdb->dsn= Yii::$app->params['data_ctrl']['dbhost'] . 'dbname=' . $udb1;
		$conn = Yii::$app->dynamicdb; //get connection

		//var_dump($_POST);

		$dbtb = $udb1 . "." . $tbn1;

		//echo "{$action},{$tbn1},{$udb1}";

		$draw = $_POST['draw']; //ลำดับที่ตารางที่จะเอาข้อมููลไปเขียน

		$columns = $_POST['columns']; //array columns 
		//var_dump($columns);

		$columnsdata = $_POST['columns'][1]['data']; //ลำดับที่ collums เริ่มต้นที่ 0
		$colname = $_POST['columns'][1]['name']; //ชื่อ column
		$colsch = $_POST['columns'][1]['searchable']; //เปิดให้ search true or false
		$colord = $_POST['columns'][1]['orderable']; //อนุญาติให้จัดเรียง true or false
		$colschtxt = $_POST['columns'][1]['search']['value']; //ข้อความค้นหาในคอลัมน์ 1
		$colschtype = $_POST['columns'][1]['search']['regex']; //ประเภทการค้นหาในคอลัมน์ true or false

		$countcolumns = count($columns);  //จำนวนคอลัมน์ที่กำหนดไว้ในส่วน header

		$ordercol = $_POST['order'][0]['column']; //การจัดเรียงเริ่มต้น
		$ordertype = $_POST['order'][0]['dir']; //ประเภทของการจัดเรียง

		$start = $_POST['start']; //จำนวน record เริ่มต้นต่อ 1 หน้า 0
		$length = $_POST['length']; //จำนวน record สุดท้าย / หน้า 10
		$page = 1;
		if (!empty($_POST['page'])) $page = $_POST['page'];  //เลขหน้าที่คลิกเข้ามา กรณีไม่มีข้อมูลจะไม่มีเลขหน้า

		$searchtxt = $_POST['search']['value']; //คำค้นหารวมที่พิมพ์เข้ามา
		$searchtype = $_POST['search']['regex']; //การค้นหา true or false

		$orderb = "";
		if (strstr($txtsql, 'order')) {
			$orderb = substr($txtsql, strpos($txtsql, 'order'), strlen($txtsql));
		} else {
			$orderb = "";
		}


		$Condition = "";
		if (strstr($txtsql, 'where')) {
			$Condition = substr($txtsql, strpos($txtsql, 'where'), strlen($txtsql));
		} else {
			$Condition = "";
		}

		if (strstr($Condition, 'order')) {
			$Condition = substr($Condition, 0, strpos($Condition, 'order'));
		} else {
			$Condition = $Condition;
		}

		//$fn = $conn->schema->getTable($tbn1)->getColumnNames(); //fieldname
		$fn = \app\models\lkup_data::getColumnName($udb1, $tbn1);

		//foreach ($fn as $col){
		//	var_dump($col);
		//}
		$params = array();

		$Allsearch = "";
		$keyall = array();

		if ($searchtxt != "") {
			$ListCL = \app\models\lkup_data::getColumnName($udb1, $tbn1, " `Type` NOT LIKE '%date%' AND `Type` NOT LIKE '%time%';"); 
			foreach ($ListCL as $col){
				$keyall[] =  $col['Field'] . " LIKE :all_" . $col['Field'];
				$keyword = $searchtxt;
				$keyword = addcslashes($keyword, '%_');
				$params[':all_' . $col['Field']] = "%$keyword%";
			}
			/*
			for ($i = 0, $ien = count($columns) - 1; $i < $ien; $i++) {
				//$keyall[] =  " " . $fn[$i] . " LIKE '%" . $_POST['search']['value'] . "%'";
				$keyall[] =  $fn[$i] . " LIKE :all_" . $fn[$i];
				$keyword = $searchtxt;
				$keyword = addcslashes($keyword, '%_');
				$params[':all_' . $fn[$i]] = "%$keyword%";
			}*/

			$Allsearch .= " WHERE (" . implode(" OR ", $keyall) . ") ";
		}
		//echo $Allsearch;
		//print_r($params);
		//exit;

		if ($Condition != "") {
			for ($i = 0, $ien = count($columns) - 1; $i < $ien; $i++) {
				if ($_POST['columns'][$i]['search']['value'] != "") {
					$Condition = $Condition . " AND " . $fn[$i] . " LIKE :" . $fn[$i];
					$keyword = $_POST['columns'][$i]['search']['value'];
					$keyword = addcslashes($keyword, '%_');
					$params[':' . $fn[$i]] = "%$keyword%";
				} //if
			} //for
		} else { //if
			$fistno = 1;
			for ($i = 0, $ien = count($columns) - 1; $i < $ien; $i++) {
				if ($_POST['columns'][$i]['search']['value'] != "") {
					if ($fistno == 1) {
						if ($searchtxt != "") {
							$Condition = $Condition . " AND " . $fn[$i] . " LIKE :" . $fn[$i];
							$keyword = $_POST['columns'][$i]['search']['value'];
							$keyword = addcslashes($keyword, '%_');
							$params[':' . $fn[$i]] = "%$keyword%";
						} else {
							$Condition = $Condition . " WHERE " . $fn[$i] . " LIKE :" . $fn[$i];
							$keyword = $_POST['columns'][$i]['search']['value'];
							$keyword = addcslashes($keyword, '%_');
							$params[':' . $fn[$i]] = "%$keyword%";
						}
						$fistno += 1;
					} else {
						$Condition = $Condition . " AND " . $fn[$i] . " LIKE :" . $fn[$i];
						$keyword = $_POST['columns'][$i]['search']['value'];
						$keyword = addcslashes($keyword, '%_');
						$params[':' . $fn[$i]] = "%$keyword%";
					} //if
				} //if
			} //for
		} //if


		$Condition =   $Allsearch . $Condition;


		//ตรวจสอบว่ามีการกรอกคำค้นหาแต่ละคอลัมน์ไหม
		/*
		$searchcol = FALSE;
		for ($i = 0, $ien = count($columns)-1; $i < $ien; $i++) {
			if ($_POST['columns'][$i]['search']['value'] != "") {
				$searchcol = TRUE;
				break;
			}
		}*/
		/*
		if ($Condition != "") {
			//ตรวจสอบจากกล่องค้นหารวม
			if ($_POST['search']['value'] != "") {
				$firstnos = 1;
				for ($i = 0, $ien = count($columns) - 1; $i < $ien; $i++) {
					if ($firstnos == 1) {
						$Condition = $Condition . " AND " . $fn[$i] . " LIKE '%" . $_POST['search']['value'] . "%'";
						$firstnos += 1;
					} else if ($firstnos > 1) {
						$Condition = $Condition . " OR " . $fn[$i] . " LIKE '%" . $_POST['search']['value'] . "%'";
						$firstnos += 1;
					}
				} //for
			} //if			
		} else { //if
			if ($_POST['search']['value'] != "") {
				$firstnos = 1;
				for ($i = 0, $ien = count($columns) - 1; $i < $ien; $i++) {
					if ($firstnos == 1) {
						$Condition = $Condition . " WHERE " . $fn[$i] . " LIKE '%" . $_POST['search']['value'] . "%'";
						$firstnos += 1;
					} else if ($firstnos == 2) {
						if(!$searchcol){
							$Condition = $Condition . " OR " . $fn[$i] . " LIKE '%" . $_POST['search']['value'] . "%'";
						}else	{
							$Condition = $Condition . " AND " . $fn[$i] . " LIKE '%" . $_POST['search']['value'] . "%'";
						}
						$firstnos += 1;
					} else {
						$Condition = $Condition . " OR " . $fn[$i] . " LIKE '%" . $_POST['search']['value'] . "%'";
						$firstnos += 1;
					}
				} //for
			} //if
		}
	*/
		if ($orderb != "") {
			$Condition = $Condition . " " . $orderb;
		} else {
			$Condition = $Condition;
		}

		//echo "{$countcolumns},{$Condition}";
		//exit;

		//echo "{$draw}, {$countcolumns}, {$columnsdata}, {$colname}, {$colsch}, {$colord}, {$colschtxt} , {$colschtype}, {$ordercol}, {$ordertype}, {$start}, {$length}, {$page}, {$searchtxt}, {$searchtype}, {$tbn1}, {$udb1}, {$txtsql}";

		//exit;


		$page = 1;
		if (!empty($_POST['page'])) $page = (int) $_POST['page'];

		$recordsPerPage = 10;
		if (!empty($_POST['length'])) $recordsPerPage = (int) $_POST['length'];

		$start = 0;
		if (!empty($_POST['start'])) $start = (int) $_POST['start'];

		$noOfRecords = 0;

		//$sql = "SELECT * FROM " . $udb1 . "." . $tbn1;

		$sqldbtball = $udb1 . "." . $tbn1 . ".*"; //wpddb.ledrpt_tb.*
		$sqldbtb = $udb1 . "." . $tbn1;

		//echo "{$sqldbtball}"; exit;

		$params[":rowstart"] = ($start + 1);
		if ((int) $_POST['length'] == -1) {

			$sql = "SELECT COUNT(*) As ct FROM " . $sqldbtb ;
			$command = $conn->createCommand($sql);
			$rows = $command->queryAll();
			$recordsPerPage =  $rows[0]['ct'];
			$params[":rowend"] = ($start + $recordsPerPage);

		} else {
			$params[":rowend"] = ($start + $recordsPerPage);
		}


		$sql = "SET @rownum := 0;";
		$command = $conn->createCommand($sql)->execute();

		$sql = "
			 SELECT * FROM (SELECT @rownum := @rownum+1 AS NUMBER, " . $sqldbtball . " FROM  " . $sqldbtb . " " . $Condition . " ) AS TBL
				WHERE NUMBER BETWEEN :rowstart AND :rowend ;
			";


		$command = $conn->createCommand($sql);
		foreach ($params as $key => $value) {
			$command->bindValue($key, $value);
		}

		$rows = $command->queryAll();

		$arr = array();
		foreach ($rows as $dataitem) {
			$arr[] = array_values($dataitem);
		}

		$jsondata = json_encode($arr);

		unset($params[":rowstart"]);
		unset($params[":rowend"]);

		$sql = "SELECT COUNT(*) As ct FROM " . $sqldbtb . " " . $Condition;

		$command = $conn->createCommand($sql);

		foreach ($params as $key => $value) {
			$command->bindValue($key, $value);
		}
		$rows = $command->queryAll();
		$noOfRecords =  $rows[0]['ct'];

		\Yii::$app->response->data =  '{"recordsTotal":' . $noOfRecords . ',"recordsFiltered":' . $noOfRecords . ',"data":' . $jsondata . '}';

		//*********************************************************

		if (!Yii::$app->user->isGuest) {
			if (isset(Yii::$app->user->username)) {
			} else { //if

			}
		} else { //if

		}
	} //function 

	public function actionError()
	{
		if ($error = Yii::$app->errorHandler->error) {
			if (Yii::$app->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
}
