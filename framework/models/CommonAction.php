<?php
namespace app\models;

use Yii;
/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
//require Yii::getPathOfAlias('application') . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;

class CommonAction 
{

	public $uid;
	public $password;
	public $displayname;
	public $ssobranch_code;
	public $ssomail;
	public $ssoaccountactive;

	public $download_dir;
	public $download_file;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('uid, displayname, ssobranch_code', 'required'),
		);
	}


	public function Check_mas_user()
	{

		$sql = "SELECT id,uid,ssobranch_code FROM mas_user WHERE uid=:uid ";
		$rows = Yii::$app->db->createCommand($sql)->bindValue(':uid', $this->uid)->queryAll();
		if (count($rows) > 0) {

			//แก้ไขข้อมูลผู้ใช้
			$this->update_mas_user($rows[0]['id']);

			$ssobranch_code = $rows[0]['ssobranch_code']; //รหัสหน่วยงานก่อนการอัพเดต			

			//เช็คว่ามีกี่ app
			$sql = "SELECT COUNT(id) AS ct FROM mas_app_permission WHERE STATUS=1 ORDER BY id;";
			$ctapp = Yii::$app->db->createCommand($sql)->queryAll();

			//ตรวจสอบแถว permission เท่ากับจำนวน app ไหม
			$sql = "SELECT COUNT(id) AS ct FROM mas_user_permission WHERE user_id=:user_id AND ssobranch_code=:ssobranch_code ;";

			$command = Yii::$app->db->createCommand($sql);
			$command->bindValue(":user_id", $rows[0]['id']);
			$command->bindValue(":ssobranch_code", $this->ssobranch_code);
			$ctper = $command->queryAll();

			$log_page = basename(Yii::$app->request->referrer);
			//ถ้ามีการเปลี่ยน branch_code 
			if (($ssobranch_code != $this->ssobranch_code)) {
				//ล้างทั้งหมด
				$this->Update_mas_user_permission($rows[0]['id'], $this->ssobranch_code);
				$this->AddEventLog($this->uid, "Update", $log_page, "มีการเปลี่ยนหน่วยงานจาก " . $ssobranch_code . " เป็น " . $this->ssobranch_code);
			}

			//หรือมีการเพิ่ม app เข้ามาใหม่
			if ($ctapp[0]['ct'] != $ctper[0]['ct']) {
				$this->Update_mas_user_app_permission($rows[0]['id'], $this->ssobranch_code);
			}

			//หรือมีการเพิ่ม app เข้ามาใหม่
			if (($ssobranch_code != $this->ssobranch_code) || ($ctapp[0]['ct'] != $ctper[0]['ct'])) {
				//$this->Update_mas_user_permission($rows[0]['id'], $this->ssobranch_code);
			}
		}

		return $rows;
		/*
			if (count($rows) > 0){
				return true;
			}else{
				return false;
			}
			*/
	}


	public function Add_mas_user()
	{

		try {
			$createby = !Yii::$app->user->isGuest ? Yii::$app->user->id : 0;

			$conn = Yii::$app->db;
			$transaction = $conn->beginTransaction();

			$sql = "INSERT INTO mas_user (uid, password, displayname, ssobranch_code, ssomail, create_by, create_date) VALUES(:uid, :password, :displayname, :ssobranch_code, :ssomail, $createby, now())";

			$command = $conn->createCommand($sql);
			$command->bindValue(":uid", $this->uid);
			$command->bindValue(":password", $this->password);
			$command->bindValue(":displayname", $this->displayname);
			$command->bindValue(":ssobranch_code", $this->ssobranch_code);
			$command->bindValue(":ssomail", $this->ssomail);
			$command->execute();
			$user_id = $conn->getLastInsertID();

			$this->Add_mas_user_permission($user_id, $this->ssobranch_code);

			/*
			//เปิดสิทธิ์เนื้อหา
			$sql = "INSERT INTO mas_user_permission(user_id, ssobranch_code, app_id, user_role, create_by, create_date) VALUES(:user_id, :ssobranch_code, :app_id, :user_role, $createby, now())";
			$command = $conn->createCommand($sql);
			$command->bindValue(":user_id", $user_id);		
			$command->bindValue(":ssobranch_code", $this->ssobranch_code);		
			$command->bindValue(":app_id", '1');	
			$command->bindValue(":user_role",'4');
			$command->execute();

			//เปิดสิทธิ์แอดมิน
			$sql = "INSERT INTO mas_user_permission(user_id, ssobranch_code, app_id, user_role, create_by, create_date) VALUES(:user_id, :ssobranch_code, :app_id, :user_role, $createby, now())";
			$command = $conn->createCommand($sql);
			$command->bindValue(":user_id", $user_id);		
			$command->bindValue(":ssobranch_code", $this->ssobranch_code);		
			$command->bindValue(":app_id", '5');	
			$command->bindValue(":user_role",'4');
			$command->execute();
			*/

			$transaction->commit();
			return $user_id;
		} catch (Exception $e) {

			$transaction->rollBack();
			Yii::$app->session['errmsg_adduser'] = 'error ' . $e->getMessage();
			return false;
		}
	}


	public function Add_mas_user_permission($user_id, $ssobranch_code)
	{
		//ALTER TABLE `itrdb`.`mas_user_permission` ADD UNIQUE INDEX (`user_id`, `app_id`); 
		$sql = "SELECT * FROM mas_app_permission WHERE status=1 order by id ";
		$rows = Yii::$app->db->createCommand($sql)->queryAll();

		$conn = Yii::$app->db;
		foreach ($rows as $dataitem) {
			$sql = "INSERT IGNORE INTO mas_user_permission(user_id, ssobranch_code, app_id, user_role, create_by, create_date) VALUES(:user_id, :ssobranch_code, :app_id, :user_role, $user_id, now())";
			$command = $conn->createCommand($sql);
			$command->bindValue(":user_id", $user_id);
			$command->bindValue(":ssobranch_code", $ssobranch_code);
			$command->bindValue(":app_id", $dataitem["id"]);
			$command->bindValue(":user_role", '4');
			$command->execute();
		}
	}

	public function update_mas_user($id)
	{

		try {
			$createby = !Yii::$app->user->isGuest ? Yii::$app->user->id : 0;

			$conn = Yii::$app->db;
			$transaction = $conn->beginTransaction();

			if ($this->ssoaccountactive != null) {
				$sql = "UPDATE mas_user SET displayname=:displayname, ssobranch_code=:ssobranch_code, ssomail=:ssomail, status=:status, update_by=:update_by, update_date=now() WHERE id=:id";
				$status = 2;
				if ($this->ssoaccountactive === 'true') {
					$status = 1;
				}
				$command = $conn->createCommand($sql);
				$command->bindValue(":displayname", $this->displayname);
				$command->bindValue(":ssobranch_code", $this->ssobranch_code);
				$command->bindValue(":ssomail", $this->ssomail);
				$command->bindValue(":status", $status);
				$command->bindValue(":update_by", $createby);
				$command->bindValue(":id", $id);
				$command->execute();
			} else {
				$sql = "UPDATE mas_user SET displayname=:displayname, ssobranch_code=:ssobranch_code, ssomail=:ssomail, update_by=:update_by, update_date=now() WHERE id=:id";

				$command = $conn->createCommand($sql);
				$command->bindValue(":displayname", $this->displayname);
				$command->bindValue(":ssobranch_code", $this->ssobranch_code);
				$command->bindValue(":ssomail", $this->ssomail);
				$command->bindValue(":update_by", $createby);
				$command->bindValue(":id", $id);
				$command->execute();
			}



			$transaction->commit();

			return true;
		} catch (Exception $e) {
			$transaction->rollBack();
			Yii::$app->session['errmsg_adduser'] = 'error ' . $e->getMessage();
			return false;
		}
	}


	public function Update_mas_user_permission($user_id, $ssobranch_code)
	{
		//ลบทั้งหมดแล้วเพิ่มเข้าไปใหม่
		//ALTER TABLE `itrdb`.`mas_user_permission` ADD UNIQUE INDEX (`user_id`, `app_id`); 
		$conn = Yii::$app->db;

		//$sql = "UPDATE mas_user_permission SET status=0, user_role='4' WHERE user_id=" . $user_id . " AND ssobranch_code !=" . $ssobranch_code;

		$sql = "DELETE FROM mas_user_permission WHERE user_id=" . $user_id . " AND ssobranch_code !=" . $ssobranch_code;
		$command = $conn->createCommand($sql);
		$command->execute();

		$sql = "SELECT * FROM mas_app_permission WHERE status=1 order by id ";
		$rows = Yii::$app->db->createCommand($sql)->queryAll();

		foreach ($rows as $dataitem) {
			$sql = "INSERT IGNORE INTO mas_user_permission(user_id, ssobranch_code, app_id, user_role, create_by, create_date) VALUES(:user_id, :ssobranch_code, :app_id, :user_role, $user_id, now()) ";

			$sql = "INSERT INTO mas_user_permission(user_id, ssobranch_code, app_id, user_role, create_by, create_date) 
			VALUES(:user_id, :ssobranch_code, :app_id, :user_role, $user_id, now()) 
			ON DUPLICATE KEY UPDATE status ='1' ;
			";
			$command = $conn->createCommand($sql);
			$command->bindValue(":user_id", $user_id);
			$command->bindValue(":ssobranch_code", $ssobranch_code);
			$command->bindValue(":app_id", $dataitem["id"]);
			$command->bindValue(":user_role", '4');
			$command->execute();
		}
	}

	public function Update_mas_user_app_permission($user_id, $ssobranch_code)
	{
		//คิวรี่แอฟมาอัพเดต
		$conn = Yii::$app->db;

		$sql = "SELECT * FROM mas_app_permission WHERE status=1 order by id ";
		$rows = Yii::$app->db->createCommand($sql)->queryAll();

		foreach ($rows as $dataitem) {
			$sql = "INSERT IGNORE INTO mas_user_permission(user_id, ssobranch_code, app_id, user_role, create_by, create_date) VALUES(:user_id, :ssobranch_code, :app_id, :user_role, $user_id, now())";
			$command = $conn->createCommand($sql);
			$command->bindValue(":user_id", $user_id);
			$command->bindValue(":ssobranch_code", $ssobranch_code);
			$command->bindValue(":app_id", $dataitem["id"]);
			$command->bindValue(":user_role", '4');
			$command->execute();
		}
	}


	public function Downloadfile()
	{

		ignore_user_abort(true);
		set_time_limit(0); // disable the time limit for this script

		$path = $this->download_dir;  // change the path to fit your websites document structure

		$dl_file = preg_replace("([^\w\s\d\-_~,;:\[\]\(\).]|[\.]{2,})", '', $this->download_file); // simple file name validation
		$dl_file = filter_var($dl_file, FILTER_SANITIZE_URL); // Remove (more) invalid characters
		$fullPath = $path . $dl_file;

		if ($fd = fopen($fullPath, "r")) {
			$fsize = filesize($fullPath);
			$path_parts = pathinfo($fullPath);
			$ext = strtolower($path_parts["extension"]);
			$type = mime_content_type($fullPath);

			header('Content-Type: ' . $type);
			header("Content-Disposition: attachment; filename=\"" . $path_parts["basename"] . "\"");
			header("Content-length: $fsize");
			header("Cache-control: private"); //use this to open files directly
			while (!feof($fd)) {
				$buffer = fread($fd, 2048);
				echo $buffer;
			}
		}
		fclose($fd);
		exit;
	}



	public static function Exportfile($rows)
	{

		// Create new Spreadsheet object
		$spreadsheet = new Spreadsheet();

		// Set document properties
		$spreadsheet->getProperties()->setCreator('Maarten Balliauw')
			->setLastModifiedBy('Maarten Balliauw')
			->setTitle('Office 2007 XLSX Test Document')
			->setSubject('Office 2007 XLSX Test Document')
			->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
			->setKeywords('office 2007 openxml php')
			->setCategory('Test result file');

		// Add some data
		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'Hello')
			->setCellValue('B2', 'world!')
			->setCellValue('C1', 'Hello')
			->setCellValue('D2', 'world!');

		// Miscellaneous glyphs, UTF-8
		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A4', 'Miscellaneous glyphs')
			->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');

		// Rename worksheet
		$spreadsheet->getActiveSheet()->setTitle('Simple');

		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$spreadsheet->setActiveSheetIndex(0);



		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		//$writer->save('php://output');

		ob_start();
		$writer->save("php://output");
		$content = ob_get_contents();
		ob_clean();
		return $content;
	}

	// Admin Only
	public static function AddEventLog($log_user, $log_action, $log_page, $log_description)
	{
		$conn = Yii::$app->logdb;
		$transaction = $conn->beginTransaction();
		try {
			$createby = !Yii::$app->user->isGuest ? Yii::$app->user->id : 0;
			//Yii::$app->request->getUserHostAddress()

			$sql = "INSERT INTO log_event(log_user, log_action, log_page, log_date, log_ip, log_description) 
			VALUES(:log_user, :log_action, :log_page, NOW(), :log_ip, :log_description)";

			$command = $conn->createCommand($sql);

			$command->bindValue(":log_user", $log_user);
			$command->bindValue(":log_action", $log_action);
			$command->bindValue(":log_page", $log_page);
			$command->bindValue(":log_ip", Yii::$app->getRequest()->getUserIP());
			$command->bindValue(":log_description", $log_description);
			$command->execute();

			$transaction->commit();
			return true;
		} catch (Exception $e) {

			$transaction->rollBack();
			Yii::$app->session['errmsg_addlog'] = 'error ' . $e->getMessage();
			return false;
		}
	}

	public function AddAdminLog($action, $description)
	{
		$conn = Yii::$app->logdb;
		$transaction = $conn->beginTransaction();
		try {
			$createby = !Yii::$app->user->isGuest ? Yii::$app->user->id : 0;

			$sql = "INSERT INTO trn_log(action, description, action_by, action_date, ipaddresss) VALUES(:action, :description, $createby, now(), :ipaddresss)";

			$command = $conn->createCommand($sql);
			$command->bindValue(":action", $action);
			$command->bindValue(":description", $description);
			$command->bindValue(":ipaddresss", Yii::$app->getRequest()->getUserIP());
			$command->execute();
			$user_id = $conn->getLastInsertID();

			$transaction->commit();
			return $user_id;
		} catch (Exception $e) {

			$transaction->rollBack();
			Yii::$app->session['errmsg_addlog'] = 'error ' . $e->getMessage();
			return false;
		}
	}

	public static function AddLoginLog($action = "Login", $description = "")
	{
		$connlog = Yii::$app->logdb;
		$transaction = $connlog->beginTransaction();
		try {
			//$createby = !Yii::$app->user->isGuest?Yii::$app->user->id:0;
			//$createby = Yii::$app->user->getState("sub");
			$cwebuser = new \app\components\CustomWebUser();
			$createby = !Yii::$app->user->isGuest? $cwebuser->getInfo('uid') : 0; 

			$sql = "
			INSERT INTO log_login (
			  `log_date`,
			  `log_type`,
			  `log_description`,
			  `log_createby`,
			  `log_ipaddress`,
			  log_session_id
			)
			VALUES
			  (
				NOW(),
				:log_type,
				:log_description,
				:log_createby,
				:log_ipaddress,
				:log_session_id
			  );";

			$command = $connlog->createCommand($sql);
			$command->bindValue(":log_type", $action);
			$command->bindValue(":log_description", $description);
			$command->bindValue(":log_createby", $createby);
			$command->bindValue(":log_ipaddress", Yii::$app->getRequest()->getUserIP());
			$command->bindValue(":log_session_id", Yii::$app->session->getId());
			$command->execute();
			$log_id = $connlog->getLastInsertID();

			$transaction->commit();

			$conn = Yii::$app->db;
			$sql = "UPDATE mas_user SET lasted_login_date=NOW() WHERE uid='{$createby}'";
			$command = $conn->createCommand($sql);
			$command->execute();

			return $log_id;
		} catch (Exception $e) {

			$transaction->rollBack();
			Yii::$app->session['errmsg_addlog'] = 'error ' . $e->getMessage();
			return false;
		}
	}

	public function ChkLoginSession()
	{
		try {
			$createby = !Yii::$app->user->isGuest ? Yii::$app->user->id : 0;
			//$createby = Yii::$app->user->getState("sub");

			$conn = Yii::$app->db;

			$sql = "SELECT * FROM log_login_session WHERE log_createby=:log_createby AND log_session_id=:log_session_id ";
			$command = $conn->createCommand($sql);
			$command->bindValue(":log_createby", $createby);
			$command->bindValue(":log_session_id", Yii::$app->user->getState("guid"));

			$rows = $command->queryAll();
			if (count($rows) == 0) {
				Yii::$app->user->logout();
			}

			return true;
		} catch (Exception $e) {

			Yii::$app->session['errmsg_chklog'] = 'error ' . $e->getMessage();
			return false;
		}
	}

	public static function AddLoginSession()
	{
		try {
			$createby = !Yii::$app->user->isGuest ? Yii::$app->user->id : 0;
			//$createby = Yii::$app->user->getState("sub");

			$conn = Yii::$app->db;
			$transaction = $conn->beginTransaction();

			$sql = "DELETE FROM log_login_session WHERE log_createby='{$createby}'";
			$command = $conn->createCommand($sql);
			$command->execute();

			$sql = "
			insert into log_login_session (
				`log_date`,
				`log_createby`,
				`log_session_id`,
				`log_ipaddress`
			  )
			  values
				(
				  NOW(),
				  :log_createby,
				  :log_session_id,
				  :log_ipaddress
				);
			";

			$command = $conn->createCommand($sql);
			$command->bindValue(":log_createby", $createby);
			//$command->bindValue(":log_session_id", Yii::$app->user->getState("guid"));
			$command->bindValue(":log_session_id", Yii::$app->session->getId());
			$command->bindValue(":log_ipaddress", Yii::$app->getRequest()->getUserIP());
			$command->execute();
			$log_id = $conn->getLastInsertID();

			$transaction->commit();

			return $log_id;
		} catch (Exception $e) {

			$transaction->rollBack();
			Yii::$app->session['errmsg_addlog'] = 'error ' . $e->getMessage();
			return false;
		}
	}
	// End Admin Only

	// User Only

	public static function AddUserEventLog($log_user, $log_action, $log_page, $log_description)
	{
		$conn = Yii::$app->logdb;
		$transaction = $conn->beginTransaction();
		try {
			$createby = !Yii::$app->user->isGuest ? Yii::$app->user->id : 0;
			//Yii::$app->request->getUserHostAddress()

			$sql = "INSERT INTO log_userevent(log_user, log_action, log_page, log_date, log_ip, log_description) 
			VALUES(:log_user, :log_action, :log_page, NOW(), :log_ip, :log_description)";

			$command = $conn->createCommand($sql);

			$command->bindValue(":log_user", $log_user);
			$command->bindValue(":log_action", $log_action);
			$command->bindValue(":log_page", $log_page);
			$command->bindValue(":log_ip", Yii::$app->getRequest()->getUserIP());
			$command->bindValue(":log_description", $log_description);
			$command->execute();

			$transaction->commit();
			return true;
		} catch (Exception $e) {

			$transaction->rollBack();
			Yii::$app->session['errmsg_addlog'] = 'error ' . $e->getMessage();
			return false;
		}
	}


	public static function AddUserLoginLog($log_user, $action = "Login", $description = "")
	{
		$connlog = Yii::$app->logdb;
		$transaction = $connlog->beginTransaction();
		try {
			//$createby = !Yii::$app->user->isGuest?Yii::$app->user->id:0;
			//$createby = Yii::$app->user->getState("sub");
			$cwebuser = new \app\components\CustomWebUser(); 

			$sql = "
			INSERT INTO log_userlogin(
			  `log_date`,
			  `log_type`,
			  `log_description`,
			  `log_createby`,
			  `log_ipaddress`
			   /*,log_session_id */
			)
			VALUES
			  (
				NOW(),
				:log_type,
				:log_description,
				:log_createby,
				:log_ipaddress
				/*,:log_session_id */
			  );";

			$command = $connlog->createCommand($sql);
			$command->bindValue(":log_type", $action);
			$command->bindValue(":log_description", $description);
			$command->bindValue(":log_createby", $log_user);
			$command->bindValue(":log_ipaddress", Yii::$app->getRequest()->getUserIP());
			//$command->bindValue(":log_session_id", Yii::$app->session->getId());
			$command->execute();
			$log_id = $connlog->getLastInsertID();

			$transaction->commit();

			$conn = Yii::$app->db;
			$sql = "UPDATE mas_sso_user SET lasted_login_date=NOW() WHERE su_id='{$log_user}'";
			$command = $conn->createCommand($sql);
			$command->execute();

			return $log_id;
		} catch (Exception $e) {

			$transaction->rollBack();
			Yii::$app->session['errmsg_addlog'] = 'error ' . $e->getMessage();
			return false;
		}
	}

	// End User Only

	public static function Sendmail(
		$Host,
		$Port,
		$IsSMTP,
		$SMTPDebug,
		$SMTPAuth,
		$SMTPSecure = "",
		$SMTPAutoTLS = false,
		$Username,
		$Password,
		$IsHTML = true,
		$SetFrom,
		$Subject,
		$Body,
		$CharSet,
		$AddAddress
	) {

		//return true ;

		require(Yii::$app->basePath . '/vendor/phpmailer/phpmailer/src/Exception.php');
		require(Yii::$app->basePath . '/vendor/phpmailer/phpmailer/src/PHPMailer.php');
		require(Yii::$app->basePath . '/vendor/phpmailer/phpmailer/src/SMTP.php');

		$mail = new PHPMailer\PHPMailer\PHPMailer();

		try {
			$mail->CharSet = $CharSet;
			$mail->Host = $Host;
			$mail->Port = $Port; // or 587
			if ($IsSMTP) {
				$mail->IsSMTP(); // enable SMTP
			}

			$mail->SMTPDebug = $SMTPDebug; // debugging: 1 = errors and messages, 2 = messages only
			$mail->SMTPAuth = $SMTPAuth; // authentication enabled
			$mail->SMTPSecure = $SMTPSecure; // 'ssl' secure transfer enabled REQUIRED for Gmail
			$mail->SMTPAutoTLS = $SMTPAutoTLS; //ใส่ fasle ไว้เพราะส่ง mail.sso ไม่ผ่าน

			if ($Username) $mail->Username = $Username;
			if ($Password) $mail->Password = $Password;

			$mail->IsHTML($IsHTML);

			$mail->SetFrom($SetFrom[0], $SetFrom[1]);
			$mail->Subject = $Subject;
			$mail->Body = $Body;

			foreach ($AddAddress as $mailto) {
				$mail->AddAddress($mailto[0], $mailto[1]);
			}
			//$mail->AddAddress("niras_s@hotmail.com");
			$result = $mail->send();

			if (!$result) {
				Yii::$app->session['errmsg_sendmail'] = 'Error: ' . $mail->ErrorInfo;
				return false;
			}
			return true;
		} catch (Exception $e) {
			Yii::$app->session['errmsg_sendmail'] = 'Error: ' . $e->getMessage();
			return false;
		}
	}
}
