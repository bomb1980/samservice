<?php

namespace app\models;

use Yii;

use app\components\CustomWebUser;

class ReportAction
{
	public $name;
	public $email;
	public $subject;
	public $body;
	public $verifyCode;

	public $id;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('name, email, subject, body, filecode', 'required'),
			// email has to be a valid email address
			array('email', 'email'),
			// verifyCode needs to be entered correctly
			array('verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements()),
		);
	}



	public $sms_text;

	public function broadcastmessage()
	{

		$array = array(
			'type' => 'text',
			'text' => $this->sms_text,
		);

		$arrsms = array(
			'messages' => array($array),
		);

		$jsonDataEncoded = json_encode($arrsms, JSON_UNESCAPED_UNICODE);

		$json_pretty = json_encode(json_decode($jsonDataEncoded), JSON_UNESCAPED_UNICODE);
		//echo $json_pretty;
		//exit;

		//API Url
		$url = 'http://116.204.183.102/api/BroadcastMessage';

		//Initiate cURL.
		$ch = curl_init($url);

		//Tell cURL that we want to send a POST request.
		curl_setopt($ch, CURLOPT_POST, 1);

		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json_pretty);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

		//Execute the request
		$result = curl_exec($ch);

		if (strpos(strtolower($result), 'success') !== false) {
			return true;
		}

		$arr = json_decode($result, true);
		Yii::$app->session['error_broadcastmessage'] = $arr['message'];
		return false;

		/*
		$data = json_decode($result, true); var_dump($result);exit;

		$info = curl_getinfo($ch);
		curl_close($ch);

		if (substr($info['http_code'], 0, 1) === "2") {

			if (strpos(strtolower($data), 'success') !== false) {
				return true;
			}
			Yii::$app->session['error_broadcastmessage'] = $data['message'];
			return false;
		} else {
			Yii::$app->session['error_broadcastmessage'] = 'error ' . $info['http_code'];
			return false;
		}*/
	}

	public function pushmessage()
	{

		$array = array(
			'to'=>[],
			"messages"=> [				
					"type"=> "text",
					"text"=> $this->sms_text				
			]
		);

		$arrsms = array(
			'messages' => array($array),
		);

		$jsonDataEncoded = json_encode($arrsms, JSON_UNESCAPED_UNICODE);

		$json_pretty = json_encode(json_decode($jsonDataEncoded), JSON_UNESCAPED_UNICODE);
		//echo $json_pretty;
		//exit;

		//API Url
		$url = 'http://116.204.183.102/api/BroadcastMessage';
		$url = Yii::$app->params['prg_ctrl']['api']['line']['server'] . "api/PushMessage";

		//Initiate cURL.
		$ch = curl_init($url);

		//Tell cURL that we want to send a POST request.
		curl_setopt($ch, CURLOPT_POST, 1);

		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json_pretty);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

		//Execute the request
		$result = curl_exec($ch);

		if (strpos(strtolower($result), 'success') !== false) {
			return true;
		}

		$arr = json_decode($result, true);
		Yii::$app->session['error_broadcastmessage'] = $arr['message'];
		return false;


	}


	public $perselect;
	public $section;
	public function save_Setmessage()
	{
		$createby = !Yii::$app->user->isGuest ? Yii::$app->user->getId() : 0;
		$conn = Yii::$app->db;
		$transaction = $conn->beginTransaction();
		try {
			$sql = "INSERT INTO trn_line_message (subject, message, section_type, ssobranch, create_by, create_date )
			 VALUE(:subject, :message, :section_type, :ssobranch, '{$createby}', NOW())";

			$command = $conn->createCommand($sql);
			$command->bindValue(":subject", $this->subject);
			$command->bindValue(":message", $this->body);
			$command->bindValue(":section_type", $this->section);
			$command->bindValue(":ssobranch", $this->perselect);
			$command->execute();

			$id = $conn->getLastInsertID();

			$transaction->commit();
			Yii::$app->session['success_Setmessage'] = Yii::$app->urlManager->createAbsoluteUrl("line/message") . '/' . $id;
			Yii::$app->session['success_Setmessage_id'] = $id;

			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			Yii::$app->session['errmsg_Setmessage'] = 'error ' . $e->getMessage();
			return false;
		}
	}

	public function Edit_message()
	{
		$createby = !Yii::$app->user->isGuest ? Yii::$app->user->getId() : 0;
		$conn = Yii::$app->db;
		$transaction = $conn->beginTransaction();
		try {
			$sql = "UPDATE trn_line_message SET subject=:subject, message=:message, section_type=:section_type, ssobranch=:ssobranch, update_by='{$createby}', update_date=NOW() 
			 WHERE id=:id";

			$command = $conn->createCommand($sql);
			$command->bindValue(":subject", $this->subject);
			$command->bindValue(":message", $this->body);
			$command->bindValue(":section_type", $this->section);
			$command->bindValue(":ssobranch", $this->perselect);
			$command->bindValue(":id", $this->id);
			$command->execute();

			$transaction->commit();
			Yii::$app->session['success_Setmessage'] = Yii::$app->urlManager->createAbsoluteUrl("line/message") . '/' . $this->id;
			Yii::$app->session['success_Setmessage_id'] = $this->id;

			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			Yii::$app->session['errmsg_Setmessage'] = 'error ' . $e->getMessage();
			return false;
		}
	}

	public function Delete_message()
	{
		$conn = Yii::$app->db;
		$transaction = $conn->beginTransaction();
		try {

			$sql = "DELETE FROM trn_line_message WHERE trn_line_message.id=:id ";
			$command = $conn->createCommand($sql);
			$command->bindValue(":id", $this->id);
			$command->execute();

			$transaction->commit();

			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			Yii::$app->session['errmsg_message'] = 'error ' . $e->getMessage();
			return false;
		} finally {
		}
	}

	public function save_Setnotify()
	{
		$createby = !Yii::$app->user->isGuest ? Yii::$app->user->getId() : 0;
		$conn = Yii::$app->db;
		$transaction = $conn->beginTransaction();
		try {
			$sql = "INSERT INTO trn_notifications (subject, message, section_type, ssobranch, create_by, create_date )
			 VALUE(:subject, :message, :section_type, :ssobranch, '{$createby}', NOW())";

			$command = $conn->createCommand($sql);
			$command->bindValue(":subject", $this->subject);
			$command->bindValue(":message", $this->body);
			$command->bindValue(":section_type", implode(',', $this->section));
			$command->bindValue(":ssobranch", $this->perselect);
			$command->execute();

			$id = $conn->getLastInsertID();

			$transaction->commit();
			Yii::$app->session['success_Setnotify'] = Yii::$app->urlManager->createAbsoluteUrl("line/notifyapi") . '/' . $id;
			Yii::$app->session['success_Setnotify_id'] = $id;

			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			Yii::$app->session['errmsg_Setnotify'] = 'error ' . $e->getMessage();
			return false;
		}
	}

	public function Edit_Setnotify()
	{
		$createby = !Yii::$app->user->isGuest ? Yii::$app->user->getId() : 0;
		$conn = Yii::$app->db;
		$transaction = $conn->beginTransaction();
		try {
			$sql = "UPDATE trn_notifications SET subject=:subject, message=:message, section_type=:section_type, ssobranch=:ssobranch, update_by='{$createby}', update_date=NOW() 
			 WHERE id=:id";

			$command = $conn->createCommand($sql);
			$command->bindValue(":subject", $this->subject);
			$command->bindValue(":message", $this->body);
			$command->bindValue(":section_type", implode(',', $this->section));
			$command->bindValue(":ssobranch", $this->perselect);
			$command->bindValue(":id", $this->id);
			$command->execute();

			$transaction->commit();
			Yii::$app->session['success_Setnotify'] = Yii::$app->urlManager->createAbsoluteUrl("line/notifyapi") . '/' . $this->id;
			Yii::$app->session['success_Setnotify_id'] = $this->id;

			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			Yii::$app->session['errmsg_Setnotify'] = 'error ' . $e->getMessage();
			return false;
		}
	}

	public function Delete_notify()
	{
		try {
			$conn = Yii::$app->db;

			$sql = "
			SELECT * FROM notifications WHERE notifications.`noti_id`=:noti_id
  			";
			$rchk = $conn->createCommand($sql)->bindValue('noti_id', $this->id)->queryAll();
			if (count($rchk) != 0) {
				Yii::$app->session['errmsg_notify'] = 'error ' . "ข้อความนี้ได้ส่งเข้าไปในกล่องข้อความผู้ประกันตนแล้วไม่สามารถลบได้";
				return false;
			}

			$transaction = $conn->beginTransaction();

			$sql = "DELETE FROM trn_notifications WHERE trn_notifications.id=:id ";
			$command = $conn->createCommand($sql);
			$command->bindValue(":id", $this->id);
			$command->execute();

			$transaction->commit();

			return true;
		} catch (\Exception $e) {

			$transaction->rollBack();
			Yii::$app->session['errmsg_pdpa'] = 'error ' . $e->getMessage();
			return false;
		}
	}

	public $search;
	public $pAdmin;

	public $page;
	public $recordsPerPage;
	public $start;
	public $noOfRecords;
	public $FSearch;

	public function Listmessage()
	{
		$cwebuser = new CustomWebUser();
		$user_id = Yii::$app->user->getId();
		//$ssobranch_code = Yii::$app->user->getInfo("ssobranch_code");
		$ssobranch_code = $cwebuser->getInfo("ssobranch_code");

		$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['admin'];

		$data = lkup_user::getUserPermission($user_id, $app_id, $ssobranch_code);
		$user_role = $data[0]["user_role"];
		$isAddmin = lkup_data::chkAddPermission($user_role, $app_id);


		$strCondition = "(start_date<=NOW() || start_date='0000-00-00 00:00:00' || start_date IS NULL) AND (end_date>=NOW() || end_date='0000-00-00 00:00:00' || end_date IS NULL) ";
		$strCondition = "";

		$supersql = "";
		if (!$this->pAdmin) {
			$supersql = " AND trn_line_message.status=1";
		}

		$conn = Yii::$app->db;
		$params = array();

		/*
		mas_ssobranch.ssobranch_code,
		mas_ssobranch.NAME,
		*/

		$sqlwhere = "";
		//if($this->search != ''){	
		$keyword = $this->search;
		$sqlwhere .= "  (trn_line_message.subject LIKE :subject OR trn_line_message.message LIKE :message ) ";
		$keyword = addcslashes($keyword, '%_');
		$params[':subject'] = "%$keyword%";
		$params[':message'] = "%$keyword%";
		//}


		$sql = "SET @rownum := 0;";
		$command = $conn->createCommand($sql)->execute();
		$sql = "
			SELECT
				COUNT(*) AS ct
			FROM
			trn_line_message 
			WHERE " . $strCondition . $sqlwhere . $supersql . " /*AND trn_line_message.status=1*/";

		$command = Yii::$app->db->createCommand($sql);
		foreach ($params as $key => $value) {
			$command->bindValue($key, $value);
		}
		$rows = $command->queryAll();;
		$noOfRecords =  $rows[0]['ct'];


		$sql = "SET @rownum := 0;";
		$command = $conn->createCommand($sql)->execute();
		$sql = "
			SELECT * FROM (
				SELECT
					@rownum := @rownum + 1 AS NUMBER,
					trn_line_message.id ,
					trn_line_message.subject,
					trn_line_message.message,
					trn_line_message.section_type,
					trn_line_message.status
				FROM
				trn_line_message 
				WHERE " . $strCondition . $sqlwhere . $supersql . " /*AND trn_line_message.status=1*/ 
				ORDER BY
				trn_line_message.id DESC
					LIMIT :rowstart, :recordsPerPage 
			) AS TBL
		";

		$params[":rowstart"] = $this->start;

		if ((int)$this->recordsPerPage == -1) {
			$params[":recordsPerPage"] = (int)$noOfRecords;
		} else {
			$params[":recordsPerPage"] = $this->recordsPerPage;
		}

		$command = Yii::$app->db->createCommand($sql);
		foreach ($params as $key => $value) {
			$command->bindValue($key, $value);
		}

		$rows = $command->queryAll();
		$arr = array();

		$folder = Yii::$app->params['prg_ctrl']['url']['baseurl'] . '/uploads/cover';
		foreach ($rows as $dataitem) {

			$strswitch = "";
			$btnDefault = "";
			$btnpush = "";
			if ($isAddmin == 1 && $this->pAdmin) {
				$strswitch = '
				<div class="col-md-2 mr-auto">
					<input type="checkbox" class="switch" data-color="#17b3a3" id="input' . $dataitem["id"] . '" name="input' . $dataitem["id"] . '" data-id="' . $dataitem["id"] . '" data-status="' . $dataitem["status"] . '"  data-plugin="switchery" ' . ($dataitem["status"] == 1 ? "checked" : "") . '/>
				</div>
			';
				$strbtn = '
				<button type="button" class="btn btn-icon btn-success" onclick="ajax_sendmessage(this,' . $dataitem["id"] . ');" title="โพสข้อความลงในไลน์"><i class="icon fa-send-o" aria-hidden="true"></i></button>					
				<div class="btn-group" role="group">					
					<button type="button" class="btn btn-icon btn-info waves-effect waves-classic" onclick="window.open(\'' . Yii::$app->params['prg_ctrl']['domain'] . '/line/message/' . $dataitem['id'] . '\', \'_blank\');" title="แก้ไข"><i class="icon md-edit" aria-hidden="true"></i></button>
				</div>
				<button type="button" class="btn btn-icon btn-danger" onclick="ajax_deldata(this,' . $dataitem["id"] . ');" title="ลบข้อมูล"><i class="fa fa-trash" aria-hidden="true"></i></button>					
			';


				//$dataitem['switch'] = $strswitch;

			} else {
				$strbtn = '
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-icon btn-info" onclick="window.open(\'' . Yii::$app->params['prg_ctrl']['domain'] . '/line/message/' . $dataitem['id'] . '\', \'_blank\');" title="โหวต"><i class="icon fa-eye" aria-hidden="true"></i></button>					
				</div>
			';
			}

			$str_section_type = "";
			switch ($dataitem["section_type"]) {
				case "1":
					$str_section_type = "มาตรา 33";
					break;
				case "2":
					$str_section_type = "มาตรา 39";
					break;
				case "3":
					$str_section_type = "มาตรา 40";
					break;
				default:
					echo "";
			}

			$dataitem['section_name'] = $str_section_type;
			//$dataitem['btn_line'] = $btnpush . $btnDefault;
			$dataitem['btn'] = $strbtn;
			unset($dataitem['section_type']);
			unset($dataitem['status']);
			$arr[] = array_values($dataitem);
		}

		$jsondata = json_encode($arr, JSON_HEX_APOS);
		unset($params[":rowstart"]);
		unset($params[":recordsPerPage"]);

		echo '{"recordsTotal":' . $noOfRecords . ', "recordsFiltered":' . $noOfRecords . ', "data":' . $jsondata . '}';
	}


	public function savepdpa()
	{
		$createby = !Yii::$app->user->isGuest ? Yii::$app->user->getId() : 0;
		$conn = Yii::$app->db;
		$transaction = $conn->beginTransaction();
		try {
			$sql = "INSERT INTO mas_pdpa (text, edition, create_by, create_date )
			 VALUE(:text, (SELECT IFNULL(MAX(edition) + 1,1) FROM mas_pdpa pa), '{$createby}', NOW())";

			$command = $conn->createCommand($sql);
			$command->bindValue(":text", $this->body);
			$command->execute();

			$id = $conn->getLastInsertID();

			$transaction->commit();
			Yii::$app->session['success_savepdpa'] = Yii::$app->urlManager->createAbsoluteUrl("line/pdpa") . '/' . $id;
			Yii::$app->session['success_sevepdpa_id'] = $id;

			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			Yii::$app->session['errmsg_savepdpa'] = 'error ' . $e->getMessage();
			return false;
		}
	}

	public function editpdpa()
	{
		$createby = !Yii::$app->user->isGuest ? Yii::$app->user->getId() : 0;
		$conn = Yii::$app->db;
		$transaction = $conn->beginTransaction();
		try {
			$sql = "UPDATE mas_pdpa SET text=:text, update_by='{$createby}', update_date=NOW() 
			 WHERE id=:id";

			$command = $conn->createCommand($sql);
			$command->bindValue(":text", $this->body);
			$command->bindValue(":id", $this->id);
			$command->execute();

			$transaction->commit();
			Yii::$app->session['success_editpdpa'] = Yii::$app->urlManager->createAbsoluteUrl("line/pdpa") . '/' . $this->id;
			Yii::$app->session['success_editpdpa_id'] = $this->id;

			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			Yii::$app->session['errmsg_editpdpa'] = 'error ' . $e->getMessage();
			return false;
		}
	}

	public function Listpdpa()
	{
		$cwebuser = new CustomWebUser();
		$user_id = Yii::$app->user->getId();
		//$ssobranch_code = Yii::$app->user->getInfo("ssobranch_code");
		$ssobranch_code = $cwebuser->getInfo("ssobranch_code");

		$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['cms'];

		$data = lkup_user::getUserPermission($user_id, $app_id, $ssobranch_code);
		$user_role = $data[0]["user_role"];
		$isAddmin = lkup_data::chkAddPermission($user_role, $app_id);


		$strCondition = "(start_date<=NOW() || start_date='0000-00-00 00:00:00' || start_date IS NULL) AND (end_date>=NOW() || end_date='0000-00-00 00:00:00' || end_date IS NULL) ";
		$strCondition = "";

		$supersql = "";
		if (!$this->pAdmin) {
			$supersql = " AND mas_pdpa.status=1";
		}

		$conn = Yii::$app->db;
		$params = array();

		/*
		mas_ssobranch.ssobranch_code,
		mas_ssobranch.NAME,
		*/

		$sqlwhere = "";
		//if($this->search != ''){	
		$keyword = $this->search;
		$sqlwhere .= "  (mas_pdpa.text LIKE :text OR mas_pdpa.edition LIKE :edition ) ";
		$keyword = addcslashes($keyword, '%_');
		$params[':text'] = "%$keyword%";
		$params[':edition'] = "%$keyword%";
		//}


		$sql = "SET @rownum := 0;";
		$command = $conn->createCommand($sql)->execute();
		$sql = "
			SELECT
				COUNT(*) AS ct
			FROM
			mas_pdpa 
			WHERE " . $strCondition . $sqlwhere . $supersql . " /*AND mas_pdpa.status=1*/";

		$command = Yii::$app->db->createCommand($sql);
		foreach ($params as $key => $value) {
			$command->bindValue($key, $value);
		}
		$rows = $command->queryAll();;
		$noOfRecords =  $rows[0]['ct'];


		$sql = "SET @rownum := 0;";
		$command = $conn->createCommand($sql)->execute();
		$sql = "
			SELECT * FROM (
				SELECT
					@rownum := @rownum + 1 AS NUMBER,
					mas_pdpa.id ,
					mas_pdpa.text,
					mas_pdpa.edition,
					mas_pdpa.status
				FROM
				mas_pdpa 
				WHERE " . $strCondition . $sqlwhere . $supersql . " /*AND mas_pdpa.status=1*/ 
				ORDER BY
				mas_pdpa.id DESC
					LIMIT :rowstart, :recordsPerPage 
			) AS TBL
		";

		$params[":rowstart"] = $this->start;

		if ((int)$this->recordsPerPage == -1) {
			$params[":recordsPerPage"] = (int)$noOfRecords;
		} else {
			$params[":recordsPerPage"] = $this->recordsPerPage;
		}

		$command = Yii::$app->db->createCommand($sql);
		foreach ($params as $key => $value) {
			$command->bindValue($key, $value);
		}

		$rows = $command->queryAll();
		$arr = array();

		$folder = Yii::$app->params['prg_ctrl']['url']['baseurl'] . '/uploads/cover';
		foreach ($rows as $dataitem) {

			$strswitch = "";
			$btnDefault = "";
			$btnpush = "";
			if ($isAddmin == 1 && $this->pAdmin) {
				$strswitch = '
				<div class="col-md-2 mr-auto">
					<input type="checkbox" class="switch" data-color="#17b3a3" id="input' . $dataitem["id"] . '" name="input' . $dataitem["id"] . '" data-id="' . $dataitem["id"] . '" data-status="' . $dataitem["status"] . '"  data-plugin="switchery" ' . ($dataitem["status"] == 1 ? "checked" : "") . '/>
				</div>
			';
				$strbtn = '				
				<div class="btn-group" role="group">					
					<button type="button" class="btn btn-icon btn-info waves-effect waves-classic" onclick="window.open(\'' . Yii::$app->params['prg_ctrl']['domain'] . '/line/pdpa/' . $dataitem['id'] . '\', \'_blank\');" title="แก้ไข"><i class="icon md-edit" aria-hidden="true"></i></button>
				</div>
				<button type="button" class="btn btn-icon btn-danger" onclick="ajax_deldata(this,' . $dataitem["id"] . ');" title="ลบข้อมูล"><i class="fa fa-trash" aria-hidden="true"></i></button>					
			';


				//$dataitem['switch'] = $strswitch;

			} else {
				$strbtn = '
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-icon btn-info" onclick="window.open(\'' . Yii::$app->params['prg_ctrl']['domain'] . '/line/message/' . $dataitem['id'] . '\', \'_blank\');" title="โหวต"><i class="icon fa-eye" aria-hidden="true"></i></button>					
				</div>
			';
			}

			//$dataitem['btn_line'] = $btnpush . $btnDefault;
			$dataitem['text'] = mb_strimwidth(strip_tags($dataitem['text']), 0, 200, "...");
			$dataitem['btn'] = $strbtn;

			$strswitch = '
				<div class="col-md-2 mr-auto">
				<input type="checkbox" class="switch customswitchery" data-color="#17b3a3" id="input' . $dataitem["id"] . '" name="input' . $dataitem["id"] . '" data-id="' . $dataitem["id"] . '" data-status="' . $dataitem["status"] . '"  data-plugin="switchery" ' . ($dataitem["status"] == 1 ? "checked" : "") . ' title="ไอคอน new" />
				</div>
			';
			$dataitem['status'] = $strswitch;
			$arr[] = array_values($dataitem);
		}

		$jsondata = json_encode($arr, JSON_HEX_APOS);
		unset($params[":rowstart"]);
		unset($params[":recordsPerPage"]);

		\Yii::$app->response->data = '{"recordsTotal":' . $noOfRecords . ', "recordsFiltered":' . $noOfRecords . ', "data":' . $jsondata . '}';
	}

	public $status;
	public function Edit_pdpastatus()
	{
		try {

			$createby = Yii::$app->user->getId();

			$conn = Yii::$app->db;
			$transaction = $conn->beginTransaction();

			$sql = "UPDATE mas_pdpa SET status='0', update_by=$createby, update_date=NOW() ";
			$sql = "UPDATE mas_pdpa SET status='0' ";
			$command = $conn->createCommand($sql)->execute();

			$sql = "UPDATE mas_pdpa SET status=:status, update_by=$createby, update_date=NOW() WHERE id=:id ";
			$command = $conn->createCommand($sql);
			$command->bindValue(":status", $this->status);
			$command->bindValue(":id", $this->id);
			$command->execute();

			$transaction->commit();

			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			Yii::$app->session['errmsg_pdpastatus'] = 'error ' . $e->getMessage();

			return false;
		}
	}
	public function Delete_pdpa()
	{
		try {
			$conn = Yii::$app->db;

			$sql = "
			SELECT * FROM trn_pdpa WHERE trn_pdpa.`id_pdpa`=:id_pdpa
  			";
			$rchk = $conn->createCommand($sql)->bindValue('id_pdpa', $this->id)->queryAll();
			if (count($rchk) != 0) {
				Yii::$app->session['errmsg_pdpa'] = 'error ' . "ข้อความ PDPA มีการเปิดเผยและมีผู้ใช้งานกดยอมรับไปแล้วไม่สามารถลบได้";
				return false;
			}

			$transaction = $conn->beginTransaction();

			$sql = "DELETE FROM mas_pdpa WHERE mas_pdpa.id=:id ";
			$command = $conn->createCommand($sql);
			$command->bindValue(":id", $this->id);
			$command->execute();

			$transaction->commit();

			return true;
		} catch (\Exception $e) {

			$transaction->rollBack();
			Yii::$app->session['errmsg_pdpa'] = 'error ' . $e->getMessage();
			return false;
		}
	}

	public function Listnotifyapi()
	{
		$cwebuser = new CustomWebUser();
		$user_id = Yii::$app->user->getId();
		//$ssobranch_code = Yii::$app->user->getInfo("ssobranch_code");
		$ssobranch_code = $cwebuser->getInfo("ssobranch_code");

		$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['cms'];

		$data = lkup_user::getUserPermission($user_id, $app_id, $ssobranch_code);
		$user_role = $data[0]["user_role"];
		$isAddmin = lkup_data::chkAddPermission($user_role, $app_id);


		$strCondition = "(start_date<=NOW() || start_date='0000-00-00 00:00:00' || start_date IS NULL) AND (end_date>=NOW() || end_date='0000-00-00 00:00:00' || end_date IS NULL) ";
		$strCondition = "";

		$supersql = "";
		if (!$this->pAdmin) {
			$supersql = " AND trn_notifications.status=1";
		}

		$conn = Yii::$app->db;
		$params = array();

		/*
		mas_ssobranch.ssobranch_code,
		mas_ssobranch.NAME,
		*/

		$sqlwhere = "";
		//if($this->search != ''){	
		$keyword = $this->search;
		$sqlwhere .= "  (trn_notifications.subject LIKE :subject OR trn_notifications.message LIKE :message ) ";
		$keyword = addcslashes($keyword, '%_');
		$params[':subject'] = "%$keyword%";
		$params[':message'] = "%$keyword%";
		//}


		$sql = "SET @rownum := 0;";
		$command = $conn->createCommand($sql)->execute();
		$sql = "
			SELECT
				COUNT(*) AS ct
			FROM
			trn_notifications 
			WHERE " . $strCondition . $sqlwhere . $supersql . " /*AND trn_notifications.status=1*/";

		$command = Yii::$app->db->createCommand($sql);
		foreach ($params as $key => $value) {
			$command->bindValue($key, $value);
		}
		$rows = $command->queryAll();;
		$noOfRecords =  $rows[0]['ct'];


		$sql = "SET @rownum := 0;";
		$command = $conn->createCommand($sql)->execute();
		$sql = "
			SELECT * FROM (
				SELECT
					@rownum := @rownum + 1 AS NUMBER,
					trn_notifications.id ,
					trn_notifications.subject,
					trn_notifications.section_type,
					trn_notifications.ssobranch,
					trn_notifications.push_status
				FROM
				trn_notifications 
				WHERE " . $strCondition . $sqlwhere . $supersql . " /*AND trn_notifications.status=1*/ 
				ORDER BY
				trn_notifications.id DESC
					LIMIT :rowstart, :recordsPerPage 
			) AS TBL
		";

		$params[":rowstart"] = $this->start;

		if ((int)$this->recordsPerPage == -1) {
			$params[":recordsPerPage"] = (int)$noOfRecords;
		} else {
			$params[":recordsPerPage"] = $this->recordsPerPage;
		}

		$command = Yii::$app->db->createCommand($sql);
		foreach ($params as $key => $value) {
			$command->bindValue($key, $value);
		}

		$rows = $command->queryAll();
		$arr = array();

		$folder = Yii::$app->params['prg_ctrl']['url']['baseurl'] . '/uploads/cover';
		foreach ($rows as $dataitem) {

			$strswitch = "";
			$btnDefault = "";
			$btnpush = "";
			if ($isAddmin == 1 && $this->pAdmin) {
				/*
				$strswitch = '
				<div class="col-md-2 mr-auto">
					<input type="checkbox" class="switch" data-color="#17b3a3" id="input' . $dataitem["id"] . '" name="input' . $dataitem["id"] . '" data-id="' . $dataitem["id"] . '" data-status="' . $dataitem["status"] . '"  data-plugin="switchery" ' . ($dataitem["status"] == 1 ? "checked" : "") . '/>
				</div>
			';
			*/
				$strbtn = '				
				<div class="btn-group" role="group">					
					<button type="button" class="btn btn-icon btn-info waves-effect waves-classic" onclick="window.open(\'' . Yii::$app->params['prg_ctrl']['domain'] . '/line/notifyapi/' . $dataitem['id'] . '\', \'_blank\');" title="แก้ไข"><i class="icon md-edit" aria-hidden="true"></i></button>
				</div>
				<button type="button" class="btn btn-icon btn-danger" onclick="ajax_deldata(this,' . $dataitem["id"] . ');" title="ลบข้อมูล"><i class="fa fa-trash" aria-hidden="true"></i></button>					
			';


				//$dataitem['switch'] = $strswitch;

			} else {
				$strbtn = '
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-icon btn-info" onclick="window.open(\'' . Yii::$app->params['prg_ctrl']['domain'] . '/line/notifyapi/' . $dataitem['id'] . '\', \'_blank\');" title="โหวต"><i class="icon fa-eye" aria-hidden="true"></i></button>					
				</div>
			';
			}

			$sql = "SELECT GROUP_CONCAT(name SEPARATOR ' + ') AS sec_name FROM mas_section WHERE id IN (" . $dataitem["section_type"] . "); ";
			$command = $conn->createCommand($sql);
			$rssec = $command->queryAll();
			if (count($rssec) > 0) {
				$dataitem['section_type'] = $rssec[0]['sec_name'];
			} else {
				$dataitem['section_type'] = "";
			}

			$sql = "SELECT GROUP_CONCAT(NAME SEPARATOR ' + ') AS branch_name FROM mas_ssobranch WHERE ssobranch_code IN (" . $dataitem["ssobranch"] . "); ";
			$command = $conn->createCommand($sql);
			$rssec = $command->queryAll();
			if (count($rssec) > 0) {
				$dataitem['ssobranch'] = $rssec[0]['branch_name'];
			} else {
				$dataitem['ssobranch'] = "";
			}

			//$dataitem['btn_line'] = $btnpush . $btnDefault;
			$dataitem['subject'] = mb_strimwidth(strip_tags($dataitem['subject']), 0, 200, "...");
			$dataitem['btn'] = $strbtn;
			/*
			$strswitch = '
				<div class="col-md-2 mr-auto">
				<input type="checkbox" class="switch customswitchery" data-color="#17b3a3" id="input' . $dataitem["id"] . '" name="input' . $dataitem["id"] . '" data-id="' . $dataitem["id"] . '" data-status="' . $dataitem["status"] . '"  data-plugin="switchery" ' . ($dataitem["status"] == 1 ? "checked" : "") . ' title="ไอคอน new" />
				</div>
			';
			*/
			if ($dataitem["push_status"] == 0) {
				$btnpush = '
				<button type="button" class="btn btn-icon btn-success" onclick="ajax_push(this,' . $dataitem["id"] . ');" title="Push ไปที่กล่องข้อความ"><i class="icon fa-send-o" aria-hidden="true"></i></button>
				';
			} else {
				$btnpush = '
				<button type="button" class="btn btn-icon btn-success" title="Push ไปที่กล่องข้อความแล้ว" disabled ><i class="icon fa-send-o" aria-hidden="true"></i></button>					
				';
			}
			$dataitem['push_status'] = $btnpush;
			$arr[] = array_values($dataitem);
		}

		$jsondata = json_encode($arr, JSON_HEX_APOS);
		unset($params[":rowstart"]);
		unset($params[":recordsPerPage"]);

		\Yii::$app->response->data = '{"recordsTotal":' . $noOfRecords . ', "recordsFiltered":' . $noOfRecords . ', "data":' . $jsondata . '}';
	}

	public function Listoverduenotify()
	{
		$cwebuser = new CustomWebUser();
		$user_id = Yii::$app->user->getId();
		//$ssobranch_code = Yii::$app->user->getInfo("ssobranch_code");
		$ssobranch_code = $cwebuser->getInfo("ssobranch_code");

		$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['cms'];

		$data = lkup_user::getUserPermission($user_id, $app_id, $ssobranch_code);
		$user_role = $data[0]["user_role"];
		$isAddmin = lkup_data::chkAddPermission($user_role, $app_id);


		$strCondition = "(start_date<=NOW() || start_date='0000-00-00 00:00:00' || start_date IS NULL) AND (end_date>=NOW() || end_date='0000-00-00 00:00:00' || end_date IS NULL) ";
		$strCondition = "";

		$supersql = "";
		if (!$this->pAdmin) {
			$supersql = " AND trn_m39notifications.status=1";
		}

		$conn = Yii::$app->db;
		$params = array();

		/*
		mas_ssobranch.ssobranch_code,
		mas_ssobranch.NAME,
		*/

		$sqlwhere = "";
		//if($this->search != ''){	
		$keyword = $this->search;
		$sqlwhere .= "  (trn_m39notifications.notitext LIKE :notitext ) ";
		$keyword = addcslashes($keyword, '%_');
		$params[':notitext'] = "%$keyword%";

		//}


		$sql = "SET @rownum := 0;";
		$command = $conn->createCommand($sql)->execute();
		$sql = "
			SELECT
				COUNT(*) AS ct
			FROM
			trn_m39notifications 
			WHERE " . $strCondition . $sqlwhere . $supersql . " /*AND trn_m39notifications.status=1*/";

		$command = Yii::$app->db->createCommand($sql);
		foreach ($params as $key => $value) {
			$command->bindValue($key, $value);
		}
		$rows = $command->queryAll();;
		$noOfRecords =  $rows[0]['ct'];


		$sql = "SET @rownum := 0;";
		$command = $conn->createCommand($sql)->execute();
		$sql = "
			SELECT * FROM (
				SELECT
					@rownum := @rownum + 1 AS NUMBER,
					trn_m39notifications.id ,
					'1/10/2564' as 'monthyear',
					33 as '33',
					trn_m39notifications.importno,
					trn_m39notifications.exportno,
					40 as '40',
					39 as '39',
					'9999' as 'ALL'
				FROM
				trn_m39notifications 
				WHERE " . $strCondition . $sqlwhere . $supersql . " /*AND trn_m39notifications.status=1*/ 
				ORDER BY
				trn_m39notifications.id DESC
					LIMIT :rowstart, :recordsPerPage 
			) AS TBL
		";

		$params[":rowstart"] = $this->start;

		if ((int)$this->recordsPerPage == -1) {
			$params[":recordsPerPage"] = (int)$noOfRecords;
		} else {
			$params[":recordsPerPage"] = $this->recordsPerPage;
		}

		$command = Yii::$app->db->createCommand($sql);
		foreach ($params as $key => $value) {
			$command->bindValue($key, $value);
		}

		$rows = $command->queryAll();
		$arr = array();

		$folder = Yii::$app->params['prg_ctrl']['url']['baseurl'] . '/uploads/cover';
		foreach ($rows as $dataitem) {

			$strswitch = "";
			$btnDefault = "";
			$btnpush = "";



			//$dataitem['notitype'] = "";

			//$dataitem['btn_line'] = $btnpush . $btnDefault;
			$dataitem['monthyear'] = mb_strimwidth(strip_tags($dataitem['monthyear']), 0, 200, "...");

			/*
			$strswitch = '
				<div class="col-md-2 mr-auto">
				<input type="checkbox" class="switch customswitchery" data-color="#17b3a3" id="input' . $dataitem["id"] . '" name="input' . $dataitem["id"] . '" data-id="' . $dataitem["id"] . '" data-status="' . $dataitem["status"] . '"  data-plugin="switchery" ' . ($dataitem["status"] == 1 ? "checked" : "") . ' title="ไอคอน new" />
				</div>
			';
			*/

			$arr[] = array_values($dataitem);
		}

		$jsondata = json_encode($arr, JSON_HEX_APOS);
		unset($params[":rowstart"]);
		unset($params[":recordsPerPage"]);

		\Yii::$app->response->data = '{"recordsTotal":' . $noOfRecords . ', "recordsFiltered":' . $noOfRecords . ', "data":' . $jsondata . '}';
	}

	public $uid;
	public $upassword;
	public $firstName;
	public $lastName;
	public $branchcode;

	public function Check_sso_user()
	{

		$sql = "SELECT su_id FROM mas_sso_user WHERE su_idcard=:su_idcard ";
		$rows = Yii::$app->db->createCommand($sql)->bindValue(':su_idcard', $this->uid)->queryAll();

		return $rows;
	}

	public function Add_sso_user()
	{

		try {
			$createby = !Yii::$app->user->isGuest ? Yii::$app->user->id : 0;

			$conn = Yii::$app->db;
			$transaction = $conn->beginTransaction();

			$encryption_key = Yii::$app->params['auth']['crypter']['encryption_key'];
			$ePassword = utf8_encode(Yii::$app->getSecurity()->encryptByPassword($this->upassword, $encryption_key)); //echo $ePassword;exit;

			$sql = "INSERT INTO mas_sso_user (su_firstname, su_lastname, su_idcard, password, createdate) VALUES(:su_firstname, :su_lastname, :su_idcard, :password, now())";

			$command = $conn->createCommand($sql);
			$command->bindValue(":su_firstname", $this->firstName);
			$command->bindValue(":su_lastname", $this->lastName);
			$command->bindValue(":su_idcard", $this->uid);
			$command->bindValue(":password", $ePassword);
			$command->execute();
			$uid_no = $conn->getLastInsertID();

			// อัพเดตมาตราปัจจุบัน
			/*$sql = "INSERT INTO tran_ssoid (id_sso, ssobranch_code, section_id, createdate) VALUES(:id_sso, :ssobranch_code, :section_id, now())";
			$command = $conn->createCommand($sql);
			$command->bindValue(":id_sso", $uid_no);
			$command->bindValue(":ssobranch_code", 1000);
			$command->bindValue(":section_id", $this->section);
			$command->execute();*/
			//$this->updatesection($uid_no, 1000, $this->section);

			if (!$this->updatesection($uid_no, $this->branchcode, $this->section)) {
				throw new \Exception("Fails update Section" . $this->section);
			}			

			// อัพเดต Line ID
			/*$sql = "INSERT INTO tran_line_id (li_user_id, li_line_id, li_img, createdate) VALUES(:li_user_id, :li_line_id, :li_img, now())";
			$command = $conn->createCommand($sql);
			$command->bindValue(":li_user_id", $uid_no);
			$command->bindValue(":li_line_id", $this->lineID);
			$command->bindValue(":li_img", $this->lineImage);
			$command->execute();*/
			//$this->updatelineid($uid_no, $this->lineID, $this->lineImage);

			if (!$this->updatelineid($uid_no, $this->lineID, $this->lineImage)) {
				throw new \Exception("Fails update Lineid");
			}

			$transaction->commit();
			return $uid_no;
		} catch (\Exception $e) {

			$transaction->rollBack();
			Yii::$app->session['errmsg_adduser'] = 'error ' . $e->getMessage();
			return false;
		}
	}

	private function updatesection($id_sso, $ssobranch_code, $section)
	{
		// อัพเดตมาตราปัจจุบัน
		try {
			$conn = Yii::$app->db;
			$sql = "SELECT * FROM tran_ssoid WHERE id_sso=:id_sso";
			$command = $conn->createCommand($sql);
			$command->bindValue(":id_sso", $id_sso);
			$rs = $command->queryAll();
			if (count($rs) > 0) {
				$sql = "UPDATE tran_ssoid SET ssobranch_code=:ssobranch_code, section_id=:section_id, updatedate=now() WHERE id_sso=:id_sso";
				$command = $conn->createCommand($sql);
				$command->bindValue(":ssobranch_code", $ssobranch_code);
				$command->bindValue(":section_id", $section);
				$command->bindValue(":id_sso", $id_sso);
				$command->execute();
			} else {
				$sql = "INSERT INTO tran_ssoid (id_sso, ssobranch_code, section_id, createdate) VALUES(:id_sso, :ssobranch_code, :section_id, now())";
				$command = $conn->createCommand($sql);
				$command->bindValue(":id_sso", $id_sso);
				$command->bindValue(":ssobranch_code", $ssobranch_code);
				$command->bindValue(":section_id", $section);
				$command->execute();
			}
			return TRUE;
		} catch (\Throwable $th) {
			return FALSE;
		}
	}

	private function updatelineid($id_sso, $lineID, $lineImage)
	{
		
		// อัพเดต Line ID
		try {
			$conn = Yii::$app->db;
			$sql = "SELECT * FROM tran_line_id WHERE li_user_id=:li_user_id";
			$command = $conn->createCommand($sql);
			$command->bindValue(":li_user_id", $id_sso);
			$rs = $command->queryAll();
			$rs = $command->queryAll();
			if (count($rs) > 0) {
				$sql = "UPDATE tran_line_id SET li_line_id=:li_line_id, li_img=:li_img, updatedate=now() WHERE li_user_id=:li_user_id";
				$command = $conn->createCommand($sql);
				$command->bindValue(":li_line_id", $lineID);
				$command->bindValue(":li_img", $lineImage);
				$command->bindValue(":li_user_id", $id_sso);
				$command->execute();
			} else {
				$sql = "INSERT INTO tran_line_id (li_user_id, li_line_id, li_img, createdate) VALUES(:li_user_id, :li_line_id, :li_img, now())";
				$command = $conn->createCommand($sql);
				$command->bindValue(":li_user_id", $id_sso);
				$command->bindValue(":li_line_id", $lineID);
				$command->bindValue(":li_img", $lineImage);
				$command->execute();
			}
			return TRUE;
		} catch (\Throwable $th) {
			return FALSE;
		}
	}

	public $lineID;
	public $lineImage;

	public function update_sso_user()
	{

		try {
			$createby = !Yii::$app->user->isGuest ? Yii::$app->user->id : 0;

			$conn = Yii::$app->db;
			$transaction = $conn->beginTransaction();

			$encryption_key = Yii::$app->params['auth']['crypter']['encryption_key'];
			$ePassword = utf8_encode(Yii::$app->getSecurity()->encryptByPassword($this->upassword, $encryption_key)); 

			//$data = Yii::$app->getSecurity()->decryptByPassword(utf8_decode($ePassword), $encryption_key); echo $data;exit;

			$sql = "UPDATE mas_sso_user SET su_firstname=:su_firstname, su_lastname=:su_lastname, password=:password, updatedate=NOW() WHERE su_idcard=:su_idcard";

			$command = $conn->createCommand($sql);
			$command->bindValue(":su_firstname", $this->firstName);
			$command->bindValue(":su_lastname", $this->lastName);
			$command->bindValue(":password", $ePassword);
			$command->bindValue(":su_idcard", $this->uid);
			$command->execute();

			// อัพเดตมาตราปัจจุบัน
			/*
			$sql = "SELECT * FROM tran_ssoid WHERE id_sso=:id_sso";
			$command = $conn->createCommand($sql);
			$command->bindValue(":id_sso", $this->uid_no);
			$rs = $command->queryAll();
			if (count($rs) > 0) {
				$sql = "UPDATE tran_ssoid SET ssobranch_code=:ssobranch_code, section_id=:section_id, updatedate=now() WHERE id_sso=:id_sso";
				$command = $conn->createCommand($sql);
				$command->bindValue(":ssobranch_code", 1000);
				$command->bindValue(":section_id", $this->section);
				$command->bindValue(":id_sso", $this->uid_no);
				$command->execute();
			} else {
				$sql = "INSERT INTO tran_ssoid (id_sso, ssobranch_code, section_id, createdate) VALUES(:id_sso, :ssobranch_code, :section_id, now())";
				$command = $conn->createCommand($sql);
				$command->bindValue(":id_sso", $this->uid_no);
				$command->bindValue(":ssobranch_code", 1000);
				$command->bindValue(":section_id", $this->section);
				$command->execute();
			}*/

			if (!$this->updatesection($this->uid_no, $this->branchcode, $this->section)) {
				throw new \Exception("Fails update Section" . $this->section);
			}

			// อัพเดต Line ID
			/*
			$sql = "SELECT * FROM tran_line_id WHERE li_user_id=:li_user_id";
			$command = $conn->createCommand($sql);
			$command->bindValue(":li_user_id", $this->uid_no);
			$rs = $command->queryAll();
			$rs = $command->queryAll();
			if (count($rs) > 0) {
				$sql = "UPDATE tran_line_id SET li_line_id=:li_line_id, li_img=:li_img, updatedate=now() WHERE li_user_id=:li_user_id";
				$command = $conn->createCommand($sql);
				$command->bindValue(":li_line_id", $this->lineID);
				$command->bindValue(":li_img", $this->lineImage);
				$command->bindValue(":li_user_id", $this->uid_no);
				$command->execute();
			} else {
				$sql = "INSERT INTO tran_line_id (li_user_id, li_line_id, li_img, createdate) VALUES(:li_user_id, :li_line_id, :li_img, now())";
				$command = $conn->createCommand($sql);
				$command->bindValue(":li_user_id", $this->uid_no);
				$command->bindValue(":li_line_id", $this->lineID);
				$command->bindValue(":li_img", $this->lineImage);
				$command->execute();
			}*/

			if (!$this->updatelineid($this->uid_no, $this->lineID, $this->lineImage)) {
				throw new \Exception("Fails update Lineid");
			}

			$transaction->commit();

			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			Yii::$app->session['errmsg_adduser'] = 'error ' . $e->getMessage();
			return false;
		}
	}

	public $access_token;
	public $expires_in;
	public $refresh_token;
	public $refresh_expires_in;
	public $uid_no;
	public function sso_user_setloginstate()
	{
		try {
			$createby = !Yii::$app->user->isGuest ? Yii::$app->user->id : 0;

			$conn = Yii::$app->db;
			$transaction = $conn->beginTransaction();

			$sql = "
				INSERT INTO tran_ssoid_state(id_sso, access_token, createdate, access_token_expire, refresh_token, refresh_token_expire) 
				VALUES(:id_sso, :access_token, now(), INTERVAL :access_token_expire SECOND, :refresh_token, INTERVAL :refresh_token_expire SECOND))
			";

			// ตรวจสอบ Token
			$sql = "SELECT id_sso FROM tran_ssoid_state WHERE id_sso=:id_sso";
			$command = $conn->createCommand($sql);
			$command->bindValue(":id_sso", $this->uid_no);
			$rs = $command->queryAll();
			if (count($rs) > 0) {
				$sql = "
				UPDATE
					tran_ssoid_state
					SET
					access_token = :access_token,
					createdate = NOW(),
					access_token_expire = NOW() + INTERVAL :access_token_expire SECOND,
					refresh_token = :refresh_token,
					refresh_token_expire = NOW() + INTERVAL :refresh_token_expire SECOND
					WHERE id_sso = :id_sso;
				";
				$command = $conn->createCommand($sql);
				$command->bindValue(":access_token", $this->access_token);
				$command->bindValue(":access_token_expire", $this->expires_in);
				$command->bindValue(":refresh_token", $this->refresh_token);
				$command->bindValue(":refresh_token_expire", $this->refresh_expires_in);
				$command->bindValue(":id_sso", $this->uid_no);
				$command->execute();
			} else {
				$sql = "
				INSERT INTO
				tran_ssoid_state(
					id_sso,
					access_token,
					createdate,
					access_token_expire,
					refresh_token,
					refresh_token_expire
				)
				VALUES(
					:id_sso,
					:access_token,
					NOW(),
					NOW() + INTERVAL :access_token_expire SECOND,
					:refresh_token,
					NOW() + INTERVAL :refresh_token_expire SECOND
				)
				";

				$command = $conn->createCommand($sql);
				$command->bindValue(":id_sso", $this->uid_no);
				$command->bindValue(":access_token", $this->access_token);
				$command->bindValue(":access_token_expire", $this->expires_in);
				$command->bindValue(":refresh_token", $this->refresh_token);
				$command->bindValue(":refresh_token_expire", $this->refresh_expires_in);
				$command->execute();
			}



			$transaction->commit();

			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			Yii::$app->session['setloginstate'] = 'error ' . $e->getMessage();
			return false;
		}
	}
	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'verifyCode' => 'Verification Code',
		);
	}
}
