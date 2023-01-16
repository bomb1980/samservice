<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

use \app\models\LineAction;
use \app\models\CommonAction;

use app\components\CustomWebUser;
use app\components\UserController;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;



class LineController extends Controller
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


		//*********************************************************
		return $this->render('index');
	}

	public function actionList()
	{
		$cwebuser = new CustomWebUser();
		$user_id = Yii::$app->user->getId();

		$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['cms'];

		$data = \app\models\lkup_user::getUserPermission($user_id, $app_id);
		$user_role = $data[0]["user_role"];

		return $this->render('listdata', array("user_role" => $user_role, "user_id" => $user_id,));
	}



	public function actionListmessage()
	{
		$page = 1;
		if (!empty($_POST['page'])) $page = (int) $_POST['page'];

		$recordsPerPage = 10;
		if (!empty($_POST['length'])) $recordsPerPage = (int) $_POST['length'];

		$start = 0;
		if (!empty($_POST['start'])) $start = (int) $_POST['start'];

		$search = '';
		if (!empty($_POST['search'])) $search = $_POST['search'];

		$type_id = null;
		if (!empty($_POST['type_id'])) $type_id = $_POST['type_id'];

		$noOfRecords = 0;


		$model = new LineAction;
		$model->search = $search;
		$model->page = $page;
		$model->recordsPerPage = $recordsPerPage;
		$model->start = $start;
		$model->noOfRecords = $noOfRecords;



		$model->pAdmin = true;
		$model->Listmessage();
	}

	public function actionListselect()
	{
		$page = 1;
		if (!empty($_POST['page'])) $page = (int) $_POST['page'];

		$recordsPerPage = 10;
		if (!empty($_POST['length'])) $recordsPerPage = (int) $_POST['length'];

		$start = 0;
		if (!empty($_POST['start'])) $start = (int) $_POST['start'];

		$search = '';
		if (!empty($_POST['search'])) $search = $_POST['search'];

		$type_id = null;
		if (!empty($_POST['type_id'])) $type_id = $_POST['type_id'];

		$noOfRecords = 0;


		$model = new RichmenuAction;
		$model->search = $search;
		$model->page = $page;
		$model->recordsPerPage = $recordsPerPage;
		$model->start = $start;
		$model->noOfRecords = $noOfRecords;



		$model->pAdmin = true;
		$model->Listselect();
	}

	public function actionCreate()
	{
		$this->render('create');
	}

	public function actionInsurer()
	{

		$cwebuser = new CustomWebUser();
		$user_id = Yii::$app->user->getId();
		$ssobranch_code = $cwebuser->getInfo("ssobranch_code");

		$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['cms'];

		$data_role = \app\models\lkup_user::getUserPermission($user_id, $app_id, $ssobranch_code);
		$user_role = $data_role[0]["user_role"];

		$isAddmin = \app\models\lkup_data::chkAddPermission($user_role, $app_id);

		if ($isAddmin) {
			return $this->render('insurer', array('data' => null, "user_role" => $user_role, "user_id" => $user_id,));
		}
	}

	public function actionMessage()
	{

		if (!empty($_GET["id"])) {
			$id = $_GET["id"];

			if (is_numeric($id)) {

				$cwebuser = new CustomWebUser();
				$user_id = Yii::$app->user->getId();
				$ssobranch_code = $cwebuser->getInfo("ssobranch_code");

				$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['cms'];

				$data_role = \app\models\lkup_user::getUserPermission($user_id, $app_id, $ssobranch_code);
				$user_role = $data_role[0]["user_role"];

				$isAddmin = \app\models\lkup_data::chkAddPermission($user_role, $app_id);

				if ($isAddmin) {
					$conn = Yii::$app->db;
					$sql = "SELECT * FROM trn_line_message WHERE id=:id ";
					$command = $conn->createCommand($sql);
					$command->bindValue(":id", $id);
					$rows = $command->queryAll();

					return $this->render('message', array('data' => $rows, "user_role" => $user_role, "user_id" => $user_id, 'id' => $id));
				} else {
					if (Yii::$app->request->urlReferrer) {
						$redirect = Yii::$app->request->urlReferrer;
					} else {
						$redirect = Yii::$app->createUrl('');
					}
?>
					<script>
						alert("เจ้าหน้าที่ไม่สามารถแก้ไขข้อมูลได้");
						window.location.href = "<?= $redirect ?>";
					</script>
				<?php
					exit;
					//return $this->redirect(Yii::$app->request->urlReferrer);
				}
			}
		} else {
			$cwebuser = new CustomWebUser();
			$user_id = Yii::$app->user->getId();
			$ssobranch_code = $cwebuser->getInfo("ssobranch_code");

			$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['cms'];

			$data_role = \app\models\lkup_user::getUserPermission($user_id, $app_id, $ssobranch_code);
			$user_role = $data_role[0]["user_role"];

			$isAddmin = \app\models\lkup_data::chkAddPermission($user_role, $app_id);

			if ($isAddmin) {
				return $this->render('message', array('data' => null, "user_role" => $user_role, "user_id" => $user_id,));
			}
		}
	}

	public function actionListoverduenotify()
	{
		$page = 1;
		if (!empty($_POST['page'])) $page = (int) $_POST['page'];

		$recordsPerPage = 10;
		if (!empty($_POST['length'])) $recordsPerPage = (int) $_POST['length'];

		$start = 0;
		if (!empty($_POST['start'])) $start = (int) $_POST['start'];

		$search = '';
		if (!empty($_POST['search'])) $search = $_POST['search'];

		$type_id = null;
		if (!empty($_POST['type_id'])) $type_id = $_POST['type_id'];

		$noOfRecords = 0;


		$model = new LineAction();
		$model->search = $search;
		$model->page = $page;
		$model->recordsPerPage = $recordsPerPage;
		$model->start = $start;
		$model->noOfRecords = $noOfRecords;



		$model->pAdmin = true;
		$model->Listoverduenotify();
	}


	public function actionOverduenotify()
	{

		if (!empty($_GET["id"])) {
			$id = $_GET["id"];

			if (is_numeric($id)) {

				$cwebuser = new CustomWebUser();
				$user_id = Yii::$app->user->getId();
				$ssobranch_code = $cwebuser->getInfo("ssobranch_code");

				$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['cms'];

				$data_role = \app\models\lkup_user::getUserPermission($user_id, $app_id, $ssobranch_code);
				$user_role = $data_role[0]["user_role"];

				$isAddmin = \app\models\lkup_data::chkAddPermission($user_role, $app_id);

				if ($isAddmin) {
					$conn = Yii::$app->db;
					$sql = "SELECT * FROM trn_line_message WHERE id=:id ";
					$command = $conn->createCommand($sql);
					$command->bindValue(":id", $id);
					$rows = $command->queryAll();

					return $this->render('overduenotify', array('data' => $rows, "user_role" => $user_role, "user_id" => $user_id, 'id' => $id));
				} else {
					if (Yii::$app->request->urlReferrer) {
						$redirect = Yii::$app->request->urlReferrer;
					} else {
						$redirect = Yii::$app->createUrl('');
					}
				?>
					<script>
						alert("เจ้าหน้าที่ไม่สามารถแก้ไขข้อมูลได้");
						window.location.href = "<?= $redirect ?>";
					</script>
				<?php
					exit;
					//return $this->redirect(Yii::$app->request->urlReferrer);
				}
			}
		} else {
			$cwebuser = new CustomWebUser();
			$user_id = Yii::$app->user->getId();
			$ssobranch_code = $cwebuser->getInfo("ssobranch_code");

			$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['cms'];

			$data_role = \app\models\lkup_user::getUserPermission($user_id, $app_id, $ssobranch_code);
			$user_role = $data_role[0]["user_role"];

			$isAddmin = \app\models\lkup_data::chkAddPermission($user_role, $app_id);

			if ($isAddmin) {
				return $this->render('overduenotify', array('data' => null, "user_role" => $user_role, "user_id" => $user_id,));
			}
		}
	}

	public function actionSaveoverduenotify()
	{

		if (Yii::$app->request->isPost) {

			set_time_limit(0);
			ini_set('memory_limit', '2048M');

			$line_message = $_POST['line_message'];

			// Allowed mime types
			$csvMimes = array(
				'text/x-comma-separated-values',
				'text/comma-separated-values',
				'application/octet-stream',
				'application/x-csv',
				'text/x-csv',
				'text/csv',
				'application/csv',
			);

			$csvMimes = array(
				'text/x-comma-separated-values',
				'text/comma-separated-values',
				'application/octet-stream',
				'application/vnd.ms-excel',
				'application/x-csv',
				'text/x-csv',
				'text/csv',
				'application/csv',
				'application/excel',
				'application/vnd.msexcel',
				'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
			);

			$tmpfirstrow = "";
			$arrId_card = array();
			$arrID_card_tel = array();
			if (!empty($_FILES['uploadBtn']['name']) && in_array($_FILES['uploadBtn']['type'], $csvMimes)) {

				$arr_file = explode('.', $_FILES['uploadBtn']['name']);
				$extension = end($arr_file);

				if ('csv' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
				} else {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				}

				$spreadsheet = $reader->load($_FILES['uploadBtn']['tmp_name']);
				$sheetData = $spreadsheet->getActiveSheet()->toArray();

				if (!empty($sheetData)) {
					$tmpfirstrow = $sheetData[0][0];
					for ($i = 1; $i < count($sheetData); $i++) {
						$id_card = $sheetData[$i][0];
						$arrId_card[] = $id_card;
						$arrID_card_tel[] = ["id_card" => $sheetData[$i][0], "telno" => $sheetData[$i][1]];
					}
				}

				/*
				// If the file is uploaded
				if (is_uploaded_file($_FILES['uploadBtn']['tmp_name'])) {

					// Open uploaded CSV file with read-only mode
					$csvFile = fopen($_FILES['uploadBtn']['tmp_name'], 'r');

					// Skip the first line
					fgetcsv($csvFile);

					// Parse data from CSV file line by line
					while (($line = fgetcsv($csvFile)) !== FALSE) {
						// Get row data
						$name   = $line[0];
						echo $name;
					}
				}*/
			}


			$csvMimes = array(
				'text/plain'
			);
			if (!empty($_FILES['uploadBtn']['name']) && in_array($_FILES['uploadBtn']['type'], $csvMimes)) {
				$fp = fopen($_FILES['uploadBtn']['tmp_name'], 'rb');
				$minrec = 0;
				while (($line = fgets($fp)) !== false) {
					$minrec++;
					if ($minrec == 1) {
						//echo "$line<br>"; ไม่เอา บรรทัดแรก
						$tmpfirstrow = $line;
					} else {
						$arrId_card[] = substr($line, 0, 13);
					}
					//echo "$line<br>";
				}
			}

			if (count($arrId_card) == 0) {
				die('error:ไม่พบผู้ประกันตนตามรายชื่อที่นำเข้า อาจเกิดจากผู้ประกันตนยังไม่มีการล็อกอินเข้าใช้งานระบบไลน์');
				return;
			}
			$strIns = "'" . implode("','", $arrId_card) . "'";

			$sql = "
			SELECT su_idcard, li_line_id
				FROM
				`ssoline`.`mas_sso_user`
				INNER JOIN `ssoline`.`tran_line_id`
					ON (
					`mas_sso_user`.`su_id` = `tran_line_id`.`li_user_id`
					)
					WHERE su_idcard IN(" . $strIns . ") GROUP BY li_line_id;
			";

			$conn = Yii::$app->db;
			$command = $conn->createCommand($sql);
			$rows = $command->queryAll();

			$typenoti = $_POST['typenoti'];

			if (count($rows) != 0) {

				// Your array
				$list = $arrId_card;
				$list_cardtel = $arrID_card_tel;

				// Initilize what to delete
				$delete_val = $rows;

				// Search for the array key and unset   
				foreach ($delete_val as $key) {
					$keyToDelete = array_search($key['su_idcard'], $list);
					unset($list[$keyToDelete]);

					$keyX = array_search($key['su_idcard'], array_column($arrID_card_tel, 'id_card'));
					unset($list_cardtel[$keyX]);
				}

				// Creates New Spreadsheet 
				$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

				$spreadsheet->getDefaultStyle()->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);

				// Retrieve the current active worksheet 
				$sheet = $spreadsheet->getActiveSheet();

				$sheetname = pathinfo($_FILES['uploadBtn']['name'], PATHINFO_FILENAME); 
				$sheet->setTitle($sheetname);

				$column_header = [$tmpfirstrow, ""];
				$j = 1;
				foreach ($column_header as $x_value) {
					$sheet->setCellValueByColumnAndRow($j, 1, $x_value);
					$j = $j + 1;
				}

				$sheet->getStyle("A")
					->getNumberFormat()
					->setFormatCode("#");

				foreach (range('A', 'B') as $col) {
					$sheet->getColumnDimension($col)->setAutoSize(true);
				}
				//$sheet->getColumnDimension('A')->setAutoSize(true);

				$list_cardtel = array_values($list_cardtel);
				for ($i = 0; $i < count($list_cardtel); $i++) {

					//set value for indi cell
					$row = $list_cardtel[$i];

					$j = 1;

					foreach ($row as $x => $x_value) {
						$sheet->setCellValueByColumnAndRow($j, $i + 2, $x_value);
						$j = $j + 1;
					}
				}

				// Write an .xlsx file  
				$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

				// Save .xlsx file to the files directory 
				$writer->save('/usr/share/nginx/download/'.$_FILES['uploadBtn']['name']);

				$li_line_id = array();
				foreach ($rows as $dataitem) {
					$li_line_id[] = [$dataitem['li_line_id']];
				}

				//$this->DownloadText($li_line_id);
				//exit;

				$sql = "
				insert into trn_m39notifications (
					`notitext`,
					`notitype`,
					`importno`,
					`exportno`
				  )
				  values
					(
					  :notitext,
					  :notitype,
					  :importno,
					  :exportno
					);
				";
				$command = $conn->createCommand($sql);
				$command->bindValue(":notitext", $line_message);
				$command->bindValue(":notitype", $typenoti);
				$command->bindValue(":importno", count($arrId_card));
				$command->bindValue(":exportno", count($rows));
				$command->execute();

				$log_page = basename(Yii::$app->request->referrer);

				$log_description = 'นำเข้ารายการแจ้งเตือน ม.39 <br/>';
				$log_description .= 'ข้อความแจ้งเตือนที่บันทึก : ' . $line_message . '<br/>';
				$log_description .= 'จำนวนที่นำเข้า : ' . count($arrId_card) . '<br/>';
				$log_description .= 'จำนวนที่ส่งออก : ' . count($rows) . '<br/>';

				$cwebuser = new \app\components\CustomWebUser();
				$createby = !Yii::$app->user->isGuest ? $cwebuser->getInfo('uid') : 0;
				CommonAction::AddEventLog($createby, "Insert", $log_page, $log_description);

				$this->DownloadText($li_line_id);
				//$download_title = array('id', 'name');
				//$this->DownloadCSV($download_title, $rows);

			} else {
				// Set http header error
				//header('HTTP/1.0 500 Internal Server Error');
				// Return error message

				$sql = "
				insert into trn_m39notifications (
					`notitext`,
					`notitype`,
					`importno`,
					`exportno`
				  )
				  values
					(
					  :notitext,
					  :notitype,
					  :importno,
					  :exportno
					);
				";
				$command = $conn->createCommand($sql);
				$command->bindValue(":notitext", $line_message);
				$command->bindValue(":notitype", $typenoti);
				$command->bindValue(":importno", count($arrId_card));
				$command->bindValue(":exportno", 0);
				$command->execute();

				$log_page = basename(Yii::$app->request->referrer);

				$log_description = 'นำเข้ารายการแจ้งเตือน ม.39 <br/>';
				$log_description .= 'ข้อความแจ้งเตือนที่บันทึก : ' . $line_message . '<br/>';
				$log_description .= 'จำนวนที่นำเข้า : ' . count($arrId_card) . '<br/>';
				$log_description .= 'จำนวนที่ส่งออก : ' . 0 . '<br/>';

				$cwebuser = new \app\components\CustomWebUser();
				$createby = !Yii::$app->user->isGuest ? $cwebuser->getInfo('uid') : 0;
				CommonAction::AddEventLog($createby, "Insert", $log_page, $log_description);

				die('error:ไม่พบผู้ประกันตนตามรายชื่อที่นำเข้า อาจเกิดจากผู้ประกันตนยังไม่มีการล็อกอินเข้าใช้งานระบบไลน์');

				return;
			}

			//var_dump($_FILES["uploadBtn"]["type"]);

			//echo is_uploaded_file($_FILES['uploadBtn']['tmp_name']);
		}
	}

	public function actionPushnotify()
	{
		if (Yii::$app->request->isPost) {
			if (!empty($_REQUEST["id"])) {
				$id = $_REQUEST['id'];

				$conn = Yii::$app->db;

				$sql = "
				SELECT * FROM trn_notifications WHERE id=:id
				  ";
				$rchk = $conn->createCommand($sql)->bindValue('id', $id)->queryAll();
				if (count($rchk) == 0) {
					echo json_encode(array('status' => 'error', 'msg' => 'ไม่พบข้อมูลข้อความที่จะส่งเข้ากล่องข้อความผู้ประกันตน',));
					return;
				} else {
					$push_status = $rchk[0]['push_status'];
					if ($push_status == 1) {
						echo json_encode(array('status' => 'error', 'msg' => 'ข้อความนี้ส่งเข้ากล่องข้อความผู้ประกันตนก่อนหน้าแล้ว',));
						return;
					} else {
						$section_type = $rchk[0]['section_type'];
						$ssobranch = $rchk[0]['ssobranch'];

						$sql = "
						SELECT id_sso, '' AS newf
							FROM
						tran_ssoid
							WHERE section_id IN(" . $section_type . ") AND ssobranch_code IN(" . $ssobranch . ");
						";

						$command = $conn->createCommand($sql);
						$rows = $command->queryAll();
						if (count($rows) != 0) {

							foreach ($rows as $key => $item) {

								$res = $this->Pushnotify($item['id_sso'], $id);

								$item["newf"] = $res;
								$rows[$key] = $item;
							}

							foreach ($rows as $dataitem) {
								//id_sso
								//$res = $this->Pushnotify($dataitem['id_sso'], $id);

							}

							$createby = !Yii::$app->user->isGuest ? Yii::$app->user->getId() : 0;

							$sql = "UPDATE trn_notifications SET push_status=1, update_by=$createby, update_date=NOW() WHERE id=:id";
							$command = $conn->createCommand($sql);
							$command->bindValue(":id", $id);
							$command->execute();

							echo json_encode(array('status' => 'success', 'msg' => '',));
						}
						//var_dump($rows);
					}
				}
			}
		}
	}

	public function Pushnotify($user_id, $noti_id)
	{

		$createby = !Yii::$app->user->isGuest ? Yii::$app->user->getId() : 0;

		$conn = Yii::$app->db;
		$transaction = $conn->beginTransaction();
		try {
			//$createby = !Yii::$app->user->isGuest?Yii::$app->user->id:0;
			//$ssobranch_code = 1051;	

			$sql = "INSERT INTO notifications (user_id, noti_id, create_by, create_date) 
			VALUES(:user_id, :noti_id, $createby, now())";
			$command = $conn->createCommand($sql);
			$command->bindValue(":user_id", $user_id);
			$command->bindValue(":noti_id", $noti_id);
			$command->execute();

			$transaction->commit();

			return true;
		} catch (Exception $e) {
			$transaction->rollBack();
			return false;
			//echo $e->getMessage();
			//http_response_code(404);
		}
	}

	public function actionNotifyapi()
	{

		if (!empty($_GET["id"])) {
			$id = $_GET["id"];

			if (is_numeric($id)) {

				$cwebuser = new CustomWebUser();
				$user_id = Yii::$app->user->getId();
				$ssobranch_code = $cwebuser->getInfo("ssobranch_code");

				$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['cms'];

				$data_role = \app\models\lkup_user::getUserPermission($user_id, $app_id, $ssobranch_code);
				$user_role = $data_role[0]["user_role"];

				$isAddmin = \app\models\lkup_data::chkAddPermission($user_role, $app_id);

				if ($isAddmin) {
					$conn = Yii::$app->db;
					$sql = "SELECT * FROM trn_notifications WHERE id=:id ";
					$command = $conn->createCommand($sql);
					$command->bindValue(":id", $id);
					$rows = $command->queryAll();

					return $this->render('notifyapi', array('data' => $rows, "user_role" => $user_role, "user_id" => $user_id, 'id' => $id));
				} else {
					if (Yii::$app->request->urlReferrer) {
						$redirect = Yii::$app->request->urlReferrer;
					} else {
						$redirect = Yii::$app->createUrl('');
					}
				?>
					<script>
						alert("เจ้าหน้าที่ไม่สามารถแก้ไขข้อมูลได้");
						window.location.href = "<?= $redirect ?>";
					</script>
				<?php
					exit;
					//return $this->redirect(Yii::$app->request->urlReferrer);
				}
			}
		} else {
			$cwebuser = new CustomWebUser();
			$user_id = Yii::$app->user->getId();
			$ssobranch_code = $cwebuser->getInfo("ssobranch_code");

			$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['cms'];

			$data_role = \app\models\lkup_user::getUserPermission($user_id, $app_id, $ssobranch_code);
			$user_role = $data_role[0]["user_role"];

			$isAddmin = \app\models\lkup_data::chkAddPermission($user_role, $app_id);

			if ($isAddmin) {
				return $this->render('notifyapi', array('data' => null, "user_role" => $user_role, "user_id" => $user_id,));
			}
		}
	}


	public function actionPdpa()
	{

		if (!empty($_GET["id"])) {
			$id = $_GET["id"];

			if (is_numeric($id)) {

				$cwebuser = new CustomWebUser();
				$user_id = Yii::$app->user->getId();
				$ssobranch_code = $cwebuser->getInfo("ssobranch_code");

				$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['cms'];

				$data_role = \app\models\lkup_user::getUserPermission($user_id, $app_id, $ssobranch_code);
				$user_role = $data_role[0]["user_role"];

				$isAddmin = \app\models\lkup_data::chkAddPermission($user_role, $app_id);

				if ($isAddmin) {
					$conn = Yii::$app->db;
					$sql = "SELECT * FROM mas_pdpa WHERE id=:id ";
					$command = $conn->createCommand($sql);
					$command->bindValue(":id", $id);
					$rows = $command->queryAll();

					return $this->render('pdpa', array('data' => $rows, "user_role" => $user_role, "user_id" => $user_id, 'id' => $id));
				} else {
					if (Yii::$app->request->urlReferrer) {
						$redirect = Yii::$app->request->urlReferrer;
					} else {
						$redirect = Yii::$app->createUrl('');
					}
				?>
					<script>
						alert("เจ้าหน้าที่ไม่สามารถแก้ไขข้อมูลได้");
						window.location.href = "<?= $redirect ?>";
					</script>
				<?php
					exit;
					//return $this->redirect(Yii::$app->request->urlReferrer);
				}
			}
		} else {
			$cwebuser = new CustomWebUser();
			$user_id = Yii::$app->user->getId();
			$ssobranch_code = $cwebuser->getInfo("ssobranch_code");

			$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['cms'];

			$data_role = \app\models\lkup_user::getUserPermission($user_id, $app_id, $ssobranch_code);
			$user_role = $data_role[0]["user_role"];

			$isAddmin = \app\models\lkup_data::chkAddPermission($user_role, $app_id);

			if ($isAddmin) {
				return $this->render('pdpa', array('data' => null, "user_role" => $user_role, "user_id" => $user_id,));
			}
		}
	}

	public function actionSavepdpa()
	{
		if (Yii::$app->request->isPost) {

			$content = $_POST['content'];

			$model = new LineAction();
			$model->body = $content;
			if ($model->savepdpa()) {

				$log_page = basename(Yii::$app->request->referrer);

				$log_description = 'เพิ่มข้อความข้อตกลง PDPA <br/>';
				$log_description .= 'ข้อความที่บันทึก : ' . $content . '<br/>';

				$cwebuser = new \app\components\CustomWebUser();
				$createby = !Yii::$app->user->isGuest ? $cwebuser->getInfo('uid') : 0;
				CommonAction::AddEventLog($createby, "Insert", $log_page, $log_description);

				echo json_encode(array('status' => 'success', 'msg' => Yii::$app->session['success_savepdpa'],));
				Yii::$app->session->remove('success_savepdpa');
				Yii::$app->session->remove('success_sevepdpa_id');
			} else {
				echo json_encode(array('status' => 'error', 'msg' => Yii::$app->session['errmsg_savepdpa'],));
				Yii::$app->session->remove('errmsg_savepdpa');
			}
		}
	}

	public function actionEditpdpa()
	{
		if (Yii::$app->request->isPost) {

			$content = $_POST['content'];
			$pdpa_type = $_POST['pdpa_type'];
			$id = $_POST['id'];

			$model = new LineAction();
			$model->id =   $id;
			$model->body = $content;
			if ($pdpa_type == "edit") {
				if ($model->editpdpa()) {

					$log_page = basename(Yii::$app->request->referrer);

					$log_description = 'แก้ไขข้อความข้อตกลง PDPA <br/>';
					$log_description .= "ID " . $id . " <br/>";
					$log_description .= 'ข้อความที่บันทึก : ' . $content . '<br/>';

					$cwebuser = new \app\components\CustomWebUser();
					$createby = !Yii::$app->user->isGuest ? $cwebuser->getInfo('uid') : 0;
					CommonAction::AddEventLog($createby, "Update", $log_page, $log_description);

					echo json_encode(array('status' => 'success', 'msg' => Yii::$app->session['success_editpdpa'],));
					Yii::$app->session->remove('success_editpdpa');
					Yii::$app->session->remove('success_editpdpa_id');
				} else {
					echo json_encode(array('status' => 'error', 'msg' => Yii::$app->session['errmsg_editpdpa'],));
					Yii::$app->session->remove('errmsg_editpdpa');
				}
			} elseif ($pdpa_type == "newver") {
				if ($model->savepdpa()) {

					$log_page = basename(Yii::$app->request->referrer);

					$log_description = 'เพิ่มข้อความข้อตกลง PDPA จากเวอร์ชั่นเก่า <br/>';
					$log_description .= "ID เก่า " . $id . " <br/>";
					$log_description .= 'ข้อความที่บันทึก : ' . $content . '<br/>';

					$cwebuser = new \app\components\CustomWebUser();
					$createby = !Yii::$app->user->isGuest ? $cwebuser->getInfo('uid') : 0;
					CommonAction::AddEventLog($createby, "Insert", $log_page, $log_description);

					echo json_encode(array('status' => 'success', 'msg' => Yii::$app->session['success_savepdpa'],));
					Yii::$app->session->remove('success_savepdpa');
					Yii::$app->session->remove('success_sevepdpa_id');
				} else {
					echo json_encode(array('status' => 'error', 'msg' => Yii::$app->session['errmsg_savepdpa'],));
					Yii::$app->session->remove('errmsg_savepdpa');
				}
			} else {
			}
		}
	}

	public function actionEditstatuspdpa()
	{
		if (Yii::$app->request->isPost) {
			$id = $_POST['id'];
			$status = $_POST['status'];
			if (is_null($id) || is_null($status)) {
				exit;
			}

			$model = new LineAction;
			$model->id = $id;
			$model->status = $status;

			if ($model->Edit_pdpastatus()) {

				$log_page = basename(Yii::$app->request->referrer);

				$log_description = 'แก้ไขสถานะ PDPA <br/>';
				$log_description .= 'ID : ' . $_POST['id'] . '<br/>';
				$log_description .= 'จากสถานะ : ' . $_POST['old_status'] . ' <br/>';
				$log_description .= 'เป็น : ' . $status . ' <br/>';

				$cwebuser = new \app\components\CustomWebUser();
				$createby = !Yii::$app->user->isGuest ? $cwebuser->getInfo('uid') : 0;
				CommonAction::AddEventLog($createby, "Update", $log_page, $log_description);
				echo json_encode(array('msg' => 'success'));
			} else {
				$msg = Yii::app()->session['errmsg_pdpastatus'];
				echo json_encode(array('msg' => $msg));
				Yii::app()->session->remove('errmsg_pdpastatus');
			}
		}
	}

	public function actionDelete_pdpa()
	{
		if (Yii::$app->request->isPost) {
			$content_id = $_POST['content_id'];
			if (is_null($content_id)) {
				exit;
			}

			$cwebuser = new CustomWebUser();
			$user_id = Yii::$app->user->getId();
			$ssobranch_code = $cwebuser->getInfo("ssobranch_code");
			$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['cms'];

			$data = \app\models\lkup_user::getUserPermission($user_id, $app_id, $ssobranch_code);
			$user_role = $data[0]["user_role"];


			if (\app\models\lkup_data::chkAddPermission($user_role, $app_id)) {
			} else {
				echo json_encode(array('msg' => "เจ้าหน้าที่ไม่สามารถลบข้อมูลได้"));
				exit;
			}

			$model = new LineAction;
			$model->id = $content_id;

			if ($model->Delete_pdpa()) {

				$log_page = basename(Yii::$app->request->referrer);

				$log_description = 'ลบ PDPA <br/>';
				$log_description .= 'ID : ' . $content_id . ' <br/>';

				$cwebuser = new \app\components\CustomWebUser();
				$createby = !Yii::$app->user->isGuest ? $cwebuser->getInfo('uid') : 0;
				\app\models\CommonAction::AddEventLog($createby, "Delete", $log_page, $log_description);

				echo json_encode(array('msg' => 'success'));
			} else {

				$log_page = basename(Yii::$app->request->referrer);

				$log_description = 'ลบ PDPA <br/>';
				$log_description .= 'ID : ' . $content_id  . ' <br/>';
				$log_description .= "ไม่สำเร็จสถานะ " . Yii::$app->session['errmsg_pdpa'];

				$cwebuser = new \app\components\CustomWebUser();
				$createby = !Yii::$app->user->isGuest ? $cwebuser->getInfo('uid') : 0;
				\app\models\CommonAction::AddEventLog($createby, "Delete", $log_page, $log_description);

				$msg = Yii::$app->session['errmsg_pdpa'];
				echo json_encode(array('msg' => $msg));
				Yii::$app->session->remove('errmsg_pdpa');
			}
		}
	}

	public function actionListpdpa()
	{
		$cwebuser = new CustomWebUser();
		$user_id = Yii::$app->user->getId();
		$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['cms'];

		$data = \app\models\lkup_user::getUserPermission($user_id, $app_id);
		$user_role = $data[0]["user_role"];
		Yii::$app->controller->layout = "main";
		return $this->render('listpdpa', array("user_role" => $user_role, "user_id" => $user_id,));
	}

	public function actionListbackpdpa()
	{
		$page = 1;
		if (!empty($_POST['page'])) $page = (int) $_POST['page'];

		$recordsPerPage = 10;
		if (!empty($_POST['length'])) $recordsPerPage = (int) $_POST['length'];

		$start = 0;
		if (!empty($_POST['start'])) $start = (int) $_POST['start'];

		$search = '';
		if (!empty($_POST['search'])) $search = $_POST['search'];

		$type_id = null;
		if (!empty($_POST['type_id'])) $type_id = $_POST['type_id'];

		$noOfRecords = 0;

		$model = new LineAction;
		$model->search = $search;
		$model->page = $page;
		$model->recordsPerPage = $recordsPerPage;
		$model->start = $start;
		$model->noOfRecords = $noOfRecords;

		$model->pAdmin = true;
		$model->Listpdpa();
	}

	public function actionListnotifyapi()
	{
		$cwebuser = new CustomWebUser();
		$user_id = Yii::$app->user->getId();
		$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['cms'];

		$data = \app\models\lkup_user::getUserPermission($user_id, $app_id);
		$user_role = $data[0]["user_role"];
		Yii::$app->controller->layout = "main";
		return $this->render('listnotifyapi', array("user_role" => $user_role, "user_id" => $user_id,));
	}

	public function actionListbacknotifyapi()
	{
		$page = 1;
		if (!empty($_POST['page'])) $page = (int) $_POST['page'];

		$recordsPerPage = 10;
		if (!empty($_POST['length'])) $recordsPerPage = (int) $_POST['length'];

		$start = 0;
		if (!empty($_POST['start'])) $start = (int) $_POST['start'];

		$search = '';
		if (!empty($_POST['search'])) $search = $_POST['search'];

		$type_id = null;
		if (!empty($_POST['type_id'])) $type_id = $_POST['type_id'];

		$noOfRecords = 0;

		$model = new LineAction;
		$model->search = $search;
		$model->page = $page;
		$model->recordsPerPage = $recordsPerPage;
		$model->start = $start;
		$model->noOfRecords = $noOfRecords;

		$model->pAdmin = true;
		$model->Listnotifyapi();
	}


	function isJSON($string)
	{
		return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
	}


	public function actionBroadcastmessage()
	{
		//if (Yii::$app->request->isPost) {

		$content_id = $_REQUEST['id'];

		if (is_null($content_id)) {
			exit;
		}

		$sql = "SELECT * FROM trn_line_message WHERE id=:id ";
		$conn = Yii::$app->db;
		$rows = $conn->createCommand($sql)->bindValue('id', $content_id)->queryAll();
		if (count($rows) != 0) {
			$items = (array) $rows[0];
			$sms_text = $items['message'];
			$this->broadcastmessage($sms_text);
		}
		//}
	}

	private function broadcastmessage($text)
	{
		$model = new LineAction();
		$string = trim(preg_replace('/\s\s+/', ' ', $text));
		$model->sms_text = $string;

		if ($model->broadcastmessage()) {

			$log_page = basename('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
			$log_page = basename(Yii::$app->request->urlReferrer);

			$log_description = 'ส่งข้อความถึงทุกคนใน LINE <br/>';
			$log_description .= 'ข้อความ : ' . $text . ' <br/>';

			CommonAction::AddEventLog(Yii::$app->user->getState("sub"), "Insert", $log_page, $log_description);

			echo json_encode(array('msg' => 'success'));
			return true;
		} else {
			$msg = Yii::$app->session['error_broadcastmessage'];
			echo json_encode(array('msg' => $msg));
			Yii::$app->session->remove('error_broadcastmessage');
			return false;
		}
	}

	public function actionSetmessage()
	{

		if (Yii::$app->request->isPost) {

			$line_subject = $_POST['line_subject'];
			$line_message = $_POST['line_message'];
			$section = $_POST['section'];
			$perselect = $_POST['perselect'];

			if ($perselect == "") {
				$perselect = null;
			}

			$model = new LineAction;
			$model->section = $section;
			$model->perselect = $perselect;
			$model->subject = $line_subject;
			$model->body = $line_message;

			if ($model->save_Setmessage()) {

				$log_page = basename(Yii::$app->request->urlReferrer);

				$log_description = 'เพิ่มสิทธิ์ข้อความสำหรับส่งให้สมาชิกแบบทั้งหมด <br/>';
				$log_description .= 'หัวข้อ : ' . $_POST['line_subject'] . '<br/>';
				$log_description .= 'ข้อความที่ส่ง : ' . $_POST['line_message'] . '<br/>';
				$log_description .= 'ประกันสังคมมาตรา : ' . strip_tags($_POST['section']) . ' <br/>';
				$log_description .= 'หน่วยงาน : ' . strip_tags($_POST['perselect']) . ' <br/>';

				CommonAction::AddEventLog(Yii::$app->user->getState("sub"), "Insert", $log_page, $log_description);

				echo CJSON::encode(array('status' => 'success', 'msg' => Yii::$app->session['success_Setmessage'],));
				Yii::$app->session->remove('success_Setmessage');
				Yii::$app->session->remove('success_Setmessage_id');
			} else {
				echo CJSON::encode(array('status' => 'error', 'msg' => Yii::$app->session['errmsg_Setmessage'],));
				Yii::$app->session->remove('errmsg_Setmessage');
			}
		}
	}

	public function actionEditmessage()
	{

		if (Yii::$app->request->isPost) {

			$id = $_POST['id'];
			$line_subject = $_POST['line_subject'];
			$line_message = $_POST['line_message'];
			$section = $_POST['section'];
			$perselect = $_POST['perselect'];

			if ($perselect == "") {
				$perselect = null;
			}

			$model = new LineAction;
			$model->section = $section;
			$model->perselect = $perselect;
			$model->subject = $line_subject;
			$model->body = $line_message;

			$model->id = $id;

			if ($model->Edit_message()) {

				$log_page = basename(Yii::$app->request->urlReferrer);

				$log_description = 'แก้ไขสิทธิ์ข้อความสำหรับส่งให้สมาชิกแบบทั้งหมด <br/>';
				$log_description .= 'ไอดีหัวข้อ : ' . $_POST['id'] . '<br/>';
				$log_description .= 'หัวข้อ : ' . $_POST['line_subject'] . '<br/>';
				$log_description .= 'ข้อความที่ส่ง : ' . $_POST['line_message'] . '<br/>';
				$log_description .= 'ประกันสังคมมาตรา : ' . strip_tags($_POST['section']) . ' <br/>';
				$log_description .= 'หน่วยงาน : ' . strip_tags($_POST['perselect']) . ' <br/>';

				CommonAction::AddEventLog(Yii::$app->user->getState("sub"), "Update", $log_page, $log_description);

				echo CJSON::encode(array('status' => 'success', 'msg' => Yii::$app->session['success_Setmessage'],));
				Yii::$app->session->remove('success_Setmessage');
				Yii::$app->session->remove('success_Setmessage_id');
			} else {
				echo CJSON::encode(array('status' => 'error', 'msg' => Yii::$app->session['errmsg_Setmessage'],));
				Yii::$app->session->remove('errmsg_Setmessage');
			}
		}
	}

	public function actionDelete_message()
	{
		if (Yii::$app->request->isPost) {
			$content_id = $_POST['content_id'];
			if (is_null($content_id)) {
				exit;
			}

			$user_id = Yii::$app->user->getInfo("id");
			$ssobranch_code = Yii::$app->user->getInfo("ssobranch_code");
			$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['cms'];

			$data = lkup_user::getUserPermission($user_id, $app_id, $ssobranch_code);
			$user_role = $data[0]["user_role"];


			if (lkup_data::chkAddPermission($user_role, $app_id)) {

				$sql = "SELECT * FROM trn_line_message WHERE id=:id ";
				$conn = Yii::$app->db;
				$rows = $conn->createCommand($sql)->bindValue('id', $content_id)->queryAll();

				$items = (array) $rows[0];
			} else {
				echo json_encode(array('msg' => "เจ้าหน้าที่ไม่สามารถลบข้อมูลได้"));
				exit;
			}

			$model = new LineAction;
			$model->id = $content_id;

			if ($model->Delete_message()) {

				$log_page = basename('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
				$log_page = basename(Yii::$app->request->urlReferrer);

				$log_description = 'ลบชุดข้อความ <br/>';
				$log_description .= 'ข้อความ ID : ' . $content_id . ' <br/>';

				CommonAction::AddEventLog(Yii::$app->user->getState("sub"), "Delete", $log_page, $log_description);

				echo json_encode(array('msg' => 'success'));
			} else {
				$msg = Yii::$app->session['errmsg_message'];
				echo json_encode(array('msg' => $msg));
				Yii::$app->session->remove('errmsg_message');
			}
		}
	}

	public function actionPushmessage()
	{
		if (Yii::$app->request->isPost) {

			$content_id = $_POST['id'];
			if (is_null($content_id)) {
				exit;
			}

			$sql = "SELECT * FROM trn_line_message WHERE id=:id ";
			$conn = Yii::$app->db;
			$rows = $conn->createCommand($sql)->bindValue('id', $content_id)->queryAll();
			if (count($rows) != 0) {
				$items = (array) $rows[0];

				$text = $items['message'];
				$result = $this->broadcastmessage($text);
				if ($result) {
					$createby = !Yii::$app->user->isGuest ? Yii::$app->user->id : 0;
					$sql = "UPDATE trn_line_message SET status_send=1, send_by='{$createby}', lastsend=NOW() 
					WHERE id=:id";
					$command = $conn->createCommand($sql);
					$command->bindValue(":id", $content_id);
					$command->execute();
				}
			}
		}
	}


	public function actionSetnotify()
	{

		if (Yii::$app->request->isPost) {

			$line_subject = $_POST['line_subject'];
			$line_message = $_POST['line_message'];
			$section = $_POST['section'];
			$perselect = $_POST['perselect'];

			if ($perselect == "") {
				$perselect = null;
			}

			$myArray = explode(',', $perselect);

			$model = new LineAction;
			$model->section = $section;
			$model->perselect = $perselect;
			$model->subject = $line_subject;
			$model->body = $line_message;

			if ($model->save_Setnotify()) {

				$log_page = basename(Yii::$app->request->referrer);

				$log_description = 'เพิ่มสิทธิ์ข้อความสำหรับส่งให้ผู้ให้ประกันตนแบบทั้งหมด <br/>';
				$log_description .= 'หัวข้อ : ' . $_POST['line_subject'] . '<br/>';
				$log_description .= 'ข้อความที่ส่ง : ' . $_POST['line_message'] . '<br/>';
				$log_description .= 'ประกันสังคมมาตรา : ' . implode(',', $_POST['section']) . ' <br/>';
				$log_description .= 'หน่วยงาน : ' . strip_tags($_POST['perselect']) . ' <br/>';

				$cwebuser = new \app\components\CustomWebUser();
				$createby = !Yii::$app->user->isGuest ? $cwebuser->getInfo('uid') : 0;

				CommonAction::AddEventLog($createby, "Insert", $log_page, $log_description);

				echo json_encode(array('status' => 'success', 'msg' => Yii::$app->session['success_Setnotify'],));
				Yii::$app->session->remove('success_Setnotify');
				Yii::$app->session->remove('success_Setnotify_id');
			} else {
				echo json_encode(array('status' => 'error', 'msg' => Yii::$app->session['errmsg_Setnotify'],));
				Yii::$app->session->remove('errmsg_Setnotify');
			}
		}
	}

	public function actionEditnotify()
	{

		if (Yii::$app->request->isPost) {

			$id = $_POST['id'];
			$line_subject = $_POST['line_subject'];
			$line_message = $_POST['line_message'];
			$section = $_POST['section'];
			$perselect = $_POST['perselect'];

			if ($perselect == "") {
				$perselect = null;
			}

			$model = new LineAction;
			$model->section = $section;
			$model->perselect = $perselect;
			$model->subject = $line_subject;
			$model->body = $line_message;

			$model->id = $id;

			if ($model->Edit_Setnotify()) {

				$log_page = basename(Yii::$app->request->referrer);

				$log_description = 'เพิ่มสิทธิ์ข้อความสำหรับส่งให้ผู้ให้ประกันตนแบบทั้งหมด <br/>';
				$log_description .= 'ไอดีหัวข้อ : ' . $_POST['id'] . '<br/>';
				$log_description .= 'หัวข้อ : ' . $_POST['line_subject'] . '<br/>';
				$log_description .= 'ข้อความที่ส่ง : ' . $_POST['line_message'] . '<br/>';
				$log_description .= 'ประกันสังคมมาตรา : ' . implode(',', $_POST['section']) . ' <br/>';
				$log_description .= 'หน่วยงาน : ' . strip_tags($_POST['perselect']) . ' <br/>';

				$cwebuser = new \app\components\CustomWebUser();
				$createby = !Yii::$app->user->isGuest ? $cwebuser->getInfo('uid') : 0;

				CommonAction::AddEventLog($createby, "Update", $log_page, $log_description);

				echo json_encode(array('status' => 'success', 'msg' => Yii::$app->session['success_Setnotify'],));
				Yii::$app->session->remove('success_Setnotify');
				Yii::$app->session->remove('success_Setnotify_id');
			} else {
				echo json_encode(array('status' => 'error', 'msg' => Yii::$app->session['errmsg_Setmessage'],));
				Yii::$app->session->remove('errmsg_Setnotify');
			}
		}
	}

	public function actionDelete_notify()
	{
		if (Yii::$app->request->isPost) {
			$content_id = $_POST['content_id'];
			if (is_null($content_id)) {
				exit;
			}

			$cwebuser = new CustomWebUser();
			$user_id = Yii::$app->user->getId();
			$ssobranch_code = $cwebuser->getInfo("ssobranch_code");
			$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['cms'];

			$data = \app\models\lkup_user::getUserPermission($user_id, $app_id, $ssobranch_code);
			$user_role = $data[0]["user_role"];


			if (\app\models\lkup_data::chkAddPermission($user_role, $app_id)) {
			} else {
				echo json_encode(array('msg' => "เจ้าหน้าที่ไม่สามารถลบข้อมูลได้"));
				exit;
			}

			$model = new LineAction;
			$model->id = $content_id;

			if ($model->Delete_notify()) {

				$log_page = basename(Yii::$app->request->referrer);

				$log_description = 'ลบ ชุดข้อความที่จะส่งไปให้ผู้ประกันตน <br/>';
				$log_description .= 'ID : ' . $content_id . ' <br/>';

				$cwebuser = new \app\components\CustomWebUser();
				$createby = !Yii::$app->user->isGuest ? $cwebuser->getInfo('uid') : 0;
				\app\models\CommonAction::AddEventLog($createby, "Delete", $log_page, $log_description);

				echo json_encode(array('msg' => 'success'));
			} else {

				$log_page = basename(Yii::$app->request->referrer);

				$log_description = 'ลบ ชุดข้อความที่จะส่งไปให้ผู้ประกันตน <br/>';
				$log_description .= 'ID : ' . $content_id  . ' <br/>';
				$log_description .= "ไม่สำเร็จสถานะ " . Yii::$app->session['errmsg_notify'];

				$cwebuser = new \app\components\CustomWebUser();
				$createby = !Yii::$app->user->isGuest ? $cwebuser->getInfo('uid') : 0;
				\app\models\CommonAction::AddEventLog($createby, "Delete", $log_page, $log_description);

				$msg = Yii::$app->session['errmsg_notify'];
				echo json_encode(array('msg' => $msg));
				Yii::$app->session->remove('errmsg_notify');
			}
		}
	}


	public function actionGetdata()
	{

		if (Yii::$app->request->isPost) {


			$section = $_POST['section'];
			if ($section == "") {
				die('error:กรุณาเลือกมาตรา');
				return;
			}

			$perselect = $_POST['perselect'];
			if ($perselect == "") {
				die('error:กรุณาเลือกหน่วยงาน');
				return;
			}

			$myArray = explode(',', $perselect);

			$sql = "
			SELECT li_line_id
				FROM
			tran_ssoid
			INNER JOIN tran_line_id
				ON (
				id_sso = li_user_id
				)
				WHERE section_id IN(" . implode(",", $section) . ") AND ssobranch_code IN(" . implode(',', $myArray) . ") GROUP BY li_line_id;
			";
			$conn = Yii::$app->db;
			$command = $conn->createCommand($sql);
			//$command->bindValue(":section_id", $section);
			//$command->bindValue(":ssobranch_code", implode(',', $some_values)); 
			$rows = $command->queryAll();
			if (count($rows) != 0) {
				$this->DownloadText($rows);
				//$download_title = array('id', 'name');
				//$this->DownloadCSV($download_title, $rows);
			} else {
				// Set http header error
				//header('HTTP/1.0 500 Internal Server Error');
				// Return error message
				die('error:ไม่พบผู้ประกันตนตามเงื่อนไขที่เลือก');

				return;
			}
		}

		/*
		$sql = "SELECT id,name FROM mas_section ";
		$conn = Yii::$app->db;
		//$rows = $conn->createCommand($sql)->bindValue('id', $content_id)->queryAll();
		$command = $conn->createCommand($sql);
		$rows = $command->queryAll();

		if (count($rows) != 0) {
			//$this->DownloadText($rows);
			$download_title = array('id', 'name');
			$this->DownloadCSV($download_title, $rows);
		}*/
	}

	function DownloadText( /*array &$txtTitle,*/array &$txtData, $fileName = '')
	{
		if (empty($fileName)) { //Saved file name
			$fileName = 'download_' . date('Ymd_His');
		}

		header("Content-Disposition: attachment; filename={$fileName}.txt");
		header("Content-Type: charset=utf-8");
		$fp = fopen("php://output", 'w');

		//Generate BOM header
		fputs($fp, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));

		//Generate a title bar
		//$titleLine = implode("\t", $txtTitle)."\n";
		//fputs($fp, $titleLine, strlen($titleLine));

		foreach ($txtData as $row) {
			$line = implode("\t", $row) . "\n";
			fputs($fp, $line, strlen($line));
		}
		exit();
	}

	function DownloadCSV(array &$csvTitle, array &$csvData, $fileName = '')
	{
		if (empty($fileName)) { //Saved file name
			$fileName = 'download_' . date('Ymd_His');
		}
		//header('Content-type: application/csv');
		header('Content-Type: application/octet-stream');
		header('Content-Transfer-Encoding: binary; charset=utf-8');
		header('Content-Disposition: attachment; filename=' . $fileName . '.csv');
		$fp = fopen("php://output", 'w');

		//Generate BOM header
		fputs($fp, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));

		//Generate a title bar
		fputcsv($fp, $csvTitle);
		foreach ($csvData as $row) {
			fputcsv($fp, $row);
		}
		exit();
	}



	public function actionExportcall()
	{

		if (!empty($_GET["id"])) {
			$id = $_GET["id"];

			if (is_numeric($id)) {

				$cwebuser = new CustomWebUser();
				$user_id = Yii::$app->user->getId();
				$ssobranch_code = $cwebuser->getInfo("ssobranch_code");

				$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['cms'];

				$data_role = \app\models\lkup_user::getUserPermission($user_id, $app_id, $ssobranch_code);
				$user_role = $data_role[0]["user_role"];

				$isAddmin = \app\models\lkup_data::chkAddPermission($user_role, $app_id);

				if ($isAddmin) {
					$conn = Yii::$app->db;
					$sql = "SELECT * FROM trn_line_message WHERE id=:id ";
					$command = $conn->createCommand($sql);
					$command->bindValue(":id", $id);
					$rows = $command->queryAll();

					return $this->render('exportcall', array('data' => $rows, "user_role" => $user_role, "user_id" => $user_id, 'id' => $id));
				} else {
					if (Yii::$app->request->urlReferrer) {
						$redirect = Yii::$app->request->urlReferrer;
					} else {
						$redirect = Yii::$app->createUrl('');
					}
				?>
					<script>
						alert("เจ้าหน้าที่ไม่สามารถแก้ไขข้อมูลได้");
						window.location.href = "<?= $redirect ?>";
					</script>
<?php
					exit;
					//return $this->redirect(Yii::$app->request->urlReferrer);
				}
			}
		} else {
			$cwebuser = new CustomWebUser();
			$user_id = Yii::$app->user->getId();
			$ssobranch_code = $cwebuser->getInfo("ssobranch_code");

			$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['cms'];

			$data_role = \app\models\lkup_user::getUserPermission($user_id, $app_id, $ssobranch_code);
			$user_role = $data_role[0]["user_role"];

			$isAddmin = \app\models\lkup_data::chkAddPermission($user_role, $app_id);

			if ($isAddmin) {
				return $this->render('exportcall', array('data' => null, "user_role" => $user_role, "user_id" => $user_id,));
			}
		}
	}


	public function actionExportlogcall()
	{

		$starts = null;
		if (!empty($_REQUEST['starts'])) $starts = $_REQUEST['starts'];
		if (is_null($starts)) {
			$response = [
				'status' => 'fails',
				'msg' => "กรุณาป้อนวันที่เริ่มต้น"
			];
			return json_encode($response);
		}
		$ends = null;
		if (!empty($_REQUEST['ends'])) $ends = $_REQUEST['ends'];
		if (is_null($ends)) {
			$response = [
				'status' => 'fails',
				'msg' => "กรุณาป้อนวันที่สุดท้าย"
			];
			return json_encode($response);
		}


		$date = \DateTime::createFromFormat("d/m/Y H:i:s", $starts);
		//$start_format = $date->format('Y-m-d H:i');
		$start_format = $date->format('Y-m-d H:i:s');

		$date = \DateTime::createFromFormat("d/m/Y H:i:s", $ends);
		$ends_format = $date->format('Y-m-d H:i:s');


		$write_array = array();
		$fileName = "excel.xlsx";
		$fileName = 'download_' . date('Ymd_His') . ".xlsx";
		$write_array[] = array("วันที่โทร", "เลขบัตรประชาชน", "ชื่อ-นามสกุล", "เพศ", "กลุ่มผู้ประกันตน");

		$conn = Yii::$app->logdb;
		$sql = "SELECT log_date, log_idcard, log_name, log_gender, log_section FROM log_call1506 WHERE log_date >=:start AND  log_date <=:end   ";
		$command = $conn->createCommand($sql);
		$command->bindValue(":start", $start_format);
		$command->bindValue(":end", $ends_format);
		$rows = $command->queryAll();

		foreach ($rows as $row) {
			$write_array[] = array($row["log_date"], $row["log_idcard"], $row["log_name"], $row["log_gender"], $row["log_section"]);
		}

		$conn->close();

		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0);
		$spreadsheet->getActiveSheet()->fromArray($write_array, NULL, 'A1');
		$spreadsheet->getActiveSheet()->setTitle("My Excel");


		$response = Yii::$app->getResponse();
		$headers = $response->getHeaders();

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $fileName . '"');
		header('Cache-Control: max-age=0');
		header('Cache-Control: max-age=1');
		header('Cache-Control: cache, must-revalidate');
		header('Pragma: public');

		ob_start();
		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save("php://output");
		$content = ob_get_contents();
		ob_clean();
		//return $content;

		$response =  array(
			'status' => 'success',
			'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64," . base64_encode($content)
		);
		return json_encode($response);


		if (Yii::$app->request->isPost) {

			ini_set('memory_limit', '2048M');
		}
	}
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
