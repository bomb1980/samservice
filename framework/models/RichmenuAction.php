<?php

namespace app\models;

use Yii;

use app\components\CustomWebUser;


class RichmenuAction
{
	public $menu_id;
	public $menu_name;
	public $menu_json;
	public $image_base64;
	public $id;
	public $richmenuid;
	public $userid;

	public function savemenu()
	{

		$conn = Yii::$app->db;
		$transaction = $conn->beginTransaction();
		try {
			//$createby = !Yii::$app->user->isGuest?Yii::$app->user->id:0;
			//$ssobranch_code = 1051;	
			$createby = Yii::$app->user->getId();

			$sql = "INSERT INTO trn_richmenu (description, img, menudata, create_by, create_date) 
			VALUES(:description, :img, :menudata, $createby, now())";
			$command = $conn->createCommand($sql);
			$command->bindValue(":description", $this->menu_name);
			$command->bindValue(":img", $this->image_base64);
			$command->bindValue(":menudata", $this->menu_json);
			$command->execute();
			$id = $conn->getLastInsertID();

			$transaction->commit();
			Yii::$app->session['success_richmenu'] = Yii::$app->urlManager->createAbsoluteUrl("richmenu/view") . '/' . $id;
			Yii::$app->session['success_richmenu_id'] = $id;
			return true;
		} catch (Exception $e) {
			// Send error response.
			#return false;
			$transaction->rollBack();
			Yii::$app->session['errmsg_richmenu'] = 'error ' . $e->getMessage();
			return false;
			//echo $e->getMessage();
			//http_response_code(404);
		}
	}

	public function editmenu()
	{

		$conn = Yii::$app->db;
		$transaction = $conn->beginTransaction();
		try {
			$createby = !Yii::$app->user->isGuest ? Yii::$app->user->getId() : 0;
			//$ssobranch_code = 1051;	
			$cwebuser = new CustomWebUser();
			$user_id = Yii::$app->user->getId();
			$ssobranch_code = $cwebuser->getInfo("ssobranch_code");

			if ($this->image_base64 != null) {
				$sql = "UPDATE trn_richmenu SET description=:description, img=:img, menudata=:menudata, update_by=$createby, update_date=NOW() WHERE id=:id";
				$command = $conn->createCommand($sql);
				$command->bindValue(":description", $this->menu_name);
				$command->bindValue(":img", $this->image_base64);
				$command->bindValue(":menudata", $this->menu_json);
				$command->bindValue(":id", $this->id);
				$command->execute();
			} else {
				$sql = "UPDATE trn_richmenu SET description=:description, menudata=:menudata, update_by=$createby, update_date=NOW() WHERE id=:id";
				$command = $conn->createCommand($sql);
				$command->bindValue(":description", $this->menu_name);
				$command->bindValue(":menudata", $this->menu_json);
				$command->bindValue(":id", $this->id);
				$command->execute();
			}

			$transaction->commit();
			Yii::$app->session['success_richmenu'] = Yii::$app->urlManager->createAbsoluteUrl("richmenu/view") . '/' . $this->id;
			Yii::$app->session['success_richmenu_id'] = $this->id;
			return true;
		} catch (Exception $e) {
			// Send error response.
			#return false;
			$transaction->rollBack();
			Yii::$app->session['errmsg_richmenu'] = 'error ' . $e->getMessage();
			return false;
			//echo $e->getMessage();
			//http_response_code(404);
		}
	}

	public function Delete_richmenu()
	{
		try {
			$conn = Yii::$app->db;

			$sql = "
			SELECT * FROM trn_richmenu_custom_view WHERE trn_richmenu_custom_view.`menu_id`=:menu_id
  			";
			$rchk = $conn->createCommand($sql)->bindValue('menu_id', $this->id)->queryAll();
			if (count($rchk) != 0) {
				Yii::$app->session['errmsg_richmenu'] = 'error ' . "มีการใช้งานเมนูนี้แล้วไม่สามารถลบได้";
				return false;
			}

			$transaction = $conn->beginTransaction();

			$sql = "DELETE FROM trn_richmenu WHERE trn_richmenu.id=:id ";
			$command = $conn->createCommand($sql);
			$command->bindValue(":id", $this->id);
			$command->execute();

			$transaction->commit();

			return true;
		} catch (Exception $e) {

			$transaction->rollBack();
			Yii::$app->session['errmsg_richmenu'] = 'error ' . $e->getMessage();
			return false;
		}
	}


	public $setDefault;

	public function pushmenu()
	{
		$postdata = http_build_query(
			array(
				'img' => $this->image_base64,
				'setDefault' => $this->setDefault,
				'jsondata' => $this->menu_json
			)
		);


		// This will search for the word start at the beginning of the string and remove it
		$m_json =  ltrim($this->menu_json, '{');

		// This will search for the word end at the end of the string and remove it
		$m_json = rtrim($m_json, '}');

		$array = 	array(
			'img' => $this->image_base64,
			'setDefault' => $this->setDefault
		);
		echo json_encode($array);
		exit;
		$opts = array(
			'http' =>
			array(
				'method'  => 'POST',
				'header'  => 'Content-Type: application/x-www-form-urlencoded',
				'content' => $postdata
			)
		);

		$context  = stream_context_create($opts);
		var_dump($postdata);
		exit;

		$result = file_get_contents('http://116.204.183.102/api/UploadRichMenu', false, $context);
		var_dump($result);
	}

	public function pushmenuraw()
	{


		// This will search for the word start at the beginning of the string and remove it
		$m_json =  ltrim($this->menu_json, '{');

		// This will search for the word end at the end of the string and remove it
		$m_json = rtrim($m_json, '}');

		$array = array(
			'img' => $this->image_base64,
			'setDefault' => $this->setDefault
		);

		$jsonDataEncoded = rtrim(json_encode($array, JSON_UNESCAPED_SLASHES), '}') . "," . $m_json . '}';

		//echo $jsonDataEncoded;exit;

		//$json_pretty = json_encode(json_decode($jsonDataEncoded), JSON_PRETTY_PRINT); echo $json_pretty;exit;
		$json_pretty = json_encode(json_decode($jsonDataEncoded), JSON_UNESCAPED_SLASHES);
		//echo $json_pretty;
		//exit;

		//API Url
		$url = 'http://116.204.183.102/api/UploadRichMenu';
		$url = Yii::$app->params['prg_ctrl']['api']['line']['server'] . "api/UploadRichMenu";

		//Initiate cURL.
		$ch = curl_init($url);

		//Tell cURL that we want to send a POST request.
		curl_setopt($ch, CURLOPT_POST, 1);

		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json_pretty);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		//Execute the request
		$result = curl_exec($ch);

		$data = json_decode($result, true);

		$info = curl_getinfo($ch);
		curl_close($ch);

		if (substr($info['http_code'], 0, 1) === "2") {
			$data = json_decode($result, true);
			if (array_key_exists('richMenuId', $data)) {
				Yii::$app->session['success_pushrichmenu'] = $data['richMenuId'];
				return true;
			} else {
				Yii::$app->session['errmsg_pushrichmenu'] = 'error ' . $info['http_code'];
				return false;
			}
		} else {
			Yii::$app->session['errmsg_pushrichmenu'] = 'error ' . $info['http_code'];
			return false;
		}
	}

	public function getrichmenu()
	{
		//API Url
		$url = 'http://116.204.183.102/api/GetRichMenuList';
		$url = Yii::$app->params['prg_ctrl']['api']['line']['server'] . "api/GetRichMenuList";

		$ch = curl_init();
		// Set query data here with the URL
		curl_setopt($ch, CURLOPT_URL, $url);

		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 3);
		$content = curl_exec($ch);
		curl_close($ch);

		$data = json_decode($content, true);

		echo "<pre>";
		print_r($data);
		echo "</pre>";
	}
	public function deletemenu()
	{
		//API Url
		$url = 'http://116.204.183.102/api/DeleteMenu';
		$url = Yii::$app->params['prg_ctrl']['api']['line']['server'] . "api/DeleteMenu";
		//Initiate cURL.
		$ch = curl_init($url);

		//Tell cURL that we want to send a POST request.
		curl_setopt($ch, CURLOPT_POST, 1);

		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch, CURLOPT_POSTFIELDS, '"' . $this->richmenuid . '"');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

		//Execute the request
		$result = curl_exec($ch);

		if (strpos(strtolower($result), 'success') !== false) {
			return true;
		}

		$arr = json_decode($result, true);
		Yii::$app->session['error_unpushmenu'] = $arr['message'];
		return false;
	}

	public function setdefaultmenu()
	{
		//API Url
		$url = 'http://116.204.183.102/api/SetDefaultRichMenu';
		$url = Yii::$app->params['prg_ctrl']['api']['line']['server'] . "api/SetDefaultRichMenu";
		//Initiate cURL.
		$ch = curl_init($url);

		//Tell cURL that we want to send a POST request.
		curl_setopt($ch, CURLOPT_POST, 1);

		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch, CURLOPT_POSTFIELDS, '"' . $this->richmenuid . '"');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

		//Execute the request
		$result = curl_exec($ch);

		if (strpos(strtolower($result), 'success') !== false) {
			return true;
		}

		$arr = json_decode($result, true);
		Yii::$app->session['error_setdefaultmenu'] = $arr['message'];
		return false;
	}

	public function linkmenutouser()
	{

		$array = array(
			'userId' => $this->userid,
			'richMenuId' => $this->richmenuid
		);

		$jsonDataEncoded = json_encode($array, JSON_UNESCAPED_SLASHES);

		//$json_pretty = json_encode(json_decode($jsonDataEncoded), JSON_UNESCAPED_SLASHES);
		$json_pretty = json_encode(json_decode($jsonDataEncoded), JSON_PRETTY_PRINT);
		//echo $json_pretty;
		//exit;

		//API Url
		$url = 'http://116.204.183.102/api/LinkRichMenuToUser';
		$url = Yii::$app->params['prg_ctrl']['api']['line']['server'] . "api/LinkRichMenuToUser";

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
		Yii::$app->session['error_LinkRichMenuToUser'] = $arr['message'];
		return false;
	}

	//Max: 500 user IDs
	public function linkrichmenutomultipleUser()
	{

		$array = array(
			'richMenuId' => $this->richmenuid,
			'userIds' => $this->userid,
		);

		$jsonDataEncoded = json_encode($array, JSON_UNESCAPED_SLASHES);

		//$json_pretty = json_encode(json_decode($jsonDataEncoded), JSON_UNESCAPED_SLASHES);
		$json_pretty = json_encode(json_decode($jsonDataEncoded), JSON_PRETTY_PRINT);
		//echo $json_pretty;
		//exit;

		//API Url
		$url = 'http://116.204.183.102/api/LinkRichmenuToMultipleUser';
		$url = Yii::$app->params['prg_ctrl']['api']['line']['server'] . "api/LinkRichmenuToMultipleUser";

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
		$result = curl_exec($ch); //var_dump(	$result);exit;

		if (strpos(strtolower($result), 'success') !== false) {
			return true;
		}

		$arr = json_decode($result, true);
		Yii::$app->session['error_LinkRichmenuToMultipleUser'] = $arr['message'];
		return false;
	}


	public $perselect;
	public $section;
	public function save_Setviewmenu()
	{
		$createby = !Yii::$app->user->isGuest ? Yii::$app->user->id : 0;
		$conn = Yii::$app->db;
		$transaction = $conn->beginTransaction();
		try {
			$sql = "INSERT INTO trn_richmenu_custom_view (menu_id, section_type, ssobranch, create_by, create_date )
			 VALUE(:menu_id, :section_type, :ssobranch, '{$createby}', NOW())";

			$command = $conn->createCommand($sql);
			$command->bindValue(":menu_id", $this->id);
			$command->bindValue(":section_type", $this->section);
			$command->bindValue(":ssobranch", $this->perselect);
			$command->execute();

			$id = $conn->getLastInsertID();

			$transaction->commit();
			Yii::$app->session['success_setviewmenu'] = Yii::$app->urlManager->createAbsoluteUrl("richmenu/setview") . '/' . $id;
			Yii::$app->session['success_setviewmenu_id'] = $id;

			return true;
		} catch (Exception $e) {
			$transaction->rollBack();
			Yii::$app->session['errmsg_setviewmenu'] = 'error ' . $e->getMessage();
			return false;
		}
	}

	public function Edit_Setviewmenu()
	{
		$createby = !Yii::$app->user->isGuest ? Yii::$app->user->id : 0;
		$conn = Yii::$app->db;
		$transaction = $conn->beginTransaction();
		try {
			$sql = "UPDATE trn_richmenu_custom_view SET menu_id=:menu_id, section_type=:section_type, ssobranch=:ssobranch, update_by='{$createby}', update_date=NOW() 
			 WHERE id=:id";

			$command = $conn->createCommand($sql);
			$command->bindValue(":menu_id", $this->menu_id);
			$command->bindValue(":section_type", $this->section);
			$command->bindValue(":ssobranch", $this->perselect);
			$command->bindValue(":id", $this->id);
			$command->execute();

			$transaction->commit();
			Yii::$app->session['success_setviewmenu'] = Yii::$app->urlManager->createAbsoluteUrl("richmenu/setview") . '/' . $this->id;
			Yii::$app->session['success_setviewmenu_id'] = $this->id;

			return true;
		} catch (Exception $e) {
			$transaction->rollBack();
			Yii::$app->session['errmsg_setviewmenu'] = 'error ' . $e->getMessage();
			return false;
		}
	}

	public $status;
	public function Edit_viewrichmenustatus()
	{
		try {

			$createby = Yii::$app->user->getId();

			$conn = Yii::$app->db;
			$transaction = $conn->beginTransaction();

			$sql = "UPDATE trn_richmenu_custom_view SET status=:status, update_by=$createby, update_date=NOW() WHERE id=:id ";
			$command = $conn->createCommand($sql);
			$command->bindValue(":status", $this->status);
			$command->bindValue(":id", $this->id);
			$command->execute();

			$transaction->commit();

			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			Yii::$app->session['errmsg_viewrichmenustatus'] = 'error ' . $e->getMessage();

			return false;
		}
	}

	public function Delete_viewrichmenu()
	{
		try {
			$conn = Yii::$app->db;

			$sql = "
			SELECT * FROM tran_line_id WHERE tran_line_id.`currichmenu`=:currichmenu
  			";
			$rchk = $conn->createCommand($sql)->bindValue('currichmenu', $this->menu_id)->queryAll();
			if (count($rchk) != 0) {
				Yii::$app->session['errmsg_richmenu'] = 'error ' . "มีการอ้างอิง Richmenu กับ ผู้ประกันตนแล้วไม่สามารถลบได้";
				return false;
			}

			$transaction = $conn->beginTransaction();

			$sql = "DELETE FROM trn_richmenu_custom_view WHERE trn_richmenu_custom_view.id=:id ";
			$command = $conn->createCommand($sql);
			$command->bindValue(":id", $this->id);
			$command->execute();

			$transaction->commit();

			return true;
		} catch (Exception $e) {

			$transaction->rollBack();
			Yii::$app->session['errmsg_richmenu'] = 'error ' . $e->getMessage();
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

	public function Listback()
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
			$supersql = " AND trn_richmenu.status=1";
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
		$sqlwhere .= "  (trn_richmenu.description LIKE :description) ";
		$keyword = addcslashes($keyword, '%_');
		$params[':description'] = "%$keyword%";
		//}


		$sql = "SET @rownum := 0;";
		$command = $conn->createCommand($sql)->execute();
		$sql = "
			SELECT
				COUNT(*) AS ct
			FROM
			trn_richmenu 
			WHERE " . $strCondition . $sqlwhere . $supersql . " /*AND trn_richmenu.status=1*/";

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
					trn_richmenu.id as richmenu_id,
					trn_richmenu.description,
					trn_richmenu.menuid,
					trn_richmenu.push_status,
					trn_richmenu.status,
					trn_richmenu.setdefault
				FROM
				trn_richmenu 
				WHERE " . $strCondition . $sqlwhere . $supersql . " /*AND trn_richmenu.status=1*/ 
				ORDER BY
				trn_richmenu.id DESC
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
			/*if($dataitem['cover'] == ""){
				$imgthumb = Yii::$app->params['prg_ctrl']['domain'] . "/images/common/1580351424515.png";
			}else{
				$imgthumb = $folder.'/'.$dataitem['cover'];
			}
			
			if(mb_strlen(strip_tags($dataitem['description']),"UTF8") > 55){
				$subject =  mb_substr(strip_tags($dataitem['description']),0,55) . "...";
			}else{
				$subject = strip_tags($dataitem['description']);
			}
			
			<div class="image-wrap">
				<img class="image rounded" src="' . $imgthumb . '">
			</div>
			$strbtn = '
				<div class="media-item" onclick="window.open(\'' . Yii::$app->params['prg_ctrl']['domain'] . '/branch/viewdata/' . $dataitem['id'] . '\', \'_blank\');" style="cursor:pointer;" >
					
					<div class="info-wrap">
						<div class="title">' . strip_tags($dataitem['description']) . '</div>
						<div class="row pt-10">
							<div class="mr-auto pl-15" style="color:#3e8ef7;"><i class="icon fa-eye" aria-hidden="true"></i>&nbsp;' .$dataitem['hit']. '
								<a href="' . Yii::$app->createAbsoluteUrl("content/editdata") . "/". $dataitem["id"] . '" class="" style="margin-left: 5px;text-decoration: none;" title="แก้ไข">
									<i class="icon fa-edit" aria-hidden="true"></i>
								</a>
								<a href="javascript:void(0)" onclick="ajax_deldata('. $dataitem["id"] .');" class="" style="margin-left: 5px;text-decoration: none;" title="ลบ">
									<i class="icon fa-remove" aria-hidden="true"></i>
								</a> 
							</div>
							<div class="next pr-15">อ่านต่อ >></div>
						</div>
					</div>
				</div>
			';*/
			//$arr[] = array($strbtn);

			$strswitch = "";
			$btnDefault = "";
			$btnpush = "";
			if ($isAddmin == 1 && $this->pAdmin) {
				$strswitch = '
				<div class="col-md-2 mr-auto">
					<input type="checkbox" class="switch" data-color="#17b3a3" id="input' . $dataitem["richmenu_id"] . '" name="input' . $dataitem["richmenu_id"] . '" data-id="' . $dataitem["richmenu_id"] . '" data-status="' . $dataitem["status"] . '"  data-plugin="switchery" ' . ($dataitem["status"] == 1 ? "checked" : "") . '/>
				</div>
			';
				$strbtn = '
				<div class="btn-group" role="group">					
					<button type="button" class="btn btn-icon btn-info waves-effect waves-classic" onclick="window.open(\'' . Yii::$app->params['prg_ctrl']['domain'] . '/richmenu/view/' . $dataitem['richmenu_id'] . '\', \'_blank\');" title="แก้ไข"><i class="icon md-edit" aria-hidden="true"></i></button>
				</div>
				<button type="button" class="btn btn-icon btn-danger" onclick="ajax_deldata(this,' . $dataitem["richmenu_id"] . ');" title="ลบข้อมูล"><i class="fa fa-trash" aria-hidden="true"></i></button>					
			';

				if ($dataitem["push_status"] == 0) {
					$btnpush = '
					<button type="button" class="btn btn-icon btn-success" onclick="ajax_push(this,' . $dataitem["richmenu_id"] . ');" title="Push Rich menu"><i class="icon fa-send-o" aria-hidden="true"></i></button>
					';
				} else {
					$btnpush = '
					<button type="button" class="btn btn-icon btn-success" title="Push Rich menu" disabled ><i class="icon fa-send-o" aria-hidden="true"></i></button>					
					<button type="button" class="btn btn-icon btn-success" onclick="ajax_unpush(this,' . $dataitem["richmenu_id"] . ');" title="Remove Rich menu" ><i class="icon fa-eraser" aria-hidden="true"></i></button>
					';
				}
				if ($dataitem["setdefault"] == 0 && $dataitem["push_status"] == 1) {
					$btnDefault = '
					<button type="button" class="btn btn-icon btn-success" onclick="ajax_setdefault(this,' . $dataitem["richmenu_id"] . ');" title="Set default"><i class="icon ti-bookmark-alt" aria-hidden="true"></i></button>
					';
				} else {
					$btnDefault = '
					<button type="button" class="btn btn-icon btn-success" title="Set default" disabled ><i class="icon ti-bookmark-alt" aria-hidden="true"></i></button>
					';
				}
				//$dataitem['switch'] = $strswitch;

			} else {
				$strbtn = '
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-icon btn-info" onclick="window.open(\'' . Yii::$app->params['prg_ctrl']['domain'] . '/richmenu/view/' . $dataitem['richmenu_id'] . '\', \'_blank\');" title="โหวต"><i class="icon fa-eye" aria-hidden="true"></i></button>					
				</div>
			';
			}

			$dataitem['btn_line'] = $btnpush . $btnDefault;
			$dataitem['btn'] = $strbtn;
			unset($dataitem['push_status']);
			unset($dataitem['status']);
			unset($dataitem['setdefault']);
			$arr[] = array_values($dataitem);
		}

		$jsondata = json_encode($arr, JSON_HEX_APOS);
		unset($params[":rowstart"]);
		unset($params[":recordsPerPage"]);

		//echo '{"recordsTotal":' . $noOfRecords . ', "recordsFiltered":' . $noOfRecords . ', "data":' . $jsondata . '}';
		\Yii::$app->response->data  =  '{"recordsTotal":' . $noOfRecords . ', "recordsFiltered":' . $noOfRecords . ', "data":' . $jsondata . '}';
	}

	public function Listselect()
	{

		$cwebuser = new CustomWebUser();
		$user_id = Yii::$app->user->getId();
		$ssobranch_code = $cwebuser->getInfo("ssobranch_code");
		$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['admin'];

		$data = lkup_user::getUserPermission($user_id, $app_id, $ssobranch_code);
		$user_role = $data[0]["user_role"];
		$isAddmin = lkup_data::chkAddPermission($user_role, $app_id);

		$strCondition = "(start_date<=NOW() || start_date='0000-00-00 00:00:00' || start_date IS NULL) AND (end_date>=NOW() || end_date='0000-00-00 00:00:00' || end_date IS NULL) ";
		$strCondition = "";

		$supersql = "";
		if (!$this->pAdmin) {
			$supersql = " AND trn_richmenu.status=1";
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
		$sqlwhere .= "  (trn_richmenu.description LIKE :description) ";
		$keyword = addcslashes($keyword, '%_');
		$params[':description'] = "%$keyword%";
		//}


		$sql = "SET @rownum := 0;";
		$command = $conn->createCommand($sql)->execute();
		$sql = "
			SELECT
				COUNT(*) AS ct
			FROM
			trn_richmenu 
			WHERE " . $strCondition . $sqlwhere . $supersql . " /*AND trn_richmenu.status=1*/";

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
					trn_richmenu.id as richmenu_id,
					trn_richmenu.description,
					trn_richmenu.menuid,
					trn_richmenu.img
				FROM
				trn_richmenu 
				WHERE " . $strCondition . $sqlwhere . $supersql . " /*AND trn_richmenu.status=1*/ 
				ORDER BY
				trn_richmenu.id DESC
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

			$btnpush = "<img id='preview' alt='' style='height:200px' src='data:image/jpg;base64," . $dataitem['img'] . "' >";
			if ($isAddmin == 1 && $this->pAdmin) {

				$strbtn = '
				<div class="btn-group" role="group">
					<input type="hidden" name="hd_richmenu' . $dataitem['richmenu_id']  . '" id="hd_richmenu' . $dataitem['richmenu_id']  . '" value = "' . $dataitem['menuid']  . '">	
					<a href="javascript:void(0)" onclick="ajax_selectdata(' . $dataitem['richmenu_id'] . ');" class="" style="margin-left: 5px;text-decoration: none;font-size: 20px;" title="เลือก"> <i class="icon fa-check" aria-hidden="true"></i> </a>			
					
				</div>
				
			';


				//$dataitem['switch'] = $strswitch;

			}

			$dataitem['btn_line'] = $btnpush;
			$dataitem['btn'] = $strbtn;

			unset($dataitem['img']);
			unset($dataitem['menuid']);
			$arr[] = array_values($dataitem);
		}

		$jsondata = json_encode($arr, JSON_HEX_APOS);
		unset($params[":rowstart"]);
		unset($params[":recordsPerPage"]);

		\Yii::$app->response->data = '{"recordsTotal":' . $noOfRecords . ', "recordsFiltered":' . $noOfRecords . ', "data":' . $jsondata . '}';
	}

	public function Listmenumapback()
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
			$supersql = " AND trn_richmenu_custom_view.status=1";
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
		$sqlwhere .= "  (trn_richmenu_custom_view.menu_id LIKE :menu_id) ";
		$keyword = addcslashes($keyword, '%_');
		$params[':menu_id'] = "%$keyword%";
		//}


		$sql = "SET @rownum := 0;";
		$command = $conn->createCommand($sql)->execute();
		$sql = "
			SELECT
				COUNT(*) AS ct
			FROM
			trn_richmenu_custom_view 
			WHERE " . $strCondition . $sqlwhere . $supersql . " /*AND trn_richmenu_custom_view.status=1*/";

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
					trn_richmenu_custom_view.id as map_id,
					trn_richmenu_custom_view.menu_id,
					trn_richmenu_custom_view.section_type,
					trn_richmenu_custom_view.ssobranch,
					trn_richmenu_custom_view.status					
				FROM
				trn_richmenu_custom_view 
				WHERE " . $strCondition . $sqlwhere . $supersql . " /*AND trn_richmenu_custom_view.status=1*/ 
				ORDER BY
				trn_richmenu_custom_view.id DESC
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
					<input type="checkbox" class="switch" data-color="#17b3a3" id="input' . $dataitem["map_id"] . '" name="input' . $dataitem["map_id"] . '" data-id="' . $dataitem["map_id"] . '" data-status="' . $dataitem["status"] . '"  data-plugin="switchery" ' . ($dataitem["status"] == 1 ? "checked" : "") . '/>
				</div>
			';
				$strbtn = '
				<div class="btn-group" role="group">					
					<button type="button" class="btn btn-icon btn-info waves-effect waves-classic" onclick="window.open(\'' . Yii::$app->params['prg_ctrl']['domain'] . '/richmenu/setview/' . $dataitem['map_id'] . '\', \'_blank\');" title="แก้ไข"><i class="icon md-edit" aria-hidden="true"></i></button>
				</div>
				<button type="button" class="btn btn-icon btn-danger" onclick="ajax_deldata(this,' . $dataitem["map_id"] . ');" title="ลบข้อมูล"><i class="fa fa-trash" aria-hidden="true"></i></button>					
			';


				//$dataitem['switch'] = $strswitch;

			} else {
				$strbtn = '
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-icon btn-info" onclick="window.open(\'' . Yii::$app->params['prg_ctrl']['domain'] . '/richmenu/setview/' . $dataitem['map_id'] . '\', \'_blank\');" title="โหวต"><i class="icon fa-eye" aria-hidden="true"></i></button>					
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
				$dataitem['ssobranch'] = mb_strimwidth($rssec[0]['branch_name'], 0, 200, "...");
				//$dataitem['ssobranch'] = $rssec[0]['branch_name'];
			} else {
				$dataitem['ssobranch'] = "";
			}

			$dataitem['btn'] = $strbtn;
			//unset($dataitem['status']);
			$strswitch = '
			<div class="col-md-2 mr-auto">
			<input type="checkbox" class="switch customswitchery" data-color="#17b3a3" id="input' . $dataitem["map_id"] . '" name="input' . $dataitem["map_id"] . '" data-id="' . $dataitem["map_id"] . '" data-status="' . $dataitem["status"] . '"  data-plugin="switchery" ' . ($dataitem["status"] == 1 ? "checked" : "") . ' title="สถานนะ" />
			</div>
		';
			$dataitem['status'] = $strswitch;

			$arr[] = array_values($dataitem);
		}

		$jsondata = json_encode($arr, JSON_HEX_APOS);
		unset($params[":rowstart"]);
		unset($params[":recordsPerPage"]);

		//echo '{"recordsTotal":' . $noOfRecords . ', "recordsFiltered":' . $noOfRecords . ', "data":' . $jsondata . '}';
		\Yii::$app->response->data  =  '{"recordsTotal":' . $noOfRecords . ', "recordsFiltered":' . $noOfRecords . ', "data":' . $jsondata . '}';
	}
}
