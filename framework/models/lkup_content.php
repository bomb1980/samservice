<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

class lkup_content extends \yii\db\ActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function tableName()
	{
		return 'mas_bank';
	}

    public function attributeLabels() {
        return array(
        );
    }
	public function search($content_category_id=null, $keyword=null,$starts=null,$ends=null,$dep=null) {
		$params = array();

		$sqlId ="";
		if($content_category_id != null){
			$sqlId .=" content_category_id = :content_category_id AND ";
			$params[':content_category_id'] = $content_category_id;
		}
		/*
		foreach ($dep as $value){
			//echo $value;
		}*/
		
		$sqlDep ="";
		if (count($dep) !=0){
			$inn = "'" . implode ( "', '", $dep ) . "'";
			$sqlDep .=" AND ub.ssobranch_code IN($inn) ";
		//	$params[':ssobranch_code'] = "'" . implode ( "', '", $dep ) . "'";
		}

		$sqlCon ="";
		if($keyword!=''){							
			$sqlCon.= " AND (subject LIKE :subject ";	
			$sqlCon.= " OR body LIKE :body) ";		
			$keyword = addcslashes($keyword, '%_');
			$params[':subject'] = "%$keyword%";
			$params[':body'] = "%$keyword%";			
		}

		$sql = "SELECT /**,*/trn_content_category.content_id, trn_content.subject , trn_content.hit, trn_content.id, 
		trn_content.create_date as content_create_date, COUNT(trn_file.obj_id) AS Totalfile, u.displayname, ub.name FROM
		trn_content_category
			INNER JOIN trn_content
		ON (
			trn_content_category.content_id = trn_content.id
		)
		LEFT JOIN trn_file
		ON (
			trn_file.obj_id = trn_content.id
		)
		INNER JOIN mas_user u
		ON (
			trn_content.create_by = u.id
		)
		INNER JOIN mas_ssobranch ub
		ON (
			u.ssobranch_code = ub.ssobranch_code
		)
		WHERE " . $sqlId . " trn_content.status=1 AND trn_content.create_date >=:starts AND trn_content.create_date <=:ends " . $sqlCon . $sqlDep . "
		GROUP BY trn_content.id
		ORDER BY trn_content.update_date DESC,	trn_content.create_date DESC";
		
		
		$params[':starts'] = $starts;
		$params[':ends'] = $ends;

		////$count = Yii::$app->db->createCommand($sql)->bindValue('content_category_id',$content_category_id)->queryScalar();

		//$rows = Yii::$app->db->createCommand($sql)->bindValue('content_category_id',$content_category_id)->queryAll();
		//$count = count($rows);

		$command = Yii::$app->db->createCommand($sql);	
		foreach ($params as $key => $value){
    	$command->bindValue($key, $value);
		}
	
		$rows = $command->queryAll();
		$count = count($rows);
	
		return new CSqlDataProvider($sql, array(
			'totalItemCount'=>$count,
			'params'=>$params,
			'sort'=>array(
				'attributes'=>array(
					'update_date','create_date',
				),
			),
			'pagination'=>array(
				'pageSize'=>Yii::$app->params['prg_ctrl']['pagination']['default']['pagesize'],
			),
		));	

	}	
	
	public function getBank($id = null)
	{
	   	//$sql="select id, code, name, address, email from mas_bank where status=1 and id='".$id."' ";	   
	   	$sql ="select id, replace(code,'\\\','') as code, replace(name,'\\\','') as name , ";
		$sql.="replace(address,'\\\','') as address , replace(email,'\\\','') as email ";
		$sql.="from mas_bank where status=1 and id='".$id."' ";
	   	$rows =Yii::$app->db->createCommand($sql)->queryAll();
	   	return $rows;
	}

	public function getContent($content_category_id = null)	{
		$sql = "SELECT * FROM
			trn_content_category
				INNER JOIN trn_content
			ON (
				`trn_content_category`.`content_id` = `trn_content`.`id`
			)
			WHERE content_category_id = :content_category_id 
			ORDER BY update_date DESC,	create_date DESC";
	  
	  	$rows= Yii::$app->db->createCommand($sql)->bindValue('content_category_id',$content_category_id)->queryAll();
	   	return $rows;
	}

	//แสดงรายการเนื้อหา หน้าหลัก
	public function getContentListMain($content_category_id = null)	{
		$sqlCat ="";
		if (is_array($content_category_id)){		
			$inn = "'" . implode ( "', '", $content_category_id ) . "'";
			$sqlCat .=" content_category_id IN($inn) ";
		}else{
			$sqlCat .=" content_category_id IN('" . $content_category_id . "') ";
		}

		$sql = "SELECT /**,*/trn_content_category.content_id, trn_content.subject , trn_content.hit, trn_content.id,
			trn_content.create_date as content_create_date, COUNT(trn_file.obj_id) AS Totalfile, u.displayname, ub.name FROM
			trn_content_category
				INNER JOIN trn_content
			ON (
				`trn_content_category`.`content_id` = `trn_content`.`id`
			)
			LEFT JOIN trn_file
			ON (
				`trn_file`.`obj_id` = `trn_content`.`id`
			)
			INNER JOIN mas_user u
			ON (
				trn_content.create_by = u.id
			)
			INNER JOIN mas_ssobranch ub
			ON (
				u.ssobranch_code = ub.ssobranch_code
			)
			WHERE " . $sqlCat . " 
			GROUP BY trn_content.id
			ORDER BY trn_content.update_date DESC,	trn_content.create_date DESC";
	  
		//$count = Yii::$app->db->createCommand($sql)->bindValue('content_category_id',$content_category_id)->queryScalar();
		$rows = Yii::$app->db->createCommand($sql)->queryAll();
		$count = count($rows);
		return new CSqlDataProvider($sql, array(
			'totalItemCount'=>$count,
			'sort'=>array(
				'attributes'=>array(
					'update_date','create_date',
				),
			),
			'pagination'=>array(
				'pageSize'=>'5',
				//'pageSize'=>Yii::$app->params['prg_ctrl']['pagination']['default']['pagesize'],
			),
		));	

	}

	//แสดงรายการเนื้อหา
	public function getContentList($content_category_id = null)	{
		$sql = "SELECT /**,*/trn_content_category.content_id, trn_content.subject , trn_content.hit, trn_content.id, 
			trn_content.create_date as content_create_date, COUNT(trn_file.obj_id) AS Totalfile, u.displayname, ub.name FROM
			trn_content_category
				INNER JOIN trn_content
			ON (
				`trn_content_category`.`content_id` = `trn_content`.`id`
			)
			LEFT JOIN trn_file
			ON (
				`trn_file`.`obj_id` = `trn_content`.`id`
			)
			INNER JOIN mas_user u
			ON (
				trn_content.create_by = u.id
			)
			INNER JOIN mas_ssobranch ub
			ON (
				u.ssobranch_code = ub.ssobranch_code
			)
			WHERE content_category_id = :content_category_id 
			GROUP BY trn_content.id
			ORDER BY trn_content.update_date DESC,	trn_content.create_date DESC";
	  
			//$rawData= Yii::$app->db->createCommand($sql)->bindValue('content_category_id',$content_category_id);
			
		$params[':content_category_id'] = $content_category_id;
		//$count = Yii::$app->db->createCommand($sql)->bindValue('content_category_id',$content_category_id)->queryScalar();
		$rows = Yii::$app->db->createCommand($sql)->bindValue('content_category_id',$content_category_id)->queryAll();
		$count = count($rows);
		return new CSqlDataProvider($sql, array(
			'totalItemCount'=>$count,
			'params'=>$params,
			'sort'=>array(
				'attributes'=>array(
					'update_date','create_date',
				),
			),
			'pagination'=>array(				
				'pageSize'=>Yii::$app->params['prg_ctrl']['pagination']['default']['pagesize'],
			),
		));	

	}

	public function getEditcustomcontent($id){

		$sql ="SELECT *, trn_file.id as file_id
		FROM
		  trn_custom_content_list
		  LEFT JOIN trn_file
			ON (
			  `trn_custom_content_list`.`id` = `trn_file`.`obj_id`
			)
		WHERE trn_custom_content_list.status = 1 AND trn_custom_content_list.id=:id AND trn_file.obj_type in(8,9,10)
		ORDER BY trn_file.create_date ;	";
		$rows= Yii::$app->db->createCommand($sql)->bindValue('id',$id)->queryAll(); 
		return $rows;
	}

	public static function getEditData($id){

		$sql ="SELECT *, trn_content.create_by as trncreate_by, trn_file.id as file_id ,trn_content.read_permission_status
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
		$rows= Yii::$app->db->createCommand($sql)->bindValue('content_id',$id)->queryAll(); 
		return $rows;
	}

	public static function getData($id = null,$uphit = true){

		$sql ="SELECT *, trn_content.create_by as trncreate_by, trn_content.update_by as trnupdate_by, trn_content.update_date as content_update_date
		FROM
		  trn_content_category
		  INNER JOIN trn_content
			ON (
			  `trn_content_category`.`content_id` = `trn_content`.`id`
			)
		  LEFT JOIN trn_file
			ON (
			  `trn_content`.`id` = `trn_file`.`obj_id` AND trn_file.obj_type=1
			)
			WHERE content_id =:content_id AND trn_content.status=1
		ORDER BY trn_content.update_date DESC,
		  trn_content.create_date DESC;	";
		$rows= Yii::$app->db->createCommand($sql)->bindValue('content_id',$id)->queryAll(); 

		if($uphit){
			if (count($rows) > 0) {
				$sql = "UPDATE trn_content SET hit = hit + 1 ";
				$sql.= "WHERE id=:id";
				$command = Yii::$app->db->createCommand($sql);	
				$command->bindValue(":id", $id);		
				$command->execute();
			}	
		}

		return $rows;
	}

	public static function getGlobaldata($id = null,$uphit = true){

		$sql ="SELECT *, trn_custom_content_list.create_by as trncreate_by,  trn_custom_content_list.create_date as content_create_date , trn_custom_content_list.update_by as trnupdate_by, trn_custom_content_list.update_date as content_update_date, trn_file.id as file_id
		FROM
		trn_custom_content_list
		  LEFT JOIN trn_file
			ON (
			  `trn_custom_content_list`.`id` = `trn_file`.`obj_id` AND trn_file.obj_type=10
			)
			WHERE trn_custom_content_list.id=:content_id AND trn_custom_content_list.status=1
		ORDER BY trn_custom_content_list.update_date DESC,
		trn_custom_content_list.create_date DESC;	";
		$rows= Yii::$app->db->createCommand($sql)->bindValue('content_id',$id)->queryAll(); 

		if($uphit){
			if (count($rows) > 0) {
				$sql = "UPDATE trn_custom_content_list SET hit = hit + 1 ";
				$sql.= "WHERE id=:id";
				$command = Yii::$app->db->createCommand($sql);	
				$command->bindValue(":id", $id);		
				$command->execute();
			}	
		}

		return $rows;
	}

	public static function getGlobalsso($id = null,$uphit = true){

		$sql ="SELECT *, trn_globalsso.id as content_id , trn_globalsso.create_date as trncreate_date,  trn_globalsso.create_by as trncreate_by, trn_globalsso.update_by as trnupdate_by, trn_globalsso.update_date as trn_update_date
		FROM
		trn_globalsso
		  INNER JOIN mas_country
			ON(
				trn_globalsso.ct_code = mas_country.`ct_code`
			)
		  LEFT JOIN trn_file
			ON (
			  `trn_globalsso`.`id` = `trn_file`.`obj_id` AND trn_file.obj_type = 10
			)
			WHERE trn_globalsso.id =:id AND trn_globalsso.status=1
		ORDER BY trn_globalsso.update_date DESC,
		trn_globalsso.create_date DESC;	";
		$rows= Yii::$app->db->createCommand($sql)->bindValue('id',$id)->queryAll(); 

		if($uphit){
			if (count($rows) > 0) {
				$sql = "UPDATE trn_globalsso SET hit = hit + 1 ";
				$sql.= "WHERE id=:id";
				$command = Yii::$app->db->createCommand($sql);	
				$command->bindValue(":id", $id);		
				$command->execute();
			}	
		}

		return $rows;
	}

	public static function getEditGlobalsso($id){

		$sql ="SELECT *, trn_globalsso.create_by as trncreate_by, trn_file.id as file_id ,trn_globalsso.read_permission_status
		FROM
		trn_globalsso
		  INNER JOIN mas_country
			ON(
				trn_globalsso.ct_code = mas_country.`ct_code`
			)
		  LEFT JOIN trn_file
			ON (
			  `trn_globalsso`.`id` = `trn_file`.`obj_id` AND trn_file.obj_type = 10
			)
		WHERE trn_globalsso.id =:id AND trn_globalsso.status=1
		ORDER BY trn_globalsso.update_date DESC,
		trn_globalsso.create_date DESC;	";
		$rows= Yii::$app->db->createCommand($sql)->bindValue('id',$id)->queryAll(); 
		return $rows;
	}

	public static function getContent_category($ssobranch_code = null, $status="1"){

		$sql ="SELECT *
		FROM
		content_category
		INNER JOIN content_subcategory
			ON (
				`content_category`.`content_category_id` = `content_subcategory`.`content_category_id`
			)
			ORDER BY content_category.content_category_id ASC ,ordno ASC;
			";
		if($ssobranch_code != null){
			$ssobranch_code = addcslashes($ssobranch_code, '%_'); 
			$sql ="SELECT * FROM mas_content_category WHERE status in(" . $status . ") AND creator_ssobranch LIKE :creator_ssobranch ORDER BY ordno_lv1,ordno_lv2,ordno_lv3 ";
			$rows= Yii::$app->db->createCommand($sql)->bindValue('creator_ssobranch',"%$ssobranch_code%")->queryAll(); 
		}else{
			$sql ="SELECT * FROM mas_content_category WHERE status in(" . $status . ") ORDER BY ordno_lv1,ordno_lv2,ordno_lv3 ";
			$rows =Yii::$app->db->createCommand($sql)->queryAll();
		}
	
		return $rows;

	}
	
	public function getCustomContent_category($ssobranch_code = null, $status="1"){
		$sql ="SELECT *
		FROM
		content_category
		INNER JOIN content_subcategory
			ON (
				`content_category`.`content_category_id` = `content_subcategory`.`content_category_id`
			)
			ORDER BY content_category.content_category_id ASC ,ordno ASC;
			";
		if($ssobranch_code != null){
			$ssobranch_code = addcslashes($ssobranch_code, '%_'); 
			$sql ="SELECT * FROM mas_custom_content_category WHERE status in(" . $status . ") AND creator_ssobranch LIKE :creator_ssobranch ORDER BY ordno_lv1,ordno_lv2,ordno_lv3 ";
			$rows= Yii::$app->db->createCommand($sql)->bindValue('creator_ssobranch',"%$ssobranch_code%")->queryAll(); 
		}else{
			$sql ="SELECT * FROM mas_custom_content_category WHERE status in(" . $status . ") ORDER BY ordno_lv1,ordno_lv2,ordno_lv3 ";
			$rows =Yii::$app->db->createCommand($sql)->queryAll();
		}
	
		return $rows;

	}

	public static function getViewPermission($contentid = null , $id  =null, $ssobranch_code = null, $superadmin = false){
		$sql = "SELECT * FROM trn_content WHERE id=:id";
		$rows= Yii::$app->db->createCommand($sql)->bindValue('id',$contentid)->queryAll(); 
		$read_permission_status = $rows[0]["read_permission_status"];
	
		if($superadmin) return true;
		switch($read_permission_status){
			case 1: //เฉพาะฉัน
				if($id === $rows[0]["create_by"]){
					return true;
				}else{
					Yii::$app->session['errmsg_content'] = 'เนื้อหานี้ได้กำหนดสิทธิ์การเข้าถึงไว้เห็นเฉพาะผู้โพสต์';
					return false;
				}
				break;
			case 2 : //เฉพาะกลุ่มงาน
				if($ssobranch_code === $rows[0]["ssobranch_code"]){
					return true;
				}else{
					Yii::$app->session['errmsg_content'] = 'เนื้อหานี้ได้กำหนดสิทธิ์การเข้าถึงไว้เห็นเฉพาะหน่วยงาน';
					return false;
				}
				break;
			case 3 : //ทั้งหมด
				return true;
				break;
			default:
				Yii::$app->session['errmsg_content'] = 'เนื้อหานี้เจ้าหน้าที่ได้กำหนดสิทธิ์การเข้าถึงไว้';
				return false;
		}

	}

	public static function getViewGlobalPermission($contentid = null , $id  =null, $ssobranch_code = null, $superadmin = false){
		$sql = "SELECT * FROM trn_globalsso WHERE id=:id";
		$rows= Yii::$app->db->createCommand($sql)->bindValue('id',$contentid)->queryAll(); 
		$read_permission_status = $rows[0]["read_permission_status"];
	
		if($superadmin) return true;
		switch($read_permission_status){
			case 1: //เฉพาะฉัน
				if($id === $rows[0]["create_by"]){
					return true;
				}else{
					Yii::$app->session['errmsg_content'] = 'เนื้อหานี้ได้กำหนดสิทธิ์การเข้าถึงไว้เห็นเฉพาะผู้โพสต์';
					return false;
				}
				break;
			case 2 : //เฉพาะกลุ่มงาน
				if($ssobranch_code === $rows[0]["ssobranch_code"]){
					return true;
				}else{
					Yii::$app->session['errmsg_content'] = 'เนื้อหานี้ได้กำหนดสิทธิ์การเข้าถึงไว้เห็นเฉพาะหน่วยงาน';
					return false;
				}
				break;
			case 3 : //ทั้งหมด
				return true;
				break;
			default:
				Yii::$app->session['errmsg_content'] = 'เนื้อหานี้เจ้าหน้าที่ได้กำหนดสิทธิ์การเข้าถึงไว้';
				return false;
		}

	}

	public static function getViewGlobaldataPermission($contentid = null , $id  =null, $ssobranch_code = null, $superadmin = false){
		$sql = "SELECT * FROM trn_custom_content_list WHERE id=:id";
		$rows= Yii::$app->db->createCommand($sql)->bindValue('id',$contentid)->queryAll(); 
		$read_permission_status = $rows[0]["read_permission_status"];
	
		if($superadmin) return true;
		switch($read_permission_status){
			case 1: //เฉพาะฉัน
				if($id === $rows[0]["create_by"]){
					return true;
				}else{
					Yii::$app->session['errmsg_content'] = 'เนื้อหานี้ได้กำหนดสิทธิ์การเข้าถึงไว้เห็นเฉพาะผู้โพสต์';
					return false;
				}
				break;
			case 2 : //เฉพาะกลุ่มงาน
				if($ssobranch_code === $rows[0]["ssobranch_code"]){
					return true;
				}else{
					Yii::$app->session['errmsg_content'] = 'เนื้อหานี้ได้กำหนดสิทธิ์การเข้าถึงไว้เห็นเฉพาะหน่วยงาน';
					return false;
				}
				break;
			case 3 : //ทั้งหมด
				return true;
				break;
			default:
				Yii::$app->session['errmsg_content'] = 'เนื้อหานี้เจ้าหน้าที่ได้กำหนดสิทธิ์การเข้าถึงไว้';
				return false;
		}

	}

	public static function getCategoryByUser($userrole = null, $ssobranch = null, $status = '1') 
	{
		$sql = "select distinct * ";
		$sql.= "from ";
		$sql.= "( ";
		$sql.= "select * ";
		$sql.= "from mas_content_category l3 ";
		$sql.= "where hassub = 0 AND STATUS in(" . $status . ") ";
		$sql.= "and (ifnull(creator_role,'')='' or substr(creator_role,".$userrole.",1)=1) ";
		$sql.= "and (ifnull(creator_ssobranch,'')='' or ifnull(creator_ssobranch,'') like '%".$ssobranch."%') ";
		$sql.= "UNION ";
		$sql.= "select l2.* ";
		$sql.= "from mas_content_category l2 ";
		$sql.= "join ";
		$sql.= "( ";
		$sql.= " select id, parent_lv1_id, parent_lv2_id ";
		$sql.= " from mas_content_category ";
		$sql.= " where hassub = 0 AND STATUS in(" . $status . ") ";
		$sql.= " and (ifnull(creator_role,'')='' or substr(creator_role,".$userrole.",1)=1) ";
		$sql.= " and (ifnull(creator_ssobranch,'')='' or ifnull(creator_ssobranch,'') like '%".$ssobranch."%') ";
		$sql.= ") dl2 on l2.id = dl2.parent_lv2_id ";
		$sql.= "where l2.hassub = 1 AND STATUS in(" . $status . ") and l2.category_level=2 ";
		$sql.= " ";
		$sql.= "UNION ";
		$sql.= "select l1.* ";
		$sql.= "from mas_content_category l1 ";
		$sql.= "join ";
		$sql.= "( ";
		$sql.= " select id, parent_lv1_id, parent_lv2_id ";
		$sql.= " from mas_content_category ";
		$sql.= " where hassub = 0 AND STATUS in(" . $status . ") ";
		$sql.= " and (ifnull(creator_role,'')='' or substr(creator_role,".$userrole.",1)=1) ";
		$sql.= " and (ifnull(creator_ssobranch,'')='' or ifnull(creator_ssobranch,'') like '%".$ssobranch."%') ";
		$sql.= ") dl1 on l1.id = dl1.parent_lv1_id ";
		$sql.= "where l1.hassub = 1 AND STATUS in(" . $status . ") and l1.category_level=1 ";
		$sql.= ") l0 ";
		$sql.= "order by l0.ordno_lv1, l0.ordno_lv2, l0.ordno_lv3 "; 

		if ($userrole == 1 ){
			$sql = "SELECT * FROM mas_content_category WHERE status in('1','2') ";
		}
 
		$rows =Yii::$app->db->createCommand($sql)->queryAll();
		return $rows;
	}

	public static function getCustomCategoryByUser($userrole = null, $ssobranch = null, $status = '1') 
	{
		$sql = "select distinct * ";
		$sql.= "from ";
		$sql.= "( ";
		$sql.= "select * ";
		$sql.= "from mas_custom_content_category l3 ";
		$sql.= "where hassub = 0 AND STATUS in(" . $status . ") ";
		$sql.= "and (ifnull(creator_role,'')='' or substr(creator_role,".$userrole.",1)=1) ";
		$sql.= "and (ifnull(creator_ssobranch,'')='' or ifnull(creator_ssobranch,'') like '%".$ssobranch."%') ";
		$sql.= "UNION ";
		$sql.= "select l2.* ";
		$sql.= "from mas_custom_content_category l2 ";
		$sql.= "join ";
		$sql.= "( ";
		$sql.= " select id, parent_lv1_id, parent_lv2_id ";
		$sql.= " from mas_custom_content_category ";
		$sql.= " where hassub = 0 AND STATUS in(" . $status . ") ";
		$sql.= " and (ifnull(creator_role,'')='' or substr(creator_role,".$userrole.",1)=1) ";
		$sql.= " and (ifnull(creator_ssobranch,'')='' or ifnull(creator_ssobranch,'') like '%".$ssobranch."%') ";
		$sql.= ") dl2 on l2.id = dl2.parent_lv2_id ";
		$sql.= "where l2.hassub = 1 AND STATUS in(" . $status . ") and l2.category_level=2 ";
		$sql.= " ";
		$sql.= "UNION ";
		$sql.= "select l1.* ";
		$sql.= "from mas_custom_content_category l1 ";
		$sql.= "join ";
		$sql.= "( ";
		$sql.= " select id, parent_lv1_id, parent_lv2_id ";
		$sql.= " from mas_custom_content_category ";
		$sql.= " where hassub = 0 AND STATUS in(" . $status . ") ";
		$sql.= " and (ifnull(creator_role,'')='' or substr(creator_role,".$userrole.",1)=1) ";
		$sql.= " and (ifnull(creator_ssobranch,'')='' or ifnull(creator_ssobranch,'') like '%".$ssobranch."%') ";
		$sql.= ") dl1 on l1.id = dl1.parent_lv1_id ";
		$sql.= "where l1.hassub = 1 AND STATUS in(" . $status . ") and l1.category_level=1 ";
		$sql.= ") l0 ";
		$sql.= "order by l0.ordno_lv1, l0.ordno_lv2, l0.ordno_lv3 "; 

		if ($userrole == 1 ){
			$sql = "SELECT * FROM mas_custom_content_category WHERE status in('1','2') ";
		}
 
		$rows =Yii::$app->db->createCommand($sql)->queryAll();
		return $rows;
	}

	public function getAddPermissionByBranch($catid, $ssobranch = null, $status = '1') 
	{
		$sql = "SELECT * FROM mas_content_category WHERE id=:id AND creator_ssobranch LIKE :creator_ssobranch AND status in(". $status .") ";
		$command = Yii::$app->db->createCommand($sql);	
		$command->bindValue(":id", $catid);
		$keyword = addcslashes($ssobranch, '%_');
		$command->bindValue(":creator_ssobranch", "%$keyword%");
		$rows = $command->queryAll();
		return $rows;	
	}
	public function getAddCustomPermissionByBranch($catid, $ssobranch = null, $status = '1') 
	{
		$sql = "SELECT * FROM mas_custom_content_category WHERE id=:id AND creator_ssobranch LIKE :creator_ssobranch AND status in(". $status .") ";
		$command = Yii::$app->db->createCommand($sql);	
		$command->bindValue(":id", $catid);
		$keyword = addcslashes($ssobranch, '%_');
		$command->bindValue(":creator_ssobranch", "%$keyword%");
		$rows = $command->queryAll();
		return $rows;	
	}

}	
