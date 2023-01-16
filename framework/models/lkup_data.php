<?php
namespace app\models;

use Yii;
class lkup_data 
{

	public static function getDepartment($ssobranch_code = null, $status = "1", $ssobranch_type_id = "1,2,3")
	{
		if ($ssobranch_code == null) {
			$sql = "SELECT * FROM mas_ssobranch WHERE status IN (" . $status . ") AND ssobranch_type_id IN (" . $ssobranch_type_id . ") order by ssobranch_code";
			$rows = Yii::$app->db->createCommand($sql)->queryAll();
		} else {
			$sql = "SELECT * FROM mas_ssobranch WHERE ssobranch_code=:ssobranch_code AND status IN (" . $status . ") AND ssobranch_type_id IN (" . $ssobranch_type_id . ") order by ssobranch_code";
			$rows = Yii::$app->db->createCommand($sql)->bindValue('ssobranch_code', $ssobranch_code)->queryAll();
		}

		return $rows;
	}

	public static function getSection($section_id = null, $status = "1")
	{
		if ($section_id == null) {
			$sql = "SELECT * FROM mas_section WHERE status IN (" . $status . ") order by id";
			$rows = Yii::$app->db->createCommand($sql)->queryAll();
		} else {
			$sql = "SELECT * FROM mas_section WHERE id=:section_id AND status IN (" . $status . ") order by ssobranch_code";
			$rows = Yii::$app->db->createCommand($sql)->bindValue('id', $section_id)->queryAll();
		}

		return $rows;
	}

	public static function getContentGroup($id = null, $status = "1")
	{

		$sql = "SELECT * FROM mas_content_category where parent_lv1_id=:parent_lv1_id and status in (" . $status . ") order by id";

		$command = Yii::$app->db->createCommand($sql);
		$command->bindValue(":parent_lv1_id", $id);
		$rows = $command->queryAll();
		return $rows;
	}

	public function getContent_category($id = null, $status = '1')
	{
		if ($id != null) {
			$sql = "SELECT * FROM mas_content_category where id=:id and status in(" . $status . ") ";
			$rows = Yii::$app->db->createCommand($sql)->bindValue('id', $id)->queryAll();
		} else {
			$sql = "SELECT * FROM mas_content_category where status in(" . $status . ")  ";
			$rows = Yii::$app->db->createCommand($sql)->queryAll();
		}
		return $rows;
	}

	public function getCustomContent_category($id = null, $status = '1')
	{
		if ($id != null) {
			$sql = "SELECT * FROM mas_custom_content_category where id=:id and status in(" . $status . ") ";
			$rows = Yii::$app->db->createCommand($sql)->bindValue('id', $id)->queryAll();
		} else {
			$sql = "SELECT * FROM mas_custom_content_category where status in(" . $status . ")  ";
			$rows = Yii::$app->db->createCommand($sql)->queryAll();
		}
		return $rows;
	}

	public static function chkPermission($user_role = null, $app_id = null)
	{
		//$ssobranch_code = Yii::$app->user->getInfo("ssobranch_code");
		//$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['cms']; 

		$data = lkup_user::getAppPermission($app_id);
		$creator_role = $data[0]["view_role"];
		return substr($creator_role, $user_role - 1, 1);
	}

	public static function chkAddPermission($user_role = null, $app_id = null, $ssobranch_code = null)
	{
		//$ssobranch_code = Yii::$app->user->getInfo("ssobranch_code");
		//$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['cms']; 

		$data = lkup_user::getAppPermission($app_id);
		$creator_role = $data[0]["creator_role"]; 
		if ($ssobranch_code == null) {
			return substr($creator_role, $user_role - 1, 1);
		}
//var_dump($data[0]['creator_ssobranch']);exit;
		if (!is_null($data[0]['creator_ssobranch']) || !empty($data[0]['creator_ssobranch'])) {
			$toArray = explode(',', $data[0]['creator_ssobranch']);
			foreach ($toArray as $line) {
				$liner = str_replace(' ', '', $line);
				if ($liner == $ssobranch_code) {
					return substr($creator_role, $user_role - 1, 1);
				}
			}
			return 0;
		} else {

			if (is_null($data[0]['creator_ssobranch']) || empty($data[0]['creator_ssobranch'])) {

				return substr($creator_role, $user_role - 1, 1);
			}
			return 0;
		}
	}

	public function getData($id = null)
	{

		$sql = "SELECT *, trn_content.update_date as content_update_date
		FROM
		  trn_content_category
		  INNER JOIN trn_content
			ON (
			  `trn_content_category`.`content_id` = `trn_content`.`id`
			)
		  LEFT JOIN trn_file
			ON (
			  `trn_content`.`id` = `trn_file`.`obj_id`
			)
			WHERE content_id =:content_id AND trn_content.status=1
		ORDER BY trn_content.update_date DESC,
		  trn_content.create_date DESC;	";
		$rows = Yii::$app->db->createCommand($sql)->bindValue('content_id', $id)->queryAll();

		if (count($rows) > 0) {
			$sql = "UPDATE trn_content SET hit = hit + 1 ";
			$sql .= "WHERE id=:id";
			$command = Yii::$app->db->createCommand($sql);
			$command->bindValue(":id", $id);
			$command->execute();
		}

		return $rows;
	}

	public function getPortal($id = null)
	{

		if ($id != null) {
			$sql = "SELECT * FROM mas_portal WHERE status = 1 AND id LIKE :id ORDER BY ordno_lv1,ordno_lv2,ordno_lv3 ";
			$rows = Yii::$app->db->createCommand($sql)->bindValue('id', $id)->queryAll();
		} else {
			$sql = "SELECT * FROM mas_portal WHERE status = 1 ORDER BY ordno_lv1,ordno_lv2,ordno_lv3 ";
			$rows = Yii::$app->db->createCommand($sql)->queryAll();
		}

		return $rows;
	}

	public function getMasPortal($id = null)
	{

		if ($id != null) {
			$sql = "SELECT * FROM mas_portal WHERE id = :id ORDER BY ordno_lv1,ordno_lv2,ordno_lv3 ";
			$rows = Yii::$app->db->createCommand($sql)->bindValue('id', $id)->queryAll();
		} else {
			$sql = "SELECT * FROM mas_portal WHERE status in(1,2) ORDER BY ordno_lv1,ordno_lv2,ordno_lv3 ";
			$rows = Yii::$app->db->createCommand($sql)->queryAll();
		}

		return $rows;
	}

	public function getMasCalendar_executive($id = null)
	{

		if ($id != null) {
			$sql = "SELECT * FROM mas_calendar_executive WHERE id = :id  ORDER BY ordno ";
			$sql = "
					SELECT *
					FROM
					  mas_calendar_executive
					  INNER JOIN trn_file
						ON (
						  mas_calendar_executive.user_id = trn_file.obj_id
						)
					  INNER JOIN mas_user
						ON mas_user.id = mas_calendar_executive.user_id
					WHERE mas_calendar_executive.id = :id
					ORDER BY ordno;
			";
			$rows = Yii::$app->db->createCommand($sql)->bindValue('id', $id)->queryAll();
		} else {
			$sql = "SELECT * FROM mas_calendar_executive WHERE status in(1,2) ORDER BY ordno ";
			$sql = "
					SELECT
					  mas_user.uid,
					  mas_calendar_executive.id,
					  mas_calendar_executive.user_id,
					  mas_calendar_executive.name,
					  mas_calendar_executive.color_code,
					  mas_calendar_executive.position,
					  trn_file.file_web_url,
					  mas_calendar_executive.status,
					  mas_calendar_executive.work_status
					FROM
					  mas_calendar_executive
					  INNER JOIN trn_file
						ON (
						  mas_calendar_executive.user_id = trn_file.obj_id
						)
					  INNER JOIN mas_user
						ON mas_user.id = mas_calendar_executive.user_id
					WHERE obj_type = 7
					  AND mas_calendar_executive.status IN (1, 2)
					ORDER BY ordno;
			";
			$rows = Yii::$app->db->createCommand($sql)->queryAll();
		}

		return $rows;
	}

	public function getMasContent_category($ssobranch_code = null)
	{

		if ($ssobranch_code != null) {
			$ssobranch_code = addcslashes($ssobranch_code, '%_');
			$sql = "SELECT * FROM mas_content_category WHERE status = 1 AND creator_ssobranch LIKE :creator_ssobranch ORDER BY ordno_lv1,ordno_lv2,ordno_lv3 ";
			$rows = Yii::$app->db->createCommand($sql)->bindValue('creator_ssobranch', "%$ssobranch_code%")->queryAll();
		} else {
			$sql = "SELECT * FROM mas_content_category WHERE status in(1,2) ORDER BY ordno_lv1,ordno_lv2,ordno_lv3 ";
			$rows = Yii::$app->db->createCommand($sql)->queryAll();
		}

		return $rows;
	}

	public static function getMasCustomContent_category($ssobranch_code = null)
	{

		if ($ssobranch_code != null) {
			$ssobranch_code = addcslashes($ssobranch_code, '%_');
			$sql = "SELECT * FROM mas_custom_content_category WHERE status = 1 AND creator_ssobranch LIKE :creator_ssobranch ORDER BY ordno_lv1,ordno_lv2,ordno_lv3 ";
			$rows = Yii::$app->db->createCommand($sql)->bindValue('creator_ssobranch', "%$ssobranch_code%")->queryAll();
		} else {
			$sql = "SELECT * FROM mas_custom_content_category WHERE status in(1,2) ORDER BY ordno_lv1,ordno_lv2,ordno_lv3 ";
			$rows = Yii::$app->db->createCommand($sql)->queryAll();
		}

		return $rows;
	}

	public static function getBranch_Description($id = null, $uphit = true)
	{

		$sql = "SELECT
			  *,
			  mas_ssobranch.id AS branch_id,
			  trn_ssobranch.`create_by` AS branch_create_by,
			  trn_ssobranch.`update_by` AS branch_update_by,
			  trn_ssobranch.`update_date` AS branch_update_date,
			  mas_ssobranch.name AS branch_name,
			  mas_ssobranch.status AS branch_status,
			  mas_ssobranch.ssobranch_code AS branch_code
			FROM
			  mas_ssobranch
			  LEFT JOIN trn_ssobranch
				ON (
				  mas_ssobranch.ssobranch_code = trn_ssobranch.ssobranch_code
				)
			  LEFT JOIN trn_file
				ON (
				  trn_ssobranch.id = trn_file.obj_id
				)
			WHERE mas_ssobranch.id =:id;			
		";
		//$sql = "SELECT * FROM trn_ssobranch WHERE trn_ssobranch.`id`=:id AND trn_ssobranch.status=1; ";
		$rows = Yii::$app->db->createCommand($sql)->bindValue('id', $id)->queryAll();

		if ($uphit) {
			if (count($rows) > 0) {
				$sql = "UPDATE trn_ssobranch SET hit = hit + 1 ";
				$sql .= "WHERE ssobranch_code=:ssobranch_code";
				$command = Yii::$app->db->createCommand($sql);
				$command->bindValue(":ssobranch_code", $rows[0]['branch_code']);
				$command->execute();
			}
		}

		return $rows;
	}

	/*-----------------------------------------------------------------------------------------------------------------------------*/
	/* system */
	public static function getDBName()
	{

		$sql = "SHOW DATABASES WHERE `Database` NOT LIKE '%schema' AND `Database` != 'mysql' ;";
		$rows = Yii::$app->db->createCommand($sql)->queryAll();

		return $rows;
	}
	public static function getTBName($DBName)
	{

		$sql = "SHOW TABLES FROM " . $DBName;
		$rows = Yii::$app->db->createCommand($sql)->queryAll();

		return $rows;
	}
	public static function getColumnName($DBName, $TBName, $Condition = null)
	{
		/*
		$sql = "SHOW COLUMNS FROM ". $DBName.".".$TBName;
		$rows = Yii::$app->db->createCommand($sql)->queryAll();

		return $rows;
*/
		if ($Condition == null) {
			$sql = "SHOW COLUMNS FROM " . $DBName . "." . $TBName;
		} else {
			$sql = "SHOW COLUMNS FROM " . $DBName . "." . $TBName . " WHERE " . $Condition;
		}
		/*
		Yii::$app->setComponents(array(
			'dynamicdb' => array('dsn' => Yii::$app->params['data_ctrl']['dbhost'] . 'dbname=' . $DBName)
		));*/
		
		\Yii::$app->dynamicdb->dsn= Yii::$app->params['data_ctrl']['dbhost'] . 'dbname=' . $DBName;
		$conn = Yii::$app->dynamicdb;
		$command = $conn->createCommand($sql);
		$rows = $command->queryAll();
		return $rows;
	}
}
