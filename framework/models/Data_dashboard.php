<?php

namespace app\models;

use Yii;

class Data_dashboard 
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

	public static function sso_new_old()
	{
		$sql = "select  DATE_FORMAT(log_date, '%d %M %Y') as log_date ,contacts,targetReaches,blocks from log_friends_overview";
			$command = Yii::$app->logdb->createCommand($sql);
			$rows = $command->queryAll();
			
			return $rows;
	}
	public static function message()
	{
		$sql = "select * from log_friends_byzone";
			$command = Yii::$app->logdb->createCommand($sql);
			$rows = $command->queryAll();
			
			return $rows;
	}
	public static function all_count()
	{
		$sql = "SELECT count(id) as total from tran_ssoid ";
			$command = Yii::$app->db->createCommand($sql);
			$rows = $command->queryAll();
			return $rows;
	}
	public static function user_count()
	{
		$sql = "SELECT count(a.id) as num,name from tran_ssoid a  RIGHT JOIN  mas_section b on a.section_id = b.id GROUP BY b.id";
			$command = Yii::$app->db->createCommand($sql);
			$rows = $command->queryAll();
			return $rows;
	}
	public static function sso_provice()
	{
		$sql = "SELECT a.code,count(b.id)as code_department from county_provice a left join tran_ssoid b on a.code_department=LEFT (b.ssobranch_code, 2) GROUP BY a.id";
			$command = Yii::$app->db->createCommand($sql);
			$rows = $command->queryAll();
			return $rows;
	}
	public static function sso_region()
	{
		$sql = "SELECT a.code,count(b.id)as cont_region ,c.region_name from county_provice a left join tran_ssoid b on a.code_department=LEFT (b.ssobranch_code, 2) join sso_region c on a.region_id= c.region_id GROUP BY c.region_id";
			$command = Yii::$app->db->createCommand($sql);
			$rows = $command->queryAll();
			return $rows;
	}
	public function provice_detail($region=null)
	{
		$sql = "SELECT  name,code_department from county_provice WHERE region_id=".$region;
			$command = Yii::$app->db->createCommand($sql);
			$rows = $command->queryAll();
			return $rows;
	}
	public function region_detail($regiondetail=null)
	{
		
		$sql = "SELECT a.name,count(b.id)as cont_region, a.code_department  from county_provice a left join tran_ssoid b on a.code_department=LEFT (b.ssobranch_code, 2) join sso_region c on a.region_id= c.region_id where c.region_name='$regiondetail' GROUP BY a.id";
			
			$command = Yii::$app->db->createCommand($sql);
			$rows = $command->queryAll();
		
			return $rows;
	}
	public function region_provicedetail($provice=null)
	{
		
		$sql = "SELECT b.name,count(a.section_id) as num FROM
	           ( SELECT section_id FROM tran_ssoid WHERE LEFT ( ssobranch_code, 2 ) = $provice ) as a
                RIGHT JOIN
               ( SELECT id, name FROM mas_section  )as b on a.section_id=b.id GROUP BY b.id";
			
			$command = Yii::$app->db->createCommand($sql);
			$rows = $command->queryAll();
			 
			return $rows;
	}
	public function thai_provicedetail($provice=null)
	{
		
		$sql = "SELECT b.name,count(a.section_id) as num FROM
	           ( SELECT a.section_id FROM tran_ssoid a join county_provice b on LEFT ( a.ssobranch_code, 2 )=b.code_department  WHERE  b.name_eng='$provice') as a
                RIGHT JOIN
               ( SELECT id, name FROM mas_section  )as b on a.section_id=b.id GROUP BY b.id";
			
			$command = Yii::$app->db->createCommand($sql);
			$rows = $command->queryAll();
			 
			return $rows;
	}
	public function nameprovice($provice_name=null)
	{
		
		$sql = "SELECT name from county_provice where name_eng='$provice_name'";
	
			$command = Yii::$app->db->createCommand($sql);
			$rows = $command->queryAll();
			
		
			return $rows;
	}
}
