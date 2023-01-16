<?php

namespace app\models;

use Yii;
use yii\base\Model;

use app\components\CustomWebUser;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user This property is read-only.
 *
 */
class AdminAction extends Model
{
	public $uid;
	public $displayname;
	public $ssobranch_code;
	public $position;

	public $id;
	public $status;

	public $page;
	public $recordsPerPage;
	public $start;
	public $noOfRecords;
	public $FSearch;
	public function Listuser()
	{
		$conn = Yii::$app->db;

		$Condition = "";
		if (!empty($this->FSearch)) {
			$Condition = " WHERE uid LIKE :Condition OR displayname LIKE :Condition ";
		}

		if ($this->ssobranch_code == null) {
			$sql = "SELECT * FROM mas_user ORDER BY uid";

			$sql = "SET @rownum := 0;";
			$command = $conn->createCommand($sql)->execute();
			$sql = "
			SELECT * FROM
			(SELECT @rownum := @rownum+1 AS NUMBER, mas_user.id, mas_user.uid, mas_user.displayname, mas_user.ssobranch_code, mas_user.ssomail, mas_ssobranch.name, mas_user.status 
			FROM mas_user LEFT JOIN mas_ssobranch ON (mas_user.ssobranch_code = mas_ssobranch.ssobranch_code) " . $Condition . " ORDER BY uid) AS TBL
			WHERE NUMBER BETWEEN :rowstart AND :rowend 
			ORDER BY uid;
			";
			$command = $conn->createCommand($sql);
			$command->bindValue(":rowstart", ($this->start + 1));
			$command->bindValue(":rowend", ($this->start + $this->recordsPerPage));
			if (!empty($this->FSearch)) {
				$command->bindValue(":Condition", "%" . $this->FSearch . "%");
			}
			$rows = $command->queryAll();

			$arr = array();
			foreach ($rows as $dataitem) {
				//$new =  array_push($dataitem,"xxx");
				$strstatus = '<input type="checkbox" class="js-switch_work_status" id="input_work_status' . $dataitem["id"] . '" name="input_work_status' . $dataitem["id"] . '" data-id="' . $dataitem["id"] . '" data-status="' . $dataitem["status"] . '" data-plugin="switchery" ' . ($dataitem["status"] == 1 ? "checked" : "") . '  />&nbsp;&nbsp;';
				$dataitem['btn1'] = $strstatus;
				//<button type="button" class="btn btn-icon btn-info waves-effect waves-classic" title="แสดงโปรไฟล์"><i class="icon md-file" aria-hidden="true"></i></button>
				$strbtn = '
				<div class="btn-group" role="group">			
					
					<button type="button" class="btn btn-icon btn-info waves-effect waves-classic" data-target="#mdEditRole" data-toggle="modal" data-user_id="' . $dataitem['id'] . '" data-ssobranch_code="' . $dataitem['ssobranch_code'] . '" title="แก้ไขสิทธิ์" ><i class="icon md-edit" aria-hidden="true"></i></button>
				</div>
				';
				$dataitem['btn'] = $strbtn;
				unset($dataitem['status']);
				$arr[] = array_values($dataitem);
			}

			$jsondata = json_encode($arr);

			$sql = "SELECT COUNT(*) As ct FROM mas_user" . $Condition;

			$command = $conn->createCommand($sql);
			if (!empty($this->FSearch)) {
				$command->bindValue(":Condition", "%" . $this->FSearch . "%");
			}
			$rows = $command->queryAll();
			$noOfRecords =  $rows[0]['ct'];

			\Yii::$app->response->data = '{"recordsTotal":' . $noOfRecords . ',"recordsFiltered":' . $noOfRecords . ',"data":' . $jsondata . '}';
		} else {
			$sql = "SELECT * FROM mas_user WHERE ssobranch_code=" . $this->ssobranch_code . " ORDER BY uid";
		}

		//$rows= Yii::$app->db->createCommand($sql)->queryAll();
		//return $rows;
	}

	public $user_id;
	public $app_id;
	public $user_role;

	public function Edit_UserAppPermission()
	{

		try {

			$createby = !Yii::$app->user->isGuest ? Yii::$app->user->id : 0;
			//$ssobranch_code = 1051;	

			$conn = Yii::$app->db;
			$transaction = $conn->beginTransaction();

			$sql = "UPDATE mas_user_permission SET user_role=:user_role, status=1, update_by=$createby, update_date=NOW() WHERE user_id=:user_id AND app_id=:app_id AND ssobranch_code=:ssobranch_code ";
			$command = $conn->createCommand($sql);
			$command->bindValue(":user_role", $this->user_role);
			$command->bindValue(":user_id", $this->user_id);
			$command->bindValue(":app_id", $this->app_id);
			$command->bindValue(":ssobranch_code", $this->ssobranch_code);
			$command->execute();

			$transaction->commit();
			return true;
		} catch (Exception $e) {

			$transaction->rollBack();
			Yii::$app->session['errmsg_permission'] = 'error ' . $e->getMessage();
			return false;
		}
	}

	public function Edit_Statusworkuser()
	{
		try {
			$createby = Yii::$app->user->id;

			$conn = Yii::$app->db;
			$transaction = $conn->beginTransaction();

			$sql = "UPDATE mas_user SET status=:status, update_by=$createby, update_date=NOW() WHERE id=:id ";
			$command = $conn->createCommand($sql);
			$command->bindValue(":status", $this->status);
			$command->bindValue(":id", $this->id);
			$command->execute();

			$transaction->commit();

			return true;
		} catch (Exception $e) {
			$transaction->rollBack();
			Yii::$app->session['errmsg_user'] = 'error ' . $e->getMessage();

			return false;
		}
	}

	public $search;
	public $type_id;
	public $pAdmin;
	public function Listbranch()
	{

		$cwebuser = new CustomWebUser();
		$user_id = Yii::$app->user->getId();
		$ssobranch_code = $cwebuser->getInfo("ssobranch_code");

		$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['admin'];

		$data = lkup_user::getUserPermission($user_id, $app_id, $ssobranch_code);
		$user_role = $data[0]["user_role"];
		$isAddmin = lkup_data::chkAddPermission($user_role, $app_id);

		$supersql = "";
		if (!$this->pAdmin) {
			$supersql = " AND mas_ssobranch.status=1";
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
		$sqlwhere .= " (mas_ssobranch.ssobranch_code LIKE :ssobranch_code OR mas_ssobranch.NAME LIKE :NAME) ";
		$keyword = addcslashes($keyword, '%_');
		$params[':ssobranch_code'] = "%$keyword%";
		$params[':NAME'] = "%$keyword%";
		//}

		if ($this->type_id != "") {
			$sqlwhere .= " AND mas_ssobranch.ssobranch_type_id =:ssobranch_type_id ";
			$params[":ssobranch_type_id"] = $this->type_id;
		}

		$sql = "SET @rownum := 0;";
		$command = $conn->createCommand($sql)->execute();
		$sql = "
			SELECT
				COUNT(*) AS ct
			FROM
				trn_ssobranch
				RIGHT JOIN mas_ssobranch ON mas_ssobranch.ssobranch_code = trn_ssobranch.ssobranch_code
			WHERE " . $sqlwhere . $supersql . " /*AND mas_ssobranch.status=1*/";

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
					mas_ssobranch.id as branch_id,
					mas_ssobranch.ssobranch_code,
					mas_ssobranch.NAME,
					mas_ssobranch.status as sso_status
				FROM
					trn_ssobranch
					RIGHT JOIN mas_ssobranch ON mas_ssobranch.ssobranch_code = trn_ssobranch.ssobranch_code
				WHERE " . $sqlwhere . $supersql . " /*AND mas_ssobranch.status=1*/
				ORDER BY
					/*trn_ssobranch.update_date DESC,
					trn_ssobranch.create_date DESC,
					trn_ssobranch.ssobranch_code ASC
					mas_ssobranch.ssobranch_code ASC*/
					trn_ssobranch.ordno ASC, trn_ssobranch.ssobranch_code
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
								<a href="' . Yii::$app->urlManager->createAbsoluteUrl("content/editdata") . "/". $dataitem["id"] . '" class="" style="margin-left: 5px;text-decoration: none;" title="แก้ไข">
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
			$strswitch = '
				<div class="col-md-2 mr-auto">
					<input type="checkbox" class="switch" data-color="#17b3a3" id="input' . $dataitem["branch_id"] . '" name="input' . $dataitem["branch_id"] . '" data-id="' . $dataitem["branch_id"] . '" data-status="' . $dataitem["sso_status"] . '" data-branchcode="' . $dataitem["ssobranch_code"] . '" data-plugin="switchery" ' . ($dataitem["sso_status"] == 1 ? "checked" : "") . '/>
				</div>
			';
			$dataitem['switch'] = $strswitch;

			if ($isAddmin) {
				$strbtn = '
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-icon btn-info waves-effect waves-classic" onclick="window.open(\'' . Yii::$app->params['prg_ctrl']['domain'] . '/branch/viewdata/' . $dataitem['branch_id'] . '\', \'_blank\');" title="แสดงรายละเอียด"><i class="icon md-search" aria-hidden="true"></i></button>
					<button type="button" class="btn btn-icon btn-info waves-effect waves-classic" onclick="window.open(\'' . Yii::$app->params['prg_ctrl']['domain'] . '/branch/editdata/' . $dataitem['branch_id'] . '\', \'_blank\');" title="แก้ไขหน่วยงาน"><i class="icon md-edit" aria-hidden="true"></i></button>
				</div>
			';
			} else {
				$strbtn = '
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-icon btn-info waves-effect waves-classic" onclick="window.open(\'' . Yii::$app->params['prg_ctrl']['domain'] . '/branch/viewdata/' . $dataitem['branch_id'] . '\', \'_blank\');" title="แสดงรายละเอียด"><i class="icon md-search" aria-hidden="true"></i></button>					
				</div>
			';
			}


			$dataitem['btn'] = $strbtn;
			$arr[] = array_values($dataitem);
		}
		$jsondata = json_encode($arr, JSON_HEX_APOS);
		unset($params[":rowstart"]);
		unset($params[":recordsPerPage"]);

		\Yii::$app->response->data = '{"recordsTotal":' . $noOfRecords . ', "recordsFiltered":' . $noOfRecords . ', "data":' . $jsondata . '}';
	}

	public $cover;
	public $branchcode;
	public $name;
	public $shortname;
	public $ssobranch_type_id;
	public $desc;
	public $filecode;

	public $address;
	public $telno;
	public $location;
	//------------------------------------------------------------------------------------------------------------------------------------------------
	public function save_insert()
	{
		try {

			$createby = Yii::$app->user->getId();

			$conn = Yii::$app->db;
			$sql = "
			INSERT INTO trn_ssobranch (cover, ssobranch_code, description, hit, status, create_by, create_date, update_date, address, telno, location)
			VALUES(:cover, :ssobranch_code, :description, 0, :status, $createby, now(), now(), :address, :telno, :location)";
			$command = $conn->createCommand($sql);
			$command->bindValue(":cover", $this->cover);
			$command->bindValue(":ssobranch_code", $this->branchcode);
			$command->bindValue(":description", $this->desc);
			$command->bindValue(":status", 1);
			$command->bindValue(":address", $this->address);
			$command->bindValue(":telno", $this->telno);
			$command->bindValue(":location", $this->location);
			$command->execute();

			$sql = "
			INSERT INTO mas_ssobranch (ssobranch_code, name, shortname, ssobranch_type_id, status, create_by, create_date, update_date)
			VALUES(:ssobranch_code, :name, :shortname, :ssobranch_type_id, :status, $createby, now(), now())";
			$command = $conn->createCommand($sql);
			$command->bindValue(":ssobranch_code", $this->branchcode);
			$command->bindValue(":name", $this->name);
			$command->bindValue(":shortname", $this->shortname);
			$command->bindValue(":ssobranch_type_id", $this->ssobranch_type_id);
			$command->bindValue(":status", 1);
			$command->execute();

			Yii::$app->session['success_content'] = Yii::$app->urlManager->createAbsoluteUrl("admin/branch");
			return true;
		} catch (Exception $e) {
			Yii::$app->session['errmsg_content'] = 'error ' . $e->getMessage();
			return false;
		}
	}
	//------------------------------------------------------------------------------------------------------------------------------------------------
	public function save_edit()
	{
		try {
			$createby = Yii::$app->user->getId();
			$conn = Yii::$app->db;

			$sql = "SELECT * FROM trn_ssobranch WHERE ssobranch_code=:ssobranch_code ";
			$command = $conn->createCommand($sql);
			$command->bindValue(":ssobranch_code", $this->branchcode);
			$rows = $command->queryAll();
			if (count($rows) == 0) {
				$sql = "
				INSERT INTO trn_ssobranch (cover, ssobranch_code, description, hit, status, create_by, create_date, update_date, address, telno, location)
				VALUES(:cover, :ssobranch_code, :description, 0, :status, $createby, now(), now(), :address, :telno, :location)";
				$command = $conn->createCommand($sql);
				$command->bindValue(":cover", $this->cover);
				$command->bindValue(":ssobranch_code", $this->branchcode);
				$command->bindValue(":description", $this->desc);
				$command->bindValue(":status", 1);
				$command->bindValue(":address", $this->address);
				$command->bindValue(":telno", $this->telno);
				$command->bindValue(":location", $this->location);
				$command->execute();
			}

			if ($this->cover != "") {
				$sql = "UPDATE trn_ssobranch SET cover=:cover ,description=:description ,update_by=$createby ,update_date=now(), address=:address, telno=:telno, location=:location WHERE ssobranch_code=:ssobranch_code ";
				$command = $conn->createCommand($sql);
				$command->bindValue(":cover", $this->cover);
				$command->bindValue(":description", $this->desc);
				$command->bindValue(":address", $this->address);
				$command->bindValue(":telno", $this->telno);
				$command->bindValue(":location", $this->location);
				$command->bindValue(":ssobranch_code", $this->branchcode);
				$command->execute();
			} else {
				$sql = "UPDATE trn_ssobranch SET description=:description ,update_by=$createby ,update_date=now(), address=:address, telno=:telno, location=:location WHERE ssobranch_code=:ssobranch_code";
				$command = $conn->createCommand($sql);
				$command->bindValue(":description", $this->desc);
				$command->bindValue(":address", $this->address);
				$command->bindValue(":telno", $this->telno);
				$command->bindValue(":location", $this->location);
				$command->bindValue(":ssobranch_code", $this->branchcode);
				$command->execute();
			}

			$sql = "UPDATE mas_ssobranch SET name=:name ,shortname=:shortname ,ssobranch_type_id=:ssobranch_type_id ,update_by=$createby ,update_date=now() WHERE ssobranch_code=:ssobranch_code";
			$command = $conn->createCommand($sql);
			$command->bindValue(":ssobranch_code", $this->branchcode);
			$command->bindValue(":name", $this->name);
			$command->bindValue(":shortname", $this->shortname);
			$command->bindValue(":ssobranch_type_id", $this->ssobranch_type_id);
			$command->execute();

			Yii::$app->session['success_content'] = Yii::$app->urlManager->createAbsoluteUrl("admin/branch");
			return true;
		} catch (Exception $e) {
			Yii::$app->session['errmsg_content'] = 'error ' . $e->getMessage();
			return false;
		}
	}
	//------------------------------------------------------------------------------------------------------------------------------------------------
	public function Edit_StatusBranch()
	{
		try {
			$createby = Yii::$app->user->getInfo("id");

			$conn = Yii::$app->db;
			$transaction = $conn->beginTransaction();

			$sql = "UPDATE mas_ssobranch SET status=:status, update_by=$createby, update_date=NOW() WHERE ssobranch_code=:ssobranch_code ";
			$command = $conn->createCommand($sql);
			$command->bindValue(":status", $this->status);
			$command->bindValue(":ssobranch_code", $this->ssobranch_code);
			$command->execute();

			$transaction->commit();

			return true;
		} catch (Exception $e) {
			$transaction->rollBack();
			Yii::$app->session['errmsg_branch'] = 'error ' . $e->getMessage();

			return false;
		}
	}


}
