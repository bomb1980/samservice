<?php
namespace app\models;

use Yii;
class lkup_branch  {
	
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public function tableName() {
		return 'mas_user';
	}
	
	public function attributeLabels() {
		return array();
	}
	
	public $id;
	public static function getEditData($id = null) {
		$sql = "
		SELECT
			mas_ssobranch.id,
			trn_ssobranch.cover,
			trn_ssobranch.address,
			trn_ssobranch.telno,
			trn_ssobranch.location,
			mas_ssobranch.ssobranch_code,
			mas_ssobranch.name,
			mas_ssobranch.shortname,
			mas_ssobranch.ssobranch_type_id,
			trn_ssobranch.description
		FROM
			mas_ssobranch
			LEFT JOIN trn_ssobranch ON trn_ssobranch.ssobranch_code = mas_ssobranch.ssobranch_code
		WHERE mas_ssobranch.id = :id;";
		$rows= Yii::$app->db->createCommand($sql)->bindValue('id',$id)->queryAll(); 
		return $rows;
	}

	public static function getBranch_type($id = null)	{
		if($id != null){
			$sql = "SELECT * FROM mas_ssobranch_type where id=:id and status=1 ";
			$rows= Yii::$app->db->createCommand($sql)->bindValue('id',$id)->queryAll(); 
		}else{
			$sql = "SELECT * FROM mas_ssobranch_type where status=1 ";
			$rows= Yii::$app->db->createCommand($sql)->queryAll(); 
		}	
	  return $rows;
	}


}