<?php

namespace app\models;

use Yii;

class lkup_user 
{
	/*
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}*/

	public function tableName()
	{
		return 'mas_user';
	}

	public function attributeLabels()
	{
		return array();
	}

	public function search($keyword = null)
	{
		$sqlCon = "";
		if ($keyword != '') {
			$sqlCon .= " and (a.username like '%" . $keyword . "%') ";
		}

		$count = Yii::$app->db->createCommand("select count(*) from mas_user a left join mas_userlevel b on a.userlevel_id=b.id where a.status!=0 " . $sqlCon)->queryScalar();
		$sql = "select a.id, ";
		$sql .= "replace(a.username,'\\\','') as username, ";
		$sql .= "replace(a.displayname,'\\\','') as displayname ";
		$sql .= "from mas_user a ";
		$sql .= "left join mas_userlevel b on a.userlevel_id=b.id ";
		$sql .= "where a.status!=0 " . $sqlCon;
		return new CSqlDataProvider($sql, array(
			'totalItemCount' => $count,
			'sort' => array(
				'attributes' => array(
					'id', 'username', 'displayname',
				),
			),
			'pagination' => array(
				'pageSize' => Yii::$app->params['prg_ctrl']['pagination']['default']['pagesize'],
			),
		));
	}
	public static function listuser($ssobranch_code = null)
	{
		if ($ssobranch_code == null) {
			$sql = "SELECT * FROM mas_user ORDER BY uid";
		} else {
			$sql = "SELECT * FROM mas_user WHERE ssobranch_code=" . $ssobranch_code . " ORDER BY uid";
		}

		$rows = Yii::$app->db->createCommand($sql)->queryAll();
		return $rows;
	}

	public static function getUsername($username = null)
	{


		//$sql="select id, username, userpass, displayname, userlevel_id, status from mas_user where username='".$username."' and status=1";	   
		//$rows =Yii::$app->db->createCommand($sql)->queryAll();
		$local = Yii::$app->params['auth']['local'];
		
		// if ($local) {

		
		$sql = "
			SELECT 
				mas_user.id, 
				mas_user.role_id, 
				mas_user.uid, 
				mas_user.password, 
				mas_user.displayname, 
				mas_user.ssobranch_code, 
				mas_user.status, 
				mas_ssobranch.name, 
				mas_ssobranch.ssobranch_type_id
			FROM mas_user INNER JOIN mas_ssobranch ON mas_user.ssobranch_code = mas_ssobranch.ssobranch_code  
			WHERE uid = :uid
		";


		$rows = Yii::$app->db->createCommand($sql)->bindValue('uid', $username)->queryAll(); 

		// arr( $rows );
		return $rows;
	}

	public static function checkuser($username = null)
	{
		$local = Yii::$app->params['auth']['local'];

		if ($local) {
			$sql = "SELECT * FROM mas_local_user WHERE uid=:uid";
			//ใช้ตารางเดิมไปก่อน
			$sql = "SELECT * FROM mas_user WHERE uid=:uid";
		} else {
			$sql = "SELECT * FROM mas_user WHERE uid=:uid";
		}
		$rows = Yii::$app->db->createCommand($sql)->bindValue('uid', $username)->queryAll();
		return $rows;
		
	}
	public static function getUserid($id = null,$status="1,2")
	{
		//$sql="select id, username, userpass, displayname, userlevel_id, status from mas_user where id='".$id."' and status=1";	
		//$rows =Yii::$app->db->createCommand($sql)->queryAll();

		$sql = "SELECT mas_user.id, mas_user.role_id, mas_user.uid, mas_user.password, mas_user.displayname, mas_user.ssobranch_code, mas_user.status, mas_ssobranch.name, mas_ssobranch.ssobranch_type_id
			FROM
		  	mas_user
		  	INNER JOIN mas_ssobranch
			ON (
			  mas_user.ssobranch_code = mas_ssobranch.ssobranch_code
			) WHERE mas_user.id=:id AND mas_user.status IN(". $status  .")
		";
		$rows = Yii::$app->db->createCommand($sql)->bindValue('id', $id)->queryAll();
		return $rows;
	}
	public function getBranch($ssobranch_code = null)
	{
		$sql = "SELECT * FROM mas_ssobranch WHERE ssobranch_code=:ssobranch_code ";
		$rows = Yii::$app->db->createCommand($sql)->bindValue('ssobranch_code', $ssobranch_code)->queryAll();
		return $rows;
	}

	public function fixContentBranch($ssobranch_code = null, $userid = null, $contentid = null)
	{
		$conn = Yii::$app->db;

		$sql = "SELECT * FROM mas_ssobranch WHERE ssobranch_code=:ssobranch_code ";
		$rows = Yii::$app->db->createCommand($sql)->bindValue('ssobranch_code', $ssobranch_code)->queryAll();
		if (count($rows) == 0) {
			$sql = "SELECT * FROM mas_user WHERE id=:id ";
			$rows = $conn->createCommand($sql)->bindValue('id', $userid)->queryAll();
			$branch_code = $rows[0]["ssobranch_code"];

			$sql = "UPDATE trn_content SET ssobranch_code=:ssobranch_code WHERE id=:id;";
			$command = $conn->createCommand($sql);
			$command->bindValue(":ssobranch_code", $branch_code);
			$command->bindValue(":id", $contentid);
			$command->execute();
		}
		return $rows;
	}

	public static function getUserPermission($id = null, $app_id = null, $ssobranch_code = null)
	{

		if ($id != null && $app_id != null && $ssobranch_code != null) {
			$sql = "select * from mas_user_permission where user_id=:user_id and app_id=:app_id and ssobranch_code=:ssobranch_code and status=1	";
			$command = Yii::$app->db->createCommand($sql);
			$command->bindValue(":user_id", $id);
			$command->bindValue(":app_id", $app_id);
			$command->bindValue(":ssobranch_code", $ssobranch_code);
			$rows = $command->queryAll();
		} elseif ($id != null && $app_id != null) {
			$sql = "select * from mas_user_permission where user_id=:user_id and app_id=:app_id and status=1	";
			$command = Yii::$app->db->createCommand($sql);
			$command->bindValue(":user_id", $id);
			$command->bindValue(":app_id", $app_id);
			$rows = $command->queryAll();
		}elseif ($app_id != null && $ssobranch_code != null) {
			$sql = "select * from mas_user_permission where app_id=:app_id and ssobranch_code=:ssobranch_code and status=1	";
			$command = Yii::$app->db->createCommand($sql);
			$command->bindValue(":app_id", $app_id);
			$command->bindValue(":ssobranch_code", $ssobranch_code);
			$rows = $command->queryAll();
		}elseif ($id != null) {
			$sql = "select * from mas_user_permission where user_id=:user_id and status=1	";
			$command = Yii::$app->db->createCommand($sql);
			$command->bindValue(":user_id", $id);
			$rows = $command->queryAll();
		} elseif ($app_id != null) {
			$sql = "select * from mas_user_permission where app_id=:app_id and status=1	";
			$command = Yii::$app->db->createCommand($sql);
			$command->bindValue(":app_id", $app_id);
			$rows = $command->queryAll();
		} elseif ($ssobranch_code != null) {
			$sql = "select * from mas_user_permission where ssobranch_code=:ssobranch_code and status=1	";
			$command = Yii::$app->db->createCommand($sql);
			$command->bindValue(":ssobranch_code", $ssobranch_code);
			$rows = $command->queryAll();			
		}else {
			$sql = "select * from mas_user_permission where status=1	";
			$command = Yii::$app->db->createCommand($sql);
			$rows = $command->queryAll();
		}
		return $rows;
	}

	public static function getAppPermission($app_id = null)
	{
		if ($app_id != null) {
			$sql = "select * from mas_app_permission where id=:app_id and status=1	";
			$command = Yii::$app->db->createCommand($sql);
			$command->bindValue(":app_id", $app_id);
			$rows = $command->queryAll();
		} else {
			$sql = "select * from mas_app_permission where status=1 ";
			$command = Yii::$app->db->createCommand($sql);
			$rows = $command->queryAll();
		}

		return $rows;
	}

	public static function LDAP_LIST($search)
	{
		$host = Yii::$app->params['prg_ctrl']['ldap']['server'];
		$port = Yii::$app->params['prg_ctrl']['ldap']['port'];
		$bind_uid = Yii::$app->params['prg_ctrl']['ldap']['bind_uid'];
		$bind_pwd = Yii::$app->params['prg_ctrl']['ldap']['bind_pwd'];
		$bind_dn = Yii::$app->params['prg_ctrl']['ldap']['bind_dn'];
		$filter_attr = Yii::$app->params['prg_ctrl']['ldap']['filter_attr'];
		$arr_search_attr = Yii::$app->params['prg_ctrl']['ldap']['arr_search_attr'];
		$arr_basedn = Yii::$app->params['prg_ctrl']['ldap']['arr_basedn'];

		$ldapcon = ldap_connect($host, $port);
		if (!$ldapcon) {
			//echo '<br> ldap cannot connect';
			return false;
		}

		ldap_set_option($ldapcon, LDAP_OPT_PROTOCOL_VERSION, 3);
		$ldapbind = ldap_bind($ldapcon, $bind_dn, $bind_pwd);
		if (!$ldapbind) {
			//echo '<br> ldap_bind Error: '.ldap_error($ldapcon); 
			ldap_close($ldapcon);
			return false;
		}
		$filter = "(&(ssofirstname=" . $search . ")(ssosurname=" . $search . "))"; //ค้นหา AND
		$filter = "(|(ssofirstname=" . $search . ")(ssosurname=" . $search . ")(uid=" . $search . "))"; //ค้นหา OR
		$ldapsr = ldap_search($ldapcon, $arr_basedn, $filter, array_values($arr_search_attr));
		//$ldapsr = ldap_search($ldapcon, $arr_basedn, $filter_attr ."=". $search, array_values($arr_search_attr)); 
		if (!$ldapsr) {
			//echo '<br> ldap_search Error: '.ldap_error($ldapcon); 
			ldap_close($ldapcon);
			return false;
		}

		$entry = @ldap_get_entries($ldapcon, $ldapsr);
		if ($entry == false) {
			if (!$entry or !$entry[0]) {
				//echo '<br> ldap_search Error: Not find username'; 
				ldap_close($ldapcon);
				return false;
			}
		}

		$allArr = array();
		$ldap_user_info = array();
		for ($i = 0; $i < $entry["count"]; $i++) {

			foreach (array_keys($arr_search_attr) as $attr) {
				//$ldap_user_info[$attr] = @$entry[$i][$arr_search_attr[$attr]][0];

				$ldap_user_info[$attr] = @$entry[$i][$arr_search_attr[$attr]][0]; //echo $arr_search_attr[$attr];


			}
			$allArr[] = $ldap_user_info;
			unset($ldap_user_info);
		}

		return $allArr;
	}
}
